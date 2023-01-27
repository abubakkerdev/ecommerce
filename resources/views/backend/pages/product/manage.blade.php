@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Product List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-responsive-sm">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th scope="col">#SL</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Product Brand</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Subcategory</th>
                                            <th scope="col">Product Price</th>
                                            <th scope="col">Discount</th>
                                            <th scope="col">Discount Price</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Updated At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($products as $key => $product)
                                            <tr>
                                                <th scope="row">{{ $key+1 }}</th>
                                                <td>
                                                    <img src="{{ asset('backend/uploads/product/preview/'. $product->product_preview) }}" width="55" alt="" class="rounded mr-3">
                                                </td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->product_brand }}</td>
                                                <td>{{ $product->category_info->cat_name }}</td>
                                                <td>{{ $product->subcategory_info->subcat_name  }}</td>
                                                <td>${{ $product->product_price }}</td>
                                                <td>
                                                    @if (!empty($product->discount))
                                                        {{ $product->discount }}%
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($product->after_discount))
                                                        ${{ $product->after_discount }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ $product->created_at->diffForHumans() }}</td>
                                                <td>{{ $product->updated_at->diffForHumans() }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-linkedin shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>

                                                        <a href="{{ route('inventory.manage', $product->id) }}" class="btn btn-info shadow btn-xs sharp mr-1">
                                                            <i class="fa fa-archive" aria-hidden="true"></i>
                                                        </a>

                                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>

                                                        <a id="{{ route('product.delete', $product->id) }}" class="btn btn-danger delete_product shadow btn-xs sharp">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty

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
        $(".delete_product").click(function() {
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

    @if (session()->has('delete_product'))
        <script>
            Swal.fire(
                'Success',
                'Your file has been deleted.',
                'success'
            );
        </script>
    @endif

@endsection
