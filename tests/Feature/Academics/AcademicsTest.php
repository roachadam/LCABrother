<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Academics;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GradesImport;

class AcademicsTest extends TestCase
{

    use RefreshDatabase;
    public function test_can_view_Academics()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
        $response = $this->get('/academics');
        $response->assertStatus(200);
    }

    public function test_basic_cannot_view_Academics()
    {
        $this->withoutExceptionHandling();
        $this->loginAsBasic();
        $response = $this->get('/academics');

        $response->assertRedirect('/dash');
        $response->assertStatus(302);
    }

    public function test_can_manage()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        $response = $this->get('/academics/manage');
        $response->assertStatus(200);
    }

    //Does not use the store route directly tries to import the file
    // public function test_can_import_file()
    // {
    //     $this->withoutExceptionHandling();
    //     $this->loginAsAdmin();

    //     try {
    //         Excel::import(new GradesImport, 'grades/testFile/gradesTestWorking.xlsx');
    //         $this->assertTrue(true);
    //     } catch (\ErrorException $e) {
    //         $this->assertFalse($e->getMessage());
    //     }
    // }

    public function test_can_import_file()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();

        try {
            Excel::import(new GradesImport, 'grades/testFile/gradesTestWorking.xlsx');
            $this->assertTrue(true);
        } catch (\ErrorException $e) {
            $this->assertFalse($e->getMessage());
        }
    }


    public function test_cannot_import_improper_formated_file()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
        try {
            Excel::import(new GradesImport, 'grades/testFile/gradesTestFail.xlsx');
            $this->assertFalse('Something is wrong here. This should have failed');
        } catch (\ErrorException $e) {
            $this->assertTrue(true);
        }
    }

    public function test_can_get_override_view()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
        $user = $this->loginAsAdmin();

        factory(Academics::class)->create([
            'name' => $user->name,
            'user_id' => $user->id
        ]);

        $response = $this->get('academics/user_id/' . $user->latestAcademics()->id . '/edit');
        $response->assertStatus(200);
    }

    public function test_can_override_user()
    {
        $this->withoutExceptionHandling();
        $user = $this->loginAsAdmin();

        factory(Academics::class)->create([
            'name' => $user->name,
            'user_id' => $user->id
        ]);

        $updated_academics = [
            'Cumulative_GPA' => $user->latestAcademics()->Cumulative_GPA + 1,
            'Previous_Term_GPA' => $user->latestAcademics()->Previous_Term_GPA + 1,
            'Current_Term_GPA' => $user->latestAcademics()->Current_Term_GPA + 1,
            'Previous_Academic_Standing' => 'test',
            'Current_Academic_Standing' => 'test',
        ];

        $response = $this->patch('/user/' . $user->id . '/academics/' . $user->latestAcademics()->id . '/update', $updated_academics);
        $this->assertDatabaseHas('academics', $updated_academics);
    }



    public function test_basic_update_standing()        //"Basic" is when you upload a new excel file with data that gets updated
    {
        $this->withoutExceptionHandling();
        $user = $this->loginAsAdmin();

        factory(Academics::class)->create([
            'name' => $user->name,
            'user_id' => $user->id,
            'Cumulative_GPA' => 3.2,
            'Previous_Term_GPA' => '',
            'Current_Term_GPA' => 3.0,
            'Previous_Academic_Standing' => '',
            'Current_Academic_Standing' => '',
        ]);


        //Initial standing calculation
        $user->updateStanding();
        $this->assertDatabaseHas('academics', [
            'id' => $user->latestAcademics()->id,
            'Current_Academic_Standing' => 'Good',
        ]);

        //Standing: Good -> Probation
        $this->patch('academics/' . $user->latestAcademics()->id . '/update', [
            'Current_Term_GPA' => 2.2
        ]);
        $user->updateStanding();
        $this->assertDatabaseHas('academics', [
            'id' => $user->latestAcademics()->id,
            'Current_Academic_Standing' => 'Probation',
        ]);


        //Standing: Probation -> Suspension
        $this->patch('academics/' . $user->latestAcademics()->id . '/update', [
            'Current_Term_GPA' => 1.0
        ]);
        $user->updateStanding();
        $this->assertDatabaseHas('academics', [
            'id' => $user->latestAcademics()->id,
            'Current_Academic_Standing' => 'Suspension',
        ]);


        //Standing: Suspension -> Probation
        $this->patch('academics/' . $user->latestAcademics()->id . '/update', [
            'id' => $user->latestAcademics()->id,
            'Current_Term_GPA' => 4.0,
            'Previous_Academic_Standing' => $user->latestAcademics()->Current_Academic_Standing,
        ]);
        $user->updateStanding();
        $this->assertDatabaseHas('academics', [
            'id' => $user->latestAcademics()->id,
            'Current_Academic_Standing' => 'Probation',
        ]);


        //Standing: Probation -> Good
        $this->patch('academics/' . $user->latestAcademics()->id . '/update', [
            'id' => $user->latestAcademics()->id,
            'Current_Term_GPA' => '3.1',
            'Previous_Academic_Standing' => $user->latestAcademics()->Current_Academic_Standing,
        ]);
        $user->updateStanding();
        $this->assertDatabaseHas('academics', [
            'id' => $user->latestAcademics()->id,
            'Current_Academic_Standing' => 'Good',
        ]);


        //Standing: Good -> Suspension
        $this->patch('academics/' . $user->latestAcademics()->id . '/update', [
            'id' => $user->latestAcademics()->id,
            'Current_Term_GPA' => 0.5,
            'Previous_Academic_Standing' => $user->latestAcademics()->Current_Academic_Standing,
        ]);
        $user->updateStanding();
        $this->assertDatabaseHas('academics', [
            'id' => $user->latestAcademics()->id,
            'Current_Academic_Standing' => 'Suspension',
        ]);
    }

    public function test_advanced_update_standing()         //"Advanced" is when you override a user and it has to figure out what you changed and update from there
    {
        //TODO
    }
}
