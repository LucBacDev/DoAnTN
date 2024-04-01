@extends('master_user')
@section('container')

    <!-- banner category -->
    {{-- {{dd(session()->get('cart'))}} --}}
    <section class="welcome_category">
        {{-- allert notification --}}
        @if (session('notification'))
        <div class="alert alert-success text-center">
            {{ session('notification') }}
        </div>
    @endif
    {{-- allert notification end --}}

        @foreach ($banner as $item)
        @if ($item->status == 1)
            <img src="{{ url('image_brands') }}\{{ $item->image }}" alt="">
        @endif
        
        @endforeach
       </a>
    </section>
    <!-- end banner category -->
    <!-- new product -->
    <section class="new_arrivals_area padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-heading text-center">
                        <h2>Điện thoại bán chạy</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                @foreach ($popular as $item)
                    @foreach ($product as $value)
                        @if ($item->product_id == $value->id)
                     
                    <div class="col-lg-3 col-md-4 col-6">
                        <!-- Single Product -->
                        <div class="single-product-wrapper">
                            <!-- Product Image -->
                            <div class="product-img" style="height: 240px;overflow: hidden;">
                                <a href="{{ route('product', $value->id) }}">
                                    <img class="img-fluid" src="{{ url('upload.product') }}/{{ $value->image }}"
                                        alt="" style="object-fit: cover; width: 100%; height: 100%;">
                                </a>
                                <!-- Hover Thumb -->
                                {{-- <img class="hover-img" src="{{ url('assets-user') }}/img/product-img/product-2.jpg"
                                alt=""> --}}
                            </div>
                            <!-- Product Description -->
                            <div class="product-description">
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
                                        <a href="{{ route('product', $value->id) }}" class="btn essence-btn check-btn">Xem điện thoại</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                           
                    @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
    <!-- new product end  -->

    <!-- banner info  -->
    <div class="banner-info">
        <div class="container-fuild">
            <div class="row">
              
                    <div class="banner-img bg-img">
                        <img src="{{ url('assets-user') }}/img/sale.png" alt="">
                    </div>
                
            </div>
        </div>
    </div>
    <!-- banner info end -->

    <!-- new product 2 -->
    <section class="new_arrivals_area padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-heading text-center">
                        <h2>Điện thoại mới</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                @foreach ($newpro as $value)
                    <div class="col-lg-3 col-md-4 col-6">
                        <!-- Single Product -->
                        <div class="single-product-wrapper">
                            <!-- Product Image -->
                            <div class="product-img">
                                
                                <a href="{{ route('product', $value->id) }}">
                                    <img src="{{ url('upload.product') }}/{{ $value->image }}" alt="">
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

                                </div>

                                <!-- Hover Content -->
                                <div class="hover-content">
                                    <!-- Add to Cart -->
                                    <div class="add-to-cart-btn">
                                        <a href="{{ route('product', $value->id) }}" class="btn essence-btn check-btn">View
                                            Product Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- new product 2 end  -->
@endsection
