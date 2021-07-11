<?php

namespace Database\Factories;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;

class SliderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Slider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'picture' => "images/" . $this->faker->image(public_path('images'), 1920, 800, null, false),
            'title' => $this->faker->realText(30),
            'sub_title' => $this->faker->realText(40),
            'button_text' => $this->faker->word(),
            'left' => $this->faker->boolean()
        ];
    }
}
