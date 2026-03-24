<?php

namespace App\Contracts\Repository\Strategy;

use App\Contracts\Repository\Strategy\Dto\CreateStrategyDto;
use App\Models\Strategy;

interface StrategyRepositoryInterface
{
    public function create(CreateStrategyDto $dto): Strategy;

    public function find(int $id): ?Strategy;

    /**
     * @param array<string, mixed> $data
     */
    public function update(Strategy $strategy, array $data): Strategy;
}
