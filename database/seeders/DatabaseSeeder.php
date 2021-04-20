<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->hasVariations(1)->count(20)->create();
        Option::factory()->hasValues(3)->count(10)->create();
        // \App\Models\User::factory(10)->create();
    }
}
