<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        $total = $this->faker->numberBetween(10000, 500000);
        $paid = $total + $this->faker->numberBetween(0, 10000);
        return [
            'total' => $total,
            'paid_amount' => $paid,
            'change' => $paid - $total,
            'created_at' => now()->subDays(rand(0, 6))->setTime(rand(8, 20), rand(0, 59)),
            'updated_at' => now()
        ];
    }
}