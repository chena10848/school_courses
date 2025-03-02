<?php

namespace app\Http\Response;

class Response {

    public static function success($data = [], $status = 200, $message = "Success") {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public static function fail($data = [], $status = 200, $message = "Fail") {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }
}