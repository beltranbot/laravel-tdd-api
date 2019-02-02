<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Controllers\Controller;

use App\Product;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;
use App\Image;

class ProductController extends Controller
{

    public function index()
    {
        return new ProductCollection(Product::paginate());
    }

    public function store(ProductStoreRequest $request)
    {
        
        $image_arr = [];
        $imageId = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')
                ->store('product_images', 'public');
            $imageId = Image::create([
                'path' => $path
            ])->id;
        }

        $productData = [
            'image_id' => $imageId,
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'price' => $request->price,
        ];
        $productData = array_merge($image_arr, $productData);

        $product = Product::create($productData);
        
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
        $imageId = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')
                ->store('product_images', 'public');
            $imageId = Image::create([
                'path' => $path
            ])->id;
        }
        
        $product = Product::findOrFail($id);


        $product->update([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'price' => $request->price,
            'image_id' => $imageId,
        ]);

        return response()->json(new ProductResource($product));
    }

    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json(null, 204);
    }
}
