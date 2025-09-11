<?php

namespace App\Filters;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class ArticleFilter extends Filter
{
    public function category(Builder $query, mixed $value): Builder
    {
        return $query->where('category_id', $value);
    }

    public function source(Builder $query, mixed $value): Builder
    {
        return $query->where('source_id', $value);
    }

    public function dateFrom(Builder $query, mixed $value): Builder
    {
        return $query->where('published_at', '>=', $value);
    }

    public function dateTo(Builder $query, mixed $value): Builder
    {
        return $query->where('published_at', '<=', $value);
    }

    public function keywords(Builder $query, mixed $value): Builder
    {
        Log::debug($value);
        if (empty($value)) {
            return $query;
        }
        $query->where('description', 'like', '%'.$value[0].'%');
        foreach (array_slice($value, 1) as $keyword) {
            $query->orWhere('description', 'like', '%'.$keyword.'%');
        }

        return $query;
    }
}
