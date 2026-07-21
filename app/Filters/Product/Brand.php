<?php 

namespace App\Filters\Product;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Brand
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->filled('brand_id')) {
            $builder->where('brand_id', request('brand_id'));
        }

        return $next($builder);
    }
}