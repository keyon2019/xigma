<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'splash' => "images/" . $this->faker->image(public_path('images'), 600, 600, null, false),
            'wide_splash' => "images/" . $this->faker->image(public_path('images'), 1200, 600, null, false),
        ];
    }
}
