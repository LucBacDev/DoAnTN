@extends('master')
@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Danh sách sản phẩm</li>
            <li class="breadcrumb-item"><a href="#">Thêm sản phẩm</a></li>
        </ul>
    </div>
    <form class="row" action="{{ route('admin.product_update',$product_id) }}" method="POST" enctype="multipart/form-data"
        id="usrform">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Tạo mới sản phẩm</h3>
                    <div class="tile-body">
                        <h3>Danh sách phân loại hàng</h3>
                        <div>
                            <table id="nameTable" style="border: 3px solid">
                                <thead>
                                    <tr>
                                        <td>Tên màu</td>
                                        <td>Size</td>
                                        <td>Số lượng</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bang as $row)
                                    <tr>
                                        <td>
                                            <input type="hidden" value="{{$row['attribute_group_id_1']}}" name="color[]"> 
                                            @foreach ($atb as $value)
                                                @if ($row['attribute_group_id_1'] == $value->id)
                                                    {{$value->name}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <input type="hidden" value="{{$row['attribute_group_id_2']}}" name="size[]"> 
                                            @foreach ($atb as $value)
                                                @if ($row['attribute_group_id_2'] == $value->id)
                                                    {{$value->name}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td><input type="number" name="stock[]" value="{{$row['stock']}}"/></td>
                                    </tr>
                                @endforeach
                                    
                                 
                                
                                                                      
                                </tbody>
                            </table>
                        </div>

                        

                    </div>
                </div>
            </div>
        </div>
        <div class="form-group d-flex justify-content-center">
            <div class="text-center" style="margin: 20px 20px">
                <button type="submit" class="btn btn-success">Lưu</button>
            </div>
            <div class="text-center" style="margin: 20px 20px">
                <a href="{{ route('admin.product') }}" type="submit" class="btn btn-danger">Hủy</a>
            </div>
        </div>
    </form>
@section('src')
@endsection
@endsection
