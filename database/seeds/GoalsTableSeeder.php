<?php

use Illuminate\Database\Seeder;
use App\Goals;

class GoalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Goals::class)->create([
            'points_goal' => 12,
            'study_goal' => 12,
            'service_hours_goal' => 12,
            'service_money_goal' => 12,
        ]);
    }
}
