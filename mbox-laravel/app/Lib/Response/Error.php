<?php

namespace App\Lib\Response;

class Error
{
    public static function notFount()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Not found',
        ], 404);
    }
    public static function validetedError()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Validated error',
        ], 419);
    }
    public static function unauthorized()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized',
        ], 401);
    }
}
