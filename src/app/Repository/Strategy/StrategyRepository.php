<?php

namespace App\Repository\Strategy;

use App\Contracts\Repository\Strategy\Dto\CreateStrategyDto;
use App\Contracts\Repository\Strategy\StrategyRepositoryInterface;
use App\Models\Strategy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function find(int $id): ?Strategy
    {
        return Strategy::query()->find($id);
    }

    public function getPaginated(int $page, int $limit): LengthAwarePaginator
    {
        return Strategy::query()
            ->orderByDesc('id')
            ->paginate($limit, ['*'], 'page', $page);
    }

    public function update(Strategy $strategy, array $data): Strategy
    {
        $strategy->update($data);
        $strategy->refresh();

        return $strategy;
    }

    public function delete(int $id): bool
    {
        return Strategy::query()->where('id', $id)->delete() > 0;
    }
}
