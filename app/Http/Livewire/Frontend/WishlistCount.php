<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WishlistCount extends Component
{
    public $wishListCount;

    protected $listeners = ['wishListAddedUpdated' => 'checkWishListCount'];

    public function checkWishListCount()
    {
        if(Auth::check()){
            return $this->wishListCount = Wishlist::where('user_id',auth()->user()->id)->count();
        }else{
            return $this->wishListCount = 0;
        }
    }
    public function render()
    {
        $this->wishListCount = $this->checkWishListCount();
        return view('livewire.frontend.wishlist-count',[
            'wishListCount' => $this->wishListCount
        ]);
    }
}
