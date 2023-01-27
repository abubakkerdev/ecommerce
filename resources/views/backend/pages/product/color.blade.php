@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-xxl-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Color</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('inventory.colorStore') }}" method="POST">
                                @csrf
                                <div class="form-row">

                                    <div class="form-group mb-4 col-md-12">
                                        <label for="color">Color Name</label>
                                        <input type="text" class="form-control" name="color_name" id="color" value="{{ old('color_name') }}">

                                        @error('color_name')
                                            <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                <span><i class="mdi mdi-alert"></i></span>
                                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                </button>
                                                <strong>Warning!</strong> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm">Add Color</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-xxl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Color List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-responsive-sm">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th scope="col">#SL</th>
                                            <th scope="col">Color Name</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($colors as $key => $color)
                                            <tr>
                                                <th scope="row">{{ $key+1 }}</th>
                                                <td>{{ $color->color_name }}</td>
                                                <td>
                                                    {{ $color->created_at->diffForHumans() }}
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a id="{{ route('inventory.color_delete', $color->id) }}" class="btn btn-danger delete_color shadow btn-xs sharp">
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
        $(".delete_color").click(function() {
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

    @if (session()->has('delete_color'))
        <script>
            Swal.fire(
                'Success',
                'Your file has been deleted.',
                'success'
            );
        </script>
    @endif

@endsection
