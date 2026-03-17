<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CommonApiController extends Controller
{
    /**
     * Get current time and week info.
     *
     * Endpoint: GET /api/v1/time/current
     *
     * @return JsonResponse
     */
    public function getWeekDayInfo(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'OK',
            'data' => [
                'currentDate' => date('d.m.Y H:i:s'),
                'dayOfWeek' => null,
                'timeToEnd' => null,
            ],
        ]);
    }
}

