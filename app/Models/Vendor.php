<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public function brands()
    {
        return $this->hasMany(Brand::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
