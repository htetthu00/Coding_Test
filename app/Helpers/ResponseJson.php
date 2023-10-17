<?php 

if(!function_exists('success')) {
    function success($message, $data, $status)  
    {
        return response()->json([
            'result' => 1,
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}

if(!function_exists('fail')) {
    function fail($message, $data, $status)  
    {
        return response()->json([
            'status' => $status,
            'result' => 0,
            'message' => $message,
            'data' => $data
        ]);
    }
}