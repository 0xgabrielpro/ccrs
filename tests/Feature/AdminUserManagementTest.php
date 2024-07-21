<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Leader;
use App\Models\Category;
use App\Models\Country;
use App\Models\Region;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    // Add this to your test case class to create and authenticate an admin user
    public function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->adminUser = User::factory()->create([
            'role' => 'admin', 
            'password' => Hash::make('password'),
        ]);

        // Authenticate the admin user
        $this->actingAs($this->adminUser);

    }


    /** @test */
    public function admin_can_create_user()
    {
        // Create related models
        $country = Country::factory()->create();
        $region = Region::factory()->create(['country_id' => $country->id]);
        $district = District::factory()->create(['region_id' => $region->id]);
        $ward = Ward::factory()->create(['district_id' => $district->id]);
        $street = Street::factory()->create(['ward_id' => $ward->id]);
        $leader = Leader::factory()->create();
        $category = Category::factory()->create();

        // User data with related models' IDs
        $userData = [
            'name' => 'Test User',
            'email' => 'testuser' . time() . '@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'citizen',
            'country_id' => $country->id,
            'region_id' => $region->id,
            'district_id' => $district->id,
            'ward_id' => $ward->id,
            'street_id' => $street->id,
            'leader_id' => $leader->id,
            'category_id' => $category->id,
        ];

        // Perform the request
        $response = $this->post(route('admin.users.store'), $userData);

        // Assert the response status
        $response->assertStatus(302);

        // Assert that the user was created in the database
        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'name' => 'Test User',
            'role' => 'citizen'
        ]);
    }

    /** @test */
    public function admin_can_view_users()
    {
        // Create users for the test, including the extra admin user
        $users = User::factory(4)->create(); // Ensure the factory creates the expected number of users

        // Perform the request
        $response = $this->get(route('admin.users.index'));

        // Assert the response status
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');

        // Get the users from the view
        $viewUsers = $response->viewData('users');

        // Convert the collections to arrays for easier comparison
        $viewUsersArray = $viewUsers->pluck('name', 'id')->toArray();
        $usersArray = $users->pluck('name', 'id')->toArray();

        // Print the user data for debugging
        // dd([
        //     'viewUsers' => $viewUsersArray,
        //     'expectedUsers' => $usersArray,
        // ]);

        // Assert that all expected users are in the view
        foreach ($users as $user) {
            $this->assertArrayHasKey($user->id, $viewUsersArray);
        }
    }


    /** @test */
    public function admin_can_view_single_user()
    {
        $user = User::factory()->create();

        $response = $this->get(route('admin.users.show', $user));
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.show');
        $response->assertViewHas('user', $user);
    }

    /** @test */
    // public function admin_can_edit_user()
    // {
    //     // Create the user and related models
    //     $user = User::factory()->create();
    //     $leaders = Leader::factory(3)->create();
    //     $categories = Category::factory(3)->create();
    //     $countries = Country::factory(3)->create();
    //     $regions = Region::factory(3)->create();
    //     $districts = District::factory(3)->create();

    //     // Perform the request to edit the user
    //     $response = $this->get(route('admin.users.edit', $user));
    //     dd($user);
    //     // Assert the response status
    //     $response->assertStatus(200);
    //     $response->assertViewIs('admin.users.edit');
    //     $response->assertViewHas('user', $user);

    //     // Debugging: Check if view data keys exist
    //     $viewData = $response->viewData();
    //     dd($viewData);
    //     $expectedKeys = ['leaders', 'categories', 'countries', 'regions', 'districts'];

    //     foreach ($expectedKeys as $key) {
    //         if (!array_key_exists($key, $viewData)) {
    //             dd("Key '$key' is missing in the view data", $viewData);
    //         }
    //     }

    //     // Assert that the expected data is present in the view
    //     $response->assertViewHas('leaders', function ($viewLeaders) use ($leaders) {
    //         return $viewLeaders->count() === $leaders->count();
    //     });

    //     $response->assertViewHas('categories', function ($viewCategories) use ($categories) {
    //         return $viewCategories->count() === $categories->count();
    //     });

    //     $response->assertViewHas('countries', function ($viewCountries) use ($countries) {
    //         return $viewCountries->count() === $countries->count();
    //     });

    //     $response->assertViewHas('regions', function ($viewRegions) use ($regions) {
    //         return $viewRegions->count() === $regions->count();
    //     });

    //     $response->assertViewHas('districts', function ($viewDistricts) use ($districts) {
    //         return $viewDistricts->count() === $districts->count();
    //     });
    // }



    /** @test */
    public function admin_can_update_user()
    {
        $user = User::factory()->create();
        $newData = [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
            'role' => 'admin',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ];

        $response = $this->put(route('admin.users.update', $user), $newData);
        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'email' => 'updatedemail@example.com',
            'name' => 'Updated Name',
        ]);
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->delete(route('admin.users.destroy', $user));
        $response->assertStatus(302);

        $this->assertDatabaseMissing('users', ['email' => $user->email]);
    }
}
