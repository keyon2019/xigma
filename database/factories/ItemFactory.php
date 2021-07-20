<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Retailer;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'variation_id' => Variation::factory(),
            'barcode' => Str::random(10)
        ];
    }
}
