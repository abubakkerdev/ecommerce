@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-xxl-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Size</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('inventory.sizeStore') }}" method="POST">
                                @csrf
                                <div class="form-row">

                                    <div class="form-group mb-4 col-md-12">
                                        <label for="size">Size Name</label>
                                        <input type="text" class="form-control" name="size_name" id="size" value="{{ old('size_name') }}">

                                        @error('size_name')
                                            <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                <span><i class="mdi mdi-alert"></i></span>
                                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                </button>
                                                <strong>Warning!</strong> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm">Add Size</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-xxl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Size List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-responsive-sm">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th scope="col">#SL</th>
                                            <th scope="col">Size Name</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($all_size as $key => $size)
                                            <tr>
                                                <th scope="row">{{ $key+1 }}</th>
                                                <td>{{ $size->size_name }}</td>
                                                <td>
                                                    {{ $size->created_at->diffForHumans() }}
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a id="{{ route('inventory.size_delete', $size->id) }}" class="btn btn-danger delete_size shadow btn-xs sharp">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No data found</td>
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

    <script>
        $(".delete_size").click(function() {
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

    @if (session()->has('delete_size'))
        <script>
            Swal.fire(
                'Success',
                'Your file has been deleted.',
                'success'
            );
        </script>
    @endif

@endsection
