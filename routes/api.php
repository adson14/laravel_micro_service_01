<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CategoryController
};

//Route::get('/', function () {
//    return response()->json(['message' => 'Service connected with success']);
//});

Route::apiResource('categories',CategoryController::class);
