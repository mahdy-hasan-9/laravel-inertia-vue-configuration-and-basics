<?php 

namespace App\Filters\Product;

use App\Models\Product;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class Category
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->filled('category_id')) {
            $builder->where('category_id', request('category_id'));
        }

        return $next($builder);
    }

}