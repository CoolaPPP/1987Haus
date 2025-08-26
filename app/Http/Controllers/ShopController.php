<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Models\RecommendProduct;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $productTypes = ProductType::all();
        
        $productsQuery = Product::with('productType');

        if ($request->filled('type')) {
            $productsQuery->where('producttype_id', $request->type);
        }

        $products = $productsQuery->latest()->paginate(12);

        return view('shop.index', compact('products', 'productTypes'));
    }

    public function recommended()
    {
        $recommendedProducts = RecommendProduct::with('product.productType')->latest()->get();
        return view('shop.recommended', compact('recommendedProducts'));
    }
}