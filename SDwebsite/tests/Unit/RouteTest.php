<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use DB;

class SDwebsiteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_route_as_guess()
    {
        $response = $this->get('/');
        $response->assertStatus(200); 
        $response = $this->get('/fuelquoteform');
        $response->assertStatus(200);
        $response = $this->get('/fuelquotehistory');
        $response->assertStatus(500);
        $response = $this->get('/home');
        $response->assertStatus(302);
        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
        $response = $this->get('/register');
        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }

    public function test_route_as_user_in_TX()
    {
        $user1 = User::find(1);
        $response = $this->actingAs($user1);

        $response = $this->get('/');
        $response->assertStatus(200); 
        $response = $this->get('/fuelquoteform');
        $response->assertStatus(200);
        $response = $this->get('/fuelquotehistory');
        $response->assertStatus(200);
        $response = $this->get('/home');
        $response->assertStatus(200);
        $response = $this->get('/login');
        $response->assertStatus(302);
        $response = $this->get('/register');
        $response->assertStatus(302);
    }

    public function test_route_as_user_out_TX()
    {
        $user1 = User::find(2);
        $response = $this->actingAs($user1);

        $response = $this->get('/');
        $response->assertStatus(200); 
        $response = $this->get('/fuelquoteform');
        $response->assertStatus(200);
        $response = $this->get('/fuelquotehistory');
        $response->assertStatus(200);
        $response = $this->get('/home');
        $response->assertStatus(200);
        $response = $this->get('/login');
        $response->assertStatus(302);
        $response = $this->get('/register');
        $response->assertStatus(302);
    }

    public function test_route_as_user_in_TX_without_prices_table()
    {
        DB::select('drop table prices');
        DB::select('create table prices (id int, state varchar(2), price float)');

        $user1 = User::find(1);
        $response = $this->actingAs($user1);

        $response = $this->get('/');
        $response->assertStatus(200); 
        $response = $this->get('/fuelquoteform');
        $response->assertStatus(200);
        $response = $this->get('/fuelquotehistory');
        $response->assertStatus(200);
        $response = $this->get('/home');
        $response->assertStatus(200);
        $response = $this->get('/login');
        $response->assertStatus(302);
        $response = $this->get('/register');
        $response->assertStatus(302);
    }
}
