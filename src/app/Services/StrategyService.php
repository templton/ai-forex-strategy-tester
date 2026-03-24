<?php

namespace App\Services;

use App\Contracts\Repository\Strategy\Dto\CreateStrategyDto;
use App\Contracts\Repository\Strategy\Dto\StrategyDto;
use App\Contracts\Repository\Strategy\Dto\UpdateStrategyDto;
use App\Contracts\Repository\Strategy\StrategyRepositoryInterface;
use App\Mappers\StrategyMapper;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function getStrategy(int $id): StrategyDto
    {
        $model = $this->strategyRepository->find($id);

        if ($model === null) {
            throw new ModelNotFoundException('Strategy not found');
        }

        return $this->strategyMapper->toDto($model);
    }

    public function updateStrategy(int $id, UpdateStrategyDto $dto): StrategyDto
    {
        $model = $this->strategyRepository->find($id);

        if ($model === null) {
            throw new ModelNotFoundException('Strategy not found');
        }

        $data = [];
        if ($dto->description !== null) {
            $data['description'] = $dto->description;
        }
        if ($dto->parameters !== null) {
            $data['parameters'] = $dto->parameters;
        }
        if ($data !== []) {
            $data['version'] = $model->version + 1;
            $model = $this->strategyRepository->update($model, $data);
        }

        return $this->strategyMapper->toDto($model);
    }
}
