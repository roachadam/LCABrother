<?php

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
            OrganizationsTableSeeder::class,
            UsersTableSeeder::class,
            SemesterTableSeeder::class,
            RolesTableSeeder::class,
            GoalsTableSeeder::class,
            AcademicStandingsTableSeeder::class,
        ]);
    }
}
