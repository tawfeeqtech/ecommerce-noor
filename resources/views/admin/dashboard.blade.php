@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        @if (session('message'))
            <h2 class="alert alert-success">{{session('message')}}</h2>
        @endif

      <div class="d-flex justify-content-between flex-wrap">
        <div class="d-flex align-items-end flex-wrap">
          <div class="me-md-3 me-xl-5">
            <h2>Dashboard</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
