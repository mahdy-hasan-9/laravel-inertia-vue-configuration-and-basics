<?php

namespace App\Models;

use App\Filters\Product\Brand as BrandFilter;
use App\Filters\Product\Category as CategoryFilter;
use App\Filters\Product\Search as SearchFilter;
use App\Filters\Product\SubCategory as SubCategoryFilter;
use App\Filters\Product\Vendor as VendorFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Pipeline;

class Product extends Model
{

    public function scopeFilterWithPipeline(Builder $query)
    {
        return Pipeline::send($query)->through([
            SearchFilter::class,
            VendorFilter::class,
            BrandFilter::class,
            CategoryFilter::class,
            SubCategoryFilter::class
        ])->thenReturn();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }
}
