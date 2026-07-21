<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::select(['id', 'brand_id', 'category_id', 'sub_category_id', 'name', 'slug', 'image', 'price', 'discount_price', 'rating', 'is_discount'])
            ->with(['brand:id,name', 'category:id,name', 'subCategory:id,name'])
            ->filterWithPipeline()
            ->latest('id')
            ->paginate(9)
            ->withQueryString();


        return Inertia("product/Products", [
            'message' => "This is products page",
            'products' => ProductResource::collection($products),
            'filters'  => $request->only(['search', 'vendor_id', 'brand_id', 'category_id', 'sub_category']),
            'vendors' => Vendor::where('is_active', 1)->select('id', 'name')->get(),

            'brands' => Inertia::defer(fn() => $request->filled('vendor_id')
                ? Brand::where('vendor_id', $request->vendor_id)->where('is_active', true)->select('id', 'name')->get()
                : []),

            'categories' => fn() => $request->filled('brand_id')
                ? Category::where('brand_id', $request->brand_id)->where('is_active', true)->select('id', 'name')->get()
                : [],

            'subCategories' => fn() => $request->filled('category_id')
                ? SubCategory::where('category_id', $request->category_id)->where('is_active', true)->select('id', 'name')->get()
                : [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
