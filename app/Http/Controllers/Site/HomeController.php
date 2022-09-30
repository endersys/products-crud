<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index() {
        return view('home.index', [
            'products' => Product::all()
        ]);
    }
}