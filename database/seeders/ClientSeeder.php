<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class CLientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::factory(1000)->create();   
    }
}
