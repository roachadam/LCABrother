<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use App\AcademicStandings;
use Tests\TestCase;
use App\Academics;

class AcademicsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * * AcademicsController@index
     * Testing to ensure a basic user cannot view the academics page
     */
    public function test_basic_user_cannot_view_Academics()
    {
        $this->loginAs('basic_user');
        $this
            ->withoutExceptionHandling()
            ->get(route('academics.index'))
            ->assertRedirect('/dash');
    }

    /**
     * * AcademicsController@index
     * Testing if the Academics Manager can view the academics page
     */
    public function test_academics_manager_can_view_Academics()
    {
        $this->loginAs('academics_manager');

        $this
            ->withoutExceptionHandling()
            ->get(route('academics.index'))
            ->assertSuccessful()
            ->assertSee('Academics')
            ->assertSee('Academic Standing Rules')
            ->assertSee('Manage');
    }

    /**
     * * AcademicsController@manage
     * Testing to ensure a basic user cannot view the manage page
     */
    public function test_basic_user_cannot_view_manage()
    {
        $this->loginAs('basic_user');

        $this
            ->withoutExceptionHandling()
            ->get(route('academics.manage'))
            ->assertRedirect('/dash');
    }

    /**
     * * AcademicsController@manage
     * Testing if the Academics Manager can view the manage page
     */
    public function test_academics_manager_can_view_manage()
    {
        $this->loginAs('academics_manager');

        $this
            ->withoutExceptionHandling()
            ->get(route('academics.manage'))
            ->assertSuccessful()
            ->assertSee('Add More Grades')
            ->assertSee('Format Rules');
    }

    /**
     * * AcademicsController@store
     * Testing uploading an invalid file (in this case its empty)
     */
    public function test_upload_invalid_file()
    {
        $user = $this->loginAs('academics_manager');

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
     * * AcademicsController@store
     * Testing uploading a valid file
     */
    public function test_upload_file()
    {
        $user = $this->loginAs('academics_manager');

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

        $this->assertTrue($academics->isNotEmpty() && $academics->count() === 3);
    }

    /**
     * * AcademicsController@edit
     * Testing to ensure a basic user cannot view the edit page
     */
    public function test_basic_user_cannot_get_override_view()
    {
        $user = $this->loginAs('basic_user');

        $createdAcademics = factory(Academics::class)->create([
            'name' => $user->name,
            'user_id' => $user->id
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('academics.edit', $createdAcademics))
            ->assertSuccessful()
            ->assertDontSee('Override Academics')
            ->assertDontSee($createdAcademics['name']);
    }

    /**
     * * AcademicsController@edit
     * Testing showing the override view from the academics page
     */
    public function test_can_get_override_view()
    {
        $user = $this->loginAs('academics_manager');

        $createdAcademics = factory(Academics::class)->create([
            'name' => $user->name,
            'user_id' => $user->id
        ]);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('academics.edit', $createdAcademics))
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
     * * AcademicsController@update
     * Testing ability to override a user's academic data
     */
    public function test_can_override_user()
    {
        $user = $this->withoutExceptionHandling()->loginAs('academics_manager');
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

        $this->assertFalse($this->checkIfAcademicsAreEqual($createdAcademics->toArray(), $user->latestAcademics()->toArray()));

        $this->assertTrue($this->checkIfAcademicsAreEqual($updated_academics, $user->latestAcademics()->toArray()));

        $this->assertDatabaseHas('academics', $updated_academics);
    }

    /**
     * Helper function for test_can_override_user() that checks if the arrays passed
     * are equal
     *
     * @param array $createdAcademics
     * @param array $updated_academics
     * @return bool
     */
    private function checkIfAcademicsAreEqual($academics, $latestAcademics): bool
    {
        $academicsSize = count($academics);
        $latestAcademicsSize = count($latestAcademics);

        $size = ($academicsSize <= $latestAcademicsSize) ? $academicsSize : $latestAcademicsSize;

        return count(array_intersect($academics, $latestAcademics)) === $size;
    }

    /**
     *
     */
    public function test_basic_update_standing()        //"Basic" is when you upload a new excel file with data that gets updated
    {
        $this->withoutExceptionHandling();
        $user = $this->loginAs('academics_manager');

        //Good 2.5
        factory(AcademicStandings::class)->create([
            'id' => 1,
            'organization_id' => $user->organization_id
        ]);

        //Probation 1.0
        factory(AcademicStandings::class)->create([
            'id' => 2,
            'organization_id' => $user->organization_id,
            'name' => 'Probation',
            'Term_GPA_Min' => 1.0,
            'Cumulative_GPA_Min' => 1.0,
        ]);

        //Suspension 0
        factory(AcademicStandings::class)->create([
            'id' => 3,
            'organization_id' => $user->organization_id,
            'name' => 'Suspension',
            'Term_GPA_Min' => 0,
            'Cumulative_GPA_Min' => 0,
        ]);

        factory(Academics::class)->create([
            'organization_id' => $user->organization_id,
            'name' => $user->name,
            'user_id' => $user->id,
            'Cumulative_GPA' => 3.2,
            'Previous_Term_GPA' => '',
            'Current_Term_GPA' => 4.0,
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
        $this->patch('user/' . $user->id . '/academics/' . $user->latestAcademics()->id . '/update', [
            'Current_Term_GPA' => 2.5
        ]);
        $user->updateStanding();
        $this->assertDatabaseHas('academics', [
            'id' => $user->latestAcademics()->id,
            'Current_Academic_Standing' => 'Probation',
        ]);

        //Standing: Probation -> Suspension
        $this->patch('user/' . $user->id . '/academics/' . $user->latestAcademics()->id . '/update', [
            'Current_Term_GPA' => 1.0
        ]);
        $user->updateStanding();
        $this->assertDatabaseHas('academics', [
            'id' => $user->latestAcademics()->id,
            'Current_Academic_Standing' => 'Suspension',
        ]);

        //Standing: Suspension -> Probation
        $this->patch('user/' . $user->id . '/academics/' . $user->latestAcademics()->id . '/update', [
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
        $this->patch('user/' . $user->id . '/academics/' . $user->latestAcademics()->id . '/update', [
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
        $this->patch('user/' . $user->id . '/academics/' . $user->latestAcademics()->id . '/update', [
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

    // public function test_advanced_update_standing()         //"Advanced" is when you override a user and it has to figure out what you changed and update from there
    // {
    //     //TODO
    // }
}
