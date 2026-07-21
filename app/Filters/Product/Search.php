<?php

namespace App\Filters\Product;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Search
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->filled('search')) {
            $builder->where('name', 'like', '%' . request('search') . '%');
        }

        return $next($builder);
    }
}
