<?php

namespace Components\Common\Contracts\TimeInfo;

use DateTime;

class TimeInfoDto
{
    public DateTime $currentDate;

    /**
     * ISO-8601 numeric representation of the day of the week.
     * 1 (for Monday) through 7 (for Sunday)
     */
    public int $dayOfWeek;

    /**
     * Time left to 00:00 of Sunday in format DD:HH:MM
     */
    public string $timeToEnd;
}

