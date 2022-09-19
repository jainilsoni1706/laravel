<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use DB;

class Doctorcontroller extends Controller
{

  function getAllStateList(Request $request)
    {
        $data = DB::select("SELECT * FROM `states` WHERE country_id=".(int)$request->country."");

         return response()->json($data);
    }

    function getAllCityList(Request $request)
    {
        $data = DB::select("SELECT * FROM `cities` WHERE state_id=".(int)$request->state."");

         return response()->json($data);
    }
  
}
