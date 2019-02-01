<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Controllers\Controller;

use App\Product;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{

    public function index()
    {
        return new ProductCollection(Product::paginate());
    }

    public function store(ProductStoreRequest $request)
    {
        $product = Product::create ([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'price' => $request->price,
        ]);
        
        return response()->json(
            new ProductResource($product),
            201
        );
    }

    public function show(int $id)
    {
        $product = Product::findOrFail($id);

        return response()->json(new ProductResource($product));
    }

    public function update(ProductUpdateRequest $request, int $id)
    {
        $product = Product::findOrFail($id);

        $updatedProduct = [];
        if ($request->name) {
            $updatedProduct['name'] = $request->name;
        }
        if ($request->slug) {
            $updatedProduct['slug'] = $request->slug;
        }
        if ($request->price) {
            $updatedProduct['price'] = $request->price;
        }

        $product->update($updatedProduct);

        return response()->json(new ProductResource($product));
    }

    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json(null, 204);
    }
}
