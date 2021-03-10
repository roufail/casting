<?php

namespace Database\Factories;

use App\Models\UserService;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id"         => \App\Models\User::inRandomOrder()->first()->id,
            "service_id"      => \App\Models\Service::inRandomOrder()->first()->id,
            "price"           => $this->faker->numberBetween($min = 1500, $max = 6000),
            "work_type"       => 'hour',
            "category_id"     =>  \App\Models\Category::inRandomOrder()->first()->id,
        ];
    }
}
