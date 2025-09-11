<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    protected function __construct(protected Builder $query, protected array $filters) {}

    public static function apply(Builder $query, array $filters): Builder
    {
        $instance = new static($query, $filters);

        foreach ($filters as $filterName => $filterValue) {
            try {
                $query = $instance->{$filterName}($query, $filterValue);
            } catch (\Error) {
                // fail silently
            }
        }

        return $query;
    }
}
