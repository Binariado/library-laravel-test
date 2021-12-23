<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use WithFaker;

    public function test_register_user() {
        $baseUrl = Config::get('app.url');
        $email = $this->faker->unique()->safeEmail();
        $password = Hash::make('password');

        $response = $this->json(
            'POST',
            $baseUrl . '/api/auth/register',
            [
                'name' => $this->faker->name(),
                'last_name' => $this->faker->lastName(),
                'email' => $email,
                'document_type' => "CC",
                'document_number' => 23423,
                'address' =>  $this->faker->address(),
                'phone' => $this->faker->phoneNumber(),
                //'image' => $this->faker->image(),
                'password' => $password,
                'password_confirmation' => $password
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'user', 'token'
            ]);

        $user = User::where('email', $email)->first();
        $user->delete();
    }

    /**
     * Test login and refresh token.
     *
     * @return void
     */
    public function test_login_and_refresh_token()
    {

        $baseUrl = Config::get('app.url');
        $email = Config::get('test.apiTestEmail');
        $password = Config::get('test.apiTestPassword');

        $response = $this->json('POST', $baseUrl . '/api/auth/login' , [
            'email' => $email,
            'password' => $password
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);

        $user = User::where('email', $email)->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', $baseUrl . '/api/auth/refresh', []);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }

    /**
     * Test logout.
     *
     * @return void
     */
    public function test_logout()
    {
        $user = User::where('email', Config::get('test.apiTestEmail'))->first();
        $token = JWTAuth::fromUser($user);
        $baseUrl = Config::get('app.url') . '/api/auth/logout';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', $baseUrl, []);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'Successfully logged out'
            ]);
    }

    /**
     * Test Get user me.
     *
     * @return void
     */
    public function test_user_me()
    {
        $user = User::where('email', Config::get('test.apiTestEmail'))->first();
        $token = JWTAuth::fromUser($user);
        $baseUrl = Config::get('app.url') . '/api/auth/me';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('get', $baseUrl, []);

        $response->assertStatus(200);
    }

}
