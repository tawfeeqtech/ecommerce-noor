<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class View extends Component
{
    public $userId, $product, $category, $prodColorSelectedQuantity, $prodSizeSelectedQuantity, $quantityCount = 1, $productColorId, $productSizeId;

    public function addToWishList($productId)
    {
        if (Auth::check()) {
            $user_id = auth()->user()->id;
            $check = Wishlist::where('user_id', $user_id)->where('product_id', $productId)->exists();

            if ($check) {
                /*session()->flash('message','Already added to wishlist');
                session()->flash('alert-class', 'alert-danger');*/
                $this->dispatchBrowserEvent('message', [
                    'message' => 'Already added to wishlist',
                    'type' => 'warning',
                    'status' => 409
                ]);
                return false;
            } else {
                Wishlist::create([
                    'user_id' => $user_id,
                    'product_id' => $productId
                ]);
                $this->emit('wishListAddedUpdated');

                /*session()->flash('message','Wishlist Added Successfully');
                session()->flash('alert-class', 'alert-success');*/
                $this->dispatchBrowserEvent('message', [
                    'message' => 'Wishlist Added Successfully',
                    'type' => 'success',
                    'status' => 200
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('message', [
                'message' => 'Please Login to continue',
                'type' => 'info',
                'status' => 401
            ]);

//            session()->flash('message','Please Login to continue');
//            session()->flash('alert-class', 'alert-danger');
            return false;
        }
    }

    public function colorSelected($productColorId)
    {
        $this->productColorId = $productColorId;
        $productColor = $this->product->productColors()->where('id', $productColorId)->first();
        $this->prodColorSelectedQuantity = $productColor->quantity;

        if ($this->prodColorSelectedQuantity == 0) {
            $this->prodColorSelectedQuantity = 'outOfStock';
        }
    }

    public function sizeSelected($productSizeId)
    {
        $this->productSizeId = $productSizeId;
        $productSize = $this->product->productSizes()->where('id', $productSizeId)->first();
        $this->prodSizeSelectedQuantity = $productSize->quantity;

        if ($this->prodSizeSelectedQuantity == 0) {
            $this->prodSizeSelectedQuantity = 'outOfStock';
        }
    }

    public function incrementQuantity()
    {
        if ($this->quantityCount < 10) {
            $this->quantityCount++;
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantityCount > 1) {
            $this->quantityCount--;
        }
    }

    public function addToCart($productId)
    {
        if (Auth::check()) {
            if ($this->product->where('id', $productId)->where('status', '0')->exists()) {
                // check for product color quantity and add to cart
                if ($this->product->productColors()->count() >= 1 && $this->product->productSizes()->count() >= 1) {
                    if ($this->prodColorSelectedQuantity && $this->prodSizeSelectedQuantity) {
                        $cartExists = Cart::where('user_id', $this->userId)
                            ->where('product_id', $productId)
                            ->where('product_color_id', $this->productColorId)
                            ->where('product_size_id', $this->productSizeId)
                            ->exists();

                        if ($cartExists) {
                            $this->dispatchBrowserEvent('message', [
                                'message' => 'Product Already Added',
                                'type' => 'warning',
                                'status' => 400
                            ]);
                            return false;
                        } else {
                            // المنتج الذي تم اختياره لم يتم اضافته من قبل

                            $productColor = $this->product->productColors()->where('id', $this->productColorId)->first();
                            $productSize = $this->product->productSizes()->where('id', $this->productSizeId)->first();
                            if ($productColor->quantity > 0 && $productSize->quantity > 0) {
                                // Adding Data To Cart
                                if ($productColor->quantity > $this->quantityCount && $productSize->quantity > $this->quantityCount) {
                                    //insert product to cart
                                    Cart::create([
                                        'user_id' => $this->userId,
                                        'product_id' => $productId,
                                        'product_color_id' => $this->productColorId,
                                        'product_size_id' => $this->productSizeId,
                                        'quantity' => $this->quantityCount
                                    ]);
                                    $this->emit('CartAddedUpdated');
                                    $this->dispatchBrowserEvent('message', [
                                        'message' => 'Product added to cart successfully',
                                        'type' => 'success',
                                        'status' => 200
                                    ]);
                                    return false;
                                } else {
                                    // الكمية المطلوبة من المنتج اكبر من الكمية الموجودة في المتجر
                                    $this->dispatchBrowserEvent('message', [
                                        'message' => "Color Quantity Available is: $productColor->quantity\nSize Quantity Available is: $productSize->quantity" ,
                                        'type' => 'warning',
                                        'status' => 404
                                    ]);
                                    return false;
                                }
                            } else {
                                // الكمية المطلوبة من اللون هذا من المنتج اكبر من الكمية الموجودة في المتجر
                                $this->dispatchBrowserEvent('message', [
                                    'message' => 'Out of Stock',
                                    'type' => 'warning',
                                    'status' => 404
                                ]);
                                return false;
                            }
                        }
                    } else {
                        // المنتج يمتلك الوان واحجام، لذا يجب عليك تحديد لون معين قبل عملية الاضافة
                        $this->dispatchBrowserEvent('message', [
                            'message' => 'Select Product Color And Size',
                            'type' => 'info',
                            'status' => 404
                        ]);
                        return false;
                    }
                } else {
                    // المنتج لا يحتوى على الالوان او مجموع الالوان اقل من 1

                    if (Cart::where('user_id', $this->userId)->where('product_id', $productId)->exists()) {
                        $this->dispatchBrowserEvent('message', [
                            'message' => 'Product Already Added',
                            'type' => 'warning',
                            'status' => 400
                        ]);
                        return false;
                    } else {
                        // المنتج الذي تم اختياره لم يتم اضافته من قبل
                        if ($this->product->quantity > 0) {
                            if ($this->product->quantity > $this->quantityCount) {
                                //insert product to cart
                                Cart::create([
                                    'user_id' => auth()->user()->id,
                                    'product_id' => $productId,
                                    'quantity' => $this->quantityCount
                                ]);
                                $this->emit('CartAddedUpdated');

                                $this->dispatchBrowserEvent('message', [
                                    'message' => 'Product added to cart successfully',
                                    'type' => 'success',
                                    'status' => 200
                                ]);
                                return false;
                            } else {
                                // الكمية المطلوبة من المنتج اكبر من الكمية الموجودة في المتجر
                                $this->dispatchBrowserEvent('message', [
                                    'message' => 'Only ' . $this->product->quantity . 'Quantity Available',
                                    'type' => 'warning',
                                    'status' => 404
                                ]);
                                return false;
                            }
                        } else {
                            // إنتهى من المخزن
                            $this->dispatchBrowserEvent('message', [
                                'message' => 'Out of Stock',
                                'type' => 'warning',
                                'status' => 404
                            ]);
                            return false;
                        }
                    }
                }
            } else {
                //المنتج غير متوفر
                $this->dispatchBrowserEvent('message', [
                    'message' => 'Product Does not exist',
                    'type' => 'warning',
                    'status' => 404
                ]);
                return false;
            }
        } else {
            // يحتاج تسجيل دخول
            $this->dispatchBrowserEvent('message', [
                'message' => 'Please Login to add to cart',
                'type' => 'info',
                'status' => 401
            ]);
            return false;
        }
    }

    public function mount($category, $product)
    {
        $this->category = $category;
        $this->product = $product;
        if (Auth::check()) {
            $this->userId = auth()->user()->id;
        }else{
            $this->userId = null;
        }
    }

    public function render()
    {
        return view('livewire.frontend.product.view', [
            'category' => $this->category,
            'product' => $this->product
        ]);
    }
}
