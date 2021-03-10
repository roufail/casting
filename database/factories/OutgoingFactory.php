<?php

namespace Database\Factories;

use App\Models\Outgoing;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutgoingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Outgoing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $order = \App\Models\Order::inRandomOrder()->first();
        $price = $order->price;
        return [
            'order_id'    => $order->id,
            'incoming_id' => \App\Models\Incoming::inRandomOrder()->first()->id,
            'fees'        => 30,
            'total'       => $price - 30,
        ];
    }
}
