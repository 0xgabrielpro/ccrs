<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Issue;

class IssueManagementTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function user_can_view_issues()
    {
        $response = $this->get(route('issues.index'));
        $response->assertStatus(200);
    }

    /** @test */
    // public function user_can_create_issue()
    // {
    //     $issueData = Issue::factory()->make()->toArray();
    //     $response = $this->post(route('issues.store'), $issueData);
    //     $response->assertStatus(302);
    //     $this->assertDatabaseHas('issues', ['title' => $issueData['title']]);
    // }

    /** @test */
    // public function user_can_update_issue()
    // {
    //     $issue = Issue::factory()->create();
    //     $updateData = ['title' => 'Updated Issue'];
    //     $response = $this->put(route('issues.update', $issue), $updateData);
    //     $response->assertStatus(302);
    //     $this->assertDatabaseHas('issues', ['id' => $issue->id, 'title' => 'Updated Issue']);
    // }

    /** @test */
    // public function user_can_delete_issue()
    // {
    //     $issue = Issue::factory()->create();
    //     $response = $this->delete(route('issues.destroy', $issue));
    //     $response->assertStatus(302);
    //     $this->assertDatabaseMissing('issues', ['id' => $issue->id]);
    // }

    /** @test */
    // public function user_can_reopen_issue()
    // {
    //     $issue = Issue::factory()->create(['status' => 'closed']);
    //     $response = $this->post(route('issues.reopen', $issue));
    //     $response->assertStatus(302);
    //     $this->assertDatabaseHas('issues', ['id' => $issue->id, 'status' => 'open']);
    // }

    /** @test */
    // public function user_can_rate_issue()
    // {
    //     $issue = Issue::factory()->create();
    //     $ratingData = ['rating' => 5];
    //     $response = $this->post(route('issues.rate', $issue), $ratingData);
    //     $response->assertStatus(302);
    //     $this->assertDatabaseHas('issues', ['id' => $issue->id, 'rating' => 5]);
    // }

    /** @test */
    // public function user_can_forward_issue()
    // {
    //     $issue = Issue::factory()->create();
    //     $anotherUser = User::factory()->create();
    //     $response = $this->post(route('issues.forward', $issue), ['forward_to' => $anotherUser->id]);
    //     $response->assertStatus(302);
    //     $this->assertDatabaseHas('issues', ['id' => $issue->id, 'to_user_id' => $anotherUser->id]);
    // }

    /** @test */
    // public function user_can_update_issue_visibility()
    // {
    //     $issue = Issue::factory()->create(['visibility' => true]);
    //     $response = $this->put(route('issues.update_visibility', $issue), ['visibility' => false]);
    //     $response->assertStatus(302);
    //     $this->assertDatabaseHas('issues', ['id' => $issue->id, 'visibility' => false]);
    // }
}
