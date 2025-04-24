<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionDetailFactory extends Factory
{
    public function definition(): array
    {
        $qty = $this->faker->numberBetween(1, 5);
        $price = $this->faker->numberBetween(1000, 100000);
        return [
            'item_id' => $this->faker->numberBetween(1, 20),
            'item_name' => $this->faker->words(2, true),
            'quantity' => $qty,
            'price' => $price,
            'subtotal' => $qty * $price,
        ];
    }
}