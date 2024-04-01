@extends('master')
@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item active"><a href="#"><b>Danh sách đơn hàng</b></a></li>
        </ul>
        <div id="clock"></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Mã Đơn Hàng</th>
                                <th>Khách hàng</th>

                                <th>Điện thoại </th>
                                <th>Tổng tiền</th>

                                <th>Tình trạng</th>
                                <th>Thời Gian Khởi Tạo</th>

                                <th>Ghi chú</th>
                                <th>Quản lý</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->Get_userName->full_name }}</td>

                                    <td> {{ $item->Get_userName->phone }}</td>
                                    <td>{{ number_format($item->total_price) }}</td>
                                    @if ($item->status == 1)
                                    <td><span class="badge bg-success">Đã xác nhận</span></td>
                                    @else
                                    <td><span class="badge bg-success">Chưa xác nhận</span></td>
                                    @endif
                                    <td>{{ $item->created_at }}</td>

                                    <td>{{ $item->note }}</td>
                                    <td><a href="{{ route('admin.view_product', $item->id) }}" class="btn btn-info">Chi Tiết</a></td>
                            
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $order->appends(request()->input())->links() }}
    </div>
@endsection
