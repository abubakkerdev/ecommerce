@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update Product Inventory</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('inventory.update') }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group mb-4 col-md-12">
                                        <label for="product_name">Product Name</label>
                                        <select class="form-control" name="product_id" id="product">
                                            <option value="">Select Category</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" {{ ($inventory_info->product_id == $product->id) ? 'selected' : ((old('product_id') == $product->id) ? 'selected' : NULL ) }}>
                                                    {{ $product->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="input-group mb-4 col-md-12">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text btn-linkedin">Options</label>
                                        </div>
                                        <select class="form-control default-select" name="color_id">
                                            <option value="">Select Colors</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}" {{ ($inventory_info->color_id == $color->id) ? 'selected' : ((old('color_id') == $color->id) ? 'selected' : NULL ) }}>
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
                                                <option value="{{ $size->id }}" {{ ($inventory_info->size_id == $size->id) ? 'selected' : ((old('size_id') == $size->id) ? 'selected' : NULL ) }}>
                                                    {{ $size->size_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-4 col-md-12">
                                        <label for="product_quality">Product Quality</label>
                                        <input type="number" class="form-control"  id="product_quality" name="product_quality" value="{{ $inventory_info->product_quality }}">
                                    </div>
                                </div>

                                <input type="hidden" name="inventory_id" value="{{ $inventory_info->id }}">

                                <button type="submit" class="btn btn-primary btn-sm">Update Inventory</button>
                            </form>
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
    <script>
        $(document).ready(function() {
            $('#product').select2();
        });
    </script>
@endsection
