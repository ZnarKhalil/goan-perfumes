<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StorePromotionRequest;
use App\Http\Requests\Dashboard\UpdatePromotionRequest;
use App\Models\Promotion;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
                'slug' => $promotion->slug,
                'title' => $promotion->translate('de', 'title') ?? $promotion->slug,
                'promo_code' => $promotion->promo_code,
                'discount_percent' => $promotion->discount_percent,
                'starts_at' => $this->dateTimeValue($promotion->starts_at),
                'ends_at' => $this->dateTimeValue($promotion->ends_at),
                'sort_order' => $promotion->sort_order,
                'is_active' => $promotion->is_active,
                'status' => $this->statusFor($promotion),
                'background_image_url' => $promotion->background_image_path
                    ? Storage::url($promotion->background_image_path)
                    : null,
            ])
            ->values();

        return Inertia::render('dashboard/promotions/index', [
            'promotions' => $promotions,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('dashboard/promotions/create');
    }

    public function store(StorePromotionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request): void {
            $promotion = new Promotion($this->promotionAttributes($data));

            if (empty($data['slug'])) {
                $promotion->setSlugSource($data['translations']['de']['title']);
            }

            $promotion->save();
            $this->syncTranslations($promotion, $data['translations'] ?? []);

            if ($request->hasFile('background_image')) {
                $promotion->background_image_path = $request
                    ->file('background_image')
                    ->store('promotions/backgrounds', 'public');
                $promotion->save();
            }
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
                'slug' => $promotion->slug,
                'background_image_url' => $promotion->background_image_path
                    ? Storage::url($promotion->background_image_path)
                    : null,
                'background_color' => $promotion->background_color ?? '',
                'link_url' => $promotion->link_url ?? '',
                'promo_code' => $promotion->promo_code ?? '',
                'discount_percent' => $promotion->discount_percent,
                'starts_at' => $this->dateTimeLocalValue($promotion->starts_at),
                'ends_at' => $this->dateTimeLocalValue($promotion->ends_at),
                'sort_order' => $promotion->sort_order,
                'is_active' => $promotion->is_active,
                'translations' => $this->translationsAsTabs($promotion),
                'title' => $promotion->translate('de', 'title') ?? $promotion->slug,
            ],
        ]);
    }

    public function update(UpdatePromotionRequest $request, Promotion $promotion): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($promotion, $data, $request): void {
            $promotion->fill($this->promotionAttributes($data));

            if (! empty($data['slug'])) {
                $promotion->slug = $data['slug'];
            } elseif (empty($promotion->slug)) {
                $promotion->setSlugSource($data['translations']['de']['title']);
            }

            $promotion->save();
            $this->syncTranslations($promotion, $data['translations'] ?? []);

            if ($request->boolean('remove_background_image') && $promotion->background_image_path) {
                Storage::disk('public')->delete($promotion->background_image_path);
                $promotion->background_image_path = null;
                $promotion->save();
            }

            if ($request->hasFile('background_image')) {
                if ($promotion->background_image_path) {
                    Storage::disk('public')->delete($promotion->background_image_path);
                }

                $promotion->background_image_path = $request
                    ->file('background_image')
                    ->store('promotions/backgrounds', 'public');
                $promotion->save();
            }
        });

        return to_route('dashboard.promotions.index')
            ->with('toast', ['type' => 'success', 'message' => 'Aktion gespeichert.']);
    }

    public function destroy(Promotion $promotion): RedirectResponse
    {
        DB::transaction(function () use ($promotion): void {
            if ($promotion->background_image_path) {
                Storage::disk('public')->delete($promotion->background_image_path);
            }

            $promotion->translations()->delete();
            $promotion->delete();
        });

        return to_route('dashboard.promotions.index')
            ->with('toast', ['type' => 'success', 'message' => 'Aktion gelöscht.']);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function promotionAttributes(array $data): array
    {
        return [
            'slug' => $data['slug'] ?? '',
            'background_color' => $data['background_color'] ?? null,
            'link_url' => $data['link_url'] ?? null,
            'promo_code' => $data['promo_code'] ?? null,
            'discount_percent' => $data['discount_percent'] ?? null,
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
