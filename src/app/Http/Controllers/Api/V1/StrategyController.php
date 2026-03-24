<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Repository\Strategy\Dto\CreateStrategyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\StrategyStoreRequest;
use App\Services\StrategyService;
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
}
