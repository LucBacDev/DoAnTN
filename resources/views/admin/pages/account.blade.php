@extends('master')
@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item active"><a href="#"><b>Danh sách Tài Khoản Người Dùng</b></a></li>
        </ul>
        <ul class="app-breadcrumb breadcrumb side ">
            <li class="breadcrumb-item active">
                <form action="{{ route ('admin.account') }}" method="get">
                    <div class="input-group">
                        <input type="text" name="keyword" class="input-search form-control rounded" placeholder="Nhập họ tên"
                            aria-label="Search" aria-describedby="search-addon" />
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
                    <table class="table table-hover table-bordered js-copytextarea" cellpadding="0" cellspacing="0"
                        border="0" id="sampleTable">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th width="150">Họ Và Tên</th>
                                <th width="300">Địa Chỉ</th>
                                <th>Email</th>
                                <th>Số Điện Thoại</th>
                                <th>Trạng Thái</th>
                                <th>Vai Trò</th>
                                <th>Tính năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Users as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user->full_name}}</td>
                                    <td>{{$user->address}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>
                                        @if ($user->status === 1)
                                        <span class="bg bg-success">
                                             Được Phép Sử Dụng
                                        </span>
                                        @else
                                        <span class="bg bg-danger">
                                            Không Được phép
                                       </span>
                                        @endif
                                    </td>
                                    <td>{{$user->role == 1  ? 'Admin' :  'Người Dùng' }}</td>
                                    <td class="table-td-center">
                                        @if ($user->role != 1)
                                        <a type="submit" href="{{route('admin.account_update',$user->id)}}" class="btn btn-add">Cấp quyền admin</a>
                                        @endif
                                        <a type="submit" href="{{route('admin.account_delete',$user->id)}}" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $Users->links() }}
    </div>
@endsection
