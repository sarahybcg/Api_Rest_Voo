<?php

namespace App\Http\Responses;

class ApiResponses
{
    public static function success($message= 'Success', $statusCode=200, $data= []){
        return response()->json([
            'message'=> $message,
            'statusCode'=> $statusCode,
            'error'=>false,
            'data'=> $data
        ],$statusCode);
    }
}