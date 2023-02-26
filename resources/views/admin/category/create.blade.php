@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-header bg-transparent d-flex justify-content-between flex-wrap">
        <div class="d-flex align-items-end">
          <h3>Add Category</h3>
        </div>

        <div class="d-flex justify-content-between align-items-end flex-wrap">
          <a href="{{ route('category.index') }}" class="btn btn-inverse-primary btn-fw">Back</a>
        </div>
      </div>

      <div class="card-body">
        <form class="forms-sample" method="post" action="{{ route('category.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">Name</label>
                <input name="name" type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="name">
                @error('name')
                <small class="text-danger"> {{ $message }} </small>
                @enderror
              </div>
            </div>
          </div>




          <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" id="description" rows="4">{{ old('description') }}</textarea>
            @error('description')
            <small class="text-danger"> {{ $message }} </small>
            @enderror
          </div>
          <div class="form-group">
            <label for="image">upload image</label>
            <input type="file" name="image" id="image" class="form-control">
          </div>

          <div class="form-group">
            <h3>
              SEO Tags
            </h3>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <input name="meta_title" type="text" class="form-control" value="{{ old('meta_title') }}" id="meta_title" placeholder="meta_title">
                @error('meta_title')
                <small class="text-danger"> {{ $message }} </small>
                @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="meta_keyword">Meta keyword</label>
                <input name="meta_keyword" type="text" class="form-control" value="{{ old('meta_keyword') }}" id="meta_keyword" placeholder="meta_keyword">
                @error('meta_keyword')
                <small class="text-danger"> {{ $message }} </small>
                @enderror
              </div>
            </div>

            <div class="col-md-6">

              <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <input name="meta_description" type="text" class="form-control" value="{{ old('meta_description') }}" id="meta_description" placeholder="meta_description">
                @error('meta_description')
                <small class="text-danger"> {{ $message }} </small>
                @enderror
              </div>
            </div>
          </div>




          <div class="form-group">
            <div class="form-check form-check-flat form-check-primary">
              <label class="form-check-label">
                <input name="status"  type="checkbox" {{ old('status') == 'checked' ? 'checked' : '' }} class="form-check-input">
                Status
                <i class="input-helper"></i></label>
            </div>
          </div>

          <button type="submit" class="btn btn-inverse-primary btn-fw">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
