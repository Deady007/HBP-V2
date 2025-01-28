<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;

class RouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_route()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

}