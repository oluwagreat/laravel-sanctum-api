<?php

namespace App\Traits;

/**
 * This is for returning Http responses
 */
trait HttpResponses
{
    protected function success($data,$message = null, $code = 200){
        return response()->json([
            'status' => 'Request was successful',
            'message' => $message,
            'data' => $data
        ],$code);
    }
    

      protected function error($data,$message = null, $code){
        return response()->json([
            'status' => 'An error occured...',
            'message' => $message,
            'data' => $data
        ],$code);
    }
    
}
