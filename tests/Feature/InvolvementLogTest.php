<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Faker\Generator as Faker;
use App\Involvement;
class InvolvementLogTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    public function test_can_create_logs()
    {
        $this->withoutExceptionHandling();

        $this->loginAsAdmin();
        $event = factory(Involvement::class)->create(['organization_id' => auth()->user()->organization->id]);
        $dt = $this->faker->dateTimeAD();
        //dd($dt);
        $response = $this->post('/involvementLog',[
            'involvement_id' => $event->id,
            'date_of_event' => '2001-10-26 21:32:52',
            'usersInvolved' => [auth()->user()->id]
        ]);

        $this->assertDatabaseHas('involvement_logs',[
            'organization_id' => auth()->user()->organization->id,
            'user_id' => auth()->id(),
            'involvement_id' => $event->id,
            'date_of_event' => '2001-10-26 21:32:52',
        ]);
        $response = $this->get('/involvementLog');
        $response->assertSee(auth()->user()->name);
        $response->assertSee(auth()->user()->getInvolvementPoints());

    }
}
