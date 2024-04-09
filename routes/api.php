<?php

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
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
        return throw new HttpResponseException(response()->json(['errors' => $messages,  'succes' => false]), 422);
    }

    return response()->json(['succes' => true]);
});
