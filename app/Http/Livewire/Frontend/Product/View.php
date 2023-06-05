<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class View extends Component
{
    public $product, $category,$prodColorSelectedQuantity, $prodSizeSelectedQuantity;

    public function addToWishList($productId)
    {
        if(Auth::check()){
            $user_id = auth()->user()->id;
            $check = Wishlist::where('user_id',$user_id)->where('product_id',$productId)->exists();

            if($check){
                /*session()->flash('message','Already added to wishlist');
                session()->flash('alert-class', 'alert-danger');*/
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Already added to wishlist',
                    'type' => 'warning',
                    'status' => 409
                ]);
                return false;
            }else{
                Wishlist::create([
                    'user_id' => $user_id,
                    'product_id' => $productId
                ]);
                /*session()->flash('message','Wishlist Added Successfully');
                session()->flash('alert-class', 'alert-success');*/
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Wishlist Added Successfully',
                    'type' => 'success',
                    'status' => 200
                ]);
            }
        }else{
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please Login to continue',
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
        $productColor = $this->product->productColors()->where('id',$productColorId)->first();
        $this->prodColorSelectedQuantity = $productColor->quantity;

        if($this->prodColorSelectedQuantity == 0){
            $this->prodColorSelectedQuantity = 'outOfStock';
        }
    }

    public function sizeSelected($productSizeId)
    {
        $productSize = $this->product->productSizes()->where('id',$productSizeId)->first();
        $this->prodSizeSelectedQuantity = $productSize->quantity;

        if($this->prodSizeSelectedQuantity == 0){
            $this->prodSizeSelectedQuantity = 'outOfStock';
        }
    }



    public function mount($category,$product)
    {
        $this->category = $category;
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.frontend.product.view',[
            'category' => $this->category,
            'product' => $this->product
        ]);
    }
}
