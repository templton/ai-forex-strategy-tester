<?php

namespace App\Repository\Strategy;

use App\Contracts\Repository\Strategy\Dto\CreateStrategyDto;
use App\Contracts\Repository\Strategy\StrategyRepositoryInterface;
use App\Models\Strategy;

class StrategyRepository implements StrategyRepositoryInterface
{
    public function create(CreateStrategyDto $dto): Strategy
    {
        $model = Strategy::create([
            'description' => $dto->description,
            'parameters' => $dto->parameters,
        ]);
        $model->refresh();

        return $model;
    }
}
