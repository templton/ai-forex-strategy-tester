<?php

namespace Components\Common\Contracts\TimeInfo;

interface TimeInfoInterface
{
    public function getTimeInfo(): TimeInfoDto;
}

