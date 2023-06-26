<?php

namespace App\Http\Livewire\Frontend\Checkout;

use App\Mail\PlaceOrderMailable;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Orderitem;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
//use Srmklive\PayPal\Services\PayPal as PayPalClient;


class CheckoutShow extends Component
{
    public $user, $carts, $totalProductAmount = 0;

    public $fullName, $email, $phone, $pinCode, $address, $payment_mode = null, $payment_id = null;

    protected $listeners = [
        'validationForAll',
        'transactionEmit' => 'paidOnlineOrder'
    ];

    public function validationForAll()
    {
        $this->validate();
    }



    public function mount()
    {
        $this->user = auth()->user();
    }

    public function rules()
    {
        return [
            'fullName' => 'required|string|max:121',
            'email' => 'required|email|max:121',
            'phone' => 'required|string|max:11|min:10',
            'pinCode' => 'required|string|max:6|min:6',
            'address' => 'required|string|max:500',
        ];
    }

    /*public function checkout()
    {
        $provider = new PayPalClient([]);
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $this->totalProductAmount
                    ]
                ]
            ],
            "application_context" => [
                "cancel_url" => route('payment.cancel'),
                "return_url" => route('payment.success'),
            ]
        ]);

        return redirect($order['links'][1]['href']);

    }*/


    public function placeOrder()
    {
        $this->validate();
        $orderData = [
            'user_id' => $this->user->id,
            'tracking_no' => 'tk-' . Str::random(10),
            'fullname' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'pin_code' => $this->pinCode,
            'address' => $this->address,
            'status_message' => 'in progress',
            'payment_mode' => $this->payment_mode,
            'payment_id' => $this->payment_id,
        ];
        $order = Order::create($orderData);

        foreach ($this->carts as $cartItem) {

            Orderitem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_color_id' => $cartItem->product_color_id,
                'product_size_id' => $cartItem->product_size_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->selling_price,
            ]);

            if ($cartItem->product_color_id == null && $cartItem->product_size_id == null) {
                $cartItem->product()->where('id', $cartItem->product_id)->decrement('quantity', $cartItem->quantity);
            } else {
                if ($cartItem->product_color_id != null) {
                    $cartItem->productColor()->where('id', $cartItem->product_color_id)->decrement('quantity', $cartItem->quantity);
                }
                if ($cartItem->product_size_id != null) {
                    $cartItem->productSize()->where('id', $cartItem->product_size_id)->decrement('quantity', $cartItem->quantity);
                }
                $cartItem->product()->where('id', $cartItem->product_id)->decrement('quantity', $cartItem->quantity);
            }

        }

        return $order;
    }

    public function codOrder()
    {
        $this->payment_mode = 'Cash On Delivery';
        $this->submitOrder();
    }

    public function paidOnlineOrder($value)
    {
        $this->payment_id = $value;
        $this->payment_mode = 'paid by Paypal';

        $this->submitOrder();
    }

    public function submitOrder()
    {
        $codOrder = $this->placeOrder();
        if ($codOrder) {
            Cart::where('user_id', $this->user->id)->delete();

            try {
                $order = Order::findOrFail($codOrder->id);
                Mail::to("$order->email")->send(new PlaceOrderMailable($order));
            }catch (\Exception $e){

            }


            session()->flash('message', 'Order Placed Successfully');
            $this->dispatchBrowserEvent('message', [
                'message' => 'Order Placed Successfully',
                'type' => 'success',
                'status' => 200
            ]);
            return redirect()->route('thank-you');
        } else {
            $this->dispatchBrowserEvent('message', [
                'message' => 'Something went Wrong!',
                'type' => 'error',
                'status' => 400
            ]);
            return false;
        }
    }


    public function totalProductAmount()
    {
        $this->totalProductAmount = 0;
        $this->carts = Cart::where('user_id', $this->user->id)->get();
        foreach ($this->carts as $cartItem) {
            $this->totalProductAmount += $cartItem->product->selling_price * $cartItem->quantity;
        }
        return $this->totalProductAmount;
    }

    public function render()
    {
        $this->fullName = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;

        if ($this->user->userDetail){
            $this->pinCode = $this->user->userDetail->pin_code;
            $this->address = $this->user->userDetail->address;
        }


        $this->totalProductAmount = $this->totalProductAmount();
        return view('livewire.frontend.checkout.checkout-show', [
            'totalProductAmount' => $this->totalProductAmount
        ]);
    }
}
