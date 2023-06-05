<div>
    <div class="row">
        <div class="col-md-3">
            @if ($category->brands)
            <div class="card">
                <div class="card-header"><h4>Brands</h4></div>
                <div class="card-body">
                    @forelse ($category->brands as $brandItem)
                    <label class="d-block">
                        <input type="checkbox" wire:model="brandInputs" name="" value="{{$brandItem->name}}"> {{$brandItem->name}}
                    </label>
                    @empty
                        <p>no brand found</p>
                    @endforelse

                </div>
            </div>
            @endif

                <div class="card mt-3">
                    <div class="card-header"><h4>Price</h4></div>
                    <div class="card-body">
                        <label class="d-block">
                            <input type="radio" name="priceSort" wire:model='priceInput' value="high-to-low"> High To Low
                        </label>

                        <label class="d-block">
                            <input type="radio" name="priceSort" wire:model='priceInput' value="low-to-high"> Low To High
                        </label>
                    </div>
                </div>


        </div>
        <div class="col-md-9">
            <div class="row">
                @forelse ($products as $item)
                <div class="col-md-4">
                    <div class="product-card">
                        <div class="product-card-img">
                            @if ($item->quantity >0)
                            <label class="stock bg-success">In Stock</label>
                            @else
                            <label class="stock bg-danger">Out Of Stock</label>
                            @endif
                            @if ($item->productImages->count() > 0 )
                            <a href="{{url('/collections/'.$item->category->slug.'/'.$item->slug)}}">
                                <img src="{{asset($item->productImages[0]->image)}}" alt="{{$item->name}}">
                            </a>
                            @endif
                        </div>
                        <div class="product-card-body">
                            <p class="product-brand">{{$item->brand}}</p>
                            <h5 class="product-name">
                                <a href="{{url('/collections/'.$item->category->slug.'/'.$item->slug)}}">
                                    {{$item->name}}
                                </a>
                            </h5>
                            <div>
                                <span class="selling-price">{{$item->selling_price}}</span>
                                <span class="original-price">{{$item->original_price}}</span>
                            </div>
                            {{-- <div class="mt-2">
                                <a href="" class="btn btn1">Add To Cart</a>
                                <a href="" class="btn btn1"> <i class="fa fa-heart"></i> </a>
                                <a href="" class="btn btn1"> View </a>
                            </div> --}}
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-md-12">
                    <div class="p-2">
                        <h4>No Products Available for {{$category->name}}</h4>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
