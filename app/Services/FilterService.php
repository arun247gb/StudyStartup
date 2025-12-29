<?php

namespace App\Services;

use App\Helpers\Helper;
use Spatie\QueryBuilder\QueryBuilder;

class FilterService
{

    public function filter(
        string $tableName,
        string $modelName,
        $baseQuery = null,
        array $allowedSorts = [],
        array $allowedFilters = [],
        array $with = [],
        ?array $authUser = null,
        $limit=0,
        bool $paginate = true
    ) {
        // Use base query if provided, otherwise model query
        $query = $baseQuery 
            ? QueryBuilder::for($baseQuery)
            : QueryBuilder::for($modelName);

        // Apply allowed filters, sorts, and relations
        $query->allowedSorts($allowedSorts)
              ->allowedFilters($allowedFilters)
              ->with($with);

        // Apply public scope if exists
        if (method_exists($modelName, 'scopePublic')) {
            $query->public($authUser);
        }
        
        if (!$paginate && $limit > 0) {
            $query->limit($limit);
        }

        return $paginate
            ? $query->paginate(Helper::paginationCount())
            : $query->get();
    }
}
