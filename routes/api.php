<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\User\UserResourceForAdmin;

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

Route::post('/auth/login', function (Request $request) {
    return response()->json([
        'token' => Str::random(32)
    ]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('categories', function(){

    $authUser = Auth::user();

    $users = App\Models\User::all();


    if($authUser->is('Admin')){
        return UserResourceForAdmin::collection($users);
    }
    
    if($authUser->is('Moderator')){
        return UserResourceForModerator::collection($users);
    }

});