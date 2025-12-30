<?php

namespace App\Http\Traits;

trait SearchFilterOperations
{
    public function applyRelationshipSearch($query, string $relationshipField, string $value)
    {
        [$relation, $column] = explode('.', $relationshipField);

        $query->orWhereHas($relation, function ($q) use ($column, $value) {
            $q->where($column, 'LIKE', "%$value%");
        });
    }

    public function applyRawQuerySearch($query, $rawQuery, string $value)
    {
        $query->orWhereRaw($rawQuery, ['%' . $value . '%']);
    }

    public function hasSearchDateField($field): bool
    {
        // Customize which fields should be searched as dates
        return in_array($field, ['planned_activation_date', 'created_at', 'updated_at']);
    }

    public function applyDateSearch($query, string $value, array $fields)
    {
        foreach ($fields as $field) {
            $query->orWhereDate($field, $value);
        }
    }
}
