@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header bg-transparent d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-end">
                        <h3>My Orders</h3>
                    </div>
                </div>

                <div class="card-body">
                    <h4 class="text-primary">
                        <i class="fa fa-shopping-cart text-dark"></i> My Order Details
                        <a href="{{route('admin.orders.index')}}" class="btn btn-inverse-danger btn-sm float-end">Back</a>
                    </h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Order Details:</h5>
                            <hr>
                            <h6>Order ID: {{$order->id}}</h6>
                            <h6>Tracking Id/No.: {{$order->tracking_no}}</h6>
                            <h6>Order Created Date: {{$order->created_at->format('d-m-Y h:i A')}}</h6>
                            <h6>Payment Mode: {{$order->payment_mode}}</h6>
                            <h6 class="border p-2 text-success">
                                Order Status Message: <span class="text-uppercase">{{$order->status_message}}</span>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h5>User Details</h5>
                            <hr>
                            <h6>Full Name: {{$order->fullname}}</h6>
                            <h6>Email ID: {{$order->email}}</h6>
                            <h6>Phone: {{$order->phone}}</h6>
                            <h6>Address: {{$order->address}}</h6>
                            <h6>Pin code: {{$order->pin_code}}</h6>
                        </div>
                    </div>
                    <br/>
                    <h5>Order Items</h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <th>Item ID</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            </thead>
                            <tbody>
                            @php
                                $totalPrice = 0;
                            @endphp
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td width="10%">{{$item->id}}</td>
                                    <td width="10%">
                                        @if($item->product->productImages)
                                            <img src="{{ asset($item->product->productImages[0]->image) }}" style="width: 50px; height: 50px" alt="{{$item->product->name}}">
                                        @else
                                            <img src="" style="width: 50px; height: 50px" alt="لا يوجد صورة للمنتج">
                                        @endif



                                    </td>
                                    <td>
                                        {{$item->product->name}}

                                        @if($item->productColor)
                                            @if($item->productColor->color)
                                                <span class="attribute">Color: {{ $item->productColor->color->name }}</span>
                                            @endif
                                        @endif

                                        @if($item->productSize)
                                            @if($item->productSize->size)
                                                <span class="attribute">Size: {{ $item->productSize->size->name }}</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td width="10%">{{$item->price}}</td>
                                    <td width="10%">{{$item->quantity}}</td>
                                    <td width="10%" class="fw-bold">{{$item->quantity * $item->price}}</td>
                                    @php
                                        $totalPrice += $item->quantity * $item->price;
                                    @endphp
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" class="fw-bold">Total Amount:</td>
                                <td colspan="1" class="fw-bold">${{$totalPrice}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
