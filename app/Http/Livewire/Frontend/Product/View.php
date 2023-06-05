<?php

namespace App\Http\Livewire\Frontend\Product;

use Livewire\Component;

class View extends Component
{
    public $product, $category,$prodColorSelectedQuantity, $prodSizeSelectedQuantity;

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
