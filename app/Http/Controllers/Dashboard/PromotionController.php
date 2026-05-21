<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StorePromotionRequest;
use App\Http\Requests\Dashboard\UpdatePromotionRequest;
use App\Models\Promotion;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PromotionController extends Controller
{
    private const LOCALES = ['de', 'ar', 'en'];

    private const TRANSLATABLE_FIELDS = [
        'badge',
        'title',
        'subtitle',
        'cta_text',
    ];

    public function index(): Response
    {
        $promotions = Promotion::query()
            ->with('translations')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get()
            ->map(fn (Promotion $promotion) => [
                'id' => $promotion->id,
                'title' => $promotion->translate('de', 'title') ?? 'Aktion',
                'starts_at' => $this->dateTimeValue($promotion->starts_at),
                'ends_at' => $this->dateTimeValue($promotion->ends_at),
                'sort_order' => $promotion->sort_order,
                'is_active' => $promotion->is_active,
                'status' => $this->statusFor($promotion),
            ])
            ->values();

        return Inertia::render('dashboard/promotions/index', [
            'promotions' => $promotions,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('dashboard/promotions/create', [
            'next_sort_order' => $this->nextSortOrder(),
        ]);
    }

    public function store(StorePromotionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data): void {
            $promotion = new Promotion($this->promotionAttributes($data));
            $promotion->save();
            $this->syncTranslations($promotion, $data['translations'] ?? []);
        });

        return to_route('dashboard.promotions.index')
            ->with('toast', ['type' => 'success', 'message' => 'Aktion angelegt.']);
    }

    public function edit(Promotion $promotion): Response
    {
        $promotion->load('translations');

        return Inertia::render('dashboard/promotions/edit', [
            'promotion' => [
                'id' => $promotion->id,
                'starts_at' => $this->dateTimeLocalValue($promotion->starts_at),
                'ends_at' => $this->dateTimeLocalValue($promotion->ends_at),
                'sort_order' => $promotion->sort_order,
                'is_active' => $promotion->is_active,
                'translations' => $this->translationsAsTabs($promotion),
                'title' => $promotion->translate('de', 'title') ?? 'Aktion',
            ],
        ]);
    }

    public function update(UpdatePromotionRequest $request, Promotion $promotion): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($promotion, $data): void {
            $promotion->fill($this->promotionAttributes($data));
            $promotion->save();
            $this->syncTranslations($promotion, $data['translations'] ?? []);
        });

        return to_route('dashboard.promotions.index')
            ->with('toast', ['type' => 'success', 'message' => 'Aktion gespeichert.']);
    }

    public function destroy(Promotion $promotion): RedirectResponse
    {
        DB::transaction(function () use ($promotion): void {
            $promotion->translations()->delete();
            $promotion->delete();
        });

        return to_route('dashboard.promotions.index')
            ->with('toast', ['type' => 'success', 'message' => 'Aktion gelöscht.']);
    }

    /**
     * The next free sort order, suggested as the default when creating a
     * promotion so the unique rule is not tripped on the common case.
     */
    private function nextSortOrder(): int
    {
        $max = Promotion::query()->max('sort_order');

        return $max === null ? 0 : ((int) $max + 1);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function promotionAttributes(array $data): array
    {
        return [
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at' => $data['ends_at'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => (bool) $data['is_active'],
        ];
    }

    /**
     * @param  array<string, array<string, ?string>>  $translations
     */
    private function syncTranslations(Promotion $promotion, array $translations): void
    {
        foreach (self::LOCALES as $locale) {
            $payload = $translations[$locale] ?? [];
            foreach (self::TRANSLATABLE_FIELDS as $field) {
                $value = $payload[$field] ?? null;

                if ($value === null || $value === '') {
                    $promotion->translations()
                        ->where('locale', $locale)
                        ->where('field', $field)
                        ->delete();

                    continue;
                }

                $promotion->setTranslation($locale, $field, $value);
            }
        }
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function translationsAsTabs(Promotion $promotion): array
    {
        $shape = [];

        foreach (self::LOCALES as $locale) {
            $shape[$locale] = [];
            foreach (self::TRANSLATABLE_FIELDS as $field) {
                $shape[$locale][$field] = $promotion->translate($locale, $field) ?? '';
            }
        }

        return $shape;
    }

    private function statusFor(Promotion $promotion): string
    {
        if (! $promotion->is_active) {
            return 'inactive';
        }

        if ($promotion->starts_at && $promotion->starts_at->isFuture()) {
            return 'upcoming';
        }

        if ($promotion->ends_at && $promotion->ends_at->isPast()) {
            return 'expired';
        }

        return 'active';
    }

    private function dateTimeValue(?CarbonInterface $date): ?string
    {
        return $date?->timezone(config('app.timezone'))->format('d.m.Y H:i');
    }

    private function dateTimeLocalValue(?CarbonInterface $date): string
    {
        return $date?->timezone(config('app.timezone'))->format('Y-m-d\TH:i') ?? '';
    }
}
