@extends('master')
@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item active"><a href="#"><h1>Danh sách Thuộc tính</h1></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row element-button">
                        <div class="col-sm-2">
                            <a class="btn btn-add btn-sm" href="{{ route('admin.attribute_add_color') }}" title="Thêm"><i
                                    class="fas fa-plus"></i>
                                Tạo mới màu sắc</a>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-add btn-sm" href="{{ route('admin.attribute_add_size') }}" title="Thêm"><i
                                    class="fas fa-plus"></i>
                                Tạo mới size</a>
                        </div>
                    </div>
                    <style>
                        table,
                        th,
                        td {
                            border: 1px solid #868585;
                        }

                        table {
                            border-collapse: collapse;
                        }
                    </style>
                    <table class="table table-hover table-bordered" id="sampleTable" style="border:2px solid black">
                        <thead>
                            <tr style="border:2px solid black">
                                <th>STT</th>
                                <th>Tên Màu Sắc</th>
                                <th>Tên Phân Loại</th>
                                <th>Tính Năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Attribute_group as $item)
                                <tr style="border:2px solid black">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td style="padding: 0px">
                                        @foreach ($Attribute as $value)
                                            @if ($item->id == $value->attribute_group_id)
                                                <div style="padding:6px; border:1px solid black;width:100%; height:65px">
                                                    <p>{{ $value->name }}</p></div>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="table-td-center">
                                        <a href="{{ route('admin.attribute_update_show', $item->id) }}"
                                            class="btn btn-success">Sửa</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
