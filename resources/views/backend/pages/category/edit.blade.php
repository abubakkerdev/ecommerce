@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update Category Information</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('category.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group mb-4 col-md-6">
                                        <label for="cat">Category Name</label>
                                        <input type="text" class="form-control" name="cat_name" value="{{ old('cat_name') ? old('cat_name') : $category_info->cat_name }}" id="cat">

                                        @error('cat_name')
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
                                    <div class="form-group mb-4 col-md-6">
                                        <label for="massage" class="form-label">Description</label>
                                        <textarea class="form-control" id="massage" rows="4" name="cat_desc">{{ old('cat_desc') ? old('cat_desc') : $category_info->cat_desc }}</textarea>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="input-group mb-2 ml-2 col-md-12">
                                        @if (!empty($category_info->category_image))
                                            <img src="{{ asset('backend/uploads/category/'.$category_info->category_image) }}" width="100" class="mb-3" alt="">
                                        @else
                                            <strong class="mb-3">N/A</strong>
                                        @endif
                                    </div>

                                    <div class="input-group mb-4 col-md-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="category_image" class="custom-file-input">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Browse</span>
                                        </div>

                                        @error('category_image')
                                            <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                <span><i class="mdi mdi-alert"></i></span>
                                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                </button>
                                                <strong>Warning!</strong> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" name="category_id" value="{{ $category_info->id }}">

                                <button type="submit" class="btn btn-primary btn-sm">Update Category</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
