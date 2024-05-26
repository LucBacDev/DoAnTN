@extends('master')
@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item active"><a href="#"><h1>Danh sách sản phẩm</h1></a></li>
        </ul>
        <ul class="app-breadcrumb breadcrumb side ">
            <li class="breadcrumb-item active">
                <form action="{{ route('admin.product') }}" method="get">
                    <div class="input-group z-index-0">
                        <input type="text" name="keyword" class="input-search form-control rounded"
                            placeholder="Nhập tên sản phẩm" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="btn-search btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </li>
        </ul>
    </div>

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
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row element-button">
                        <div class="col-sm-2">
                            <a class="btn btn-add btn-sm" href="{{ route('admin.product_add') }}" title="Thêm"><i
                                    class="fas fa-plus"></i>
                                Tạo mới sản phẩm</a>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Giá Gốc</th>
                                <th>Giá Khuyến Mại</th>
                                <th>Trạng Thái</th>
                                <th>Danh Mục</th>
                                <th>Tính Năng</th>
                            </tr>
                        </thead>
                        {{-- <tbody> --}}
                        @foreach ($products as $item)
                            <tr class="clickable-row" data-href="{{ route('admin.product_detail', $item->id) }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->sale_price }}</td>
                                @if ($item->status == true)
                                    <td class="m-3 p-1 badge bg-success">Đang bán</td>
                                @else
                                    <td class="m-3 p-1 badge bg-danger">Ngừng bán</td>
                                @endif
                                <td>{{ $item->getCategoryName->name }}</td>
                                <td class="table-td-center">
                                    <a href="{{ route('admin.product_update_show', $item->id) }}" type="submit"
                                        class="btn btn-success">Sửa</a>
                                    <a href="{{ route('admin.product_delete', $item->id) }}" type="submit"
                                        class="btn btn-danger" onclick = "return confirm('Bạn có muốn xóa?')">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var rows = document.querySelectorAll('.clickable-row');
                        rows.forEach(function(row) {
                            row.addEventListener('click', function() {
                                window.location.href = row.dataset.href;
                            });
                        });
                        var buttons = document.querySelectorAll('.table-td-center');
                        buttons.forEach(function(button) {
                            button.addEventListener('click', function(event) {
                                event.stopPropagation();
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $products->appends(request()->input())->links() }}
    </div>
@endsection
