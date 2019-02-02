<?php

namespace App\Utopia\Repositories\Eloquent;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use App\Utopia\Repositories\Interfaces\ProductRepoInterface;
use App\Image;
use App\Utopia\Repositories\Eloquent\AbstractRepo;

class ProductRepo extends AbstractRepo implements ProductRepoInterface
{
    public function __construct()
    {
        parent::__construct('Product');
    }
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

    public function update(ProductUpdateRequest $request, $product)
    {
        $imageId = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')
                ->store('product_images', 'public');
            $imageId = Image::create([
                'path' => $path
            ])->id;
        }

        $product->update([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'price' => $request->price,
            'image_id' => $imageId,
        ]);

        return $product;
    }

    public function delete($product)
    {
        $product->delete();
    }
}