<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\doctorController;


Route::get('/getallstatelist',[doctorController::class,'getAllStateList']);
Route::get('/getallcitylist',[doctorController::class,'getAllCityList']);
