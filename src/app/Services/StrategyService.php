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

    /**
     * @return array{
     *     data: array<int, array{id:int,description:string,parameters:array,version:int,created_at:string|null,updated_at:string|null}>,
     *     meta: array{current_page:int,last_page:int,per_page:int,total:int}
     * }
     */
    public function getStrategies(int $page, int $limit): array
    {
        $paginator = $this->strategyRepository->getPaginated($page, $limit);

        $data = $paginator->getCollection()
            ->map(static fn ($strategy): array => [
                'id' => $strategy->id,
                'description' => $strategy->description,
                'parameters' => $strategy->parameters,
                'version' => $strategy->version,
                'created_at' => $strategy->created_at?->toDateTimeString(),
                'updated_at' => $strategy->updated_at?->toDateTimeString(),
            ])
            ->values()
            ->all();

        return [
            'data' => $data,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ];
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

    public function deleteStrategy(int $id): void
    {
        $model = $this->strategyRepository->find($id);

        if ($model === null) {
            throw new ModelNotFoundException('Strategy not found');
        }

        $this->strategyRepository->delete($id);
    }
}
