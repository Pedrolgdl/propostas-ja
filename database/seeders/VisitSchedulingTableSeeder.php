<?php

namespace Database\Seeders;

use App\Models\VisitScheduling;
use Illuminate\Database\Seeder;

class VisitSchedulingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VisitScheduling::factory()->count(40)->create();
    }
}
