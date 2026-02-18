<?php

namespace App\DTOs;

class ExplanationResult
{
    public function __construct(
        public string $summary_ar,
        public string $summary_en,
        public array $reasons_ar,
        public array $reasons_en,
        public array $debug_payload,
    ) {}

    public function toArray(): array
    {
        return [
            'summary_ar' => $this->summary_ar,
            'summary_en' => $this->summary_en,
            'reasons_ar' => $this->reasons_ar,
            'reasons_en' => $this->reasons_en,
            'debug_payload' => $this->debug_payload,
        ];
    }
}
