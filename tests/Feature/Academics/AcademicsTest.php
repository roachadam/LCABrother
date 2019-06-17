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

    public function test_cannot_import_invalid_file()
    {
        $this->withoutExceptionHandling();
        $this->loginAsAdmin();
        try {
            Excel::import(new GradesImport, 'grades/testFile/gradesTestFail.xlsx');
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

        $response = $this->post('academics/user_id/' . $user->latestAcademics()->id . '/edit');
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

        $response = $this->patch('academics/' . $user->latestAcademics()->id . '/update', $updated_academics);
        $this->assertDatabaseHas('academics', $updated_academics);
    }
}
