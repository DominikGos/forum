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

        $response = $this->get(route('profile', ['id' => $user->id]));

        $response->assertStatus(200)
            ->assertViewIs('profile')
            ->assertViewHasAll([
                'user',
                'dataToDisplay',
            ]);
    }

    public function test_user_can_view_edit_profile_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('profile.edit', ['id' => $user->id]));

        $response->assertStatus(200)
            ->assertViewIs('profile.edit');
    }

    public function test_user_can_update_own_profile()
    {
        $user = User::factory()->create();

        $updatedUser = User::factory()->make(['id' => $user->id]);

        $response = $this->actingAs($user)
            ->put(
                route('profile.update', ['id' => $user->id]),
                [
                    'name' => $updatedUser->name,
                    'avatar' => $updatedUser->avatar
                ]
            );

        $response->assertRedirect(route('profile', ['id' => $user->id]))
            ->assertSessionHas('profile-update-success');
    }

    public function test_user_cannot_update_not_his_profile()
    {
        $firstUser = User::factory()->create();

        $secondUser = User::factory()->create();

        $updatedFirstUser = User::factory()->make(['id' => $firstUser->id]);

        $response = $this->actingAs($firstUser)
            ->put(
                route('profile.update', ['id' => $firstUser->id]),
                [
                    'name' => $updatedFirstUser->name,
                    'avatar' => $updatedFirstUser->avatar
                ]
            );

        $response->assertRedirect(route('profile', ['id' => $firstUser->id]))
            ->assertStatus(403);
    }
}
