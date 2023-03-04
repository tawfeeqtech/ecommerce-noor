<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Orderitem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    use ApiResponseTrait;
    protected $totalProductAmount;

    public function index()
    {
        $carts = Cart::where('user_id',auth()->user()->id)->get();

        foreach ($carts as $cartItem){
            $this->totalProductAmount += $cartItem->product->selling_price * $cartItem->quantity;
        }
        $data['carts'] = $carts;
        $data['totalProductAmount'] = $this->totalProductAmount;
        return $this->apiResponse($data, "بيانات السلة", 200);
    }
    function placeOrder($request)
    {


    }

    function store(Request $request)
    {
        $carts = Cart::where('user_id',auth()->user()->id)->get();
        if($carts->first() != null){
            $this->validate($request, [
                'fullname' => 'required|string|max:121',
                'email' => 'required|email|max:121',
                'phone' => 'required|max:11|min:10',
                'address' => 'required|string|max:500',
            ]);

            $payment_mode = 'Cash On Delivery';
            $payment_id = null;
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'tracking_no' => 'funda-' .Str::random(10),
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'status_message' => 'in progress',
                'payment_mode' =>$payment_mode,
                'payment_id' =>$payment_id,
            ]);
            foreach ($carts as $cartItem){
                Orderitem::create([
                    'order_id' =>$order->id,
                    'product_id' => $cartItem->product_id,
                    'product_color_id' => $cartItem->product_color_id,
                    'product_size_id' => $cartItem->product_size_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->selling_price,
                ]);

                if($cartItem->product_size_id != null){
                    $cartItem->productSize()->where('id',$cartItem->product_size_id)->decrement('quantity',$cartItem->quantity);
                    $cartItem->product->where('id',$cartItem->product_id)->decrement('quantity',$cartItem->quantity);
                }
                else{
                    $cartItem->product()->where('id',$cartItem->product_id)->decrement('quantity',$cartItem->quantity);

                }
            }
            if($order){
                Cart::where('user_id',auth()->user()->id)->delete();
                return $this->apiResponse(null, "تم طلب المنتجات بنجاح", 200);

            }else{
                return $this->apiResponse(null, "يوجد مشكلة في الطلب", 400);
            }
        }else{
            return $this->apiResponse(null, "لا يوجد منتجات في السلة", 400);
        }


    }
}
