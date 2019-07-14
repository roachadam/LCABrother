<?php

namespace Tests\Feature;

use DB;
use App\ServiceLog;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceLogsTest extends TestCase
{
    use RefreshDatabase;

    public function test_placeholder()
    {
        $this->assertTrue(true);
    }
}
