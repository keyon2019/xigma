<?php

namespace Database\Factories;

use App\Models\Option;
use App\Models\Value;
use Illuminate\Database\Eloquent\Factories\Factory;

class ValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Value::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'option_id' => Option::factory(),
            'name' => $this->faker->name
        ];
    }
}
