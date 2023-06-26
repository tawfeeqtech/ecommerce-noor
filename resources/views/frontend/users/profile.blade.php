@extends('layouts.app')
@section('title','Profile')

@section('content')
    <div class="py-5 ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h4>User Profile
                        <a href="{{route('profile.create-password')}}" class="btn btn-warning float-end">Change Password?</a>
                    </h4>
                    <div class="underline mb-4"></div>
                </div>

                <div class="col-md-10">

                    @if (session('message'))
                        <h2 class="alert alert-success">{{session('message')}}</h2>
                    @endif

                    <div class="card shadow">
                        <div class="card-header bg-primary">
                            <h4 class="mb-0 text-white">User Details</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{route('profile.update')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label >Username</label>
                                            <input type="text" name="username" value="{{Auth::user()->name}}" placeholder="username" class="form-control">
                                            @error('username')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label >Email Address</label>
                                            <input type="text" name="email" readonly value="{{Auth::user()->email}}" placeholder="email" class="form-control">
                                            @error('email')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label >Phone Number</label>
                                            <input type="text" name="phone" value="{{isset(Auth::user()->userDetail->phone) ? Auth::user()->userDetail->phone : old('phone')}}" placeholder="phone" class="form-control">
                                            @error('phone')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label >Zip/Pin Code</label>
                                            <input type="text" name="pin_code" value="{{isset(Auth::user()->userDetail->pin_code) ? Auth::user()->userDetail->pin_code : old('pin_code')}}" placeholder="pin_code" class="form-control">
                                            @error('pin_code')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 ">
                                        <div class="mb-3">
                                            <label >Address</label>
                                            <textarea rows="3" name="address" placeholder="address" class="form-control">{{isset(Auth::user()->userDetail->address) ? Auth::user()->userDetail->address : old('address')}}</textarea>
                                            @error('address')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Save Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
