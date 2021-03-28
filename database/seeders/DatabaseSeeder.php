<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            ClientSeeder::class,
            UserServiceSeeder::class,
            OrderSeeder::class,
            IncomingSeeder::class,
            OutgoingSeeder::class,
            RateSeeder::class,
        ]);    
    }
}
