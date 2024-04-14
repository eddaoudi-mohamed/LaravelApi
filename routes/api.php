<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user', function (Request $request) {
    return "hello welcom " . app()->getLocale();
})->middleware("checkPassword");



Route::post("/check", function (Request $request) {

    $rules = [
        "name" => "required",
        "email" => "required|string"
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        $messages = $validator->messages();
        return throw new HttpResponseException(response()->json(['errors' => $messages,  'succes' => false]), 404);
    }

    $user = Auth::guard("api")->user();
    return response()->json(['succes' => true, "data" => $user]);
});
Route::post("/login", [Controller::class, "login"]);
Route::post("/logout", [Controller::class, "logout"]);
