<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        if(DB::table('prices')->count() == 0){
            DB::table('prices')->insert([
                'state' => 'TX',
                'price' => 1.50,
            ]);
            DB::table('prices')->insert([
                'state' => 'Others',
                'price' => 1.50,
            ]);
        }

        if(DB::table('users')->count() == 0){
            $state = array("TX", "AL", "CA", "FL");
            $thing = array("Avenue", "Lane", "Road", "Boulevard", "Drive", "Street", "Ave", "Dr", "Court", "Rd", "Blvd", "Ln", "St");
            $random_state_key = 0;
            $pass_arr = array();

            for ($i = 0; $i < 2; $i++) {
                //User in TX
                $random_thing_key = array_rand($thing, 1);
                $random_password = Str::random(10);
                array_push($pass_arr, $random_password);
                DB::table('users')->insert([
                    'name' => Str::random(10),
                    'email' => Str::random(10).'@gmail.com',
                    'password' => Hash::make($random_password),
                    'address1' => rand(1, 1000).' '.Str::random(10).' '.$thing[$random_thing_key],
                    'city' => Str::random(10),
                    'state' => 'TX',
                    'zipcode' => rand(10000, 99999),
                ]);

                //User out TX
                $random_thing_key = array_rand($thing, 1);
                $random_password = Str::random(10);
                array_push($pass_arr, $random_password);
                DB::table('users')->insert([
                    'name' => Str::random(10),
                    'email' => Str::random(10).'@gmail.com',
                    'password' => Hash::make($random_password),
                    'address1' => rand(1, 1000).' '.Str::random(10).' '.$thing[$random_thing_key],
                    'city' => Str::random(10),
                    'state' => 'CA',
                    'zipcode' => rand(10000, 99999),
                ]);
            }
            //Random Users
            for ($i = 0; $i < 3; $i++) {
                $random_thing_key = array_rand($thing, 1);
                $random_password = Str::random(10);
                array_push($pass_arr, $random_password);
                DB::table('users')->insert([
                    'name' => Str::random(10),
                    'email' => Str::random(10).'@gmail.com',
                    'password' => Hash::make($random_password),
                    'address1' => rand(1, 1000).' '.Str::random(10).' '.$thing[$random_thing_key],
                    'city' => Str::random(10),
                    'state' => $state[$random_state_key],
                    'zipcode' => rand(10000, 99999),
                ]);
                $random_state_key = array_rand($state, 1);
            }

            $user_arr = DB::table('users')->get();
            $user_arr_count = count($user_arr);
            file_put_contents('fake_user_accs.txt','');
            for ($i = 0; $i < $user_arr_count; $i++){
            $acc_string = 'User id: '.$user_arr[$i]->id."\nEmail: ".$user_arr[$i]->email."\nPassword: ".$pass_arr[$i]."\n\n";
            file_put_contents('fake_user_accs.txt', $acc_string, FILE_APPEND | LOCK_EX);
        }
        }
        //Adding user Fuel Quote histories
        if(DB::table('users')->count() > 0){
            $user_arr_count = count($user_arr);
            //$user_id_arr_key = array_rand($user_id_arr, 1);
            //echo $user_arr;
            for ($i = 0; $i < 10; $i++) {
                //reserve user 1 and 2 for unit testing
                $rand_user = $user_arr[rand(2, $user_arr_count - 1)];

                if($rand_user->state == 'TX'){
                    $locationFactor = 0.02;
                }
                else {
                    $locationFactor = 0.04;
                }
                if(DB::table('quote_histories')->where('user_id', $rand_user->id)->count() > 0){
                    $HistoryFactor = 0.01;
                }
                else{
                    $HistoryFactor = 0.0;
                }

                $G = rand(1, 5000);
                if($G >= 1000){
                    $GallonsRequestedFactor = 0.02;
                }
                else{
                    $GallonsRequestedFactor = 0.03;
                }

                $CompanyProfit = 0.10;
        
                $Suggested_Price = ($locationFactor - $HistoryFactor + $CompanyProfit + $GallonsRequestedFactor) * 1.5 + 1.5;

                DB::table('quote_histories')->insert([
                    'user_id' => $rand_user->id,
                    'Gallons' => $G,
                    'Address' => $rand_user->address1.' '.$rand_user->city.' '.$rand_user->state.' '.$rand_user->zipcode,
                    'start' => date("Y-m-d", mt_rand(time(),time() + (180 * 24 * 60 * 60))),
                    'Suggested_Price' => $Suggested_Price,
                    'Due' => round(($Suggested_Price * $G + 0.5) * 100)/100,
                ]);
            }
        }


    }
}
