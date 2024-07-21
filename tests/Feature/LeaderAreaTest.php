<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Issue;

class LeaderAreaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->leader = User::factory()->create(['role' => 'leader']);
        $this->actingAs($this->leader);
    }

    /** @test */
    public function leader_can_view_issues_in_his_area()
    {
        Issue::factory()->create(['to_user_id' => $this->leader->id]);
        $response = $this->get(route('leader.issues'));
        $response->assertStatus(200);
    }

    /** @test */
    public function leader_can_view_insights()
    {
        $response = $this->get(route('leader.insights'));
        $response->assertStatus(200);
    }
}
