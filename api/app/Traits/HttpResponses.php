<?php

namespace App\Traits;

/**
 * HttpResponses Trait
 */
trait HttpResponses
{
    protected function success($data, $message = NULL, $code = 200)
    {
        return response()->json([
            'status' => 'Request was successful.',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($data, $message = NULL, $code)
    {
        return response()->json([
            'status' => 'Error Occured.',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}


