<?php

namespace App;

class Helpers
{
    /**
     * Created a reusable function for us to use (REMEMBER DRY - Don't Repeat Yoursel)
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
}