<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\AnonIssue;

class AnonIssueManagementTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->leader = User::factory()->create(['role' => 'leader']);
        $this->actingAs($this->leader);
    }

    /** @test */
    public function leader_can_update_anonymous_issue_status()
    {
        $anonIssue = AnonIssue::factory()->create(['status' => 'open']);
        $response = $this->put(route('anon-issues.update_status', $anonIssue), ['status' => 'closed']);
        $response->assertStatus(302);
        $this->assertDatabaseHas('anon_issues', ['id' => $anonIssue->id, 'status' => 'closed']);
    }

    // /** @test */
    // public function leader_can_forward_anonymous_issue()
    // {
    //     $anonIssue = AnonIssue::factory()->create();
    //     $anotherLeader = User::factory()->create(['role' => 'leader']);
    //     $response = $this->post(route('anon-issues.forward', $anonIssue), ['forward_to' => $anotherLeader->id]);
    //     $response->assertStatus(302);
    //     $this->assertDatabaseHas('anon_issues', ['id' => $anonIssue->id, 'to_user_id' => $anotherLeader->id]);
    // }

    /** @test */
    public function leader_can_update_anonymous_issue_visibility()
    {
        $anonIssue = AnonIssue::factory()->create(['visibility' => true]);
        $response = $this->put(route('anon-issues.update_visibility', $anonIssue), ['visibility' => false]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('anon_issues', ['id' => $anonIssue->id, 'visibility' => false]);
    }
}
