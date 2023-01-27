@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-xxl-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Sub Category</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('subcategory.store') }}" method="POST">
                                @csrf
                                <div class="form-row">

                                    <div class="input-group mb-4 col-md-12">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text btn-linkedin">Options</label>
                                        </div>
                                        <select class="form-control default-select" name="category_id">
                                            <option value="">Select Category</option>
                                            @foreach ($category as $cate)
                                                <option value="{{ $cate->id }}" {{ (old('category_id') == $cate->id) ? 'selected' : NULL }}>
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

                                    <div class="form-group mb-4 col-md-12">
                                        <label for="cat">Sub Category Name</label>
                                        <input type="text" class="form-control" name="subcat_name" value="{{ old('subcat_name') }}" id="cat">

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

                                <button type="submit" class="btn btn-primary btn-sm">Add Subcategory</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-xxl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Sub-Category List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-responsive-sm">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th scope="col">#SL</th>
                                            <th scope="col">Category Name</th>
                                            <th scope="col">Sub-Category Name</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Updated At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($subcategory as $key => $subcate)
                                            <tr>
                                                <th scope="row">{{ $key+1 }}</th>
                                                <td>
                                                    {!! ($subcate->category->deleted_at == NULL) ? $subcate->category->cat_name : $subcate->category->cat_name.'&nbsp; &nbsp; <span class="badge light badge-warning"><i class="fa fa-circle text-warning mr-1"></i>Trash</span>' !!}
                                                </td>
                                                <td>{{ $subcate->subcat_name }}</td>
                                                <td>
                                                    {{ $subcate->created_at->diffForHumans() }}
                                                </td>
                                                <td>
                                                    {{ ($subcate->updated_at == NULL) ? 'N/A' : $subcate->updated_at->diffForHumans() }}
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('subcategory.edit', $subcate->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>

                                                        <a id="{{ route('subcategory.delete', $subcate->id) }}" class="btn btn-danger delete_subcat shadow btn-xs sharp">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No data found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('alertScripts')

    @if (session()->has('store'))
        <script>
            $.toast({
                heading: 'Success',
                text: '{{ session()->get("store") }}',
                icon: 'success',
                position: 'top-right',
                hideAfter: 2000,
                showHideTransition: 'slide'
            });
        </script>
    @endif

    @if (session()->has('update'))
        <script>
            $.toast({
                heading: 'Update successful',
                text: '{{ session()->get("update") }}',
                icon: 'info',
                position: 'top-right',
                hideAfter: 2500,
                showHideTransition: 'slide'
            });
        </script>
    @endif

    <script>
        $(".delete_subcat").click(function() {
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = $(this).attr('id');
            }
            });
        });
	</script>

    @if (session()->has('delete_subcat'))
        <script>
            Swal.fire(
                'Success',
                'Your file has been deleted.',
                'success'
            );
        </script>
    @endif

@endsection
