@extends('master_user')
@section('search')
    {{-- <!-- banner shop -->
    <div class="banner-shop">
        <div class="container h-100">
            <div class="row flex_center h-100">
                <div class="col-12">
                    <h2>Banner</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- banner shop end --> --}}

    <!-- shop gird area -->

    <div class="shop_gird_area padding-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop_sidebar_area">
                        <!-- ##### Single Widget ##### -->
                        <div class="widget catagory mb-50">
                            <!-- Widget Title -->
                            <h6 class="widget-title" style="margin-bottom: 0px">Lọc giá</h6>
                            <form id="searchForm" action="{{ route('search') }}" method="GET">
                                <div class="form-group" style="display: flex; flex-direction: column">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="price_range" id="price_all"
                                            value="all" checked>
                                        <label class="form-check-label" for="price_all">All</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="price_range" id="price_0_100"
                                            value="0_10000000">
                                        <label class="form-check-label" for="price_0_10000000">0 - 10.000.000đ</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="price_range" id="price_100_15000000"
                                            value="10000000_15000000">
                                        <label class="form-check-label" for="price_10000000_15000000">10.000.000đ - 15.000.000đ</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="price_range" id="price_100_15000000"
                                            value="15000000_20000000">
                                        <label class="form-check-label" for="price_100_200">15.000.000đ - 20.000.000đ</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="price_range" id="price_300_above" value="300_above">
                                        <label class="form-check-label" for="price_20000000_above">20.000.000đ trở lên</label>
                                    </div>
                                    <!-- Thêm các mức giá khác tùy ý -->
                                </div>
                                <h6 class="widget-title" style="margin-bottom: 0px">Hãng</h6>
                                <select class="form-control" id="brand" name="brand" style="margin: 10px 0">
                                    <option value="all">Tất cả</option>
                                    @foreach ($Brand as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                    <!-- Thêm các option cho các hãng khác tùy ý -->
                                </select>
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </form>
                           
                            <!--  Catagories  -->
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop_grid_product_area">
                        <div class="row">
                            <div class="col-12">
                                <div class="product-topbar d-flex align-items-center justify-content-between">
                                    <!-- Total Products -->
                                    <div class="total-products">
                                        <p><span>{{ $Total_product }}</span> được tìm thấy</p>
                                    </div>
                                    <!-- Sorting -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Single Product -->
                            @foreach ($Products as $value)
                                <div class="col-12 col-sm-6 col-lg-4">

                                    <div class="single-product-wrapper">
                                        <!-- Product Image -->
                                        <div class="product-img" style="height: 240px;overflow: hidden;">

                                            <a href="{{ route('product', $value->id) }}">
                                                <img class="img-fluid"
                                                    src="{{ url('upload.product') }}/{{ $value->image }}" alt=""
                                                    style="object-fit: cover; width: 100%; height: 100%;">
                                            </a>

                                            <!-- Hover Thumb -->
                                            {{-- <img class="hover-img" src="{{ url('assets-user') }}/img/product-img/product-2.jpg"
                                            alt=""> --}}
                                        </div>
                                        <!-- Product Description -->
                                        <div class="product-description">
                                            <span>{{ $value->getBrandName->name }}</span>
                                            <a href="{{ route('product', $value->id) }}">
                                                <h6>{{ $value->name }}</h6>
                                            </a>
                                            <div class="d-flex justify-content-space-around">
                                                <p class="product-price text-danger"
                                                    style="display: inline-block; margin-right:10px;font-size:18px">
                                                    {{ number_format($value->sale_price) }}đ</p>
                                                <p>
                                                <p>
                                                    <del class="product-price"
                                                        style="vertical-align: -webkit-baseline-middle">{{ number_format($value->price) }}đ</del>
                                                </p>
                                            </div>

                                            <!-- Hover Content -->
                                            <div class="hover-content">
                                                <!-- Add to Cart -->
                                                <div class="add-to-cart-btn">
                                                    <a href="{{ route('product', $value->id) }}"
                                                        class="btn essence-btn check-btn">View Product Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                </div>
            </div>
            <div class="d-flex justify-content-center" style="margin-left: 300px">
                {{ $Products->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- shop gird area end -->
@endsection
