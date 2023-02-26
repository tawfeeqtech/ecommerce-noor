<div wire:ignore.self class="modal fade" data-bs-backdrop='static' data-bs-keyboard='false' id="add{{$pageName}}" tabindex="-1" aria-labelledby="add{{$pageName}}Label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add{{$pageName}}Label">{{$pageName}} </h5>
                <button type="button" class="btn-close" wire:click='closeModal' data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div wire:loading class="p-4 ml-0 mr-0 mx-auto text-center">
                <div class="spinner-border text-primary mx-2" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
            </div>
            <div wire:loading.remove>
                <form wire:submit.prevent="store{{$pageName}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category_id">Brand</label>
                            <select wire:model.defer="category_id" class="form-control form-control-sm" id="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id') <small class="text-danger"> {{ $message }} </small> @enderror
                        </div>


                        <div class="form-group">
                            <label for="name">Name</label>
                            <input wire:model.defer='name' type="text" class="form-control" id="name" placeholder="name">
                            @error('name') <small class="text-danger"> {{ $message }} </small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input wire:model.defer="slug" type="text" class="form-control" id="slug" placeholder="slug">
                            @error('slug') <small class="text-danger"> {{ $message }} </small> @enderror
                        </div>
            
                        <div class="form-group">
                            <div class="form-check form-check-flat form-check-primary">
                                <label class="form-check-label">
                                    <input wire:model.defer="status" type="checkbox" class="form-check-input">
                                    Status
                                    <i class="input-helper"></i></label>
                                    Checked=Hidden, unChecked=Visible
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click='closeModal' class="btn btn-inverse-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-inverse-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div wire:ignore.self class="modal fade" data-bs-backdrop='static' data-bs-keyboard='false' id="edit{{$pageName}}" tabindex="-1" aria-labelledby="edit{{$pageName}}Label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit{{$pageName}}Label">Update {{$pageName}} </h5>
                <button type="button" class="btn-close" wire:click='closeModal' data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div wire:loading class="p-4 ml-0 mr-0 mx-auto text-center">
                <div class="spinner-border text-primary mx-2" role="status">
                    <span class="visually-hidden">Loading...</span> 
                  </div>Loading...
            </div>
            <div wire:loading.remove>
                <form wire:submit.prevent="update{{$pageName}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category_id">Brand</label>
                            <select wire:model.defer="category_id" class="form-control form-control-sm" id="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $item)
                                <option value="{{$item->id}}" {{$item->id == $category_id ?
                                    'selected' : ''}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id') <small class="text-danger"> {{ $message }} </small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input wire:model.defer='name' type="text" class="form-control" id="name" placeholder="name">
                            @error('name') <small class="text-danger"> {{ $message }} </small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input wire:model.defer="slug" type="text" class="form-control" id="slug" placeholder="slug">
                            @error('slug') <small class="text-danger"> {{ $message }} </small> @enderror
                        </div>
            
                        <div class="form-group">
                            <div class="form-check form-check-flat form-check-primary">
                                <label class="form-check-label">
                                    <input wire:model.defer="status" type="checkbox" class="form-check-input">
                                    Status
                                    <i class="input-helper"></i></label>
                                    Checked=Hidden, unChecked=Visible
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click='closeModal' class="btn btn-inverse-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-inverse-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div wire:ignore.self class="modal fade" data-bs-backdrop='static' data-bs-keyboard='false' id="delete{{$pageName}}" tabindex="-1" aria-labelledby="delete{{$pageName}}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete{{$pageName}}Label">{{$pageName}} Delete</h5>
                <button type="button" wire:click='closeModal' class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div wire:loading class="p-4 ml-0 mr-0 mx-auto text-center">
                <div class="spinner-border text-primary mx-2" role="status">
                    <span class="visually-hidden ">Loading...</span> 
                  </div>Loading...
            </div>
            <div wire:loading.remove>
                <form wire:submit.prevent='destroy{{$pageName}}'>
                    <div class="modal-body">
                        <h6> Are you sure you want to delete this data? </h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click='closeModal' class="btn btn-inverse-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-inverse-primary">Yes Delete.</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>