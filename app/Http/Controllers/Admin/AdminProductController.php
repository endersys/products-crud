<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'products' => Product::all()
        ]);
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        try {
            $input = $request->validate([
                'name' => 'required',
                'price' => 'required',
                'stock' => 'required|integer',
                'description' => 'required',
                'cover' => 'required|file'
            ]);
            
            if ($request->hasFile('cover')) {
                $image = $request->file('cover');
                $imageName = date('YmdHi') . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $input['cover'] = $imageName;
            }
            
            Product::create(array_merge($input, ['slug' => Str::slug($input['name'])]));
            return to_route('admin.products.index');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        return view('admin.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            $input = $request->validate([
                'name' => 'required',
                'price' => 'required',
                'stock' => 'required|integer',
                'description' => 'required',
            ]);

            $product->update(array_merge($input, ['slug' => Str::slug($input['name'])]));

            return to_route('admin.products.index');
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        return to_route('admin.products');
    }

    public function destroy(Product $product)
    {
    }
}
