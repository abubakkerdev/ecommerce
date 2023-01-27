@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update Subcategory Information</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('subcategory.update') }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="input-group mb-4 col-md-6">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text btn-linkedin">Options</label>
                                        </div>
                                        <select class="form-control default-select" name="category_id">
                                            <option value="">Select Category</option>
                                            @foreach ($category as $cate)
                                                <option value="{{ $cate->id }}" {{ ($subcat_edit->category_id == $cate->id) ? 'selected' : ((old('category_id') == $cate->id) ? 'selected' : NULL ) }}>
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
                                    <div class="form-group mb-4 col-md-6">
                                        <label for="cat">Sub Category Name</label>
                                        <input type="text" class="form-control" name="subcat_name" value="{{ old('subcat_name') ? old('subcat_name') : $subcat_edit->subcat_name }}" id="cat">

                                        @error('subcat_name')
                                            <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                <span><i class="mdi mdi-alert"></i></span>
                                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                </button>
                                                <strong>Warning!</strong> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" name="subcat_id" value="{{ $subcat_edit->id }}">

                                <button type="submit" class="btn btn-primary btn-sm">Update Subcategory</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
