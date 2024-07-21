<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fetches_countries()
    {
        $response = $this->get('/api2/countries');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_fetches_regions()
    {
        $response = $this->get('/api2/regions');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_fetches_districts()
    {
        $response = $this->get('/api2/districts');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_fetches_wards()
    {
        $response = $this->get('/api2/wards');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_fetches_streets()
    {
        $response = $this->get('/api2/streets');
        $response->assertStatus(200);
    }
}
