@extends('master_user')
@section('container')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <!-- banner category -->
    {{-- {{dd(session()->get('cart'))}} --}}
    <section class="welcome_category">
        {{-- allert notification --}}
        @if (session('notification'))
            <div id="notification" class="alert alert-success text-center">
                {{ session('notification') }}
            </div>
        @endif
        <script>
            setTimeout(function() {
                document.getElementById('notification').style.display = 'none';
            }, 10000); // 10 giây
        </script>
        {{-- allert notification end --}}
     
            <div id="slider">
                <div class="owl-carousel owl-theme">
                    @foreach ($banner as $item)
                        @if ($item->status == 1)
                            <div class="item" style="padding: 0;margin:0">
                                <img src="{{ url('image_brands') }}\{{ $item->image }}" alt="">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>






    </section>
    <!-- end banner category -->
    <!-- new product -->

    {{-- <section class="new_arrivals_area padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-heading text-center">
                        <h2>Quần áo bán chạy</h2>
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
                                <div class="single-product-wrapper">
                                    <div class="product-img" style="height: 240px;overflow: hidden;">
                                        <a href="{{ route('product', $value->id) }}">
                                            <img class="img-fluid" src="{{ url('upload.product') }}/{{ $value->image }}"
                                                alt="" style="object-fit: cover; width: 100%; height: 100%;">
                                        </a>

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

                                            <div class="hover-content">
                                                <div class="add-to-cart-btn">
                                                    <a href="{{ route('product', $value->id) }}"
                                                        class="btn essence-btn check-btn">Xem quần áo</a>
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
    </section> --}}

    <!-- new product end  -->

    {{-- <!-- banner info  -->
    <div class="banner-info">
        <div class="container-fuild">
            <div class="row">
              
                    <div class="banner-img bg-img">
                        <img src="{{ url('assets-user') }}/img/sale.png" alt="">
                    </div>
                
            </div>
        </div>
    </div>
    <!-- banner info end --> --}}

    <!-- new product 2 -->
    <section class="new_arrivals_area padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-heading text-center">
                        <h2>Quần áo mới</h2>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Owl Carousel JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#slider .owl-carousel').owlCarousel({
                    loop: true,
                    margin: 10,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 5000, // 5000ms = 5s
                    autoplayHoverPause: true,
                    items: 1,
                    nav: true
                })
            })
        </script>
        <style>
            .item {
                padding: 30px;
                margin: 10px;
                color: white;
                border-radius: 3px;
                text-align: center;
            }

            /* Custom CSS for navigation buttons */
            .owl-nav {
                position: absolute;
                top: 50%;
                width: 100%;
                display: flex;

                justify-content: space-between;
                transform: translateY(-50%);
            }

            .owl-nav span {
                font-size: 40px;
            }

            .owl-nav button {
                background: none;
                border: none;
                font-size: 30px;
                color: #fff;
            }

            /* .owl-nav button.owl-prev {
                position: absolute;
                left: -25px; /* Adjust this value to move the button further left or right */
            }

            .owl-nav button.owl-next {
                position: absolute;
                right: -25px;
                /* Adjust this value to move the button further left or right */
            }

            */
        </style>
    </section>
    <!-- new product 2 end  -->
@endsection
