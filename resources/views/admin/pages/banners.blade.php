@extends('master')
@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item active"><a href="#"><b>Danh sách banners</b></a></li>
        </ul>
        <ul class="app-breadcrumb breadcrumb side ">
            <li class="breadcrumb-item active">
                <form action="{{ route('admin.product') }}" method="get">
                    <div class="input-group z-index-0">
                        <input type="text" name="keyword" class="input-search form-control rounded"
                            placeholder="Nhập tên hãng" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="btn-search btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row element-button">
                        <div class="col-sm-2">
                            <a class="btn btn-add btn-sm" href="{{ route('admin.banners_add') }}" title="Thêm"><i
                                    class="fas fa-plus"></i>
                                Tạo mới banners</a>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Banner</th>
                                <th>Ảnh</th>
                                <th>Danh Mục</th>
                                <th>Trạng Thái</th>
                                <th>Tính Năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banner as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td style="height: 240px; width: 480px; overflow: hidden;">
                                        <img src="{{ url('image_brands') }}/{{ $item->image }}" alt=""
                                            style="object-fit: cover; max-width: 100%; max-height: 100%;">
                                    </td>
                                    @foreach ($category as $query)
                                        @if ($item->category_id == $query->id)
                                            <td>{{ $query->name }}</td>
                                        @endif
                                    @endforeach
                                    @if ($item->status == 1)
                                        <td class="m-3 p-1 badge bg-success">Hiện</td>
                                    @else
                                        <td class="m-3 p-1 badge bg-danger">Ẩn</td>
                                    @endif
                                    <td class="table-td-center">
                                        <a href="{{ route('admin.banners_update_show', $item->id) }}" type="submit"
                                            class="btn btn-success">Sửa</a>
                                        <a href="{{ route('admin.banners_delete', $item->id) }}" type="submit"
                                            class="btn btn-danger" onclick = "return confirm('Bạn có muốn xóa?')">Xóa</a>
                                    </td>
                                </tr>
                            @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
