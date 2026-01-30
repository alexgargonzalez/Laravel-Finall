<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait JsonTrait {

    private function jsonResponse($data, $message, $success = true, $code = 200): JsonResponse {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'success' => $success
        ], $code);
    }

}