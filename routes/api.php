<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\RoomController;
use App\Models\Room;
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

Route::group(['middleware' =>['auth:sanctum']],function(){

    Route::get('/users',[AuthController::class, 'index']);
    Route::get('/users/{id}',[AuthController::class, 'show']);
    Route::put('/users/{id}',[AuthController::class, 'update']);
   
    Route::get('/reserves/search/user/{id}', [ReserveController::class, 'search']);
    Route::get('/reserves/search/{id}', [ReserveController::class, 'show']);
    Route::resource('rooms', RoomController::class);
    Route::get('/rooms/search/{id}',[RoomController::class,'search']);
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/logout',[AuthController::class,'logout']);

});
Route::post('/login',[AuthController::class,'login']);

Route::resource('reserves',ReserveController::class);
Route::put('reserves',[ReserveController::class,'store']);



