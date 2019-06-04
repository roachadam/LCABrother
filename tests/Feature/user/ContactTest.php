<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;
    public function testExample()
    {
        $this->loginAsAdmin();

        $this->get('/users/contact')
            ->assertSee(auth()->user()->name)
            ->assertSee(auth()->user()->email)
            ->assertSee(auth()->user()->phone);


    }
}
