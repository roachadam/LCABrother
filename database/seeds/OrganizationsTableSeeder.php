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
        factory(Organization::class)->create([
            'id' => 1,
            'name' => 'Lambda Chi Alpha',
            'owner_id' => 1
        ]);
    }
}
