<?php

namespace App\DTOs;

class SensitivityResult
{
    public function __construct(
        public float $base_cost,
        public array $bar_data,
        public array $top_influencers,
        public array $debug_payload,
    ) {}

    public function toArray(): array
    {
        return [
            'base_cost' => $this->base_cost,
            'bar_data' => $this->bar_data,
            'top_influencers' => $this->top_influencers,
            'debug_payload' => $this->debug_payload,
        ];
    }
}
