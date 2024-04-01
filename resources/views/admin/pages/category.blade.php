@extends('master')
@section('content')
    <div class="app-title d-flex justify-content-between">
        <ul class="app-breadcrumb breadcrumb side ">
            <li class="breadcrumb-item active"><a href="#"><b>Danh sách danh mục</b></a></li>
        </ul>
        <ul class="app-breadcrumb breadcrumb side ">
            <li class="breadcrumb-item active">
                <form action="{{ route('admin.category') }}" method="get">
                    <div class="input-group">
                        <input type="text" name="keyword" class="input-search form-control rounded"
                            placeholder="Nhập tên danh mục" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="btn-search btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </li>
        </ul>
        {{-- allert notification --}}
        @if (session('notification'))
            <div class="alert alert-success">
                {{ session('notification') }}
            </div>
        @endif
        {{-- allert notification end --}}

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row element-button">
                        <div class="col-sm-2">
                            <a class="btn btn-add btn-sm" href="{{ route('admin.category_add') }}" title="Thêm"><i
                                    class="fas fa-plus"></i>
                                Tạo mới Danh Mục</a>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Danh Mục</th>
                                {{-- <th>Danh mục</th> --}}
                                <th>Tính Năng</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($Categories as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{ route('admin.category_list', $item->id) }}">{{ $item->name }}</a></td>

                                    {{-- @foreach ($Categories as $query)
                                        @if ($item->parent_id == $query->id )
                                           @if($query->parent_id = 0 )
                                                <td class="">Danh mục gốc</td>
                                            @else
                                                <td class="">{{ $query->name }}</td>
                                            @endif
                                        @endif
                                    @endforeach --}}
                                    <td class="table-td-center">
                                        <a href="{{ route('admin.category_update_show', $item->id) }}" type="submit"
                                            class="btn btn-success">Sửa</a>
                                        <a href="{{ route('admin.category_delete', $item->id) }}" type="submit"
                                            class="btn btn-danger" onclick = "return confirm('Bạn có muốn xóa?')">Xóa</a>
                                    </td>
                                </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $Categories->appends(request()->input())->links() }}
    </div>
@endsection
