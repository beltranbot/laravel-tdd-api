<?php

namespace App\Utopia\Repositories\Eloquent;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use App\Utopia\Repositories\Interfaces\ProductRepoInterface;

class ProductRepo implements ProductRepoInterface
{
    public function create(ProductStoreRequest $request)
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

        return $product = Product::create($productData);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $imageId = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')
                ->store('product_images', 'public');
            $imageId = Image::create([
                'path' => $path
            ])->id;
        }

        return $product->update([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'price' => $request->price,
            'image_id' => $imageId,
        ]);
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}