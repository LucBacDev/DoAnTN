@extends('master_user')
@section('container')
    <div class="container">
        <div class="row" style="padding-top: 20px">
            @if (Auth::check())
                <div class="col-md-3">
                    @if (Auth::check())
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ Auth::user()->full_name }}</h5>
                                <p class="card-text">Quản Lý Đơn Hàng</p>
                            </div>
                        </div>
                    @endif
                    <ul class="list-group" style="padding: 10px 0px">
                        <li class="list-group-item active" aria-current="true">Đơn Mua</li>
                    </ul>
                </div>
        
                <div class="col-md-9">
                    <div class="box-order">
                        <div class="search-order">
                            <form action="" method="get">
                                <input type="text" name="" id=""
                                    placeholder="Bạn có thể tìm kiếm theo tên Shop, ID đơn hàng hoặc Tên Sản phẩm">
                                <button type="submit">Tìm Kiếm</button>
                            </form>
                        </div>
                        {{-- change here --}}
                        <div class="box-bought">
                            <div class="single_box_buy">
                                @foreach ($order_detail as $item)
                                <div>
                                <div class="card product_purchased">
                                    <div class="row">
                                     
                                        <div class="col-md-10 product">
                                            <div class="product_img">
                                                <img src="https://i.pinimg.com/564x/4c/73/20/4c7320a9d200b90bafbf1f79ffdef61e.jpg"
                                                    class="img-fluid rounded-start" alt="...">
                                            </div>
                                            <div class="product_title">
                                                <div>
                                                    <h5>{{$item->name}}</h5>
                                                    <span>Phân loại Hàng</span>
                                                    <span> @foreach ($product_atb as $value)
                                                        @if ($item->pro_id == $value->id)
                                                            @foreach ($product_cb as $query)
                                                                @if ($value->id == $query->product_attribute_id)
                                                                @foreach ($attribute as $key)
                                                                    @if ($query->attribute_id == $key->id)
                                                                        <td>{{$key->name}}</td>
                                                                    @endif
                                                                @endforeach
                                                                    
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach</span>
                                                    <p>Số lượng: {{$item->quantity}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 product_price">
                                             
                                                <span>{{ number_format($item->unit_price)}}đ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="into_money--product">
                                    <div>
                                        <i class="fa-solid fa-money-check-dollar"></i>
                                        <span>Thành Tiền :</span>
                                    </div>
                                    <div>120.000đ</div>
                                    <div>
                                        <button type="submit">Mua lại</button>
                                    </div>
                                </div>
                                </div>
                                @endforeach.
                            </div>
                        </div>
                        {{-- <tr>
                        <td></td>
                        <td></td>
                        @foreach ($product_atb as $value)
                            @if ($item->pro_id == $value->id)
                                @foreach ($product_cb as $query)
                                    @if ($value->id == $query->product_attribute_id)
                                    @foreach ($attribute as $key)
                                        @if ($query->attribute_id == $key->id)
                                            <td>{{$key->name}}</td>
                                        @endif
                                    @endforeach
                                        
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        <td>{{ number_format($item->unit_price)}}đ</td>
                        
                    </tr> --}}
                    
                        {{-- change here --}}
                    </div>
                </div>
             
            @else
                <div class="container" style="height: 100vh">
                    <div class="row justify-content-center" style="padding: 350px">
                        <div class="col-12">
                            <h1 class="text-center" style="font-weight: 500">Chưa Có Đơn Hàng !</h1>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
