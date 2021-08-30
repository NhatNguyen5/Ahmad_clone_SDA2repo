<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_correct_password()
    {

        $user = User::factory()->make([
            'password' => bcrypt($password = 'testpass'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ])->assertStatus(302);
    }

    public function test_wrong_password()
    {
        $user = User::factory()->make([
            'password' => bcrypt('testpass'),
        ]);
        
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'testpasstt',
        ]);
        
        $response->assertRedirect('/login');
    }
}
