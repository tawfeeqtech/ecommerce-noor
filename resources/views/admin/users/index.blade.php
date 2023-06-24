@extends('layouts.admin')

@section('title','Users List')

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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse ($entities as $entity)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$entity->name}}</td>
                                        <td>{{$entity->email}}</td>
                                        <td>
                                            @if($entity->role_as == '0')
                                                <lable class="badge btn-inverse-primary">User</lable>
                                            @elseif($entity->role_as == '1')
                                                <lable class="badge btn-inverse-success">Admin</lable>
                                            @else
                                                <lable class="badge btn-inverse-danger">None</lable>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route($pageName.'s.destroy',$entity->id) }}" method="POST">

                                                <a class="btn btn-inverse-secondary btn-sm"
                                                   href="{{ route($pageName.'s.edit',$entity->id) }}">
                                                    <i class="mdi mdi-border-color "></i>
                                                </a>

                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('are you sure?')" class="btn btn-inverse-danger btn-sm">
                                                    <i class="mdi mdi-delete-forever "></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"> no data</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <div>
                                {{$entities->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
