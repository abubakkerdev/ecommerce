@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-xxl-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Category</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group mb-4 col-md-12">
                                        <label for="cat">Category Name</label>
                                        <input type="text" class="form-control" name="cat_name" value="{{ old('cat_name') }}" id="cat">

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
                                    <div class="form-group mb-4 col-md-12">
                                        <label for="massage" class="form-label">Description</label>
                                        <textarea class="form-control" id="massage" rows="4" name="cat_desc">{{ old('cat_desc') }}</textarea>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="input-group mb-4 col-md-12">
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

                                <button type="submit" class="btn btn-primary btn-sm">Add Category</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-xxl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Category List</h4>
                            <h4> <a href="{{ route('category.download') }}">Download</a> </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="{{ route('category.alltrash') }}" method="POST">
                                    @csrf
                                    <table class="table table-hover table-bordered table-responsive-sm">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th scope="col">
                                                    <label class="ckbox">
                                                        <input type="checkbox" id="checkAll"><span> All</span>
                                                    </label>
                                                </th>
                                                <th scope="col">#Sl</th>
                                                <th scope="col">Category Name</th>
                                                <th scope="col">Added By</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Created At</th>
                                                <th scope="col">Updated At</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($category as $key => $cate)
                                                <tr>
                                                    <th scope="row">
                                                        <input type="checkbox" class="checkAll" name="cate_id[]" value="{{ $cate->id }}">
                                                    </th>
                                                    <th scope="row">{{ $key+1 }}</th>
                                                    <td>{{ $cate->cat_name }}</td>
                                                    <td>{{ App\Models\User::find($cate->auth_id)->name }}</td>
                                                    <td class="sorting_1">
                                                        @if (!empty($cate->category_image))
                                                            <img class="rounded-circle" width="70" src="{{ asset('backend/uploads/category/'.$cate->category_image) }}" alt="">
                                                        @endif
                                                    </td>
                                                    <td>{{ $cate->created_at <  now()->subDays(30) ? $cate->created_at->format('d-m-Y') : $cate->created_at->diffForHumans() }}</td>
                                                    <td>
                                                        {{ ($cate->updated_at == NULL) ? 'N/A' : $cate->updated_at->diffForHumans() }}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="{{ route('category.edit', $cate->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>

                                                            <a id="{{ route('category.delete', $cate->id) }}" class="btn btn-danger delete_cat shadow btn-xs sharp">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No data found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    @if ($category->count() > 0)
                                        <button type="submit" name="trashuser_id" class="btn btn-danger btn-sm mb-3 mt-2">Trash All</button>
                                    @endif

                                    <a href="{{ route('category.perdelete') }}" class="btn btn-warning btn-sm mb-3 mt-2 float-end" style="float: right;">Permanent Delete</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xxl-4">
                </div>
                <div class="col-lg-8 col-xxl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Trash Category</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="{{ route('category.allrestore') }}" method="POST">
                                    @csrf
                                    <table class="table table-hover table-bordered table-responsive-sm">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th scope="col">
                                                    <label class="ckbox">
                                                        <input type="checkbox" id="restoreORdelete"><span> All</span>
                                                    </label>
                                                </th>
                                                <th scope="col">#Sl</th>
                                                <th scope="col">Category Name</th>
                                                <th scope="col">Added By</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Created At</th>
                                                <th scope="col">Updated At</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($trash_cate as $key => $category)
                                                <tr>
                                                    <th scope="row">
                                                        <input type="checkbox" class="restoreORdelete" name="trashCate_id[]" value="{{ $category->id }}">
                                                    </th>
                                                    <th scope="row">{{ $key+1 }}</th>
                                                    <td>{{ $category->cat_name }}</td>
                                                    <td>{{ App\Models\User::find($category->auth_id)->name }}</td>
                                                    <td class="sorting_1">
                                                        @if (!empty($category->category_image))
                                                            <img class="rounded-circle" width="70" src="{{ asset('backend/uploads/category/'.$category->category_image) }}" alt="">
                                                        @endif
                                                    </td>
                                                    <td>{{ $category->created_at <  now()->subDays(30) ? $category->created_at->format('d-m-Y') : $category->created_at->diffForHumans() }}</td>
                                                    <td>{{ $category->updated_at <  now()->subDays(30) ? $category->updated_at->format('d-m-Y') : $category->updated_at->diffForHumans() }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('category.restore', $category->id) }}" class="btn btn-info btn-sm">Restore</a>

                                                            <a  href="{{ route('category.forcedel', $category->id) }}" class="btn btn-warning btn-sm">Delete</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-warning">
                                                        <strong>
                                                            No Data Found
                                                        </strong>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    @if ($trash_cate->count() > 0)
                                        <button type="submit" name="trashrestore" value="1" class="btn btn-primary btn-sm mb-3 mt-2">Restore All</button>
                                        <button type="submit" name="trashdelete" value="2" class="btn btn-danger btn-sm mb-3 ml-2 mt-2">Delete All</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('alertScripts')

    @if (session()->has('category_store'))
        <script>
            $.toast({
                heading: 'Success',
                text: '{{ session()->get("category_store") }}',
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
        $(".delete_cat").click(function() {
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

    @if (session()->has('delete'))
        <script>
            Swal.fire(
                'Success',
                'Your file has been trash.',
                'success'
            );
        </script>
    @endif

    <script>
        $("#checkAll").click(function(){
            $('.checkAll').not(this).prop('checked', this.checked);
        });

        $("#restoreORdelete").click(function(){
            $('.restoreORdelete').not(this).prop('checked', this.checked);
        });
    </script>

@endsection
