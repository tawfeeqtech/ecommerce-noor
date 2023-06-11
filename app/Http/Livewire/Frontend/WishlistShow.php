<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Wishlist;
use Livewire\Component;

class WishlistShow extends Component
{
    public $user_id;
    public function mount()
    {
        $this->user_id = auth()->user()->id;
    }

    public function removeWishListItem($wishListId)
    {
        Wishlist::where('user_id',$this->user_id)->where('id',$wishListId)->delete();
        $this->emit('wishListAddedUpdated');
        $this->dispatchBrowserEvent('message', [
            'message' => 'WishList Item Removed Successfully',
            'type' => 'success',
            'status' => 200
        ]);
    }
    public function render()
    {
        $wishlist= Wishlist::where('user_id',$this->user_id)->get();
        return view('livewire.frontend.wishlist-show',[
            'wishlist' => $wishlist
        ]);
    }
}
