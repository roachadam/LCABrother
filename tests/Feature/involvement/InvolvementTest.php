<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Involvement;
use App\Organization;

class InvolvementTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_view_involvement()
    {
        $this->loginAsAdmin();
        $response = $this->get('involvement');

        $response->assertStatus(200);
    }

    public function test_can_add_involvement()
    {
        $this->withoutExceptionHandling();

        $this->loginAsAdmin();
        $event = factory(Involvement::class)->raw(['organization_id' => auth()->user()->organization->id]);
        $response = $this->post('involvement', $event);

        $this->assertDatabaseHas('involvements', [
            "name" => $event['name'],
        ]);
    }

    public function test_cannot_add_involvement_without_points()
    {
        $this->loginAsAdmin();
        $event = factory(Involvement::class)->raw([
            'organization_id' => auth()->user()->organization->id,
            'points' => ''
        ]);
        $response = $this->post('involvement', $event);

        $response->assertSessionHasErrors('points');
    }

    public function test_cannot_add_involvement_without_name()
    {
        //$this->withoutExceptionHandling();

        $this->loginAsAdmin();
        $event = factory(Involvement::class)->raw([
            'organization_id' => auth()->user()->organization->id,
            'name' => ''
        ]);
        $response = $this->post('involvement', $event);

        $response->assertSessionHasErrors('name');
    }

    public function test_can_view_edit_involvement()
    {
        $this->loginAsAdmin();
        $event = factory(Involvement::class)->create(['organization_id' => auth()->user()->organization->id]);

        $response = $this->get('involvement/' . $event->id . '/edit');
        $response->assertSee($event->name);
        $response->assertSee($event->points);
        $response->assertStatus(200);
    }
}
