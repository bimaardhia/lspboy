<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_name' => $this->faker->words(2, true),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'price' => $this->faker->numberBetween(5000, 20000),
            'stock' => $this->faker->numberBetween(10, 100),
        ];
    }
}