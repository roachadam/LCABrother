<?php

use Illuminate\Database\Seeder;
use App\Organization;
class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Organization::class, 10)->create();
    }
}
