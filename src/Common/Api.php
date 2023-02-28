<?php

namespace Lincms\Common;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class Api extends Response
{
    protected static function status($status, $data, $code, $message = ''): JsonResponse
    {
        $res = [
            'status' => $status,
            'message' => $message,
            'data' => (object) $data,
        ];

        return Response::json($res, $code);
    }

    public static function message(string $message, mixed $data = [], int $code = 200): JsonResponse
    {
        return static::status('success', $data, $code, $message);
    }

    public static function success(mixed $data, string $message = '', int $code = 200): JsonResponse
    {
        return static::status('success', $data, $code, $message);
    }

    public static function failed(string $message, int $code = 400, mixed $data = []): JsonResponse
    {
        return static::status('error', $data, $code, $message);
    }
}
