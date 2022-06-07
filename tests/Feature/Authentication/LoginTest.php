<?php

declare(strict_types = 1);

namespace Tests\Authentication\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_login_form(): void
    {
        $response = $this->get(route('login.form'));

        $response->assertViewIs('authentication.login');
    }

    public function test_user_cannot_see_login_form_when_authenticated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('login.form'));

        $response->assertRedirect(LoginTest::HOME);
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        define('PASSWORD', '12345678');

        $user = User::factory()->create([
            'password' => Hash::make(PASSWORD)
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => PASSWORD
        ]);

        $response->assertRedirect()->assertSessionHasNoErrors();

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_incorrect_credentials(): void
    {
        //Login request has stopOnFirstFailure set on true

        $response = $this->post(route('login'), [
            'email' => null,
            'password' => null
        ]);

        $response->assertRedirect()->assertSessionHasErrors(['email']);

        $this->assertGuest();
    }
}
