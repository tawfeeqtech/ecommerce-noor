@extends('layouts.app')
@section('title','Featured Products')

@section('content')
    <div class="py-5 ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Featured Products</h4>
                    <div class="underline mb-4"></div>
                </div>
                @forelse($featuredProducts as $item)
                    <div class="col-md-3">
                        <div class="product-card">
                            <div class="product-card-img">
                                <label class="stock bg-danger">New</label>
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
                                    <span class="selling-price">${{$item->selling_price}}</span>
                                    <span class="original-price">${{$item->original_price}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 p-2">
                        <h4>No Featured Products Available for {{$category->name}}</h4>
                    </div>
                @endforelse

                <div class="text-center">
                    <a href="{{route('collections')}}" class="btn btn-warning px-3">View More</a>
                </div>

            </div>
        </div>
    </div>
@endsection
