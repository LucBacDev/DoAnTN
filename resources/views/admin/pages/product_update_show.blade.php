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
                <h3 class="tile-title">Cập nhật sản phẩm</h3>
                <div class="tile-body">
                    <form class="row" action="{{ route('admin.product_update_atb', $product->id) }}" method="POST"
                        enctype="multipart/form-data" id="usrform">
                        @csrf
                        <input type="hidden" value="{{ $product->id }}" name="product_id">
                        <div class="form-group col-md-3">
                            <label class="control-label">Tên Sản Phẩm</label>
                            <input class="form-control" type="text" name="name" value="{{ $product->name }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Danh Mục</label>
                            <select class="form-control" name="category_id">
                                <option value="null">-- Chọn Danh mục --</option>
                                @foreach ($category as $value)
                                    <option value="{{ $value->id }}"
                                        {{ $product->category_id == $value->id ? 'selected' : '' }}>{{ $value->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="control-label">Giá</label>
                            <input class="form-control" type="text" name="price" value="{{ $product->price }}">
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="control-label">Giá Khuyến Mại</label>
                            <input class="form-control" type="text" name="sale_price"
                                value="{{ $product->sale_price }}">
                            @error('sale_price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group  col-md-12">
                            <label class="control-label">Mô tả</label>
                            <textarea id="editor1" rows="10" cols="80" form="usrform" name="description">{{ $product->description }}</textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 p-3">
                            <label class="control-label pr-1">Ảnh Sản Phẩm:</label>
                            <input type="file" id="product-image" name="image"
                                onchange="previewImage(this, 'product-image-preview');" />
                            <div id="product-image-preview">
                                <img src="{{ asset('upload.product/' . $product->image) }}" alt="product image"
                                    style="width: 100px;">
                            </div>
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 p-3">
                            <label class="control-label pr-1">Ảnh mô tả sản phẩm:</label>
                            <input type="file" id="description-images" name="images1[]" multiple
                                onchange="previewImage(this, 'description-images-preview');" />
                            <div id="description-images-preview">
                                @foreach ($product_images as $image)
                                    <img src="{{ asset('upload.product/' . $image->image) }}" alt="product image"
                                        style="width: 100px;">
                                @endforeach
                            </div>
                            @error('images1')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <h3>Thông tin bán hàng</h3>
                        <div class="tile-body">
                            <div id="category-container">
                                <div class="form-nhap-phan-loai">
                                    <label class="control-label">Nhóm phân loại màu sắc</label>

                                    @foreach ($color as $item)
                                        <div class="classify-merchandise d-flex my-3 size">
                                            <select class="form-control phanloai" id="exampleSelect4"
                                                name="name_attribute[]" data-index="">
                                                <option value="null">Chọn phân loại size</option>
                                                <option value="{{ $item['attribute_id'] }}" selected>{{ $item['name'] }}
                                            </select>
                                            <button type="button" class="delete-classify-merchandise-size"
                                                style="border-radius: 5px;cursor: pointer;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    @endforeach


                                    <div class="classify-merchandise-color d-flex my-3 color">
                                        <select class="form-control phanloai" id="exampleSelect2" name="name_attribute[]"
                                            data-index="">
                                            <option value="null">Chọn phân loại màu sắc</option>
                                            @foreach ($attribute_color as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="delete-classify-merchandise-color"
                                            style="border-radius: 5px;cursor: pointer;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <button type="button" class="add-classify-merchandise-color">Thêm phân loại
                                        màu sắc</button>
                                </div>

                                <div class="form-nhap-phan-loai">
                                    <label class="control-label">Nhóm phân loại size </label>
                                    @foreach ($size as $item)
                                        <div class="classify-merchandise d-flex my-3 size">
                                            <select class="form-control phanloai" id="exampleSelect4"
                                                name="name_attribute[]" data-index="">
                                                <option value="null">Chọn phân loại size</option>
                                                <option value="{{ $item['attribute_id'] }}" selected>{{ $item['name'] }}
                                            </select>
                                            <button type="button" class="delete-classify-merchandise-size"
                                                style="border-radius: 5px;cursor: pointer;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    @endforeach

                                    <div class="classify-merchandise d-flex my-3 size">
                                        <select class="form-control phanloai" id="exampleSelect4" name="name_attribute[]"
                                            data-index="">
                                            <option value="null">Chọn phân loại size</option>
                                            @foreach ($attribute_size as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="delete-classify-merchandise-size"
                                            style="border-radius: 5px;cursor: pointer;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>

                                    <button type="button" class="add-classify-merchandise-size">Thêm phân loại
                                        size</button>
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
                </div>
            </div>
        </div>
    </div>
@section('src')
    <script src="{{ url('assets-admin') }}/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor1');
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('#category-container').addEventListener('click', function(event) {
                if (event.target.classList.contains('delete-classify-merchandise-color')) {
                    const row = event.target.closest('.classify-merchandise-color');
                    row.parentNode.removeChild(row); // Xóa dòng khỏi DOM
                } else if (event.target.classList.contains('delete-classify-merchandise-size')) {
                    const row = event.target.closest('.classify-merchandise');
                    row.parentNode.removeChild(row); // Xóa dòng khỏi DOM
                } else if (event.target.classList.contains('add-classify-merchandise-color')) {
                    addClassificationRow('color');
                } else if (event.target.classList.contains('add-classify-merchandise-size')) {
                    addClassificationRow('size');
                }
            });
        });

        function addClassificationRow(type) {
        let rowHtml = '';
        if (type === 'color') {
            rowHtml = `
                <div class="classify-merchandise-color d-flex my-3 color">
                    <select class="form-control phanloai" name="name_attribute[]" data-index="">
                        <option value="null">Chọn phân loại màu sắc</option>
                        @foreach ($attribute_color as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="delete-classify-merchandise-color" style="border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `;
            const addColorButton = document.querySelector('.add-classify-merchandise-color');
            addColorButton.insertAdjacentHTML('beforebegin', rowHtml);
        } else if (type === 'size') {
            rowHtml = `
                <div class="classify-merchandise d-flex my-3 size">
                    <select class="form-control phanloai" name="name_attribute[]" data-index="">
                        <option value="null">Chọn phân loại size</option>
                        @foreach ($attribute_size as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="delete-classify-merchandise-size" style="border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `;
            const addSizeButton = document.querySelector('.add-classify-merchandise-size');
            addSizeButton.insertAdjacentHTML('beforebegin', rowHtml);
        }
    }
        

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
