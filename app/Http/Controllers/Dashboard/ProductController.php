<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreProductRequest;
use App\Http\Requests\Dashboard\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Translation;
use App\Services\MediaService;
use App\Support\Price;
use App\Support\PublicLocale;
use App\Support\StorageUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    private const MAX_FEATURED_PRODUCTS = 4;

    private const PRODUCTS_PER_PAGE = 25;

    private const TRANSLATABLE_FIELDS = [
        'name',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
    ];

    private const SORTABLE_COLUMNS = ['name', 'brand', 'price', 'variants', 'created'];

    public function __construct(private readonly MediaService $mediaService) {}

    public function index(Request $request): Response
    {
        $filters = $this->resolveFilters($request);

        $products = Product::query()
            ->with(['translations', 'categories.translations', 'primaryMedia'])
            ->withMin('variants', 'price')
            ->withMax('variants', 'price')
            ->withCount('variants')
            ->addSelect(['de_name' => Translation::query()
                ->select('value')
                ->whereColumn('translatable_id', 'products.id')
                ->where('translatable_type', Product::class)
                ->where('locale', 'de')
                ->where('field', 'name')
                ->limit(1)])
            ->when(filled($filters['name']), fn ($query) => $query
                ->whereHas('translations', fn ($translation) => $translation
                    ->where('field', 'name')
                    ->whereRaw('LOWER(value) LIKE ?', ['%'.Str::lower($filters['name']).'%'])))
            ->when(filled($filters['brand']), fn ($query) => $query
                ->whereRaw('LOWER(brand) LIKE ?', ['%'.Str::lower($filters['brand']).'%']))
            ->when($filters['category'] !== null, fn ($query) => $query
                ->whereHas('categories', fn ($category) => $category
                    ->whereKey($filters['category'])))
            ->when($filters['status'] !== null, fn ($query) => $query
                ->where('is_active', $filters['status'] === 'active'))
            ->when($filters['featured'] !== null, fn ($query) => $query
                ->where('is_featured', $filters['featured'] === 'yes'))
            ->tap(fn ($query) => $this->applySort($query, $filters['sort'], $filters['direction']))
            ->paginate(self::PRODUCTS_PER_PAGE)
            ->withQueryString();

        return Inertia::render('dashboard/products/index', [
            'filters' => $filters,
            'categories' => $this->categoryOptions(),
            'products' => $products
                ->getCollection()
                ->map(fn (Product $product) => [
                    'id' => $product->id,
                    'slug' => $product->slug,
                    'name' => $product->translate('de', 'name') ?? $product->slug,
                    'brand' => $product->brand,
                    'categories' => $product->categories
                        ->map(fn (Category $category) => $category->translate('de', 'name') ?? $category->slug)
                        ->values()
                        ->all(),
                    'min_price' => Price::decimal($product->variants_min_price),
                    'max_price' => Price::decimal($product->variants_max_price),
                    'variants_count' => $product->variants_count,
                    'is_active' => $product->is_active,
                    'is_featured' => $product->is_featured,
                    'image_url' => StorageUrl::for($product->primaryMedia?->path),
                ])
                ->values()
                ->all(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
                'links' => $products->linkCollection()->all(),
            ],
        ]);
    }

    /**
     * @return array{name: string, brand: string, category: ?int, status: ?string, featured: ?string, sort: string, direction: string}
     */
    private function resolveFilters(Request $request): array
    {
        $status = $request->string('status')->toString();
        $featured = $request->string('featured')->toString();
        $sort = $request->string('sort')->toString();
        $direction = $request->string('direction')->lower()->toString();
        $category = $request->integer('category');

        return [
            'name' => $request->string('name')->trim()->toString(),
            'brand' => $request->string('brand')->trim()->toString(),
            'category' => $category > 0 ? $category : null,
            'status' => in_array($status, ['active', 'inactive'], true) ? $status : null,
            'featured' => in_array($featured, ['yes', 'no'], true) ? $featured : null,
            'sort' => in_array($sort, self::SORTABLE_COLUMNS, true) ? $sort : 'created',
            'direction' => $direction === 'asc' ? 'asc' : 'desc',
        ];
    }

    /**
     * @param  Builder<Product>  $query
     */
    private function applySort(Builder $query, string $sort, string $direction): void
    {
        match ($sort) {
            'name' => $query->orderBy('de_name', $direction)->orderByDesc('id'),
            'brand' => $query->orderBy('brand', $direction)->orderByDesc('id'),
            'price' => $query->orderBy('variants_min_price', $direction)->orderByDesc('id'),
            'variants' => $query->orderBy('variants_count', $direction)->orderByDesc('id'),
            default => $query->orderBy('id', $direction),
        };
    }

    public function create(): Response
    {
        return Inertia::render('dashboard/products/create', [
            'categories' => $this->categoryOptions(),
            'attributes' => $this->attributeGroups(),
            'highlightSlots' => $this->highlightSlots(),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request): void {
            if ((bool) $data['is_featured']) {
                $this->assertFeaturedSlotAvailable();
            }

            $product = new Product([
                'slug' => '',
                'brand' => $data['brand'] ?? null,
                'is_active' => (bool) $data['is_active'],
                'is_featured' => (bool) $data['is_featured'],
            ]);

            $product->setSlugSource($data['translations']['de']['name']);
            $product->save();

            $this->syncTranslations($product, $data['translations'] ?? []);
            $product->categories()->sync($data['categories']);
            $product->attributeValues()->sync($this->uniqueIds($data['attribute_values'] ?? []));
            $this->syncVariants($product, $data['variants']);
            $this->mediaService->syncFromRequest(
                $product,
                $request->file('media_uploads', []),
                $data['media_meta'] ?? [],
            );
        });

        return to_route('dashboard.products.index')
            ->with('toast', ['type' => 'success', 'message' => 'Produkt angelegt.']);
    }

    public function edit(Product $product): Response
    {
        $product->load([
            'translations',
            'categories',
            'attributeValues',
            'variants' => fn ($query) => $query->orderBy('size_ml')->orderBy('id'),
            'media' => fn ($query) => $query
                ->with('translations')
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        return Inertia::render('dashboard/products/edit', [
            'product' => [
                'id' => $product->id,
                'slug' => $product->slug,
                'brand' => $product->brand,
                'is_active' => $product->is_active,
                'is_featured' => $product->is_featured,
                'translations' => $this->translationsAsTabs($product),
                'categories' => $product->categories->pluck('id')->values()->all(),
                'attribute_values' => $product->attributeValues->pluck('id')->values()->all(),
                'variants' => $product->variants
                    ->map(fn (ProductVariant $variant) => [
                        'id' => $variant->id,
                        'size_ml' => $variant->size_ml,
                        'price' => $variant->price,
                        'compare_at_price' => $variant->compare_at_price ?? '',
                        'is_default' => $variant->is_default,
                        'is_active' => $variant->is_active,
                    ])
                    ->values()
                    ->all(),
                'media' => $product->media
                    ->map(fn (Media $media) => [
                        'id' => $media->id,
                        'url' => StorageUrl::for($media->path),
                        'sort_order' => $media->sort_order,
                        'is_primary' => $media->is_primary,
                        'alt_text' => $media->translate('de', 'alt_text') ?? $media->alt_text ?? '',
                        'alt_text_translations' => [
                            'de' => $media->translate('de', 'alt_text') ?? '',
                            'ar' => $media->translate('ar', 'alt_text') ?? '',
                            'en' => $media->translate('en', 'alt_text') ?? '',
                        ],
                    ])
                    ->values()
                    ->all(),
            ],
            'categories' => $this->categoryOptions(),
            'attributes' => $this->attributeGroups(),
            'highlightSlots' => $this->highlightSlots($product),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($product, $data, $request): void {
            if ((bool) $data['is_featured']) {
                $this->assertFeaturedSlotAvailable($product);
            }

            $product->fill([
                'brand' => $data['brand'] ?? null,
                'is_active' => (bool) $data['is_active'],
                'is_featured' => (bool) $data['is_featured'],
            ]);

            $product->save();

            $this->syncTranslations($product, $data['translations'] ?? []);
            $product->categories()->sync($data['categories']);
            $product->attributeValues()->sync($this->uniqueIds($data['attribute_values'] ?? []));
            $this->syncVariants($product, $data['variants']);
            $this->mediaService->syncFromRequest(
                $product,
                $request->file('media_uploads', []),
                $data['media_meta'] ?? [],
            );
        });

        return to_route('dashboard.products.index')
            ->with('toast', ['type' => 'success', 'message' => 'Produkt gespeichert.']);
    }

    public function destroy(Product $product): RedirectResponse
    {
        DB::transaction(function () use ($product): void {
            $product->load('media.translations');
            $mediaPaths = $product->media->pluck('path')->all();

            foreach ($product->media as $media) {
                $media->translations()->delete();
                $media->delete();
            }

            $product->translations()->delete();
            $product->delete();

            DB::afterCommit(fn () => Storage::disk('public')->delete($mediaPaths));
        });

        return to_route('dashboard.products.index')
            ->with('toast', ['type' => 'success', 'message' => 'Produkt gelöscht.']);
    }

    /**
     * @return array<int, array{id: int, name: string}>
     */
    private function categoryOptions(): array
    {
        return Category::query()
            ->with('translations')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (Category $category) => [
                'id' => $category->id,
                'name' => $category->translate('de', 'name') ?? $category->slug,
            ])
            ->values()
            ->all();
    }

    /**
     * Guard the homepage highlight limit inside the write transaction. The
     * locked count keeps two concurrent saves from both claiming the last
     * free slot.
     *
     * @throws ValidationException
     */
    private function assertFeaturedSlotAvailable(?Product $product = null): void
    {
        $used = Product::query()
            ->where('is_featured', true)
            ->when(
                $product instanceof Product,
                fn ($query) => $query->whereKeyNot($product->id),
            )
            ->lockForUpdate()
            ->pluck('id')
            ->count();

        if ($used >= self::MAX_FEATURED_PRODUCTS) {
            throw ValidationException::withMessages([
                'is_featured' => 'Es sind bereits 4 Highlights ausgewählt. Entferne zuerst ein Highlight, um ein neues hinzuzufügen.',
            ]);
        }
    }

    /**
     * @return array{max: int, used: int, remaining: int}
     */
    private function highlightSlots(?Product $product = null): array
    {
        $used = Product::query()
            ->where('is_featured', true)
            ->when(
                $product instanceof Product,
                fn ($query) => $query->whereKeyNot($product->id),
            )
            ->count();

        return [
            'max' => self::MAX_FEATURED_PRODUCTS,
            'used' => $used,
            'remaining' => max(0, self::MAX_FEATURED_PRODUCTS - $used),
        ];
    }

    /**
     * @return array<int, array{id: int, code: string, name: string, is_multiple: bool, values: array<int, array{id: int, name: string, slug: string, is_active: bool}>}>
     */
    private function attributeGroups(): array
    {
        return Attribute::query()
            ->with([
                'translations',
                'values' => fn ($query) => $query
                    ->with('translations')
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('id'),
            ])
            ->where('is_filterable', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (Attribute $attribute) => [
                'id' => $attribute->id,
                'code' => $attribute->code,
                'name' => $attribute->translate('de', 'name') ?? $attribute->code,
                'is_multiple' => $attribute->is_multiple,
                'values' => $attribute->values
                    ->map(fn (AttributeValue $value) => [
                        'id' => $value->id,
                        'name' => $value->translate('de', 'name') ?? $value->slug,
                        'slug' => $value->slug,
                        'is_active' => $value->is_active,
                    ])
                    ->values()
                    ->all(),
            ])
            ->values()
            ->all();
    }

    /**
     * @param  array<string, array<string, ?string>>  $translations
     */
    private function syncTranslations(Product $product, array $translations): void
    {
        $payloads = [];
        foreach (PublicLocale::codes() as $locale) {
            $payloads[$locale] = $this->withDerivedSeoTranslations($translations[$locale] ?? []);
        }

        $product->syncTranslations($payloads, self::TRANSLATABLE_FIELDS);
    }

    /**
     * @param  array<string, ?string>  $payload
     * @return array<string, ?string>
     */
    private function withDerivedSeoTranslations(array $payload): array
    {
        $name = $payload['name'] ?? null;
        $shortDescription = $payload['short_description'] ?? null;
        $description = $payload['description'] ?? null;
        $metaDescription = filled($shortDescription) ? $shortDescription : $description;

        return [
            ...$payload,
            'meta_title' => filled($name) ? $name : null,
            'meta_description' => filled($metaDescription)
                ? Str::limit(Str::squish(strip_tags((string) $metaDescription)), 500, '')
                : null,
        ];
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function translationsAsTabs(Product $product): array
    {
        $shape = [];
        foreach (PublicLocale::codes() as $locale) {
            $shape[$locale] = [];
            foreach (self::TRANSLATABLE_FIELDS as $field) {
                $shape[$locale][$field] = $product->translate($locale, $field) ?? '';
            }
        }

        return $shape;
    }

    /**
     * @param  array<int, mixed>  $ids
     * @return array<int, int>
     */
    private function uniqueIds(array $ids): array
    {
        return collect($ids)
            ->filter()
            ->map(fn (mixed $id) => (int) $id)
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @param  array<int, array<string, mixed>>  $variants
     */
    private function syncVariants(Product $product, array $variants): void
    {
        $keptIds = [];

        foreach ($variants as $variantData) {
            $variant = isset($variantData['id'])
                ? $product->variants()->whereKey($variantData['id'])->first()
                : null;

            $variant ??= new ProductVariant(['product_id' => $product->id]);
            $variant->fill([
                'size_ml' => $variantData['size_ml'],
                'price' => $variantData['price'],
                'compare_at_price' => $variantData['compare_at_price'] ?? null,
                'is_default' => (bool) $variantData['is_default'],
                'is_active' => (bool) $variantData['is_active'],
            ]);
            $variant->product()->associate($product);
            $variant->save();

            $keptIds[] = $variant->id;
        }

        $product->variants()
            ->whereNotIn('id', $keptIds)
            ->delete();
    }
}
