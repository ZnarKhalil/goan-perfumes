<?php

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\PageSection;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Promotion;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\AttributeSeeder;
use Database\Seeders\AttributeValueSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PerfumeCatalog;
use Database\Seeders\ProductCatalogSeeder;

test('the perfume catalog seeds products attributes and variants', function () {
    $this->seed([
        CategorySeeder::class,
        AttributeSeeder::class,
        AttributeValueSeeder::class,
        ProductCatalogSeeder::class,
    ]);

    expect(Product::query()->count())->toBe(179);

    $product = Product::query()
        ->with(['attributeValues.attribute', 'categories', 'variants'])
        ->where('slug', 'd1')
        ->sole();

    expect($product->translate('de', 'name'))->toBe('D1')
        ->and($product->translate('de', 'description'))->toBe('Ein kühner Damenduft, der pure Verführung und Weiblichkeit verkörpert. Startet mit intensivem Honig und bleibt warm und langanhaltend.')
        ->and($product->categories->pluck('slug')->all())->toBe(['damenparfums'])
        ->and($product->variants->pluck('size_ml')->all())->toBe([30, 50, 100])
        ->and($product->variants->firstWhere('size_ml', 50)->is_default)->toBeTrue();

    $valueSlugs = $product->attributeValues
        ->map(fn (AttributeValue $value): string => "{$value->attribute->code}.{$value->slug}")
        ->sort()
        ->values()
        ->all();

    expect($valueSlugs)->toContain(
        'art.designer',
        'familie.orientalisch',
        'familie.gourmand',
        'stimmung.anziehend',
        'stimmung.luxurioes',
        'noten.blutorange',
        'noten.gardenie',
        'noten.honig',
        'noten.patchouli',
    );

    $gesalzeneVanille = AttributeValue::query()
        ->where('slug', 'gesalzene-vanille')
        ->whereHas('attribute', fn ($query) => $query->where('code', 'noten'))
        ->sole();

    expect($gesalzeneVanille->translate('de', 'name'))->toBe('Gesalzene Vanille');

    $combinedNoteSlugs = [
        'aprikose-galbanum-himbeere-hyazinthe-jasmin-moschus-pfirsich-rose-sandelholz-ylang-ylang-zedernholz',
        'amber-basilikum-grapefruit-ingwer-kardamom-koriander-orangenbluete-tabak-zedernholz',
        'bulgarische-damaszener-rose-tuerkische-damaszener-rose-absolue-laotisches-oud-vanille-siam-benzoe-veilchen-amber',
    ];
    $catalogNoteSlugs = collect(PerfumeCatalog::attributeValues()['noten'])->pluck('slug');
    $productNoteSlugs = collect(PerfumeCatalog::products())
        ->flatMap(fn (array $product): array => $product['attributes']['noten']);

    expect($catalogNoteSlugs->intersect($combinedNoteSlugs)->all())->toBe([])
        ->and($productNoteSlugs->intersect($combinedNoteSlugs)->all())->toBe([]);

    expect(
        AttributeValue::query()
            ->whereHas('attribute', fn ($query) => $query->where('code', 'noten'))
            ->whereIn('slug', [
                'aprikose',
                'galbanum',
                'hyazinthe',
                'ylang-ylang',
                'basilikum',
                'grapefruit',
                'koriander',
                'bulgarische-damaszener-rose',
                'tuerkische-damaszener-rose-absolue',
                'laotisches-oud',
                'siam-benzoe',
                'veilchen',
            ])
            ->count(),
    )->toBe(12);

    $orientalischCount = AttributeValue::query()
        ->where('slug', 'orientalisch')
        ->whereHas('attribute', fn ($query) => $query->where('code', 'familie'))
        ->count();

    expect($orientalischCount)->toBe(1);

    $luxuryProduct = Product::query()
        ->with('variants')
        ->where('slug', 'lu15')
        ->sole();

    expect($luxuryProduct->categories()->pluck('slug')->sort()->values()->all())
        ->toBe(['luxusparfums', 'unisex-parfums'])
        ->and($luxuryProduct->variants)->toHaveCount(1)
        ->and($luxuryProduct->variants->sole()->size_ml)->toBe(50)
        ->and($luxuryProduct->variants->sole()->price)->toBe('40.00')
        ->and($luxuryProduct->variants->sole()->is_default)->toBeTrue();
});

test('database seeder keeps catalog data fixed page sections users and settings', function () {
    $user = User::factory()->create(['email' => 'keep@example.test']);
    Setting::put('custom_key', 'keep');

    $staleCategory = Category::factory()->create(['slug' => 'manual-category']);
    $staleCategory->setTranslation('de', 'name', 'Manual Category');
    $staleCategory->media()->create([
        'path' => 'manual/category.jpg',
        'sort_order' => 0,
        'is_primary' => true,
    ]);

    $staleProduct = Product::factory()->create(['slug' => 'manual-product']);
    $staleProduct->setTranslation('de', 'name', 'Manual Product');
    ProductVariant::factory()->for($staleProduct)->create(['size_ml' => 250]);
    $staleProduct->media()->create([
        'path' => 'manual/product.jpg',
        'sort_order' => 0,
        'is_primary' => true,
    ]);

    $staleAttribute = Attribute::factory()->create(['code' => 'manual']);
    AttributeValue::factory()->for($staleAttribute, 'attribute')->create(['slug' => 'manual-value']);
    PageSection::query()->create([
        'key' => 'manual',
        'type' => 'text',
        'payload' => [],
        'sort_order' => 0,
        'is_active' => true,
    ])->setTranslation('de', 'title', 'Manual Section');
    Promotion::factory()->create()->setTranslation('de', 'title', 'Manual Promotion');

    $this->seed(DatabaseSeeder::class);

    expect(User::query()->whereKey($user->id)->exists())->toBeTrue()
        ->and(Setting::get('custom_key'))->toBe('keep')
        ->and(Product::query()->where('slug', 'manual-product')->exists())->toBeFalse()
        ->and(Category::query()->where('slug', 'manual-category')->exists())->toBeFalse()
        ->and(Attribute::query()->where('code', 'manual')->exists())->toBeFalse()
        ->and(PageSection::query()->count())->toBe(3)
        ->and(PageSection::query()->where('key', 'manual')->exists())->toBeFalse()
        ->and(PageSection::query()->where('key', 'hero')->firstOrFail()->translate('de', 'title'))
        ->toBe('Parfums gezielt entdecken, persönlich beraten lassen.')
        ->and(Promotion::query()->count())->toBe(0)
        ->and(Product::query()->count())->toBe(179)
        ->and(Category::query()->count())->toBe(count(PerfumeCatalog::categories()))
        ->and(AttributeValue::query()->count())->toBe(
            collect(PerfumeCatalog::attributeValues())->sum(fn (array $values): int => count($values)),
        );
});
