<?php

namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Traits\SearchFilterOperations;

class SearchText implements Filter
{
    use SearchFilterOperations;

    /**
     * Apply search filter dynamically based on config.
     *
     * @param Builder $query
     * @param mixed $value
     * @param string $tableName
     */
    public function __invoke(Builder $query, $value, string $tableName)
    {
        $value = trim(is_array($value) ? implode(',', $value) : $value);
        if ($value === '') return;

        // Load columns and relationships from config
        $config = config('search-fields');

        $fields = $config[$tableName] ?? ['name']; 

        $query->where(function ($q) use ($fields, $tableName, $value) {
            foreach ($fields as $field) {

                // If field is an array with relationship search
                if (is_array($field)) {
                    if (!empty($field['with-search'])) {
                        $this->applyRelationshipSearch($q, $field['with-search'], $value);
                    }
                    if (!empty($field['raw-query-search'])) {
                        $this->applyRawQuerySearch($q, $field['raw-query-search'], $value);
                    }
                    continue;
                }

                // If field is a relational column string "relation.column"
                if (strpos($field, '.') !== false) {
                    [$relation, $column] = explode('.', $field);
                    $q->orWhereHas($relation, function ($relQuery) use ($column, $value) {
                        $relQuery->where($column, 'LIKE', "%{$value}%");
                    });
                } else {
                    // Normal table column
                    $q->orWhere("{$tableName}.{$field}", 'LIKE', "%{$value}%");

                    // Optional date search
                    if ($this->hasSearchDateField($field)) {
                        $this->applyDateSearch($q, $value, [$field]);
                    }
                }
            }
        });
    }
}
