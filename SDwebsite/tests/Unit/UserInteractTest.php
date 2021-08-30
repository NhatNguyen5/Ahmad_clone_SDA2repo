<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Assert as PHPUnit;
use Illuminate\Support\Str;
use DB;

class ResponseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    //use RefreshDatabase;

    public function test_price_calculation_as_user_in_tx()
    {
        $user1 = User::find(1);

        $response = $this->actingAs($user1);
        //test bad input
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>'abc',
                                                            'start'=>'abc']);
        $response
        ->assertStatus(500);

        //test appropriate input
        //request < 1000 Gallons first time
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>100,
                                                            'start'=>"2021-10-10"]);
        $response
        ->assertStatus(302);
        //check price view with user have history
        $response = $this->get('/fuelquoteform');
        $response -> assertStatus(200);
        //request < 1000 Gallons with history
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>100,
                                                            'start'=>"2021-10-10"]);
        $response
        ->assertStatus(302);
        //request 1000 Gallons with history
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>1000,
                                                            'start'=>"2021-10-10"]);
        $response
        ->assertStatus(302);
        //Check if all Suggested_Price and Due in db match up
        $SP = DB::table('quote_histories')->where('user_id', $user1->id)->get("Suggested_Price");
        $Due = DB::table('quote_histories')->where('user_id', $user1->id)->get("Due");
        PHPUnit::assertTrue($SP[0]->Suggested_Price == 1.725 and $Due[0]->Due == 172.5);
        PHPUnit::assertTrue($SP[1]->Suggested_Price == 1.71 and $Due[1]->Due == 171.0);
        PHPUnit::assertTrue($SP[2]->Suggested_Price == 1.695 and $Due[2]->Due == 1695.0);
        
    }

    public function test_price_calculation_as_user_out_tx()
    {
        $user2 = User::find(2);

        $response = $this->actingAs($user2);

        //test bad input
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>'abc',
                                                            'start'=>'abc']);
        $response
        ->assertStatus(500);

        //test appropriate input
        //request < 1000 Gallons first time
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>100,
                                                            'start'=>"2021-10-10"]);
        $response
        ->assertStatus(302);
        //request < 1000 Gallons with history
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>100,
                                                            'start'=>"2021-10-10"]);
        $response
        ->assertStatus(302);
        //request 1000 Gallons with history
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>1000,
                                                            'start'=>"2021-10-10"]);
        $response
        ->assertStatus(302);
        //Check if all Suggested_Price and Due in db match up
        $SP = DB::table('quote_histories')->where('user_id', $user2->id)->get("Suggested_Price");
        $Due = DB::table('quote_histories')->where('user_id', $user2->id)->get("Due");
        PHPUnit::assertTrue($SP[0]->Suggested_Price == 1.755 and $Due[0]->Due == 175.5);
        PHPUnit::assertTrue($SP[1]->Suggested_Price == 1.74 and $Due[1]->Due == 174.0);
        PHPUnit::assertTrue($SP[2]->Suggested_Price == 1.725 and $Due[2]->Due == 1725.0);
    }

    public function test_database_as_guest()
    {
        $response = $this->get('/fuelquoteform');
        $response -> assertStatus(200);
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>100, 
                                                            'start'=>"2021-10-10"]);
        $response
        ->assertStatus(500);
    }

    public function test_if_user_can_register()
    {
        /**
         * Test Auth user profile data
         *
         * @return void
         */
        $name = Str::random(10);
        $response = $this -> json('POST', '/register', [
            'name' => $name,
            'email' => Str::random(10).'@gmail.com',
            'password' => 'testpass',
            'password_confirmation' => 'testpass'])
            ->assertStatus(201);

        $response = $this->assertDatabaseHas('users', ['name' => $name]);
    }

    public function test_price_calculation_as_user_with_no_address()
    {
        $user3 = User::find(8);

        $response = $this->actingAs($user3);
        
        //test bad input
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>'abc',
                                                            'start'=>'abc']);
        $response
        ->assertStatus(500);

        //test appropriate input
        //request < 1000 Gallons first time
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>100,
                                                            'start'=>"2021-10-10"]);
        $response
        ->assertStatus(302);
        //request < 1000 Gallons with history
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>100,
                                                            'start'=>"2021-10-10"]);
        $response
        ->assertStatus(302);
        //request 1000 Gallons with history
        $response = $this -> json('POST', '/fuelquoteform', ['Gallons'=>1000,
                                                            'start'=>"2021-10-10"]);
        $response
        ->assertStatus(302);
        //Check if all Suggested_Price and Due in db match up
        $SP = DB::table('quote_histories')->where('user_id', $user3->id)->get("Suggested_Price");
        $Due = DB::table('quote_histories')->where('user_id', $user3->id)->get("Due");
        PHPUnit::assertTrue($SP[0]->Suggested_Price == 1.755 and $Due[0]->Due == 175.5);
        PHPUnit::assertTrue($SP[1]->Suggested_Price == 1.74 and $Due[1]->Due == 174.0);
        PHPUnit::assertTrue($SP[2]->Suggested_Price == 1.725 and $Due[2]->Due == 1725.0);
    }

    public function test_register_with_wrong_confirm_password()
    {
        /**
         * Test Auth user profile data
         *
         * @return void
         */

        $response = $this -> json('POST', '/register', [
            'name' => 'asd2',
            'email' => 'asdasd2@asd',
            'password' => 'testpasst',
            'password_confirmation' => 'testpass'])
            ->assertStatus(422);
        $isExist = User::select('*')
        ->where('name', 'asd2')
        ->exists();
        if($isExist)
        $response = $this->assertTrue(False);
        else
        $response = $this->assertTrue(True);
    }

    public function test_register_with_existed_email()
    {
        /**
         * Test Auth user profile data
         *
         * @return void
         */

        $exist_users = DB::table('users')->get();

        if($exist_users == NULL){

            $response = $this -> json('POST', '/register', [
                'name' => 'asd',
                'email' => 'asdasd@asd',
                'password' => 'testpass',
                'password_confirmation' => 'testpass'])
                ->assertStatus(201);
                
            $response = $this->assertDatabaseHas('users', ['name' => 'asd']);
            $user_email = 'asdasd@asd';
        }
        else{
            $user_email = $exist_users[0] -> email;
        }

        $response = $this -> json('POST', '/register', [
            'name' => 'asd2',
            'email' => $user_email,
            'password' => 'testpass',
            'password_confirmation' => 'testpass'])
            ->assertStatus(422);
    }

    public function test_user_profile_interaction()
    {
        $user3 = User::find(8);

        $response = $this->actingAs($user3);
        $response = $this->get('/profile');
        $response -> assertStatus(200);
        //test good input
        $response = $this -> json('PUT', '/profile', ['name'=>"Larry Test", 'address1'=>"638 Glen Ridge Drive", 
        "city" => "Uniondale", "state"=> "NY", "zipcode" => "11553" ]);
        $response
        ->assertStatus(302);
        $user_profile = DB::table('users')->where('id', $user3->id)->get();
        PHPUnit::assertTrue(
            $user_profile[0]->name == "Larry Test" and 
            $user_profile[0]->address1 == "638 Glen Ridge Drive" and
            $user_profile[0]->city == "Uniondale" and
            $user_profile[0]->state == "NY" and
            $user_profile[0]->zipcode == "11553"
        );
        //test bad input
        //bad state
        $response = $this -> json('PUT', '/profile', ['name'=>"Larry Test", 'address1'=>"638 Glen Ridge Drive", 
        "city" => "Uniondale", "state"=> "asd", "zipcode" => "11553" ]);
        $response
        ->assertStatus(500);
        $user_profile = DB::table('users')->where('id', $user3->id)->get();
        PHPUnit::assertFalse(
            $user_profile[0]->state == "asd"
        ); //no change

    }
}
