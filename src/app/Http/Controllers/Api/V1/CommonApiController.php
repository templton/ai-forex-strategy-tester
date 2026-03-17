<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Components\Common\Contracts\TimeInfo\TimeInfoInterface;
use Illuminate\Http\JsonResponse;

class CommonApiController extends Controller
{
    private TimeInfoInterface $commonComponent;

    public function __construct(TimeInfoInterface $commonComponent)
    {
        $this->commonComponent = $commonComponent;
    }

    /**
     * Get current time and week info.
     *
     * Endpoint: GET /api/v1/time/current
     *
     * @return JsonResponse
     */
    public function getWeekDayInfo(): JsonResponse
    {
        $timeInfo = $this->commonComponent->getTimeInfo();

        $weekDays = [
            1 => 'ПН',
            2 => 'ВТ',
            3 => 'СР',
            4 => 'ЧТ',
            5 => 'ПТ',
            6 => 'СБ',
            7 => 'ВС',
        ];

        return response()->json([
            'success' => true,
            'message' => 'OK',
            'data' => [
                'currentDate' => $timeInfo->currentDate->format('d.m.Y H:i:s'),
                'dayOfWeek' => $weekDays[$timeInfo->dayOfWeek] ?? 'ВС',
                'timeToEnd' => $timeInfo->timeToEnd,
            ],
        ]);
    }
}

