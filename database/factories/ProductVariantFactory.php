<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'size_ml' => fake()->randomElement([30, 50, 100]),
            'price' => fake()->randomFloat(2, 19.99, 199.99),
            'compare_at_price' => null,
            'is_default' => false,
            'is_active' => true,
        ];
    }

    public function default(): static
    {
        return $this->state(fn () => ['is_default' => true]);
    }

    public function size(int $ml): static
    {
        return $this->state(fn () => ['size_ml' => $ml]);
    }
}
