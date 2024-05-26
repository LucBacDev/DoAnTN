@extends('master')
@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item active"><a href="#"><h1>Danh sách sản phẩm</h1></a></li>
        </ul>
        <ul class="app-breadcrumb breadcrumb side ">
            <li class="breadcrumb-item active">
                <form action="{{ route ('admin.product') }}" method="get">
                    <div class="input-group z-index-0">
                        <input type="text" name="keyword" class="input-search form-control rounded" placeholder="Nhập tên sản phẩm"
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
                                @foreach ($pro_atb as $row)
                                <tr>
                                    <td>
                                        <input type="hidden" value="{{$row['attribute_color_id']}}" name="color[]"> 
                                        @foreach ($atb as $value)
                                            @if ($row['attribute_color_id'] == $value->id)
                                                {{$value->name}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <input type="hidden" value="{{$row['attribute_size_id']}}" name="size[]"> 
                                        @foreach ($atb as $value)
                                            @if ($row['attribute_size_id'] == $value->id)
                                                {{$value->name}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{$row['stock']}}</td>
                                </tr>
                            @endforeach
                                
                             
                            
                                                                  
                            </tbody>
                        </table>
                    </div>

                    

                </div>
            </div>
        </div>
    </div>
   
    {{-- <div class="d-flex justify-content-center">
        {{ $products->appends(request()->input())->links() }}
    </div> --}}
@endsection
