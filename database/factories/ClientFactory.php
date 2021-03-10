<?php

namespace Database\Factories;

use App\Models\CLient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CLientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CLient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'country'  => $this->faker->randomElement(arabic_country_array()),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'active'         => $this->faker->boolean
        ];
    }
}
