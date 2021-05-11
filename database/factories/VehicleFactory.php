<?php

namespace Database\Factories;

use App\Models\Picture;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

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
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Vehicle $vehicle) {
            $splash = Picture::factory()->for(Vehicle::factory(), 'picturable')->create(['picturable_id' => $vehicle->id]);
            $vehicle->update(['splash' => $splash->id]);
        });
    }
}
