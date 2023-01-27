@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Product Inventory List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-responsive-sm">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th scope="col">#SL</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Color</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">Quality</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Updated At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($inventory as $key => $inventory_info)
                                            <tr>
                                                <th scope="row">{{ $key+1 }}</th>
                                                <td>{{ $inventory_info->product->product_name }}</td>
                                                <td>{{ $inventory_info->color->color_name }}</td>
                                                <td>{{ $inventory_info->size->size_name }}</td>
                                                <td>{{ $inventory_info->product_quality }}</td>
                                                <td>
                                                    {{ $inventory_info->created_at->diffForHumans() }}
                                                </td>
                                                <td>
                                                    {{ ($inventory_info->updated_at == NULL) ? 'N/A' : $inventory_info->updated_at->diffForHumans() }}
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('inventory.edit', $inventory_info->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>

                                                        <a id="{{ route('inventory.delete', $inventory_info->id) }}" class="btn btn-danger delete_inventory shadow btn-xs sharp">
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
        $(".delete_inventory").click(function() {
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

    @if (session()->has('delete_inventory'))
        <script>
            Swal.fire(
                'Success',
                'Your file has been deleted.',
                'success'
            );
        </script>
    @endif

@endsection
