@extends('layouts.app')
@section('title','Categories Page')

@section('content')
<div class="py-3 py-md-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-4">Our Categories</h4>
            </div>
            @forelse ($entities as $item)
            <div class="col-6 col-md-3">
                <div class="category-card">
                    <a href="{{route('products',$item->slug)}}">
                        <div class="category-card-img">
                            <img src="{{asset($item->image)}}" class="w-100" alt="Laptop">
                        </div>
                        <div class="category-card-body">
                            <h5>{{$item->name}}</h5>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-md-12">
                <h5>No Categories Available</h5>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection