<?php

namespace Database\Factories;

use App\Models\Picture;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'price' => $this->faker->numberBetween(1000000, 9999999),
            'delivery_cost' => $this->faker->numberBetween(20000,40000)
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $splash = Picture::factory()->for(Product::factory(), 'picturable')->create(['picturable_id' => $product->id]);
            $product->update(['splash' => $splash->id]);
        });
    }
}
