@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Product</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('product.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-row">
                                            <div class="form-group mb-4 col-md-12">
                                                <label for="proname">Product Name</label>
                                                <input type="text" class="form-control" name="product_name" value="{{ old('product_name') ? old('product_name') : $product->product_name }}" id="proname">

                                                @error('product_name')
                                                    <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                        <span><i class="mdi mdi-alert"></i></span>
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                        <strong>Warning!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group mb-4 col-md-12">
                                                <label for="prodesc">Product Description</label>
                                                <textarea name="product_desc" class="summernote">{{ old('product_desc') ? old('product_desc') : $product->product_desc }}</textarea>

                                                @error('product_desc')
                                                    <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                        <span><i class="mdi mdi-alert"></i></span>
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                        <strong>Warning!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group mb-4 col-md-12">
                                                <label for="short_desc">Product Short-Description</label>

                                                <textarea class="form-control" name="short_desc" rows="6" id="short_desc">{{ old('short_desc') ? old('short_desc') : $product->short_desc }}</textarea>

                                                @error('short_desc')
                                                    <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                        <span><i class="mdi mdi-alert"></i></span>
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                        <strong>Warning!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-row mt-4">
                                            <div class="input-group mb-4 col-md-12">

                                                <select class="form-control" name="category_id" id="category">
                                                    <option value="">Select Category</option>
                                                    @foreach ($category as $cate)
                                                        <option value="{{ $cate->id }}" {{ ($product->category_id == $cate->id) ? 'selected' : ((old('category_id') == $cate->id) ? 'selected' : NULL ) }}>
                                                            {{ $cate->cat_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('category_id')
                                                    <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                        <span><i class="mdi mdi-alert"></i></span>
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                        <strong>Warning!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="input-group mb-4 col-md-12">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text btn-linkedin">Options</label>
                                                </div>
                                                <select class="form-control" name="subcategory_id" id="subcat">
                                                    <option value="">Select Subcategory</option>
                                                    @foreach ($subcategory as $subcate)
                                                        <option value="{{ $subcate->id }}" {{ ($product->category_id == $subcate->id) ? 'selected' : ((old('subcategory_id') == $subcate->id) ? 'selected' : NULL ) }}>
                                                            {{ $subcate->subcat_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('subcategory_id')
                                                    <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                        <span><i class="mdi mdi-alert"></i></span>
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                        <strong>Warning!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group mb-4 col-md-12">
                                                <label for="brand">Product Brand</label>
                                                <input type="text" class="form-control" name="product_brand" value="{{ old('product_brand') ? old('product_brand') : $product->product_brand }}" id="brand">

                                                @error('product_brand')
                                                    <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                        <span><i class="mdi mdi-alert"></i></span>
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                        <strong>Warning!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group mb-4 col-md-12">
                                                <label for="price">Product Price</label>
                                                <input type="number" class="form-control" name="product_price" value="{{ old('product_price') ? old('product_price') : $product->product_price }}" id="price">

                                                @error('product_price')
                                                    <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                        <span><i class="mdi mdi-alert"></i></span>
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                        <strong>Warning!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group mb-4 col-md-12">
                                                <label for="discount">Discount</label>
                                                <input type="number" class="form-control" name="discount" value="{{ old('discount') ? old('discount') : $product->discount }}" id="discount">

                                                @error('discount')
                                                    <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                        <span><i class="mdi mdi-alert"></i></span>
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                        <strong>Warning!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <label for="proview" class="ml-2">Product Image</label>
                                        </div>

                                        <div class="form-row">
                                            <div class="input-group mb-2 ml-2 col-md-5">
                                                @if (!empty($product->product_preview))
                                                    <img src="{{ asset('backend/uploads/product/preview/'.$product->product_preview) }}" width="100" class="mb-3" alt="">
                                                @else
                                                    <strong class="mb-3">N/A</strong>
                                                @endif

                                                <input type="hidden" value="{{ $product->id }}" id="product_id">
                                            </div>

                                            <div class="input-group mb-4 col-md-12">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" name="product_preview" class="custom-file-input" id="proview">
                                                    <label class="custom-file-label">Choose</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Browse</span>
                                                </div>

                                                @error('product_preview')
                                                    <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                        <span><i class="mdi mdi-alert"></i></span>
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                        <strong>Warning!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-8">

                                        <div class="row" id="thumbnail_html">

                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-row mt-5">
                                            <label for="prothumb" class="ml-2" style="
                                            margin-top: 40px;"> Thumbnails</label>
                                            <div class="input-group mb-4 col-md-12">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" multiple  name="product_thumbnail[]" class="custom-file-input" id="prothumb">
                                                    <label class="custom-file-label">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Browse</span>
                                                </div>

                                                @error('product_thumbnail[]')
                                                    <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                        <span><i class="mdi mdi-alert"></i></span>
                                                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                        </button>
                                                        <strong>Warning!</strong> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" value="{{ $product->id }}" name="product_id">

                                <button type="submit" class="btn btn-primary btn-sm">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('alertScripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function thumbnail()
        {
            var id = $('#product_id').val();

            $.ajax({
                type: "GET",
                url: "/admin/dashboard/product/thumbnails/"+id,
                dataType: "json",
                success: function (data) {
                    $('#thumbnail_html').html(data);
                }
            });
        }
        thumbnail();

        function runthumbnail(myinfo)
        {
            var thumbnail_id = myinfo;

            $.ajax({
                type: "POST",
                url: "/admin/dashboard/product/delthumbnail",
                data: {'thumbnail_id': thumbnail_id},
                dataType: "json",
                success: function (data) {
                    thumbnail();
                }
            });
        }

        $('#category').change(function ()
        {
            var category = $(this).val();

            $.ajax({
                type: "POST",
                url: "/admin/dashboard/product/subcategory",
                data: {'category_id':category},
                dataType: "json",
                success: function (catData) {
                    $('#subcat').html(catData);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#category').select2();
        });
    </script>
@endsection
