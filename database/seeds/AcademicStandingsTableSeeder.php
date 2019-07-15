<?php

use Illuminate\Database\Seeder;

class AcademicStandingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Good 2.5
        factory(App\AcademicStandings::class)->create([
            'id' => 1,
        ]);

        //Probation 1.0
        factory(App\AcademicStandings::class)->create([
            'id' => 2,
            'name' => 'Probation',
            'Term_GPA_Min' => 1.0,
            'Cumulative_GPA_Min' => 1.0,
        ]);

        //Suspension 0
        factory(App\AcademicStandings::class)->create([
            'id' => 3,
            'name' => 'Suspension',
            'Term_GPA_Min' => 0,
            'Cumulative_GPA_Min' => 0,
        ]);
    }
}
