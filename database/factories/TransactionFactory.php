<?php

namespace Database\Factories;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(TransactionTypeEnum::cases()),
            'quantity' => $this->faker->numberBetween(1, 10),
            'unit_price' => $this->faker->randomFloat(2, 1, 1000),
            'transaction_date' => $this->faker->date(),
        ];
    }
}
