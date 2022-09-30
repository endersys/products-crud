<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\{ StoreProductRequest, UpdateProductRequest };
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Storage;
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

            if ($input['cover']) {
                $file = $input['cover'];
                $path = $file->store('public/products');
                $input['cover'] = $path;
            }
            
            $input['slug'] = Str::slug($input['name']);

            Product::create($input);
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

            if (!is_null($input['cover']) && $input['cover']->isValid()) {
                Storage::delete($product->cover ?? '');
                $file = $input['cover'];
                $path = $file->store('public/products');
                $input['cover'] = $path;
            }
            
            $input['slug'] = Str::slug($input['name']);

            $product->update($input);

            return to_route('admin.products.index');
        } catch (Exception $e) {
            return to_route('admin.products.index')->with('error', 'Erro ao tentar atualizar o produto!');
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
        Storage::delete($product->cover);

        return to_route('admin.products.index');
    }

    public function destroyImage(Product $product) {
        Storage::delete($product->cover);
        $product->update(['cover' => null]);
        return back();
    }
}
