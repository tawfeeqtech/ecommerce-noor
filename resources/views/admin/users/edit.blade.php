@extends('layouts.admin')

@section('title','Create User')

@section('content')
    <div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                @if ($message = session('message'))
                    <h2 class="alert alert-success">{{$message}}</h2>
                @endif

                <div class="card">
                    <div class="card-header bg-transparent d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-end">
                            <h3>Edit {{$pageName}}</h3>
                        </div>
                        <div class="d-flex justify-content-between align-items-end flex-wrap">
                            <a href="{{ route($pageName.'s.index') }}" class="btn btn-inverse-primary btn-fw">Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="forms-sample" method="post" action="{{ route($pageName.'s.update',$entity->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row py-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" value="{{ $entity->name }}" name="name" id="name" placeholder="name" class="form-control">
                                        @error('name')
                                            <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Email</label>
                                        <input type="text" readonly value="{{ $entity->email }}" name="email" id="email" placeholder="email" class="form-control">
                                        @error('email')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Password</label>
                                        <input type="text" name="password" id="password" placeholder="password" class="form-control">
                                        @error('password')
                                        <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role_as">Role</label>
                                        <select name="role_as" class="form-control" id="role_as">
                                            <option value="">Select Role</option>
                                            <option value="0" {{ $entity->role_as == '0' ? 'selected' : '' }}>User</option>
                                            <option value="1" {{ $entity->role_as == '1' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-inverse-primary btn-fw">Update</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
