<div>

    @include('livewire.admin.brand._modal',['pageName',$pageName])


    <div class="row">
        <div class="col-md-12 grid-margin">


            <div class="card">
                <div class="card-header bg-transparent d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-end">
                        <h3>{{$pageName}}</h3>
                    </div>
                    <div class="d-flex justify-content-between align-items-end flex-wrap">
                        <a data-bs-toggle="modal" data-bs-target="#add{{$pageName}}"
                            class="btn btn-inverse-primary btn-fw">Add {{$pageName}}</a>
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
                                    <th>Category</th>
                                    <th>Slug</th>
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
                                    <td>{{$entity->slug}}</td>
                                    <td>
                                        @if ($entity->status == '1')
                                        <span class="p-2 bg-danger badge text-white rounded-pill"> Hidden</span>
                                        @else
                                        <span class="p-2 bg-success badge text-white rounded-pill"> Visable </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a wire:click='edit{{$pageName}}({{$entity->id}})' data-bs-toggle="modal"
                                            data-bs-target="#edit{{$pageName}}" class="btn btn-inverse-secondary btn-sm"
                                            href="javascript:void(0);">
                                            <i class="mdi mdi-border-color"></i>
                                        </a>

                                        <a wire:click='delete{{$pageName}}({{$entity->id}})'
                                            class="btn btn-inverse-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{$pageName}}" href="#">
                                            <i class="mdi mdi-delete-forever "></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center"> empty</td>
                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                        <div class="mt-4">
                            {{ $entities->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    window.addEventListener('close-modal',event => {
            $('#deleteBrand').modal('hide');
            $("#addBrand").modal('hide');
            $("#editBrand").modal('hide');
        });
</script>
@endpush