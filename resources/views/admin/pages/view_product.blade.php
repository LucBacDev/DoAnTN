@extends('master')
@section('content')
<section class="invoice">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="#"><b>Quản Lý Chi Tiết Đơn Hàng</b></a></li>
            </ul>
        </div>
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <p>Người nhận: <strong>{{$user->full_name}}</strong><br></p>
                <p>Địa chỉ: {{$user->address}}</p>
                <p>Điện thoại: {{$user->email}}</p>
            </div>

            <div class="col-sm-4 invoice-col">
                <b>Mã đơn hàng: </b> {{$order->id}}<br>
                <b>Thời Gian Khởi Tạo: </b>{{$order->created_at}}<br>
                <b>Ghi chú: </b>{{$order->note}}<br>
            </div>

        </div>


        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tên Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Màu sắc</th>
                            <th>Giá tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order_detail as $item)
                            <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->quantity}}</td>
                            @foreach ($product_atb as $value)
                                @if ($item->pro_id == $value->id)
                                    @foreach ($attribute as $query)
                                        @if ($value->attribute_color_id == $query->id)
                                            <td>{{$query->name}}</td>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            <td>{{ number_format($item->unit_price)}}đ</td>
                            
                        </tr>
                        @endforeach
                        
                       
                    </tbody>
                </table>
            </div>

        </div>

        <div class="row">
            <div class="col-xs-6">
                {{-- <p class="lead">Amount Due 2/22/2014</p> --}}
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width:50%">Tổng tiền sản phẩm:</th>
                                <td>{{number_format($total_price)}}</td>
                            </tr>
                            <tr>
                                <th>Phí vận chuyển</th>
                                <td>30.000đ</td>
                            </tr>
                            <tr>
                                <th>Tổng tiền:</th>
                                <td>{{number_format($total)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


        {{-- <div class="row no-print">
            <div class="col-xs-12">
                <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
                </button>
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                    <i class="fa fa-download"></i> Generate PDF
                </button>
            </div>
        </div> --}}
    </section>
@endsection
