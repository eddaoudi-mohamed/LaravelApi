<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\GeneraleTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use PhpParser\Node\Stmt\TryCatch;
use Tymon\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, GeneraleTrait;



    public function login(Request $request)
    {
        $rules = [
            "email" => "required",
            "password" => "required"
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages  = $validator->messages();
            return $this->returnError($messages, "405");
        }


        $token =   Auth::guard("api")->attempt($request->only(['email', "password"]));
        if (!$token) {
            return $this->returnError("credentials not correct", "#0000");
        }

        $user = Auth::guard("api")->user();

        return $this->returnData("token", [$token, $user], true);
        // return response("login success", 200, [$token, $user])->withCookie($token);
    }

    public function logout(Request $request)
    {
        $token = $request->header('auth-token');


        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate();
                return $this->returnSuccess("logout successfuly", "#0004");
            } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

                return $this->returnError($e->getMessage(), "#333");
            }
        } else {

            return $this->returnError("some thing worng", "#333");
        }
    }
    public function profile()
    {
        $user = Auth::user();
        return $this->returnData("user", $user,  "#200");
    }
}
