<?php

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

beforeEach(function () {
    $this->damenparfums = Category::factory()->create(['slug' => 'damenparfums']);
    $this->herrenparfums = Category::factory()->create(['slug' => 'herrenparfums']);

    $familie = Attribute::factory()->multiple()->create(['code' => 'familie']);
    $stimmung = Attribute::factory()->multiple()->create(['code' => 'stimmung']);
    $noten = Attribute::factory()->multiple()->create(['code' => 'noten']);

    $this->blumig = AttributeValue::factory()->for($familie, 'attribute')->create(['slug' => 'blumig']);
    $this->frisch = AttributeValue::factory()->for($stimmung, 'attribute')->create(['slug' => 'frisch']);
    $this->rose = AttributeValue::factory()->for($noten, 'attribute')->create(['slug' => 'rose']);
});

/**
 * Builds a product, attaches it to one or more categories, attaches the given
 * attribute values, and gives it one variant at the given price.
 */
function makeProduct(array $categories, array $values, float $price): Product
{
    $product = Product::factory()->create();
    $product->categories()->sync(collect($categories)->pluck('id')->all());
    $product->attributeValues()->sync(collect($values)->pluck('id')->all());
    ProductVariant::factory()->create(['product_id' => $product->id, 'price' => $price]);

    return $product;
}

test('matches products with all required values in the right category', function () {
    $hit = makeProduct(
        [$this->damenparfums],
        [$this->blumig, $this->frisch, $this->rose],
        49.99,
    );

    // Same values, wrong category.
    makeProduct(
        [$this->herrenparfums],
        [$this->blumig, $this->frisch, $this->rose],
        49.99,
    );

    // Right category, missing one value.
    makeProduct(
        [$this->damenparfums],
        [$this->blumig, $this->frisch],
        49.99,
    );

    // Right category, only one value.
    makeProduct(
        [$this->damenparfums],
        [$this->rose],
        49.99,
    );

    $results = Product::query()
        ->whereHas('categories', fn ($q) => $q->where('slug', 'damenparfums'))
        ->whereHas(
            'attributeValues',
            fn ($q) => $q->whereIn('slug', ['blumig', 'frisch', 'rose']),
            '=',
            3,
        )
        ->get();

    expect($results->pluck('id')->all())->toBe([$hit->id]);
});

test('AND-across-groups still requires the count to match', function () {
    // Has only 2 of the 3 required values — must not match.
    makeProduct(
        [$this->damenparfums],
        [$this->blumig, $this->rose],
        29.99,
    );

    $results = Product::query()
        ->whereHas('categories', fn ($q) => $q->where('slug', 'damenparfums'))
        ->whereHas(
            'attributeValues',
            fn ($q) => $q->whereIn('slug', ['blumig', 'frisch', 'rose']),
            '=',
            3,
        )
        ->get();

    expect($results)->toHaveCount(0);
});

test('orders by minimum variant price ascending', function () {
    $cheap = makeProduct([$this->damenparfums], [$this->blumig, $this->frisch, $this->rose], 19.99);
    $mid = makeProduct([$this->damenparfums], [$this->blumig, $this->frisch, $this->rose], 79.50);
    $pricey = makeProduct([$this->damenparfums], [$this->blumig, $this->frisch, $this->rose], 199.99);

    $results = Product::query()
        ->whereHas('categories', fn ($q) => $q->where('slug', 'damenparfums'))
        ->whereHas(
            'attributeValues',
            fn ($q) => $q->whereIn('slug', ['blumig', 'frisch', 'rose']),
            '=',
            3,
        )
        ->withMin('variants', 'price')
        ->orderBy('variants_min_price')
        ->pluck('id')
        ->all();

    expect($results)->toBe([$cheap->id, $mid->id, $pricey->id]);
});
