<div>
    <div wire:ignore.self class="modal fade" data-bs-backdrop='static' data-bs-keyboard='false' id="deleteCategory" tabindex="-1" aria-labelledby="deleteCategoryLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryLabel">Category Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading class="p-4 ml-0 mr-0 mx-auto text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                </div>
                <div wire:loading.remove>
                <form wire:submit.prevent='destroyCategory'>
                    <div class="modal-body">
                        <h6> Are you sure you want to delete this data? </h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-inverse-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-inverse-primary">Yes Delete.</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-md-12 grid-margin">
            @if ($message = session('message'))
            <h2 class="alert alert-success">{{$message}}</h2>
            @endif

            <div class="card">
                <div class="card-header bg-transparent d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-end">
                        <h3>Category</h3>
                    </div>
                    <div class="d-flex justify-content-between align-items-end flex-wrap">
                        <a href="{{ route('category.create') }}" class="btn btn-inverse-primary btn-fw">Add Category</a>
                    </div>
                </div>

                <div class="card-body">
                    <h4 class="card-title">List Unordered</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($entities as $entity)
                                <tr>
                                    <td>{{($entities->currentpage() -1 ) * $entities->perpage() + $loop->index + 1}}
                                    </td>
                                    <td>{{$entity->name}}</td>
                                    <td>
                                        @if ($entity->status == '1')
                                            <span class="p-2 bg-success badge text-white rounded-pill"> Visible </span>
                                        @else
                                            <span class="p-2 bg-danger badge text-white rounded-pill"> Hidden</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-inverse-secondary btn-sm"
                                            href="{{ route('category.edit',$entity->id) }}">
                                            <i class="mdi mdi-border-color "></i>
                                        </a>

                                        <a wire:click='deleteCategory({{$entity->id}})'
                                            class="btn btn-inverse-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteCategory" href="#">
                                            <i class="mdi mdi-delete-forever "></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

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
            $('#deleteCategory').modal('hide');
        });
</script>
@endpush
