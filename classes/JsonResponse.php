<?php

class JsonResponse
{
    public static function success($message = '', $data = [])
    {
        self::send(true, $message, $data);
    }

    public static function error($message = '', $data = [])
    {
        self::send(false, $message, $data);
    }

    private static function send($success, $message, $data = [])
    {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }
}