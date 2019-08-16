<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * * SurveyController@index
     * Testing ability to get survey page
     */
    public function test_get_survey_page()
    {
        $user = $this->loginAs('basic_user');

        $this
            ->withoutExceptionHandling()
            ->followingRedirects()
            ->get(route('survey.index'))
            ->assertSuccessful();
    }
}
