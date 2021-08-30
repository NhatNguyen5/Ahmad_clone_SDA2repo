<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteHistory;
use DB;

class QuoteFormController extends Controller
{
    
    function addHistory(Request $req)
    {   
        $user =  auth()->user();
        
        $address = ($user->address1);
        $city = ($user->city);
        $state = ($user->state);
        $zip = ($user->zipcode);
        if(empty($address) || empty($city) || empty($state) || empty($zip)){
            $fulladdress = "Full address not given!";
        }
        else {
            $fulladdress = $address." ".$city.", ".$state." ".$zip;
        }

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

        if ($fetch_uh_obj != NULL) {
            $HistoryFactor = 0.01;
        }
        else{
            $HistoryFactor = 0;
        }

        if($req->Gallons >= 1000){
            $GallonsRequestedFactor = 0.02;
        }
        else{
            $GallonsRequestedFactor = 0.03;
        }

        $CompanyProfit = 0.10;
        
        $Suggested_Price = ($locationFactor - $HistoryFactor + $CompanyProfit + $GallonsRequestedFactor) * $basePay + $basePay;

        $QuoteHistory = new QuoteHistory;
        
        $QuoteHistory -> Gallons = $req -> Gallons;
        $QuoteHistory -> Address = $fulladdress;
        $QuoteHistory -> start = $req -> start;
        $QuoteHistory -> user_id = $user -> id;
        $QuoteHistory -> Suggested_Price = $Suggested_Price;
        $QuoteHistory -> Due = ($req -> Gallons) * ($QuoteHistory -> Suggested_Price);
        $QuoteHistory -> save();
        response(['created'=>true], 201);
        return redirect('home');
    }
}
