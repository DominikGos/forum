<?php

declare(strict_types = 1);

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_register_form(): void
    {
        $response = $this->get(route('register.form'));

        $response->assertStatus(200)->assertViewIs('authentication.register');
    }

    public function test_user_cannot_see_register_form_when_authenticated(): void
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get(route('register.form'));

        $response->assertRedirect(route('home'));
    }

    public function test_user_can_register_with_correct_credentials(): void
    {
        $user = User::factory()->make([
            'name' => 'user1234',
            'password' => '12345678',
            'email' => 'email@email.com',
        ]);

        $response = $this->post(route('register'), [
            'name' => $user->name,
            'password' => $user->password,
            'password_confirmation' => $user->password,
            'email' => $user->email
        ]);

        $response->assertRedirect(route('login.form'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('register-success');
    }

    public function test_user_cannot_register_with_incorrect_credentials(): void
    {
        $response = $this->post(route('register'), [
            'name' => null,
            'password' => null,
            'email' => null
        ]);

        $response->assertRedirect(route('register.form'))->assertSessionHasErrors(['name']);
    }
}
