<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incoming;
class IncomingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Incoming::factory(1000)->create();   
    }
}
