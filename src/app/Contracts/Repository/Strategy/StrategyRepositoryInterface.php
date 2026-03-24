<?php

namespace App\Contracts\Repository\Strategy;

use App\Contracts\Repository\Strategy\Dto\CreateStrategyDto;
use App\Models\Strategy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface StrategyRepositoryInterface
{
    public function create(CreateStrategyDto $dto): Strategy;

    public function find(int $id): ?Strategy;

    public function getPaginated(int $page, int $limit): LengthAwarePaginator;

    /**
     * @param array<string, mixed> $data
     */
    public function update(Strategy $strategy, array $data): Strategy;

    public function delete(int $id): bool;
}
