<?php

namespace Database\Factories;

use App\Models\Rate;
use Illuminate\Database\Eloquent\Factories\Factory;

class RateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $order = \App\Models\Order::inRandomOrder()->first();

        return [
            'service_id'      => $order->service_id,
            'user_service_id' => $order->user_service_id,
            'client_id'       => $order->client_id,
            'user_id'         => $order->user_id,
            'rate'            => rand(1,5),
            'feedback'        => $this->faker->paragraph(3),
        ];
    }
}
