<?php

namespace App\Services;

use App\Contracts\Repository\Strategy\Dto\CreateStrategyDto;
use App\Contracts\Repository\Strategy\Dto\StrategyDto;
use App\Contracts\Repository\Strategy\StrategyRepositoryInterface;
use App\Mappers\StrategyMapper;

class StrategyService
{
    public function __construct(
        private StrategyRepositoryInterface $strategyRepository,
        private StrategyMapper $strategyMapper,
    ) {
    }

    public function createStrategy(CreateStrategyDto $dto): StrategyDto
    {
        $model = $this->strategyRepository->create($dto);

        return $this->strategyMapper->toDto($model);
    }
}
