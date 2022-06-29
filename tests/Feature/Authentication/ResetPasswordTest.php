<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_forgot_password_form_view()
    {
        $response = $this->get(route('forgot.pasword.form'));

        $response->assertViewIs('authentication.forgot-password');
    }

    public function test_user_can_send_email_in_forgot_password_form()
    {
        $user = User::factory()->create();

        $response = $this->post(route('forgot.pasword', ['email' => $user->email]));

        $response->assertSessionHasNoErrors()->assertSessionHas('status');
    }

    public function test_user_get_failed_status_for_send_bad_email_in_forgot_password_form()
    {
        $response = $this->post(route('forgot.pasword', ['email' => null]));

        $response->assertSessionHasErrors();
    }

    public function test_user_can_change_password_with_correct_credentials()
    {
        $user = User::factory()->create();

        $token = Password::createToken($user);

        $response = $this->post(route('password.reset'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'newPassword',
            'password_confirmation' => 'newPassword'
        ]);

        $this->assertTrue(Hash::check('newPassword', $user->fresh()->password));
    }

    public function test_user_cannot_change_password_with_incorrect_credentials()
    {
        $user = User::factory()->create();

        $response = $this->post(route('password.reset'), [
            'token' => null,
            'email' => null,
            'password' => null,
            'password_confirmation' => null
        ]);

        $response->assertSessionHasErrors('token')->assertRedirect();
    }
}
