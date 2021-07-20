<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\Option;
use App\Models\Product;
use App\Models\Retailer;
use App\Models\Slider;
use App\Models\User;
use App\Models\Vehicle;
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
        User::create([
            'name' => 'admin',
            'email' => "admin@xigma.ir",
            'password' => bcrypt('admin@123456'),
            'is_admin' => true
        ]);
        if (config('app.env') == 'local') {
            Product::factory()->hasVariations(1)->count(15)->create();
            Option::factory()->hasValues(3)->count(6)->create();
            Category::factory()->count(10)->create();
            Vehicle::factory()->count(5)->create();
            Item::factory()->count(5)->create();
            Slider::factory()->count(3)->create();
            Retailer::factory()->count(2)->create();
        }
    }
}
