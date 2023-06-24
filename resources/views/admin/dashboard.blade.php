@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        @if (session('message'))
            <h2 class="alert alert-success">{{session('message')}}</h2>
        @endif

        <div class="me-md-3 me-xl-5">
            <h2>Dashboard</h2>
            <hr>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card card-body bg-primary text-white">
                    <label>Total Orders</label>
                    <h1>{{$totalOrder}}</h1>
                    <a href="{{route('admin.orders.index')}}" class="text-white">View</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-body bg-success text-white">
                    <label>Today Orders</label>
                    <h1>{{$todayOrder}}</h1>
                    <a href="{{route('admin.orders.index')}}" class="text-white">View</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-body bg-warning text-white">
                    <label>This Month Orders</label>
                    <h1>{{$thisMonthOrder}}</h1>
                    <a href="{{route('admin.orders.index')}}" class="text-white">View</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-body bg-danger text-white">
                    <label>Year Orders</label>
                    <h1>{{$thisYearOrder}}</h1>
                    <a href="{{route('admin.orders.index')}}" class="text-white">View</a>
                </div>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-3">
                <div class="card card-body bg-primary text-white ">
                    <label>Total Products</label>
                    <h1>{{$totalProducts}}</h1>
                    <a href="{{route('products.index')}}" class="text-white">View</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-body bg-success text-white">
                    <label>Total Categories</label>
                    <h1>{{$totalCategories}}</h1>
                    <a href="{{route('category.index')}}" class="text-white">View</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-body bg-warning text-white">
                    <label>Total Brand</label>
                    <h1>{{$totalBrand}}</h1>
                    <a href="{{route('brand.index')}}" class="text-white">View</a>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-3">
                <div class="card card-body bg-primary text-white">
                    <label>Total All Users</label>
                    <h1>{{$totalAllUsers}}</h1>
                    <a href="{{route('users.index')}}" class="text-white">View</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-body bg-success text-white">
                    <label>Total Users</label>
                    <h1>{{$totalUser}}</h1>
                    <a href="{{route('users.index')}}" class="text-white">View</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-body bg-warning text-white">
                    <label>Total Admin Users</label>
                    <h1>{{$totalAdmin}}</h1>
                    <a href="{{route('users.index')}}" class="text-white">View</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
