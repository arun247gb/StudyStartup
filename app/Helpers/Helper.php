<?php

// This class file to define all general functions

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
}