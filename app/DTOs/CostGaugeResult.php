<?php

namespace App\DTOs;

class CostGaugeResult
{
    public function __construct(
        public float $a,
        public string $label_key,
        public string $label,
        public array $range_used,
        public array $ranges,
        public int $min,
        public int $max,
    ) {}

    public function toArray(): array
    {
        return [
            'a' => $this->a,
            'label_key' => $this->label_key,
            'label' => $this->label,
            'range_used' => $this->range_used,
            'ranges' => $this->ranges,
            'min' => $this->min,
            'max' => $this->max,
        ];
    }
}
