<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Issue;
use App\Models\Category;

class LeaderboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_leaderboard()
    {
        // Create a leader user
        $leader = User::factory()->create(['role' => 'leader']);
        
        // Create a category to be used by the issue
        $category = Category::factory()->create();

        // Create an issue and associate it with the leader
        Issue::factory()->create([
            'sealed_by' => $leader->id,
            'category_id' => $category->id,
        ]);

        // Test if leaderboard displays the leader's name
        $response = $this->get(route('leaderboard.index'));
        $response->assertStatus(200);
        $response->assertSee($leader->name);
    }
}
