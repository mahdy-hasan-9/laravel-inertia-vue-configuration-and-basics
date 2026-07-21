<?php

namespace App\Filters\Product;

use Illuminate\Database\Eloquent\Builder;


use Closure;

class Vendor
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->filled('vendor_id')) {
            $builder->where('vendor_id', request('vendor_id'));
        }

        return  $next($builder);
    }
}
