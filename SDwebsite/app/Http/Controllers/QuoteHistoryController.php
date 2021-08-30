<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Http;
use DB;
use App\Models\QuoteHistory;

class QuoteHistoryController extends Controller
{
    function index()
    {
      $user =  auth()->user();
      $collection = DB::select(sprintf('select * from quote_histories where user_id = %d order by start asc', $user -> id));
      return view('fuelquotehistory', ['collection' => $collection]);
  
    }
}
