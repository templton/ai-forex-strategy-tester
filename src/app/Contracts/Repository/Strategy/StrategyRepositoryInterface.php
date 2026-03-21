<?php

namespace App\Contracts\Repository\Strategy;

use App\Contracts\Repository\Strategy\Dto\CreateStrategyDto;
use App\Models\Strategy;

interface StrategyRepositoryInterface
{
    public function create(CreateStrategyDto $dto): Strategy;
}
