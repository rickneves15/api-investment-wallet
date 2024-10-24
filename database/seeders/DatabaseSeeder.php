<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Asset::factory()->count(10)->create();
        Asset::query()->inRandomOrder()->limit(10)->get()
            ->each(function (Asset $asset) {
                Transaction::factory()->count(10)->create(['asset_id' => $asset->id]);
            });
    }
}
