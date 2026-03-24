<?php

namespace App\Contracts\Repository\Strategy\Dto;

readonly class UpdateStrategyDto
{
    public function __construct(
        public ?string $description,
        public ?array $parameters,
    ) {
    }
}
