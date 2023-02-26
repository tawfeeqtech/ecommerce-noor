@extends('layouts.admin')

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
                        <h3>{{$pageName}}</h3>
                    </div>
                    <div class="d-flex justify-content-between align-items-end flex-wrap">
                        <a href="{{ route($pageName.'s.create') }}" class="btn btn-inverse-primary btn-fw">Add
                            {{$pageName}}</a>
                    </div>
                </div>

                <div class="card-body">
                    <h4 class="card-title">List of {{$pageName}}</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($entities as $entity)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$entity->name}}</td>

                                    <td>
                                        @if ($entity->category)
                                            {{$entity->category->name}}
                                        @else
                                            No Category
                                        @endif
                                        
                                    </td>
                                    
                                    <td>{{$entity->selling_price}}</td>
                                    <td>{{$entity->quantity}}</td>
                                    <td>
                                        @if ($entity->status == '1')
                                        <span class="p-2 bg-danger badge text-white rounded-pill"> Hidden</span>
                                        @else
                                        <span class="p-2 bg-success badge text-white rounded-pill"> Visable </span>
                                        @endif
                                    </td>
                                
                                    <td>
                                        <form action="{{ route($pageName.'s.destroy',$entity->id) }}" method="POST">

                                        <a class="btn btn-inverse-secondary btn-sm"
                                            href="{{ route($pageName.'s.edit',$entity->id) }}">
                                            <i class="mdi mdi-border-color "></i>
                                        </a>

                                        {{-- <a class="btn btn-inverse-danger btn-sm" onclick="return confirm('Are you sure')" href="{{ route($pageName.'.destroy',$entity->id) }}">
                                            <i class="mdi mdi-delete-forever "></i>
                                        </a> --}}
                                            @csrf

                                            @method('DELETE')
                                            <button type="submit" class="btn btn-inverse-danger btn-sm">
                                                <i class="mdi mdi-delete-forever "></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"> no data</td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>
                        {{-- <div class="mt-4">
                            {{ $entities->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection