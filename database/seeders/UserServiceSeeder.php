<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserService;

class UserServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserService::factory(1000)->create();   
    }
}
