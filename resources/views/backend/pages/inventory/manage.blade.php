@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-xxl-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Inventory</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('inventory.store') }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group mb-4 col-md-12">
                                        <label for="product_name">Product Name</label>
                                        <input type="text" class="form-control"  id="product_name" value="{{ $product->product_name }}" readonly>
                                    </div>

                                    <div class="input-group mb-4 col-md-12">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text btn-linkedin">Options</label>
                                        </div>
                                        <select class="form-control default-select" name="color_id">
                                            <option value="">Select Colors</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}" {{ (old('color_id') == $color->id) ? 'selected' : NULL }}>
                                                    {{ $color->color_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="input-group mb-4 col-md-12">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text btn-linkedin">Options</label>
                                        </div>
                                        <select class="form-control default-select" name="size_id">
                                            <option value="">Select Sizes</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}" {{ (old('size_id') == $size->id) ? 'selected' : NULL }}>
                                                    {{ $size->size_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-4 col-md-12">
                                        <label for="product_quality">Product Quality</label>
                                        <input type="number" class="form-control"  id="product_quality" name="product_quality" value="{{ old('product_quality') }}">
                                    </div>
                                </div>

                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <button type="submit" class="btn btn-primary btn-sm">Add Inventory</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-xxl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Product Inventory List</h4>
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
                                                <td>{{ ($inventory_info->size) ? $inventory_info->size->size_name : 'N/A' }}</td>
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

    @if (session()->has('invenStore'))
        <script>
            $.toast({
                heading: 'Success',
                text: '{{ session()->get("invenStore") }}',
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
