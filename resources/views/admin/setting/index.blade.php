@extends('layouts.admin')

@section('title','Admin Setting')

@section('content')
    <div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                @if ($message = session('message'))
                    <h2 class="alert alert-success mb-3">{{$message}}</h2>
                @endif

                <form action="{{route('admin.settings')}}" method="post">
                    @csrf
                    <div class="card mb-3">
                        <div class="card-header bg-primary">
                            <h3 class="text-white mb-0">Website</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Website Name</label>
                                        <input type="text" value="{{$setting->website_name ?: ''}}" name="website_name" placeholder="website_name" class="form-control">
                                        @error('website_name')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Website URL</label>
                                        <input type="text" value="{{$setting->website_url ?: ''}}" name="website_url" placeholder="website_url" class="form-control">
                                        @error('website_url')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Page Title</label>
                                        <input type="text" value="{{$setting->page_title ?: ''}}" name="page_title" placeholder="page_title" class="form-control">
                                        @error('page_title')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Meta Keywords</label>
                                        <textarea rows="3" name="meta_keywords" placeholder="meta_keywords" class="form-control">{{$setting->meta_keywords ?: ''}}</textarea>
                                        @error('meta_keywords')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Meta Description</label>
                                        <textarea rows="3" name="meta_description" placeholder="meta_description" class="form-control">{{$setting->meta_description ?: ''}}</textarea>
                                        @error('meta_description')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header bg-primary">
                            <h3 class="text-white mb-0">Website - Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label >Address</label>
                                        <textarea rows="3" name="address" placeholder="address" class="form-control">{{$setting->address ?: ''}}</textarea>
                                        @error('address')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label >Phone 1 *</label>
                                        <input type="text" value="{{$setting->phone1 ?: ''}}" name="phone1" placeholder="phone1" class="form-control">
                                        @error('phone1')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label >Phone No. 2</label>
                                        <input type="text" value="{{$setting->phone2 ?: ''}}" name="phone2" placeholder="phone2" class="form-control">
                                        @error('phone2')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label >Email Id. 1 *</label>
                                        <input type="text" value="{{$setting->email1 ?: ''}}" name="email1" placeholder="email1" class="form-control">
                                        @error('email1')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label >Email Id. 2</label>
                                        <input type="text" value="{{$setting->email2 ?: ''}}" name="email2" placeholder="email2" class="form-control">
                                        @error('email2')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header bg-primary">
                            <h3 class="text-white mb-0">Website - Social Media</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Facebook (Optional)</label>
                                        <input type="text" value="{{$setting->facebook ?: ''}}" name="facebook" placeholder="facebook" class="form-control">
                                        @error('facebook')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Twitter (Optional)</label>
                                        <input type="text" value="{{$setting->twitter ?: ''}}" name="twitter" placeholder="twitter" class="form-control">
                                        @error('twitter')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Instagram (Optional)</label>
                                        <input type="text" value="{{$setting->instagram ?: ''}}" name="instagram" placeholder="instagram" class="form-control">
                                        @error('instagram')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Youtube (Optional)</label>
                                        <input type="text" value="{{$setting->youtube ?: ''}}" name="youtube" placeholder="youtube" class="form-control">
                                        @error('youtube')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-inverse-primary">Save Setting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
