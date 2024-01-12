<?php

namespace App;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Helpers
{
    /***
     * Created a reusable function for us to use
     */
    public static function returnJsonResponse($message, $httpStatus, $data = null)
    {
        if (!$data) {
            return response()->json(['message' => $message], $httpStatus);
        } else {
            return response()
                ->json([
                    'message' => $message,
                    'data' => $data
                ], $httpStatus);
        }
    }

    public static function permission_check($value)
    {
        if (auth()->check()) {
            $permission = json_decode(auth()->user()->userRole->permissions);
            if (in_array($value, $permission)) {
                return true;            
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
