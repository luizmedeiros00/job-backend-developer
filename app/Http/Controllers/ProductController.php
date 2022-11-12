<?php

namespace App\Http\Controllers;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(ProductFilter $request, Product $product)
    {
        try {
            $products = $product->filter($request)->get();
            return response($products);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function show(Product $product)
    {
        try {
            return response($product);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->validated();
            $product = Product::create($data);
            return response($product);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $product->update($request->validated());
            return response($product);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response('Produto deletado com sucesso');
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }
}
