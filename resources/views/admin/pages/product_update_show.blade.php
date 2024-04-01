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
                <h3 class="tile-title">Sửa sản phẩm</h3>
                <div class="tile-body">
                    <form class="row" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-3">
                            <label class="control-label">Tên Sản Phẩm</label>
                            <input class="form-control" type="text" name="name" value="{{ $product->name }}">
                            {{-- @error('name')
                  <div class="alert alert-danger">{{$message}}</div>
                @enderror --}}
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="control-label">Giá</label>
                            <input class="form-control" type="text" name="price" value="{{ $product->price }}">
                            {{-- @error('price')
                  <div class="alert alert-danger">{{$message}}</div>
                @enderror --}}
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="control-label">Giá Khuyến Mại</label>
                            <input class="form-control" type="text" name="sale_price" value="{{ $product->sale_price }}">
                            {{-- @error('sale_price')
                  <div class="alert alert-danger">{{$message}}</div>
                @enderror --}}
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="control-label">Xuất Xứ</label>
                            <input class="form-control" type="text" name="origin" value="{{ $product->origin }}">
                            {{-- @error('origin')
                  <div class="alert alert-danger">{{$message}}</div>
                @enderror --}}
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="control-label">Năm Sản Xuất</label>
                            <input class="form-control" type="text" name="year" value="{{ $product->year }}">
                            {{-- @error('year')
                  <div class="alert alert-danger">{{$message}}</div>
                @enderror --}}
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleSelect1" class="control-label">Danh Mục</label>
                            <select class="form-control" id="exampleSelect1" name="category_id">
                                <option>-- Chọn Danh mục --</option>
                                @foreach ($category as $value)
                                    <option value="{{ $value->id }}"
                                        {{ $value->id == $product->category_id ? 'selected' : '' }}>{{ $value->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="exampleSelect1" class="control-label">Thương Hiệu</label>
                            <select class="form-control" id="exampleSelect1" name="brand_id">
                                <option>-- Chọn Thương hiệu --</option>
                                @foreach ($brand as $value)
                                    <option value="{{ $value->id }}"
                                        {{ $value->id == $product->brand_id ? 'selected' : '' }}>{{ $value->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3 ">
                            <label for="exampleSelect1" class="control-label">Trạng Thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="1"
                                    id="flexRadioDefault1" {{ $product->status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Đang bán
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="0"
                                    id="flexRadioDefault2" {{ $product->status == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexRadioDefault2">Ngừng bán</label>
                            </div>
                            @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group  col-md-12">
                            <label class="control-label">Mô tả</label>
                            <textarea type="text" id="editor1" rows="10" cols="80" name="description">
                {{ $product->description }}
                </textarea>
                            {{-- @error('description')
                  <div class="alert alert-danger" >{{$message}}</div>
                @enderror --}}

                
                        </div>
                        <div class="form-group col-md-12 p-3">
                            <label class="control-label pr-1">Ảnh Sản Phẩm:</label>
                            <input type="file" id="product-image" name="image"  />
                            <div id="product-image-preview"></div>
                            <img src="{{ url('upload.product') }}/{{ $product->image }}" class="database-image" alt="" width="100px">
                        {{-- @error('image')
                  <div class="alert alert-danger">{{$message}}</div>
                @enderror --}}
                        </div>
                        <div class="form-group col-md-12 p-3">
                            <label class="control-label pr-1">Ảnh mô tả sản phẩm:</label>
                            <input type="file" name="images1[]" multiple />
                            @foreach ($product_images as $item)
                            <img src="{{ url('upload.product') }}/{{ $item->image }}" class="database-image" alt="" width="100px">
                            @endforeach
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
                                @foreach ($product_attrs as $key => $query)
                                <tr class="attribute-row">
                                    <td>
                                        <select name="attributes[]" class="">
                                            <option value="">-- Chọn thuộc tính --</option>
                                            @foreach ($attribute as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == $query->attribute_color_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="file" name="images2[]" class="image"
                                            value="{{ old('images2') }}"
                                            onchange="previewImages(this, 'image-preview-3')" />
                                            <img src="{{ url('upload.product') }}/{{ $query->image }}" alt="" width=100px>
                                        {{-- <div id="image-preview-3"></div> --}}
                                        @error('images')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td><input type="number" name="stocks[]" value="{{$query->stock}}" /></td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-row">Xóa</button>
                                        <button type="button" class="btn btn-primary add-row">Thêm</button>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                      
                        <div class="form-group">
                            <td class="table-td-center">
                                <button type="submit" class="btn btn-success">Lưu</button>
                                <a href="{{ route('admin.product') }}" type="submit" class="btn btn-danger">Hủy</a>
                            </td>
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
            const rows = document.querySelectorAll('.attribute-row');
            if (rows.length > 1) { // Kiểm tra có nhiều hơn một hàng thuộc tính hay không
                const row = event.target.closest('.attribute-row');
                row.parentNode.removeChild(row); // Xóa dòng khỏi DOM

                // Cập nhật chỉ mục của các dòng form còn lại
                updateFormRowIndexes();
            } else {
                alert('Không thể xóa hàng cuối cùng!');
            }
        } else if (event.target.classList.contains('add-row')) {
            const newRow = document.querySelector('.attribute-row').cloneNode(true);
            // Làm mới lại các trường input trong hàng mới
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelectorAll('select').forEach(select => select.value = '');
            document.querySelector('#attribute-table tbody').appendChild(newRow);

            // Cập nhật chỉ mục của các dòng form
            updateFormRowIndexes();
        }
    });
});

function updateFormRowIndexes() {
    const rows = document.querySelectorAll('.attribute-row');
    rows.forEach((row, index) => {
        const attributesSelect = row.querySelector('select[name="attributes[]"]');
        if (attributesSelect) {
            attributesSelect.name = `attributes[${index}]`;
        }

        const imageInput = row.querySelector('input[type="file"].image');
        if (imageInput) {
            imageInput.name = `images2[${index}]`;
        }

        const stockInput = row.querySelector('input[type="number"][name^="stocks"]');
        if (stockInput) {
            stockInput.name = `stocks[${index}]`;
        }
    });
}


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

    // Ẩn các ảnh từ cơ sở dữ liệu
    var databaseImages = document.querySelectorAll('.database-image');
    databaseImages.forEach(function(image) {
        image.style.display = 'none';
    });
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

    // Ẩn các ảnh từ cơ sở dữ liệu
    var databaseImages = document.querySelectorAll('.database-image');
    databaseImages.forEach(function(image) {
        image.style.display = 'none';
    });
}

    </script>
@stop
@stop
{{--  --}}
