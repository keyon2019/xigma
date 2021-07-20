<?php

namespace Database\Factories;

use App\Models\Picture;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VariationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Variation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'name' => $this->faker->word,
            'sku' => Str::random(),
            'price' => $this->faker->numberBetween(1000000, 9999999),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Variation $variation) {
            $splash = Picture::factory()->for(Product::factory(), 'picturable')->create(['picturable_id' => $variation->product_id]);
            $variation->update(['splash' => $splash->id]);
        });
    }
}
