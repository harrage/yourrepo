<?php

namespace App\Jobs;

use App\Enums\CategoryEnum;
use Illuminate\Support\Str;

abstract class FetchFromSource
{
    abstract public function handle(): void;

    protected function extractCategory(?string $category): ?CategoryEnum
    {
        return match (Str::lower($category)) {
            'business' => CategoryEnum::BUSINESS,
            'entertainment', 'top', 'styles', 'tstyles', 'lifestyle', 'world', 'tourism', 'travel' => CategoryEnum::ENTERTAINMENT,
            'health' => CategoryEnum::HEALTH,
            'science' => CategoryEnum::SCIENCE,
            'sports' => CategoryEnum::SPORTS,
            'technology' => CategoryEnum::TECHNOLOGY,
            'politics', 'foreign', 'national' => CategoryEnum::POLITICS,
            default => CategoryEnum::GENERAL
        };
    }

    protected function extractAuthor(?string $author): ?string
    {
        return explode('and ', str_replace('by ', '', strtolower($author)))[0] ?? null;
    }
}
