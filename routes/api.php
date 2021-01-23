<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[\App\Http\Controllers\API\AuthController::class,'login']);
Route::post('sign-up',[\App\Http\Controllers\API\AuthController::class,'register']);
Route::get('getRegions',[\App\Http\Controllers\API\RegionController::class,'getRegions']);


Route::middleware('auth:sanctum')->group(function (){

    /*** Start Address Route  ***/
    Route::get('getAddresses',[\App\Http\Controllers\API\AddressController::class,'getAddresses']);
    Route::post('createAddress',[\App\Http\Controllers\API\AddressController::class,'createAddress']);
    Route::post('updateAddress/{address}',[\App\Http\Controllers\API\AddressController::class,'updateAddress']);
    Route::get('showAddress/{address}',[\App\Http\Controllers\API\AddressController::class,'showAddress']);
    /** End Address Route **/

    Route::get('getUserInfo',[\App\Http\Controllers\API\AuthController::class,'getUserInfo']);
    Route::post('updateUserInfo',[\App\Http\Controllers\API\AuthController::class,'updateUserInfo']);


});

