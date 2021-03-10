<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $service = \App\Models\UserService::inRandomOrder()->first();
        
        $status = get_status();
        return [
            "user_id"         => \App\Models\User::inRandomOrder()->first()->id,
            "client_id"       => \App\Models\Client::inRandomOrder()->first()->id,
            "user_service_id" => $service->id,
            "service_id"      => $service->service_id,
            "status"          => $status[array_rand($status)],
            "price"           => $service->price,
        ];
    }
}
