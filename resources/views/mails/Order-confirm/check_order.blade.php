<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="col-12">
        <h2>Xin chào {{ Auth::user()->full_name }}</h2>
        <h2>Vui lòng xác nhận lại đơn hàng của bạn</h2>
    </div>
    
    <h4><a href="{{ route('xacnhan', ['id'=>$order->id, 'token'=>$order->token])}}" style="padding: 10px; background-color: green" >Xác nhận đơn hàng</a></h4>
   
    
    <h5>Billing Address</h5>

    <tr>
        <td>Full Name</td>
        <td>Email</td>
        <td>Phone Number</td>
        <td>Address</td>
        <td>Order notes</td>
    </tr>
    <tr>
        <td>{{ Auth::user()->full_name }}</td>
        <td>{{ Auth::user()->email }}</td>
        <td>{{ Auth::user()->phone }}</td>
        <td>{{ Auth::user()->address }}</td>
        <td></td>

    </tr>
<br>

<div class="col-12 col-md-9">
<div class="order-details-confirmation">
<div class="cart-page-heading">
    <h5 class="text-center pb-4">Your Order</h5>
</div>
<tbody>
    <table class="table">
        <thead>
            <tr>
                <td scope="col" colspan="2">Product</td>
                <td scope="col">Price</td>
                <td scope="col">Attribute color</td>
                <td scope="col">Quantity</td>
                <td scope="col" class="text-end">Provisional Amount</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart->getItem() as $item)
                <tr>
                    {{-- image --}}
                
                    {{-- name sp --}}
                    <td class="pd-15 product-name">
                        {{ $item['name'] }}
                    </td>
                    {{-- giá --}}
                    <td class="pd-15 product-price">{{ number_format($item['price']) }}</td>
                    {{-- color --}}
                    @foreach ($attribute as $query)
                    @if ($item['attribute_color_id'] == $query->id)
                        <td class="pd-15 product-color">
                            {{ $query->name }}
                        </td>
                    @endif
                @endforeach
                    {{-- sl --}}
                    <td class="pd-15 product-quantity text-center">
                        {{ $item['quantity'] }}
                    </td>
                    {{-- tổng tiền --}}
                    <td class="pd-15 product-total text-end">
                        {{ number_format($item['quantity'] * $item['price']) }}đ
                    </td>
                </tr>
            @endforeach
            <tr>
                <th class="pd-15" colspan="6">Transport fee: </th>
                <th class="pd-15 text-end" colspan="1">30,000 đ</th>
            </tr>
            <tr>
                <th class="pd-15" colspan="6">Total Money: </th>
                <th class="pd-15 text-end" colspan="1">{{ number_format($cart->totalPrice_ship()) }}đ
                </th>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>

