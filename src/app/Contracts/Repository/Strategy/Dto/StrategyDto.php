<?php

namespace App\Contracts\Repository\Strategy\Dto;

readonly class StrategyDto
{
    public function __construct(
        public int $id,
        public string $description,
        public array $parameters,
        public int $version,
        public string $createdAt,
        public string $updatedAt,
    ) {
    }
}
