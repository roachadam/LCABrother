<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\AcademicStandings;
use Tests\TestCase;

class AcademicStandingsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * AcademicStandingsController@index
     * Testing to ensure a basic user cannot view the academics standing page
     */
    public function test_basic_user_cannot_view_academics_standings()
    {
        $this->loginAs('basic_user');

        $this
            ->withoutExceptionHandling()
            ->get(route('academicStandings.index'))
            ->assertRedirect('/dash');
    }

    /**
     * * AcademicStandingsController@index
     * Testing if the academics manager can view the academics standing page
     */
    public function test_academics_manager_can_view_academics_standings()
    {
        $this->loginAs('academics_manager');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('academicStandings.index'))
            ->assertSuccessful()
            ->assertSee('Academic Standing Rules')
            ->assertSee('Add Standing Rule');
    }

    /**
     * * AcademicStandingsController@store
     * Testing if the academics manager can add new academic standing rules
     */
    public function test_create_new_academic_standings()
    {
        $user = $this->loginAs('academics_manager');

        $createdStanding = factory(AcademicStandings::class)->raw();

        unset($createdStanding['id']);
        unset($createdStanding['organization_id']);
        unset($createdStanding['lowest']);
        unset($createdStanding['created_at']);
        unset($createdStanding['updated_at']);

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('academicStandings.index'))
            ->post(route('academicStandings.store'), $createdStanding)
            ->assertSuccessful()
            ->assertSee('Successfully Created New Rule!')
            ->assertSee('Academic Standing Rules')
            ->assertSee($createdStanding['name'])
            ->assertSee($createdStanding['Term_GPA_Min'])
            ->assertSee($createdStanding['Cumulative_GPA_Min']);

        $createdStanding['organization_id'] = $user->organization_id;

        $this->assertDatabaseHas('academic_standings', $createdStanding);
    }

    /**
     * * AcademicStandingsController@edit
     * Testing if the academics manager can add view the edit academic log page
     */
    public function test_can_get_edit_academic_standing()
    {
        $user = $this->loginAs('academics_manager');
        $createdStanding = factory(AcademicStandings::class)->create(['organization_id' => $user->organization_id]);

        $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->from(route('academicStandings.index'))
            ->get(route('academicStandings.edit', $createdStanding))
            ->assertSuccessful()
            ->assertSee('Override Academic Standing Rules')
            ->assertSee($createdStanding->name)
            ->assertSee($createdStanding->Term_GPA_Min)
            ->assertSee($createdStanding->Cumulative_GPA_Min);
    }

    /**
     * * AcademicStandingsController@update
     * Testing if the academics manager can edit academic standing rules with valid values
     */
    public function test_can_edit_academic_standing_both_valid_values()
    {
        $user = $this->loginAs('academics_manager');
        $createdStanding = factory(AcademicStandings::class)->create(['organization_id' => $user->organization_id]);

        $changedTermGPA = $createdStanding->Term_GPA_Min + 0.5;
        $changedCum = $createdStanding->Cumulative_GPA_Min + 0.5;

        $this
            ->withExceptionHandling()
            ->followingRedirects()
            ->from(route('academicStandings.edit', $createdStanding))
            ->patch(route('academicStandings.update', $createdStanding), [
                'name' => $createdStanding->name,
                'Term_GPA_Min' => $changedTermGPA,
                'Cumulative_GPA_Min' => $changedCum,
            ])
            ->assertSuccessful()
            ->assertSee('Successfully Updated Standing Rule!')
            ->assertSee($changedTermGPA)
            ->assertSee($changedCum);

        $this->assertDatabaseHas('academic_standings', [
            'id' => $createdStanding->id,
            'Term_GPA_Min' => $changedTermGPA,
            'Cumulative_GPA_Min' => $changedCum,
        ]);

        $this->assertDatabaseMissing('academic_standings', [
            'id' => $createdStanding->id,
            'Term_GPA_Min' => $createdStanding->Term_GPA_Min,
            'Cumulative_GPA_Min' => $createdStanding->Cumulative_GPA_Min,
        ]);
    }

    /**
     * * AcademicStandingsController@destroy
     * Testing ability to delete Academic Standing Rule
     */
    public function test_can_delete_academic_standing_rule()
    {
        $user = $this->loginAs('academics_manager');
        $standing = factory(AcademicStandings::class)->create(['organization_id' => $user->organization_id]);
        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->from(route('academicStandings.index'))
            ->delete(route('academicStandings.destroy', $standing))
            ->assertSuccessful()
            ->assertSee('Successfully Deleted Standing Rule!')
            ->assertSee('Academic Standing Rules')
            ->assertDontSee($standing->name)
            ->assertDontSee($standing->Term_GPA_Min)
            ->assertDontSee($standing->Cumulative_GPA_Min);

        $this->assertDatabaseMissing('academic_standings', $standing->toArray());
    }
}
