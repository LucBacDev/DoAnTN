@extends('master')
@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Danh sách sản phẩm</li>
            <li class="breadcrumb-item"><a href="#">Thêm sản phẩm</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Tạo mới sản phẩm</h3>
                <div class="tile-body">
                    <form class="row" action="{{ route('admin.product_create') }}" method="POST"
                        enctype="multipart/form-data" id="usrform">
                        @csrf
                        <div class="form-group col-md-3">
                            <label class="control-label">Tên Sản Phẩm</label>
                            <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="control-label">Giá</label>
                            <input class="form-control" type="text" name="price" value="{{ old('price') }}">
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="control-label">Giá Khuyến Mại</label>
                            <input class="form-control" type="text" name="sale_price" value="{{ old('sale_price') }}">
                            @error('sale_price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="control-label">Xuất Xứ</label>
                            <input class="form-control" type="text" name="origin" value="{{ old('origin') }}">
                            @error('origin')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="control-label">Năm Sản Xuất</label>
                            <input class="form-control" type="text" name="year" value="{{ old('year') }}">
                            @error('year')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleSelect1" class="control-label">Danh Mục</label>
                            <select class="form-control" id="exampleSelect1" name="category_id"
                                value="{{ old('category_id') }}">
                                <option value="null">-- Chọn Danh mục --</option>
                                @foreach ($category as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label for="exampleSelect1" class="control-label">Thương Hiệu</label>
                            <select class="form-control" id="exampleSelect1" name="brand_id">
                                <option>-- Chọn Thương hiệu --</option>
                                @foreach ($brand as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-3 ">
                            <label for="exampleSelect1" class="control-label">Trạng Thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="1"
                                    id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Đang bán
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="0"
                                    id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">Ngừng bán</label>
                            </div>
                            @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group  col-md-12">
                            <label class="control-label">Mô tả</label>
                            <textarea id="editor1" rows="10" cols="80" form="usrform" name="description"
                                value="{{ old('description') }}">
                                Nhập mô tả sản phẩm
                            </textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 p-3">
                            <label class="control-label pr-1">Ảnh Sản Phẩm:</label>
                            <input type="file" id="product-image" name="image" value="{{ old('image') }}"
                                onchange="previewImage(this, 'product-image-preview');" />
                            <div id="product-image-preview"></div>
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 p-3">
                            <label class="control-label pr-1">Ảnh mô tả sản phẩm:</label>
                            <input type="file" id="description-images" name="images1[]" multiple
                                value="{{ old('images1') }}"
                                onchange="previewImage(this, 'description-images-preview');" />
                            <div id="description-images-preview"></div>
                        </div>
                        <table id="attribute-table">
                            <thead>
                                <tr>
                                    <th>Chọn thuộc tính</th>
                                    <th>Chọn ảnh cho thuộc tính</th>
                                    <th>Số lượng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="attribute-row">
                                    <td>
                                        <select name="attributes[]" class="">
                                            <option value="">-- Chọn thuộc tính --</option>
                                            @foreach ($attribute as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="file" name="images2[]" class="image"
                                            value="{{ old('images2') }}"
                                            onchange="previewImages(this, 'image-preview-3')" />
                                        <div id="image-preview-3"></div>
                                        @error('images')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td><input type="number" name="stocks[]" /></td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-row">Xóa</button>
                                        <button type="button" class="btn btn-primary add-row">Thêm</button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="form-group d-flex justify-content-center">
                            <div class="text-center" style="margin: 20px 20px">
                                <button type="submit" class="btn btn-success">Lưu</button>
                            </div>
                            <div class="text-center" style="margin: 20px 20px">
                                <a href="{{ route('admin.product') }}" type="submit" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@section('src')
    <script src="{{ url('assets-admin') }}/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor1');
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('#attribute-table').addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-row')) {
                    const row = event.target.closest('.attribute-row');
                    row.parentNode.removeChild(row);
                } else if (event.target.classList.contains('add-row')) {
                    const newRow = document.querySelector('.attribute-row').cloneNode(true);
                    document.querySelector('#attribute-table tbody').appendChild(newRow);
                }
            });
        });

        function previewImage(input, divId) {
            var preview = document.getElementById(divId);
            preview.innerHTML = '';

            if (input.files && input.files.length > 0) {
                for (var i = 0; i < input.files.length; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        var image = document.createElement('img');
                        image.src = event.target.result;
                        image.style.width = '100px'; // Thiết lập kích thước ảnh
                        preview.appendChild(image);
                    }

                    reader.readAsDataURL(input.files[i]);
                }
            }
        }

        function previewImages(input, divId) {
            var preview = input.closest('.attribute-row').querySelector('#' + divId);
            preview.innerHTML = '';

            if (input.files && input.files.length > 0) {
                for (var i = 0; i < input.files.length; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        var image = document.createElement('img');
                        image.src = event.target.result;
                        image.style.width = '100px'; // Thiết lập kích thước ảnh
                        preview.appendChild(image);
                    }

                    reader.readAsDataURL(input.files[i]);
                }
            }
        }
    </script>
@endsection
@endsection
