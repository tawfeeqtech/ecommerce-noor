@extends('layouts.app')
@section('title','Home Page')

@section('content')
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($sliders as $key => $sliderItem)
                <div class="carousel-item {{$key == 0 ? 'active' : ''}} ">
                    @if ($sliderItem->image)
                        <img src="{{asset($sliderItem->image)}}" class="d-block w-100">
                    @endif
                    <div class="carousel-caption d-none d-md-block">
                        <div class="custom-carousel-content">
                            <h1>
                                {!!$sliderItem->title!!}
                            </h1>
                            <p>
                                {!!$sliderItem->description!!}
                            </p>
                            <div>
                                <a href="#" class="btn btn-slider">
                                    Get Now
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h4>Welcome To my E-Commerce</h4>
                    <div class="underline mx-auto"></div>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    </p>
                </div>
            </div>
        </div>
    </div>


    <div class="py-5 ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Trending Products</h4>
                    <div class="underline mb-4"></div>
                </div>
                @if($trendingProducts->first() != null)
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme four-carousel">
                        @foreach($trendingProducts as $item)
                            <div class="item">
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
                        @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="p-2">
                            <h4>No Products Available</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>New Arrivals
                        @if($newArrivalsProducts->first() != null)
                        <a href="{{route('new-arrivals')}}" class="btn btn-warning float-end">View More</a>
                            @endif
                    </h4>
                    <div class="underline mb-4"></div>
                </div>
                @if($newArrivalsProducts->first() != null)
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme four-carousel">
                            @foreach($newArrivalsProducts as $item)
                                <div class="item">
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
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="p-2">
                            <h4>No Arrivals Available for </h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Featured Products
                        @if($featuredProducts->first() != null)
                        <a href="{{route('featured-products')}}" class="btn btn-warning float-end">View More</a>
                        @endif
                    </h4>
                    <div class="underline mb-4"></div>
                </div>
                @if($featuredProducts->first() != null)
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme four-carousel">
                            @foreach($featuredProducts as $item)
                                <div class="item">
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
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="p-2">
                            <h4>No featured Products Available for </h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $('.four-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    })
</script>
@endsection
