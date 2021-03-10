<?php

namespace Database\Factories;

use App\Models\Incoming;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncomingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Incoming::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id'       => \App\Models\User::inRandomOrder()->first()->id,
            'received'       => $this->faker->boolean,
            'delivered'      => $this->faker->boolean,
            'delivered_date' => $this->faker->date,
        ];
    }
}
