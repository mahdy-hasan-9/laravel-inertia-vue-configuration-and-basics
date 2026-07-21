<?php 

namespace App\Filters\Product;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class SubCategory
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->filled('sub_category_id')) {
            $builder->where('sub_category_id', request('sub_category_id'));
        }

        return $next($builder);
    }
}