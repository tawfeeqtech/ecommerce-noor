<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;

class ProductController extends Controller
{
    use ApiResponseTrait;

    public function show($id)
    {
        try {
            if (Product::whereId($id)->doesntExist()) {
                return $this->apiResponse([], "هذا المنتج غير موجود", 400);
            }
            $product = Product::whereId($id)->first();

            $product_color = $product->productColors->pluck('quantity', 'color_id')->toArray();
            $product_size = $product->productSizes->pluck('quantity', 'size_id')->toArray();
            //$product_size_key = array_keys($product_size);
            //$product_size_val = array_values($product_size);
//            $colors = Color::whereIn('id', $product_color)->pluck('name', 'code');

            $colorCollection = collect($product_color)->map(function ($item, $key) {
                return [
                    'color_id' => $key,
                    'color_quantity' => $item,
                    'color_name' => Color::where('id', $key)->select('name')->first()->name
                ];
            });

            $sizeCollection = collect($product_size)->map(function ($item, $key) {
                 return [
                     'size_id' => $key,
                     'size_quantity' => $item,
                     'size_name' => Size::where('id', $key)->select('name')->first()->name
                 ];
            });
//            $products = $collection->flatten(1);

//            dd($collection->values()->all());

            $result = Product::whereId($id)
                ->with(['productImages:id,image,product_id'])
                ->select(['id', 'name', 'description', 'small_description', 'original_price', 'selling_price', 'quantity'])
                ->first();

            $result['product_colors'] = $colorCollection->values()->all();
            $result['product_sizes'] = $sizeCollection->values()->all();

            return $this->apiResponse($result, "بيانات المنتج", 200);
        } catch (\Exception $e) {
            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }
}
