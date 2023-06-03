<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class FavoriteController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
//    public function index(Request $request)
//    {
//        $user = auth()->user();
//
//        $validator = validator()->make($request->all(), [
//            'category_id' => [
//                'nullable',
//                'exists:categories,id',
//                function ($attribute, $value, $fail) use ($user) {
//                    if ($value) {
//                        $favorite = Favorite::whereHas('product', function ($query) use ($value) {
//                            $query->where('category_id', $value);
//                        })->where('user_id', $user->id)->first();
//
//                        if (!$favorite) {
//                            $fail('The selected category does not belong to a product in your favorites.');
//
//                            //return $this->apiResponse("التصنيف المحدد لا ينتمي إلى أي منتج في المفضلة",'errors', 422);
//                        }
//                    }
//                }
//            ],
//            'color_id' => [
//                'nullable',
//                'exists:colors,id',
//                function ($attribute, $value, $fail) use ($user) {
//                    if ($value) {
//                        $favorite = Favorite::whereHas('product.productColors.color', function ($query) use ($value) {
//                            $query->where('id', $value);
//                        })->where('user_id', $user->id)->first();
//
//                        if (!$favorite) {
//                            $fail('The selected color does not belong to a product in your favorites.');
//                        }
//
//
//                        /*$favorite = Favorite::whereHas('product', function ($query) use ($value) {
//                            $query->whereHas('colors', function ($subQuery) use ($value) {
//                                $subQuery->where('color_id', $value);
//                            });
//                        })->where('user_id', $user->id)->first();
//
//                        if (!$favorite) {
//                            $fail('The selected color does not belong to a product in your favorites.');
//                        }*/
//                    }
//                }
//            ],
//        ]);
//
//        if ($validator->fails()) {
//            //return $this->apiResponse("التصنيف المحدد لا ينتمي إلى أي منتج في المفضلة",'errors', 422);
//            return $this->apiResponse($validator->errors(),'errors', 422);
//        }
//
//        $categoryId = $request->category_id;
//        $colorId = $request->color_id;
//
//
//        $favorites = $user->favorites();
//
//        if ($categoryId) {
//            /*$category = Category::findOrFail($categoryId);
//            $favorites->whereHas('product', function ($query) use ($category) {
//                $query->where('category_id', $category->id);
//            });*/
//            $favorites->whereHas('product', function ($query) use ($categoryId) {
//                $query->where('category_id', $categoryId);
//            });
//
//        }
//
//        if ($colorId) {
//            /*$favorites->whereHas('product', function ($query) use ($colorId) {
//                $query->whereHas('colors', function ($subQuery) use ($colorId) {
//                    $subQuery->where('color_id', $colorId);
//                });
//            });*/
//
//            $favorites->whereHas('product.productColors.color', function ($query) use ($colorId) {
//                $query->where('id', $colorId);
//            })
//                ->where('user_id', $user->id)
//                ->with(['product.productImages:id,image,product_id'])
//                ->orderBy('id', 'ASC');
//        }
//
//
//
//        $favorites->with(['product:id,name,small_description,original_price,selling_price']);
//
//        $products = $favorites->paginate(5,['product_id']);
//
//        return $this->apiResponse($products, "بيانات المفضلة", 200);
//    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'color_id' => 'nullable|exists:colors,id',
            'category_id' => 'nullable|exists:categories,id',
            'size_id' => 'nullable|exists:sizes,id',
            'search' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(),'errors', 422);
        }

        $user = $request->user();
        $colorId = $request->input('color_id');
        $category_id = $request->input('category_id');
        $sizeId = $request->input('size_id');
        $search = $request->input('search');

        $favorites = Favorite::where('user_id', $user->id)
            ->when($colorId, function ($query) use ($colorId) {
                $query->whereHas('product.productColors.color', function ($query) use ($colorId) {
                    $query->where('id', $colorId);
                });
            })
            ->when($category_id, function ($query) use ($category_id) {
                $query->whereHas('product.category', function ($query) use ($category_id) {
                    $query->where('id', $category_id);
                });
            })
            ->when($sizeId, function ($query) use ($sizeId) {
                $query->whereHas('product.productSizes', function ($query) use ($sizeId) {
                    $query->where('size_id', $sizeId);
                });
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('product', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            })
            ->with(['product.productImages:id,image,product_id'])

            ->orderBy('id', 'ASC')
            ->paginate(5, ['product_id']);

        if ($favorites->isEmpty()) {
            return $this->apiResponse('No favorites found matching the specified criteria','errors', 404);
        }
//        ->transform(function ($favorite) {
//        $product = $favorite->product;
////                'id', 'name','small_description','original_price','selling_price'
//        $productData = [
//            'name' => $product->name,
//            'small_description' => $product->small_description,
//            'original_price' => $product->original_price,
//            'selling_price' => $product->selling_price,
//        ];
//        unset($favorite['product']);
//        return array_merge($favorite->toArray(), $productData);
//    });

        $favorites->getCollection()->transform(function ($favorite) {
            $product = $favorite->product;
            $productData = [
                'name' => $product->name,
                'small_description' => $product->small_description,
                'original_price' => $product->original_price,
                'selling_price' => $product->selling_price,
            ];
            unset($favorite['product']);
            return array_merge($favorite->toArray(), $productData);
        });


        return $this->apiResponse($favorites, "بيانات المفضلة", 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(),'errors', 422);
        }
        $validated = $validator->validated();

        $favorite = Favorite::firstOrCreate([
            'user_id' => $user->id,
            'product_id' => $validated['product_id'],
        ]);

        return $this->apiResponse($favorite, "تم اضافة المنتج للمفضلة", 201);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return Response
     */
    public function destroy($product)
    {
        $user = auth()->user();
        try {
            $product = Product::findOrFail($product);
        } catch (ModelNotFoundException $exception) {
            return $this->apiResponse(null, "المنتج غير موجود", 404);
        }


        $favorite = $user->favorites()->where('product_id', $product->id)->first();

        if (!$favorite) {
            return $this->apiResponse(null, "المنتج غير موجود", 404);
        }

        $favorite->delete();
        return $this->apiResponse(null, "تم حذف المنتج من المفضلة", 200);
    }
}
