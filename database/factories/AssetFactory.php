<?php

namespace Database\Factories;

use App\Enums\AssetTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AssetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'purchase_date' => $this->faker->date(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'quote' => $this->faker->numberBetween(1, 10),
            'type' => $this->faker->randomElement(AssetTypeEnum::cases()),
        ];
    }
}
