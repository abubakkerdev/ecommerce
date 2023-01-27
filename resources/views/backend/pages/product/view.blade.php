@extends('backend.layouts.template')

@section('dashboardBodyContent')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xxl-12">

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Product Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-lg-6  col-md-6 col-xxl-5 ">
                                    <!-- Tab panes -->
                                    <div class="tab-content">

                                        <div role="tabpanel" class="tab-pane fade show active">
                                            <img class="img-fluid" src="{{ asset('backend/uploads/product/preview/'.$product_info->product_preview) }}" alt="">
                                        </div>

                                        @foreach ($product_info->product_thumbnail as $product_img)
                                            <div role="tabpanel" class="tab-pane fade" id="image_{{ $product_img->id }}">
                                                <img class="img-fluid" src="{{ asset('backend/uploads/product/thumbnail/'.$product_img->product_thumbnail) }}" alt="">
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="tab-slide-content new-arrival-product mb-4 mb-xl-0">
                                        <!-- Nav tabs -->
                                        <ul class="nav slide-item-list mt-3" role="tablist">

                                            @foreach ($product_info->product_thumbnail as $product_image)
                                                <li role="presentation" class="show">
                                                    <a href="#image_{{ $product_image->id }}" role="tab" data-toggle="tab">
                                                        <img class="img-fluid" src="{{ asset('backend/uploads/product/thumbnail/'.$product_image->product_thumbnail) }}" alt="" width="50">
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>


                                <!--Tab slider End-->
                                <div class="col-xl-9 col-lg-6  col-md-6 col-xxl-7 col-sm-12">
                                    <div class="product-detail-content">
                                        <!--Product details-->
                                        <div class="new-arrival-content pr">
                                            <h4> {{ $product_info->product_name }} </h4>
                                            <div class="d-table mb-2">
                                                <p class="price float-left d-block">${{ $product_info->product_price }}.00</p>
                                            </div>
                                            <p>Availability: <span class="item"> In stock <i class="fa fa-shopping-basket"></i></span>
                                            </p>
                                            <p>Product code: <span class="item">0405689</span> </p>
                                            <p>Brand: <span class="item">{{ $product_info->product_brand }}</span></p>
                                            <p>Category: <span class="item">{{ $product_info->category_info->cat_name }}</span></p>
                                            <p>Subcategory: <span class="item">{{ $product_info->subcategory_info->subcat_name  }}</span></p>
                                            <p class="text-content">{{ $product_info->product_desc }}</p>
                                            <div class="filtaring-area my-3">
                                                <div class="size-filter">
                                                    <h4 class="m-b-15">Select size</h4>

                                                    <div class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-outline-primary light btn-sm"><input type="radio" class="position-absolute invisible" name="options" id="option5"> XS</label>
                                                        <label class="btn btn-outline-primary light btn-sm"><input type="radio" class="position-absolute invisible" name="options" id="option1" checked="">SM</label>
                                                        <label class="btn btn-outline-primary light btn-sm"><input type="radio" class="position-absolute invisible" name="options" id="option2"> MD</label>
                                                        <label class="btn btn-outline-primary light btn-sm"><input type="radio" class="position-absolute invisible" name="options" id="option3"> LG</label>
                                                        <label class="btn btn-outline-primary light btn-sm"><input type="radio" class="position-absolute invisible" name="options" id="option4"> XL</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Quantity start-->
                                            <div class="col-2 px-0">
                                                <input type="text" name="num" class="form-control input-btn input-number" value="1 NULL" disabled>
                                            </div>
                                            <!--Quanatity End-->
                                            <div class="shopping-cart mt-3">
                                                <a class="btn btn-primary " href="{{ route('product.edit',$product_info->id) }}">Update Product Info</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
