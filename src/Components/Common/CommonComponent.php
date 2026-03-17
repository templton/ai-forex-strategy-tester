<?php

namespace Components\Common;

use Components\Common\Contracts\TimeInfo\TimeInfoDto;
use Components\Common\Contracts\TimeInfo\TimeInfoInterface;
use DateTime;

class CommonComponent implements TimeInfoInterface
{
    public function getTimeInfo(): TimeInfoDto
    {
        $now = new DateTime();
        $isoDay = (int) $now->format('N'); // 1..7 (Mon..Sun)

        $daysUntilSunday = (7 - $isoDay) % 7;
        if ($daysUntilSunday === 0) {
            $daysUntilSunday = 7;
        }

        $endOfWeek = (clone $now)->modify('+' . $daysUntilSunday . ' days')->setTime(0, 0, 0);
        $diffSeconds = max(0, $endOfWeek->getTimestamp() - $now->getTimestamp());

        $totalMinutes = intdiv($diffSeconds, 60);
        $minutes = $totalMinutes % 60;
        $totalHours = intdiv($totalMinutes, 60);
        $hours = $totalHours % 24;
        $days = intdiv($totalHours, 24);

        $dto = new TimeInfoDto();
        $dto->currentDate = $now;
        $dto->dayOfWeek = $isoDay;
        $dto->timeToEnd = sprintf('%02d:%02d:%02d', $days, $hours, $minutes);

        return $dto;
    }
}

