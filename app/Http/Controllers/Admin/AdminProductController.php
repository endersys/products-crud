<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\{ StoreProductRequest, UpdateProductRequest };
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

    public function store(StoreProductRequest $request)
    {
        try {
            $input = $request->all();

            if ($request->hasFile('cover')) {
                $image = $request->file('cover');
                $imageName = date('YmdHi') . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $input['cover'] = $imageName;
            }
            
            Product::create(array_merge($input, ['slug' => Str::slug($input['name'] . date('Hi'))]));
            return to_route('admin.products.index');
        } catch (Exception $e) {
            return to_route('admin.products.create')->with('error', 'Erro ao tentar cadastrar o produto!');
        }
    }

    public function edit(Product $product)
    {
        return view('admin.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $input = $request->all();

            if ($request->hasFile('cover')) {
                $image = $request->file('cover');
                $imageName = date('YmdHi') . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $input['cover'] = $imageName;
            }

            $product->update(array_merge($input, ['slug' => Str::slug($input['name'])]));

            return to_route('admin.products.index');
        } catch (Exception $e) {
            return to_route('admin.products.index')->with('error', 'Erro ao tentar atualizar o produto!');
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return to_route('admin.products.index');
    }
}
