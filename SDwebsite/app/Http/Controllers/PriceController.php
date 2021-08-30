<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteHistory;
use DB;

class PriceController extends Controller
{
    function viewPrice(Request $req)
    {
        $user =  auth()->user();
        if($user != NULL)
        {
            $address = ($user->address1);
            $city = ($user->city);
            $state = ($user->state);
            $zip = ($user->zipcode);
            $user_id = ($user->id);
            $fulladdress = $address." ".$city.", ".$state." ".$zip;
        }
        else {
            $address = NULL;
            $city = NULL;
            $state = NULL;
            $zip = NULL;
            $user_id = NULL;
            $fulladdress = "No address given!\nUsing other location factor (4%) as default";
        }

        //Final Assignment thing 
        
        $basePay = 1.50; //given
        
        if($state != 'TX'){
            $locationFactor = 0.04;
        }
        else{
            $locationFactor = 0.02;
        } //self-explanatory 
        
        
        if ($user != NULL && DB::table('quote_histories')->where('user_id', $user->id )->exists())
        {
            $fetch_uh_obj = DB::select(sprintf('select * from quote_histories where user_id = \'%s\'', $user->id));
        }
        else {
            $fetch_uh_obj = NULL;
        }
        


/*    //find whether the user's id is even in the  FuelQuoteHistory table at all
        if($user != NULL){
            $fetch_uh_obj = DB::select(sprintf('select * from quote_histories where user_id = \'%s\'', $user->id));
        }
        else{
            $fetch_uh_obj = NULL;
        }
*/
        if ($fetch_uh_obj != NULL) {
            $HistoryFactor = 0.01;
        }
        else{
            $HistoryFactor = 0;
        }
        /*
        if($req->Gallons >= 1000){
            $GallonsRequestedFactor = 0.02;
        }  //<- idk how to do this one in this controller
        else{
            $GallonsRequestedFactor = 0.03;
        }
        */

        $CompanyProfit = 0.10;
        
        $ResultingPrice = ($locationFactor - $HistoryFactor + $CompanyProfit);
        // We do GALLON REQUEST FACTOR on the http page
        
        if(empty($address) || empty($city) || empty($state) || empty($zip))
        {
            $fulladdress = "Full address not given!"; 
            $Suggested_Price = $ResultingPrice;
        }
        else
        {   
            $Suggested_Price = $ResultingPrice;
        }
        
        $Address = $fulladdress;        
        $QuoteFormData = array($Suggested_Price, $Address);
        Controller::console_log('Success!');

        return view('fuelquoteform', ['QuoteFormData' => $QuoteFormData]);
        
    }
}
