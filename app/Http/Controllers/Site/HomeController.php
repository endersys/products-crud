<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();

        $products->when($request->term, function($query, $vl) {
            $query->where('name', 'like', '%' . $vl . '%');
        });

        return view('home.index', [
            'products' => $products->get()
        ]);
    }
}