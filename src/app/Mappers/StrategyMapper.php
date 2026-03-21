<?php

namespace App\Mappers;

use App\Contracts\Repository\Strategy\Dto\StrategyDto;
use App\Models\Strategy;

class StrategyMapper
{
    public function toDto(Strategy $model): StrategyDto
    {
        return new StrategyDto(
            id: (int) $model->id,
            description: $model->description,
            parameters: $model->parameters ?? [],
            version: (int) $model->version,
            createdAt: $model->created_at->toIso8601String(),
            updatedAt: $model->updated_at->toIso8601String(),
        );
    }
}
