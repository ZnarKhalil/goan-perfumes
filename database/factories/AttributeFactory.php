<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => Str::lower(Str::random(8)),
            'sort_order' => 0,
            'is_filterable' => true,
            'is_multiple' => true,
        ];
    }

    public function single(): static
    {
        return $this->state(fn () => ['is_multiple' => false]);
    }

    public function multiple(): static
    {
        return $this->state(fn () => ['is_multiple' => true]);
    }
}
