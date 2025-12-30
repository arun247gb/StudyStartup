<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;

class Helper
{
    public static function paginationCount(): int
    {
        return Request::input(
            'pagination_count',
            config('auth.default_pagination_count', 20)
        );
    }

    public static function filterBoolean($request)
    {
        $paginate = ($request->query('paginate', true));
        return filter_var($paginate, FILTER_VALIDATE_BOOLEAN);
    }
}