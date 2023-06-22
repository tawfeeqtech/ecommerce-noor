@extends('layouts.app')
@section('title','My Order Details')

@section('content')
    <div class="py-3 py-md-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="shadow bg-white p-3">
                        <h4 class="text-primary">
                            <i class="fa fa-shopping-cart text-dark"></i> My Order Details
                            <a href="{{route('orders.index')}}" class="btn btn-danger btn-sm float-end">Back</a>
                        </h4>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
