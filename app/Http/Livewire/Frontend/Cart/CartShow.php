<?php

namespace App\Http\Livewire\Frontend\Cart;

use App\Models\Cart;
use Livewire\Component;

class CartShow extends Component
{
    public $cart, $user_id, $totalPrice = 0;

    public function mount()
    {
        $this->user_id = auth()->user()->id;
    }

    /*function setQuantity($cartData, $type)
    {
        if ($cartData) {
            $productColor = $cartData->productColor()->where('id', $cartData->product_color_id);
            $productSize = $cartData->productSize()->where('id', $cartData->product_size_id);

            if ($productColor->exists() && $productSize->exists()) {
                $productColor = $productColor->first();
                $productSize = $productSize->first();

                if ($productColor->quantity > $cartData->quantity && $productSize->quantity > $cartData->quantity) {
                    if ($type == 'increment') {
                        $cartData->increment('quantity');
                    } else {
                        $cartData->decrement('quantity');
                    }

                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Quantity Updated Successfully',
                        'type' => 'success',
                        'status' => 200
                    ]);
                } else {
                    $this->dispatchBrowserEvent('message', [
                        'text' => "Color Quantity Available is: $productColor->quantity\nSize Quantity Available is: $productSize->quantity" ,
                        'type' => 'error',
                        'status' => 400
                    ]);
                }
            } else {
                if ($cartData->product->quantity > $cartData->quantity) {

                    if ($type == 'increment') {
                        $cartData->increment('quantity');
                    } else {
                        $cartData->decrement('quantity');
                    }
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Quantity Updated Successfully',
                        'type' => 'success',
                        'status' => 200
                    ]);
                } else {
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Only ' . $cartData->product->quantity . ' Quantity Available',
                        'type' => 'error',
                        'status' => 400
                    ]);
                }
            }
        } else {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Has Error',
                'type' => 'error',
                'status' => 400
            ]);
        }
    }*/

    function setQuantity($cartData,$type)
    {
        if ($cartData) {
            $productColor = $cartData->productColor()->where('id', $cartData->product_color_id);
            $productSize = $cartData->productSize()->where('id', $cartData->product_size_id);

            if (!$productColor->exists() && !$productSize->exists()) {
                if ($cartData->product->quantity > $cartData->quantity) { //$this->quantityCount
                    if ($type == 'increment') {
                        $cartData->increment('quantity');
                    } else {
                        $cartData->decrement('quantity');
                    }
                    $this->dispatchBrowserEvent('message', [
                        'message' => 'Quantity Updated Successfully',
                        'type' => 'success',
                        'status' => 200
                    ]);
                    return false;
                } else {
                    $this->dispatchBrowserEvent('message', [
                        'message' => 'Only ' . $cartData->product->quantity . ' Quantity Available',
                        'type' => 'error',
                        'status' => 400
                    ]);
                    return false;
                }
            } else {
                $productColor = $productColor->first();
                $productSize = $productSize->first();
//                echo 'productSize quantity: ' . $productSize->quantity . "\n";
//                echo 'cartData quantity: ' . $cartData->quantity . "\n";
//                exit;
                if ($productColor->quantity < $cartData->quantity) {  //$this->quantityCount
                    $this->dispatchBrowserEvent('message', [
                        'message' => "Color Quantity Available is: $productColor->quantity" ,
                        'type' => 'error',
                        'status' => 400
                    ]);
                    return false;
                }elseif($productSize->quantity < $cartData->quantity){ //$this->quantityCount
                    $this->dispatchBrowserEvent('message', [
                        'message' => "Size Quantity Available is: $productSize->quantity" ,
                        'type' => 'error',
                        'status' => 400
                    ]);
                    return false;
                }else{

                    if ($type == 'increment') {
                        $cartData->increment('quantity');
                    } else {
                        $cartData->decrement('quantity');
                    }

                    $this->dispatchBrowserEvent('message', [
                        'message' => 'Quantity Updated Successfully',
                        'type' => 'success',
                        'status' => 200
                    ]);
                    return false;
                }
            }
        } else {
            $this->dispatchBrowserEvent('message', [
                'message' => 'Has Error',
                'type' => 'error',
                'status' => 400
            ]);
        }
    }

    public function incrementQuantity($cartId)
    {

        $cartData = Cart::where('id', $cartId)->where('user_id', $this->user_id)->first();
        $this->setQuantity($cartData, 'increment');
//        $this->setQuantity($cartData);
    }

    public function decrementQuantity($cartId)
    {
        $cartData = Cart::where('id', $cartId)->where('user_id', $this->user_id)->first();
        $this->setQuantity($cartData, 'decrement');
//        $this->setQuantity($cartData);
    }

    public function removeCartItem($cartId)
    {
        $cartData = Cart::where('id', $cartId)->where('user_id', $this->user_id)->first();
        if ($cartData) {
            $cartData->delete();
            $this->emit('CartAddedUpdated');
            $this->dispatchBrowserEvent('message', [
                'message' => 'Cart Item Removed Successfully',
                'type' => 'success',
                'status' => 200
            ]);
        } else {
            $this->dispatchBrowserEvent('message', [
                'message' => 'Something went Wrong!',
                'type' => 'error',
                'status' => 400
            ]);
        }
    }

    public function render()
    {
        $this->cart = Cart::where('user_id', $this->user_id)->get();
        return view('livewire.frontend.cart.cart-show', [
            'cart' => $this->cart
        ]);
    }
}
