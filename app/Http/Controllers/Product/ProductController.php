<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product) {
        return view('products.show', [
            'product' => $product
        ]);
    }
}
