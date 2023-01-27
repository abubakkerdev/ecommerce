@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-xxl-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Coupon</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('coupon.store') }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group mb-4 col-md-12">
                                        <label for="coupon">Coupon Name</label>
                                        <input type="text" class="form-control" name="coupon_name" value="{{ old('coupon_name') }}" id="coupon">

                                        @error('coupon_name')
                                            <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                <span><i class="mdi mdi-alert"></i></span>
                                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                </button>
                                                <strong>Warning!</strong> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4 col-md-12">
                                        <label for="discount">Discount</label>
                                        <input type="number" class="form-control" name="discount" value="{{ old('discount') }}" id="discount">

                                        @error('discount')
                                            <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                <span><i class="mdi mdi-alert"></i></span>
                                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                </button>
                                                <strong>Warning!</strong> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4 col-md-12">
                                        <label for="validity">Validity</label>
                                        <input type="date" class="form-control" name="validity" value="{{ old('validity') }}" id="validity">

                                        @error('validity')
                                            <div class="alert mt-3 alert-dark solid alert-right-icon alert-dismissible fade show">
                                                <span><i class="mdi mdi-alert"></i></span>
                                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                                </button>
                                                <strong>Warning!</strong> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm">Add Coupon</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-xxl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Coupon List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-responsive-sm">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th scope="col">#SL</th>
                                            <th scope="col">Coupon Name</th>
                                            <th scope="col">Discount</th>
                                            <th scope="col">Validity</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($coupons as $key => $coupon)
                                            <tr>
                                                <th scope="row">{{ $key+1 }}</th>
                                                <td>
                                                    {{ $coupon->coupon_name }}
                                                </td>
                                                <td>{{ $coupon->discount }} %</td>
                                                <td>{{ $coupon->validity }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>

                                                        <a id="{{ route('coupon.delete', $coupon->id) }}" class="btn btn-danger delete_subcat shadow btn-xs sharp">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No data found</td>
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

    @if (session()->has('delete_coupon'))
        <script>
            Swal.fire(
                'Success',
                'Your file has been deleted.',
                'success'
            );
        </script>
    @endif

@endsection
