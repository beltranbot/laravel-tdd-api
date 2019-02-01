<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('passport:install');
    }

    /**
     * @test
     */
    public function can_authenticate()
    {
        $user = $this->create('User', [], false);
        $email = $user->email;
        
        $response = $this->json('POST', '/auth/token', [
            'email' => $email,
            'password' => 'secret'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

}