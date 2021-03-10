<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category = \App\Models\Category::inRandomOrder()->first();
        return [
            'title'          => $this->faker->name,
            'description'    => $this->faker->paragraph(3),
            'active'         => $this->faker->boolean,
            'category_id'    => $category->id
        ];
    }
}
