<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Academics;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GradesImport;
use Illuminate\Http\UploadedFile;

class AcademicsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing getting the academics page
     */
    public function test_can_view_Academics()
    {
        $this->loginAsAdmin();

        $this
            ->withoutExceptionHandling()
            ->get(route('academics.index'))
            ->assertSuccessful()
            ->assertSee('Academics')
            ->assertSee('Override Academic Rules')
            ->assertSee('Manage');
    }

    /**
     * Testing prevention of basic users from accessing the page
     */
    public function test_basic_cannot_view_Academics()
    {
        $this->loginAsBasic();

        $this
            ->withoutExceptionHandling()
            ->get(route('academics.index'))
            ->assertRedirect('/dash');
    }

    /**
     * Testing showing the manage view from the academics page
     */
    public function test_can_view_manage()
    {
        $this->loginAsAdmin();

        $this
            ->withoutExceptionHandling()
            ->get(route('academics.manage'))
            ->assertSuccessful()
            ->assertSee('Add More Grades')
            ->assertSee('Format Rules');
    }

    /**
     * Testing uploading an invalid file (in this case its empty)
     */
    public function test_upload_invalid_file()
    {
        $user = $this->loginAsAdmin();

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post(route('academics.store'), [
                'grades' => new UploadedFile('storage\app\public\grades\testFile\gradesTestFail.xlsx', 'gradesTestFail.xlsx', 'xlsx', null, true),
                'test' => true,
            ])
            ->assertSuccessful()
            ->assertSee('Failed to import new Records: Invalid format');

        $this->assertTrue($user->organization->academics->filter(function ($academic) {
            return $academic['name'] !== null && $academic['Cumulative_GPA'] !== null && $academic['Current_Term_GPA'] !== null;
        })->values()->isEmpty());
    }

    /**
     * Testing uploading a valid file
     */
    public function test_upload_file()
    {
        $user = $this->loginAsAdmin();

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->post(route('academics.store'), [
                'grades' => new UploadedFile('storage\app\public\grades\testFile\gradesTestWorking.xlsx', 'gradesTestWorking.xlsx', 'xlsx', null, true),
                'test' => true,
            ])
            ->assertSuccessful()
            ->assertSee('Successfully imported new academic records!');

        $academics = $user->organization->academics->filter(function ($academic) {
            return $academic['name'] !== null && $academic['Cumulative_GPA'] !== null && $academic['Current_Term_GPA'] !== null;
        })->values();

        $this->assertTrue($academics->isNotEmpty());
        $this->assertTrue($academics->count() === 3);
    }

    /**
     * Testing showing the override view from the academics page
     */
    public function test_can_get_override_view()
    {
        $user = $this->loginAsAdmin();

        $createdAcademics = factory(Academics::class)->create([
            'name' => $user->name,
            'user_id' => $user->id
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get('academics/user_id/' . $createdAcademics->id . '/edit')
            ->assertSuccessful()
            ->assertSee('Override Academics')
            ->assertSee($createdAcademics['name'])
            ->assertSee($createdAcademics['Cumulative_GPA'])
            ->assertSee($createdAcademics['Previous_Term_GPA'])
            ->assertSee($createdAcademics['Current_Term_GPA'])
            ->assertSee($createdAcademics['Previous_Academic_Standing'])
            ->assertSee($createdAcademics['Current_Academic_Standing']);
    }

    /**
     * Testing ability to override a user's academic data
     */
    public function test_can_override_user()
    {
        $user = $this->withoutExceptionHandling()->loginAsAdmin();
        $user->update(['name' => 'Billy Bob']);
        $user->refresh();

        $createdAcademics = factory(Academics::class)->create([
            'name' => $user->name,
            'user_id' => $user->id
        ]);

        $updated_academics = [
            'name' => $user->name,
            'Cumulative_GPA' => $user->latestAcademics()->Cumulative_GPA - 0.5,
            'Previous_Term_GPA' => $user->latestAcademics()->Previous_Term_GPA - 0.5,
            'Current_Term_GPA' => $user->latestAcademics()->Current_Term_GPA - 0.5,
            'Previous_Academic_Standing' => 'test',
            'Current_Academic_Standing' => 'test',
        ];

        $this
            ->followingRedirects()
            ->patch('/user/' . $user->id . '/academics/' . $user->latestAcademics()->id . '/update', $updated_academics)
            ->assertSuccessful()
            ->assertSee(e('Successfully overrode ' . $user->name . '\'s academic records!'));

        $this->assertFalse($this->checkIfAcademicsAreEqual($createdAcademics, $user->latestAcademics()->toArray()));

        $this->assertDatabaseHas('academics', $updated_academics);
    }

    /**
     * Helper function for test_can_override_user() that checks if the academics that the
     * factory created are the same as the updated academics in the database
     *
     * @param array $createdAcademics
     * @param array $updated_academics
     * @return bool
     */
    private function checkIfAcademicsAreEqual($createdAcademics, $latestAcademics): bool
    {
        unset($createdAcademics['id']);
        unset($createdAcademics['organization_id']);
        unset($createdAcademics['user_id']);
        unset($createdAcademics['created_at']);
        unset($createdAcademics['updated_at']);

        return serialize($createdAcademics) === serialize($latestAcademics);
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
