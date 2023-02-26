@extends('layouts.admin')

@section('content')
    <div class="row">
        @if ($message = session('message'))
            <h2 class="alert alert-success">{{$message}}</h2>
        @endif

        <div class="col-md-12 grid-margin">
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


                    <form class="forms-sample" method="post" action="{{ route($pageName.'s.update',$entity->id) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <ul class="nav nav-tabs " id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home"
                                        type="button" role="tab" aria-controls="home" aria-selected="true">Home
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="seotag-tab" data-bs-toggle="tab" data-bs-target="#seotag"
                                        type="button" role="tab" aria-controls="seotag" aria-selected="false">SEO Tag
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                                        type="button" role="tab" aria-controls="details" aria-selected="false">Details
                                </button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images"
                                        type="button" role="tab" aria-controls="images" aria-selected="false">Product
                                    Image
                                </button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="colors-tab" data-bs-toggle="tab" data-bs-target="#colors"
                                        type="button" role="tab" aria-controls="colors" aria-selected="false">Product
                                    Colors
                                </button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="sizes-tab" data-bs-toggle="tab" data-bs-target="#sizes"
                                        type="button" role="tab" aria-controls="sizes" aria-selected="false">Product
                                    Sizes
                                </button>
                            </li>

                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane border p-3 fade show active" id="home" role="tabpanel"
                                 aria-labelledby="home-tab">
                                <div class="row py-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input name="name" type="text" value="{{ $entity->name }}"
                                                   class="form-control"
                                                   id="name" placeholder="name">
                                            @error('name')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input name="slug" value="{{ $entity->slug }}" type="text"
                                                   class="form-control"
                                                   id="slug" placeholder="slug">
                                            @error('slug')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select name="category_id" class="form-control" id="category">
                                                @foreach ($categories as $category)
                                                    <option value="{{$category->id}}" {{$category->id == $entity->category_id ?
                                                'selected' : ''}}>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{--<div class="col-md-3">
                                        <div class="form-group">
                                            <label for="brand">Brand</label>
                                            <select name="brand" value="{{ $entity->brand }}" class="form-control"
                                                    id="brand">
                                                @foreach ($brands as $brand)
                                                    <option value="{{$brand->name}}" {{$brand->name == $entity->brand ?
                                                'selected' : ''}}>{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="small_description">Small Description</label>
                                            <textarea name="small_description" class="form-control"
                                                      id="small_description"
                                                      rows="4"> {{ $entity->small_description }}</textarea>
                                            @error('description')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" class="form-control" id="description"
                                                      rows="4">{{ $entity->description }}</textarea>
                                            @error('description')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane border p-3 fade" id="seotag" role="tabpanel"
                                 aria-labelledby="seotag-tab">
                                <div class="row py-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="meta_title">Meta Title</label>
                                            <input name="meta_title" value="{{ $entity->meta_title }}" type="text"
                                                   class="form-control" id="meta_title" placeholder="meta_title">
                                            @error('meta_title')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="meta_keyword">Meta keyword</label>
                                            <input name="meta_keyword" value="{{ $entity->meta_keyword }}" type="text"
                                                   class="form-control" id="meta_keyword" placeholder="meta_keyword">
                                            @error('meta_keyword')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <input name="meta_description" value="{{ $entity->meta_description }}"
                                                   type="text" class="form-control" id="meta_description"
                                                   placeholder="meta_description">
                                            @error('meta_description')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane border p-3 fade" id="details" role="tabpanel"
                                 aria-labelledby="details-tab">
                                <div class="row py-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="original_price">original price</label>
                                            <input name="original_price" value="{{ $entity->original_price }}"
                                                   type="text"
                                                   class="form-control" id="original_price"
                                                   placeholder="original_price">
                                            @error('original_price')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selling_price">selling price</label>
                                            <input name="selling_price" value="{{ $entity->selling_price }}" type="text"
                                                   class="form-control" id="selling_price" placeholder="selling_price">
                                            @error('selling_price')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="quantity">quantity</label>
                                            <input name="quantity" value="{{ $entity->quantity }}" type="text"
                                                   class="form-control" id="quantity" placeholder="quantity">
                                            @error('quantity')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-check form-check-flat form-check-primary">
                                                <label class="form-check-label">
                                                    <input name="trending" type="checkbox" class="form-check-input" {{
                                                    $entity->trending == '1' ? 'checked' : '' }}>
                                                    trending
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-check form-check-flat form-check-primary">
                                                <label class="form-check-label">
                                                    <input name="status" type="checkbox" class="form-check-input" {{
                                                    $entity->status == '1' ? 'checked' : '' }}>
                                                    Status
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane border p-3 fade" id="images" role="tabpanel"
                                 aria-labelledby="images-tab">
                                <div class="form-group py-2">
                                    <label for="image">upload image</label>
                                    <input type="file" name="image[]" multiple id="image" class="form-control">
                                </div>

                                <div>
                                    @if ($entity->productImages)
                                        <div class="row">
                                            @foreach ($entity->productImages as $item)
                                                <div class="col-md-2">
                                                    <img src="{{ asset($item->image)}}"
                                                         style="width: 80px; height:80px;"
                                                         class="me-4 border" alt="img">
                                                    <a href="{{ route($pageName.'s.removeImage',$item->id) }}"
                                                       class="d-block">Remove</a>
                                                </div>
                                            @endforeach

                                        </div>
                                    @else
                                        <h5>no image added</h5>
                                    @endif
                                </div>
                            </div>

                            <div class="tab-pane border p-3 fade" id="colors" role="tabpanel"
                                 aria-labelledby="colors-tab">
                                <label> Select Color</label>
                                <hr/>
                                <div class="row">

                                    @forelse ($colors as $colorItem)
                                        <div class="col-md-3">
                                            <div class="p-2 border mb-3">
                                                Color:
                                                <div class="form-check ">
                                                    <label class="form-check-label ">
                                                        <input type="checkbox"
                                                               {{ $colorItem->status == '1' ? 'checked' : '' }}
                                                               value="{{$colorItem->id}}"
                                                               name="colors[{{$colorItem->id}}]"
                                                               class="form-check-input">
                                                        {{$colorItem->name}}
                                                        <i class="input-helper"></i>
                                                    </label>
                                                </div>
                                                Quantity:

                                                <input class="form-control mt-2 form-control-sm d-inline" type="number"
                                                       name="colorquantity[{{$colorItem->id}}]">

                                            </div>

                                        </div>
                                    @empty
                                        <div class="col-md-12">
                                            <h1> No Color Found</h1>
                                        </div>
                                    @endforelse

                                </div>

                                <div class="table-responsive">
                                    <table class="table-sm table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Color Name</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($entity->productColors as $prodColor)
                                            <tr class="prod-color-tr">
                                                <td>
                                                    @if ($prodColor->color)
                                                        {{$prodColor->color->name}}
                                                    @else
                                                        <span class="text-center">No Color Found</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="input-group w-50">
                                                        <input type="text" value="{{$prodColor->quantity}}"
                                                               class="productColorQuantity form-control form-control-sm">
                                                        <button type="button" value="{{$prodColor->id}}"
                                                                data-action="{{ route('products.updateProdColorQty',$prodColor->id) }}"
                                                                class="updateProductColorBtn btn btn-primary btn-sm text-white">
                                                            Update
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" value="{{$prodColor->id}}"
                                                            data-action="{{ route('products.deleteProdColorQty',$prodColor->id) }}"
                                                            class="deleteProductColorBtn btn btn-danger btn-sm text-white">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-danger "> No Data</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane border p-3 fade" id="sizes" role="tabpanel"
                                 aria-labelledby="sizes-tab">
                                <label> Select Size</label>
                                <hr/>
                                <div class="row">

                                    @forelse ($sizes as $sizeItem)
                                        <div class="col-md-3">
                                            <div class="p-2 border mb-3">
                                                Size:
                                                <div class="form-check ">
                                                    <label class="form-check-label ">
                                                        <input type="checkbox"
                                                               {{ $sizeItem->status == '1' ? 'checked' : '' }}
                                                               value="{{$sizeItem->id}}"
                                                               name="colors[{{$sizeItem->id}}]"
                                                               class="form-check-input">
                                                        {{$sizeItem->name}}
                                                        <i class="input-helper"></i>
                                                    </label>
                                                </div>
                                                Quantity:

                                                <input class="form-control mt-2 form-control-sm d-inline" type="number"
                                                       name="sizequantity[{{$sizeItem->id}}]">

                                            </div>

                                        </div>
                                    @empty
                                        <div class="col-md-12">
                                            <h1> No Size Found</h1>
                                        </div>
                                    @endforelse

                                </div>

                                <div class="table-responsive">
                                    <table class="table-sm table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Size Name</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($entity->productSizes as $prodSize)
                                            <tr class="prod-size-tr">
                                                <td>
                                                    @if ($prodSize->size)
                                                        {{$prodSize->size->name}}
                                                    @else
                                                        <span class="text-center">No Size Found</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="input-group w-50">
                                                        <input type="text" value="{{$prodSize->quantity}}"
                                                               class="productSizeQuantity form-control form-control-sm">
                                                        <button type="button" value="{{$prodSize->id}}"
                                                                data-action="{{ route('products.updateProdSizeQty',$prodSize->id) }}"
                                                                class="updateProductSizeBtn btn btn-primary btn-sm text-white">
                                                            Update
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" value="{{$prodSize->id}}"
                                                            data-action="{{ route('products.deleteProdSizeQty',$prodSize->id) }}"
                                                            class="deleteProductSizeBtn btn btn-danger btn-sm text-white">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-danger "> No Data</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-inverse-primary btn-fw">Update</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $(document).on('click', '.updateProductColorBtn', function () {
                var product_id = "{{$entity->id}}";
                var prod_color_id = $(this).val();

                //var my_url = "/admin/product/product-color/"+prod_color_id;
                //var my_url = "/admin/products/product-color/"+prod_color_id;
                var my_url = $(this).attr('data-action');

                var qty = $(this).closest('.prod-color-tr').find('.productColorQuantity').val();

                //alert(prod_color_id);
                if (qty <= 0) {
                    alert("Quantity is required");
                    return false;
                }
                if (!$.isNumeric(qty)) {
                    alert("Quantity must be a number");
                    return false;
                }


                var data = {
                    'product_id': product_id,
                    'prod_color_id': prod_color_id,
                    'qty': qty,
                };

                $.ajax({
                    type: 'POST',
                    url: my_url,
                    data: data,
                    success: function (response) {
                        alert(response.message)
                    }
                });

            });
            $(document).on('click', '.deleteProductColorBtn', function () {
                var prod_color_id = $(this).val();
                var thisClick = $(this);
                my_url = $(this).attr('data-action');
                $.ajax({
                    type: 'GET',
                    url: my_url,
                    success: function (response) {
                        thisClick.closest('.prod-color-tr').remove();
                    }
                });

            });

            $(document).on('click', '.updateProductSizeBtn', function () {
                var product_id = "{{$entity->id}}";
                var prod_size_id = $(this).val();

                var my_url = $(this).attr('data-action');

                var qty = $(this).closest('.prod-size-tr').find('.productSizeQuantity').val();

                //alert(prod_color_id);
                if (qty <= 0) {
                    alert("Quantity is required");
                    return false;
                }
                if (!$.isNumeric(qty)) {
                    alert("Quantity must be a number");
                    return false;
                }


                var data = {
                    'product_id': product_id,
                    'prod_size_id': prod_size_id,
                    'qty': qty,
                };

                $.ajax({
                    type: 'POST',
                    url: my_url,
                    data: data,
                    success: function (response) {
                        alert(response.message)
                    }
                });

            });
            $(document).on('click', '.deleteProductSizeBtn', function () {
                var prod_size_id = $(this).val();
                var thisClick = $(this);
                my_url = $(this).attr('data-action');
                $.ajax({
                    type: 'GET',
                    url: my_url,
                    success: function (response) {
                        thisClick.closest('.prod-color-tr').remove();
                    }
                });

            });
        });
    </script>
@endsection
