<?php

declare(strict_types = 1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_profile()
    {
        $user = User::factory()->create();

        $response = $this->get(route('user.get', ['id' => $user->id]));

        $response->assertStatus(200)
            ->assertViewIs('user.get')
            ->assertViewHasAll([
                'user',
                'userPostedResourcesName',
                'userPostedResources',
            ]);
    }

    public function test_user_can_view_edit_profile_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('user.edit', ['id' => $user->id]));

        $response->assertStatus(200)
            ->assertViewIs('user.edit');
    }

    public function test_user_can_update_own_profile()
    {
        $user = User::factory()->create();

        $updatedUser = User::factory()->make();

        $response = $this->actingAs($user)
            ->put(
                route('user.update', ['id' => $user->id]),
                [
                    'name' => $updatedUser->name,
                ]
            );

        $response->assertRedirect(route('user.get', ['id' => $user->id]))
            ->assertSessionHas('profile-update-success')
            ->assertSessionHasNoErrors();
    }

    public function test_user_cannot_update_not_his_profile()
    {
        $firstUser = User::factory()->create();

        $secondUser = User::factory()->create();

        $updatedFirstUser = User::factory()->make();

        $response = $this->actingAs($secondUser)
            ->put(
                route('user.update', ['id' => $firstUser->id]),
                [
                    'name' => $updatedFirstUser->name,
                ]
            );

        $response->assertStatus(403);
    }
}
