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

        $response = $this->actingAs($user)
            ->get(route('profile', ['id' => $user->id]));

        $response->assertStatus(200)
            ->assertViewIs('profile')
            ->assertViewHasAll([
                'user',
                'dataToDisplay',
            ]);
    }
}
