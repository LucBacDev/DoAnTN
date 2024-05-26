@extends('master_user')
@section('receipt')
    <!-- banner shop -->
    <div class="banner-shop">
        <div class="container h-100">
            <div class="row flex_center h-100">
                <div class="col-12">
                    <h2>Thanh Toán</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- banner shop end -->
    <div class="checkout_area padding-80">
        <div class="container">
            <div class="row">

                <div class="col-12 col-md-3">
                    <div class="checkout_details_area">

                        <div class="cart-page-heading mb-3">
                            <h5>Thông tin khách hàng</h5>
                        </div>

                        <form action="#" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="first_name">Họ và tên</label>
                                    <input type="text" class="form-control" name="full_name"
                                        value="{{ Auth::user()->full_name }}" required="">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="email_address">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ Auth::user()->email }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="phone_number">Số điện thoại</label>
                                    <input type="number" class="form-control" name="phone" min="0"
                                        value="{{ Auth::user()->phone }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="street_address">Địa chỉ</label>
                                    <input type="text" class="form-control" name="address"
                                        value="{{ Auth::user()->address }}">
                                </div>
                                <div class=" col-12 mb-3">
                                    <label for="" class="form-label">Ghi chú</label>
                                    <textarea class="form-control" id="" rows="3" name="note" value="note"></textarea>
                                </div>
                                <div class=" col-12 mb-3">
                                    <label for="exampleSelect1" class="control-label">Phương thức thanh toán</label>
                                    <select class="form-control" id="paymentSelect" name="payment_method">
                                        <option value="1">Thanh toán khi nhận hàng</option>
                                        <option value="2">Thanh toán qua Vn-Pay</option>
                                    </select>

                                    {{-- <script>
                                        document.getElementById('paymentSelect').addEventListener('change', function() {
                                            if (this.value == '2') {
                                                document.getElementById('vnpayForm').submit();
                                            }
                                        });
                                    </script> --}}
                                </div>
                            </div>
                    </div>
                </div>

                <div class="col-12 col-md-9">
                    <div class="order-details-confirmation">
                        <div class="cart-page-heading">
                            <h5 class="text-center pb-4">Đơn hàng của bạn</h5>
                        </div>
                        <tbody>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" colspan="2">Sản phẩm</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Màu sắc</th>
                                        <th scope="col">Kích cỡ</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col" class="text-end">Tổng tiền sản phẩm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart->getItem() as $item)
                                        <tr>
                                            {{-- image --}}
                                            <td class="pd-15 product-image">
                                                <img src="{{ url('upload.product') }}/{{ $item['image'] }}" width="100"
                                                    height="100" alt="">
                                            </td>
                                            {{-- name sp --}}
                                            <td class="pd-15 product-name">
                                                <a href="{{ route('product', $item['id']) }}">{{ $item['name'] }}</a>
                                            </td>
                                            {{-- giá --}}
                                            <th class="pd-15 product-price">{{ number_format($item['price']) }}</th>

                                            {{-- color --}}
                                            <td class="pd-15 product-color">
                                                {{ $item['attribute_color_id'] }}
                                            </td>

                                            {{-- size --}}
                                            <td class="pd-15 product-size">
                                                {{ $item['attribute_size_id'] }}
                                            </td>

                                            {{-- sl --}}
                                            <td class="pd-15 product-quantity text-center">
                                                {{ $item['quantity'] }}
                                            </td>
                                            {{-- tổng tiền --}}
                                            <th class="pd-15 product-total text-end">
                                                {{ number_format($item['quantity'] * $item['price']) }}đ
                                            </th>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th class="pd-15" colspan="6">Phí vận chuyển: </th>
                                        <th class="pd-15 text-end" colspan="1">30,000 đ</th>
                                    </tr>
                                    <tr>
                                        <th class="pd-15" colspan="6">Tổng tiền: </th>
                                        <th class="pd-15 text-end" colspan="1">
                                            {{ number_format($cart->totalPrice_ship()) }}đ
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn-checkout"> <span style="color:white;font-weight:600">Thanh
                                    Toán</span> </button>
                    </div>
                </div>
                </form>
                {{-- <form id="vnpayForm" action="{{ route('vnpay_payment') }}" method="POST" style="display:none;">
                    @csrf <!-- Include the CSRF token for security -->
                    <input type="hidden" name="payment_method" value="2">
                </form> --}}
            </div>
        </div>
    </div>
@endsection
