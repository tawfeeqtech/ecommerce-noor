<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use ApiResponseTrait;

    public function addToCart(Request $request, $product_id)
    {
        // auth user
        $this->validate($request, [
            'quantity_count' => 'required',
            'size_id' => 'nullable',
        ]);
        try {
            if (Product::whereId($product_id)->doesntExist()) {
                return $this->apiResponse([], "هذا المنتج غير موجود", 400);
            } else {
                $user_id = auth()->user()->id;
                $product = Product::whereId($product_id)->first();
                if (!empty($request->size_id)) {
                    if ($product->productSizes()->where('size_id', $request->size_id)->first()) {
                        $productSize = $product->productSizes()->where('size_id', $request->size_id)->first();
                        if (Cart::where('user_id', $user_id)
                            ->where('product_id', $product_id)
                            ->where('product_size_id', $request->size_id)
                            ->exists()) {
                            return $this->apiResponse([], "تم طلب هذا المنتج مسبقاً", 400);
                        } else {
                            if ($productSize->quantity > 0) {
                                if ($productSize->quantity >= $request->quantity_count) {
                                    Cart::create([
                                        'user_id' => $user_id,
                                        'product_id' => $product_id,
                                        'product_size_id' => $request->size_id,
                                        'quantity' => $request->quantity_count,
                                    ]);
                                    return $this->apiResponse(['ok'], "تم طلب المنتج بنجاح", 200);
                                } else {
                                    return $this->apiResponse([], "الكمية المتوفرة '$productSize->quantity' فقط", 400);
                                }
                            } else {
                                return $this->apiResponse([], "الكمية من هذا الحجم غير متوفرة", 400);
                            }
                        }

                    } else {
                        return $this->apiResponse([], "هذا الحجم غير موجود", 400);
                    }
                } else {
                    if ($product->quantity > 0) {
                        if (Cart::where('user_id', $user_id)
                            ->where('product_id', $product_id)
                            ->exists()) {
                            return $this->apiResponse([], "تم طلب هذا المنتج مسبقاً", 400);
                        } else {
                            if ($product->quantity > $request->quantity_count) {
                                Cart::create([
                                    'user_id' => $user_id,
                                    'product_id' => $product_id,
                                    'product_size_id' => $request->size_id,
                                    'quantity' => $request->quantity_count,
                                ]);
                                return $this->apiResponse(['ok'], "تم طلب المنتج بنجاح", 200);
                            } else {
                                return $this->apiResponse([], "الكمية المتوفرة '$product->quantity' فقط", 400);
                            }
                        }

                    } else {
                        return $this->apiResponse([], "الكمية غير متوفرة", 400);
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->apiResponse([], $e->getMessage(), 400);
        }
    }

    public function checkCartCount()
    {
        $cartCount = Cart::where('user_id', auth()->user()->id)->count();
        return $this->apiResponse($cartCount, "مجموع الطلبات في السلة", 200);
    }

    public function cartShow()
    {
        $carts = Cart::where('user_id', auth()->user()->id)->get();
        $cartsCollection = collect($carts)->map(function ($item) {
            $productSize = '';
            $productSizeQuantity = '';
            if ($item->productSize) {
                $productSizeQuantity = $item->productSize->where('product_id', $item->product_id)->where('size_id', $item->product_size_id)->first()->quantity;
                if ($item->productSize->where('product_id', $item->product_id)->where('size_id', $item->product_size_id)->first()->size) {
                    $productSize = $item->productSize->where('product_id', $item->product_id)->where('size_id', $item->product_size_id)->first()->size->name;
                }
            }
            $productImage = '';
            if ($item->product->productImages[0]->image) {
                $productImage = $item->product->productImages[0]->image;
            }
            return [
                'cart_id' => $item->id,
                'product_id' => $item->product->id,
                'name' => $item->product->name,
                'image' => $productImage,
                'price' => $item->product->selling_price,
                'size' => $productSize,
                'quantity' => $item->quantity,
                'available_quantity' => $productSizeQuantity,
            ];
        });
        return $this->apiResponse($cartsCollection->all(), "بيانات السلة", 200);
    }

    public function destroy($cart_id)
    {
        $cartRemoveData = Cart::where('user_id', auth()->user()->id)->where('id',$cart_id)->first();
        if($cartRemoveData){
            $cartRemoveData->delete();
            return $this->checkCartCount();
        }else{
            return $this->apiResponse([], "يوجد مشكلة", 201);
        }
    }
}
