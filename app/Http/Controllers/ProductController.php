<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id) {
        $product = Product::find($id);
        
        return view('products.show', [
            'product' => $product
        ]);
    }
}
