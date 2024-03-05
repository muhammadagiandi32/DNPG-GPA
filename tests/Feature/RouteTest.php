<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/dnpg');

        $response->assertStatus(200); // Periksa apakah status response adalah 200 (OK)
    }

    public function testCreate()
    {
        $response = $this->get('/dnpg/store');

        $response->assertStatus(200); // Periksa apakah status response adalah 200 (OK)
    }
}
