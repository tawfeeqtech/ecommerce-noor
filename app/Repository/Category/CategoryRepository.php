<?php

namespace App\Repository\Category;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;


class CategoryRepository implements CategoryRepositoryInterface
{
    use ApiResponseTrait;

    public function getAllCategories()
    {
        $categories = CategoryResource::collection(Category::where('status','0')->get());
        return $this->apiResponse($categories, "جميع التصنيفات", 200);
    }

    public function showCategories($id)
    {
        try {
            if ($id == 0){
                $result = Product::with(['productImages:id,image,product_id'])
                    ->orderBy('id', 'ASC')
                    ->select(['id', 'name','small_description','original_price','selling_price'])
                    ->paginate(5);
            }else{
                $result = Product::where('category_id',$id)->with(['productImages:id,image,product_id'])
                    ->orderBy('id', 'ASC')
                    ->select(['id', 'name','small_description','original_price','selling_price'])
                    ->paginate(5);
            }
            if ($result->total() > 0) {
                return $this->apiResponse($result, 'جميع المنتجات', 200);
            }
            return $this->apiResponse(null, "لا يوجد منتجات", 201);
        } catch (\Exception $e) {
            return $this->apiResponse(null, $e->getMessage(), 400);
        }
    }

    public function searchProduct($id,$search)
    {
        try {
            if ($search !== "") {
                if($id == 0){
                    $result = Product::where(function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })->with(['productImages:id,image,product_id'])->orderBy('id', 'ASC')->paginate(5, ['id', 'name', 'small_description', 'original_price', 'selling_price']);
                }else{
                    $result = Product::where('category_id', $id)->where(function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })->with(['productImages:id,image,product_id'])->orderBy('id', 'ASC')->paginate(5, ['id', 'name', 'small_description', 'original_price', 'selling_price']);
                }
                if(!empty($result->items())){
                    return $this->apiResponse($result, 'جميع المنتجات', 200);
                }else{
                    return $this->apiResponse(null, 'لا يوجد منتجات', 200);
                }
            }else{
                return $this->apiResponse(null, "يجب ادخال كلمة للبحث", 400);
            }
        }catch (\Exception $e) {
            return $this->apiResponse(null, $e->getMessage(), 400);
        }

    }

}
