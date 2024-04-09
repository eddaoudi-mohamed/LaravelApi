<?php


namespace App\Http\Traits;


trait GeneraleTrait
{

    public function returnError($message = "", $statusCode)
    {

        return response()->json(["status" => false, "statusCode" => $statusCode, "message" => $message]);
    }


    public function returnSuccess($message = "", $statusCode)
    {
        return response()->json(["status" => true, "statusCode" => $statusCode, "message" => $message]);
    }

    public function returnData($key, $value,  $statusCode)
    {
        return response()->json([$key => $value,  "statusCode" => $statusCode]);
    }
}
