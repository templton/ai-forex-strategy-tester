<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class TestApiController extends Controller
{
    /**
     * Test API endpoint
     *
     * @return JsonResponse
     */
    public function test(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'API is working properly',
            'data' => [
                'timestamp' => time(),
                'date' => date('Y-m-d H:i:s'),
                'php_version' => phpversion(),
                'laravel_version' => app()->version()
            ]
        ]);
    }
}
