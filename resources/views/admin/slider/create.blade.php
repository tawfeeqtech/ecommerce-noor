@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-header bg-transparent d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end">
                    <h3>Add {{$pageName}}</h3>
                </div>

                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    <a href="{{ route($pageName.'.index') }}" class="btn btn-inverse-primary btn-fw">Back</a>
                </div>
            </div>

            <div class="card-body">
                <form class="forms-sample" method="post" action="{{ route($pageName.'.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input name="title" type="text" class="form-control" id="title" placeholder="title">
                        @error('title')
                        <small class="text-danger"> {{ $message }} </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="4"></textarea>
                        @error('description')
                        <small class="text-danger"> {{ $message }} </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">upload image</label>
                        <input type="file" name="image" id="image" class="form-control">
                      </div>

                    <div class="form-group">
                        <div class="form-check form-check-flat form-check-primary">
                            <label class="form-check-label">
                                <input name="status" type="checkbox" class="form-check-input">
                                Status
                                <i class="input-helper"></i></label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-inverse-primary btn-fw">Save</button>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection