<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function sendResponse(array $data = [], int $httpCode = 200): JsonResponse
    {
        $responseStatus = [
            'success' => true
        ];

        if ($httpCode !== 200) {
            $responseStatus['success'] = false;
        }
        if ($httpCode === 401) {
            $responseStatus['message'] = 'Invalid credentials.';
        }
        if ($httpCode === 403) {
            $responseStatus['message'] = 'Unauthorized action.';
        }
        if ($httpCode === 422) {
            $responseStatus['message'] = 'Validation error.';
        }
        $response = array_merge($responseStatus, $data);
        return response()->json($response, $httpCode);
    }
}
