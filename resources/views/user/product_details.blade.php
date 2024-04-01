@extends('master_user')
@section('product')
    <!-- product details -->
    <div class="product_details">
        <div class="container-fuild">
            <div class="row" style="margin-top: 100px">
                <div class="col-lg-6">
                    <div class="single_product_thumb" style="padding-left: 100px">
                        <div class="product_thumbnail_slides owl-carousel" id="product-images">
                            @foreach ($prodetail->imgs as $value)
                                <div class="item" style="width: 380px; height: 429px; overflow: hidden; margin-left:150px">
                                    <img class="bg-img" src="{{ url('upload.product') }}\{{ $value->image }}" alt=""
                                        style="object-fit: cover; max-width: 100%; max-height: 100%;">
                                </div>
                            @endforeach

                            @foreach ($img as $item)
                                <div class="item"
                                    style="width: 380px; height: 429px; overflow: hidden; margin-left:150px">
                                    <img class="product_image color-{{ $item->attribute_color_id }}"
                                        src="{{ url('upload.product') }}\{{ $item->image }}" alt=""
                                        style="object-fit: cover; max-width: 100%; max-height: 100%;">
                                </div>
                            @endforeach

                        </div>
                        {{-- <div class="d-flex">
                            @foreach ($atbdetail as $item)
                            <button style="margin-right: 30px; font-weight: bold; cursor: pointer; border: 1px solid transparent; background-color: transparent;" onclick="showImage({{ $item->attribute_color_id }}, this)">{{ $item->name }}</button>
                            @endforeach
                        </div> --}}
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="single_product_desc">

                        <a href="#">
                            <h2>{{ $prodetail->name }}</h2>
                        </a>
                        <p>
                        <h6>Màu sắc</h6>
                        </p>
                        <div class="d-flex">
                            @foreach ($atbdetail as $item)
                                <p data-color-id="{{ $item->attribute_color_id }}"
                                    data-image="{{ url('upload.product') }}\{{ $item->image }}"
                                    style="margin-right: 30px; font-weight: bold; cursor: pointer; border: 1px solid transparent; background-color: transparent;"
                                    onclick="showImage(this)">{{ $item->name }}</p>
                            @endforeach
                        </div>
                        <span>
                            <h6>Hãng: </h6>{{ $prodetail->getBrandName->name }}
                        </span>
                        @if ($prodetail->sale_price > 0)
                            <p class="product-price">
                                <span>{{ number_format($prodetail->price) }}đ</span>{{ number_format($prodetail->sale_price) }}đ
                            </p>
                        @else
                            <p class="product-price">{{ number_format($prodetail->price) }}đ</p>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('cart.add', $prodetail->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="attribute_color_id" id="selected-color">
                            {{-- quantity --}}
                            <div class="quatity">
                                <label for="">Số Lượng:</label>
                                <input type="number" step="1" max="100" value="1" name="quantity"
                                    class="quantity-field border-0 text-center w-25">
                            </div>
                            <!-- Select Box -->

                            <!-- Cart & Favourite Box -->
                            <div class="cart-fav-box d-flex align-items-center">
                                <!-- Cart -->
                                <button type="submit" class="btn essence-btn check-btn">Add to
                                    cart</button>
                                {{-- <div class="checkout">
                                        <a href="" class="btn essence-btn check-btn">Checkout</a>
                                    </div> --}}
                            </div>
                        </form>

                    </div>
                </div>


            </div>
            <div class="product-desc">
                <h4>Thông tin chi tiết</h4>
                <div class="short-description">
                    <p class="fonts">{!! $short_description !!}</p>
                </div>
                <div class="full-description" style="display: none;">
                    <p class="fonts">{!! $prodetail->description !!}</p>
                </div>
                <button class="show-more-btn">Xem thêm</button>
            </div>
        </div>
    </div>
    <style>
        .product-desc {
            justify-content: center;
            margin: 0px 0px 400px;
            padding: 50px 200px;
        }

        .short-description {

            /* Đặt chiều cao tối đa */
            overflow: hidden;
        }

        /* Ẩn phần nội dung dài */
        .full-description {
            display: none;
        }

        .show-more-btn {

            bottom: -50px;
            /* Đặt vị trí ẩn ban đầu dưới cùng */
            padding: 10px 20px;
            background-color: transparent;
            color: #333;
            border: 2px solid #333;
            border-radius: 5px;
            cursor: pointer;
            rgb(3, 2, 2) transition: all 0.3s ease;
        }

        .show-more-btn:hover {
            background-color: orange;
            color: #fff;
        }
    </style>
    <!-- product details ênd -->
    <script src="{{ url('assets-user') }}/js/cart.js"></script>
    <script src="{{ url('assets-user') }}/OwlCarousel/dist/jquery-3.6.2.min.js"></script>
    <script src="{{ url('assets-user') }}/OwlCarousel/dist/owl.carousel.min.js"></script>
    <script>
        $('.product_thumbnail_slides').owlCarousel({
            items: 1,
            margin: 0,
            loop: true,
            nav: true,
            navText: [`<i class="fa-solid fa-arrow-left item-left"></i>`,
                `<i class="fa-solid fa-arrow-right item-right"></i>`
            ],
            dots: false,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1000
        });
        document.addEventListener('DOMContentLoaded', function() {
            const showMoreBtn = document.querySelector('.show-more-btn');
            const fullDescription = document.querySelector('.full-description');
            const firstColorButton = document.querySelector('[data-color-id]');
    
    // Nếu có màu sắc trong danh sách
    if (firstColorButton) {
        // Gọi hàm showImage() cho màu sắc đầu tiên
        showImage(firstColorButton);
    }
            showMoreBtn.addEventListener('click', function() {
                if (fullDescription.style.display === 'none') {
                    fullDescription.style.display = 'block';
                    showMoreBtn.textContent = 'Thu gọn';
                } else {
                    fullDescription.style.display = 'none';
                    showMoreBtn.textContent = 'Xem thêm';
                }
            });
        });

        function showImage(element) {
    // Lấy dữ liệu từ các thuộc tính data của thẻ p
    const colorId = element.getAttribute('data-color-id');
    
    // Đặt giá trị màu vào trường ẩn
    const selectedColorField = document.getElementById('selected-color');
    selectedColorField.value = colorId;

    // Xóa lớp active từ tất cả các thẻ p
    const paragraphs = document.querySelectorAll('[data-color-id]');
    paragraphs.forEach(para => {
        para.style.borderColor = 'transparent';
    });

    // Thêm lớp active cho thẻ p được chọn
    element.style.borderColor = 'orange';
}
    </script>
@endsection
