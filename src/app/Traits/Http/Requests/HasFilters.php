<?php

namespace App\Traits\Http\Requests;

trait HasFilters
{
    /**
     * @return mixed
     */
    abstract public function query($key = null, $default = null);

    protected function getFilterKeyName(): string
    {
        return 'filters';
    }

    public function filters(): array
    {
        $filteredValues = [];
        foreach ($this->processedFilters() as $filter) {
            try {
                $filter = explode('=', $filter);
                $filteredValues[$filter[0]] = explode('|', $filter[1]);
            } catch (\ErrorException) {
            }
        }

        return $filteredValues;
    }

    protected function processedFilters(): array
    {
        return explode(',', $this->query($this->getFilterKeyName()));
    }
}
