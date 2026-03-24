<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Repository\Strategy\Dto\CreateStrategyDto;
use App\Contracts\Repository\Strategy\Dto\UpdateStrategyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\StrategyStoreRequest;
use App\Http\Requests\Strategy\StrategyUpdateRequest;
use App\Services\StrategyService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class StrategyController extends Controller
{
    public function __construct(
        private StrategyService $strategyService,
    ) {
    }

    /**
     * Create a new trading strategy.
     *
     * Endpoint: POST /api/v1/strategies
     *
     * @return JsonResponse
     */
    public function store(StrategyStoreRequest $request): JsonResponse
    {
        /** @var array{description: string, parameters: array} $validated */
        $validated = $request->validated();

        $dto = new CreateStrategyDto(
            description: $validated['description'],
            parameters: $validated['parameters'],
        );

        $result = $this->strategyService->createStrategy($dto);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $result->id,
                'description' => $result->description,
                'parameters' => $result->parameters,
                'version' => $result->version,
                'createdAt' => $result->createdAt,
                'updatedAt' => $result->updatedAt,
            ],
            'message' => 'Strategy created successfully',
            'errors' => [],
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->strategyService->getStrategy($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => $exception->getMessage(),
                'errors' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $result->id,
                'description' => $result->description,
                'parameters' => $result->parameters,
                'version' => $result->version,
                'createdAt' => $result->createdAt,
                'updatedAt' => $result->updatedAt,
            ],
            'message' => 'OK',
            'errors' => [],
        ], 200);
    }

    public function update(StrategyUpdateRequest $request, int $id): JsonResponse
    {
        /** @var array{description?: string, parameters?: array} $validated */
        $validated = $request->validated();

        $dto = new UpdateStrategyDto(
            description: $validated['description'] ?? null,
            parameters: $validated['parameters'] ?? null,
        );

        try {
            $result = $this->strategyService->updateStrategy($id, $dto);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => $exception->getMessage(),
                'errors' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $result->id,
                'description' => $result->description,
                'parameters' => $result->parameters,
                'version' => $result->version,
                'createdAt' => $result->createdAt,
                'updatedAt' => $result->updatedAt,
            ],
            'message' => 'OK',
            'errors' => [],
        ], 200);
    }
}
