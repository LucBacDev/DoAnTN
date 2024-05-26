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
                        <div class="form-group col-md-3">
                            <label class="control-label">Danh Mục</label>
                            <select class="form-control" name="category_id" value="{{ old('category_id') }}">
                                <option value="null">-- Chọn Danh mục --</option>
                                @foreach ($category as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
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
                        <h3>Thông tin bán hàng</h3>
                        <div class="tile-body">
                            <div id="category-container">
                                <div class="form-nhap-phan-loai">
                                    <label class="control-label">Nhóm phân loại màu sắc</label>
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
                @section('src')
                    <script src="{{ url('assets-admin') }}/ckeditor/ckeditor.js"></script>
                    <script>
                        CKEDITOR.replace('editor1');

                        function previewImage(input, divId) {
                            var preview = document.getElementById(divId);
                            preview.innerHTML = '';

                            if (input.files && input.files.length > 0) {
                                for (var i = 0; i < input.files.length; i++) {
                                    var reader = new FileReader();

                                    reader.onload = function(event) {
                                        var image = document.createElement('img');
                                        image.src = event.target.result;
                                        image.style.width = '100px';
                                        preview.appendChild(image);
                                    }

                                    reader.readAsDataURL(input.files[i]);
                                }
                            }
                        }


                        var container = document.getElementById("category-container");
                        container.addEventListener('click', function(event) {
                            var target = event.target;
                            let countColor = document.querySelectorAll('.classify-merchandise-color').length;

                            if (target.classList.contains("add-classify-merchandise-color")) {
                                // Tạo một thẻ div mới chứa phần tử mới
                                countColor++;
                                var newDiv = document.createElement('div');
                                newDiv.className = 'classify-merchandise-color d-flex my-3';
                                // Tạo phần tử select mới
                                var selectElement = document.createElement('select');
                                selectElement.className = 'form-control';
                                selectElement.id = 'exampleSelect2';
                                selectElement.name = 'name_attribute[]';

                                // Tạo một option mặc định
                                var defaultOption = document.createElement('option');
                                defaultOption.value = 'null';
                                defaultOption.textContent = 'Chọn phân loại màu sắc';
                                selectElement.appendChild(defaultOption);

                                var groupId = 1;
                                // Thêm option từ danh sách attribute dựa trên groupId
                                @foreach ($attribute as $item)
                                    var item = @json($item);
                                    if (item.attribute_group_id == groupId) {
                                        var option = document.createElement("option");
                                        option.value = '{{ $item->id }}';
                                        option.textContent = '{{ $item->name }}';
                                        selectElement.appendChild(option);
                                    }
                                @endforeach



                                // Tạo nút xóa
                                var deleteButton = document.createElement('button');
                                deleteButton.type = 'button';
                                deleteButton.className = 'delete-classify-merchandise-color';
                                deleteButton.style.borderRadius = '5px';
                                deleteButton.style.cursor = 'pointer';
                                deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';

                                // Thêm select và nút xóa vào thẻ div mới
                                newDiv.appendChild(selectElement);
                                newDiv.appendChild(deleteButton);

                                // Tìm tất cả các phần tử "Phân loại hàng" hiện có

                                var classifyMerchandises = document.querySelectorAll('.classify-merchandise-color');
                                // Lấy phần tử "Phân loại hàng" cuối cùng và chèn thẻ div mới vào sau nó
                                var lastClassifyMerchandise = classifyMerchandises[classifyMerchandises.length - 1];
                                lastClassifyMerchandise.parentNode.insertBefore(newDiv, lastClassifyMerchandise.nextSibling);

                                console.log(countColor);
                            } else if (target.classList.contains("delete-classify-merchandise-color")) {
                                console.log(countColor);
                                if (countColor == 1) {
                                    alert("Không thể xóa phân loại cuối cùng!");
                                } else {
                                    target.parentNode.remove();
                                    countColor--;
                                }
                            }
                            let countSize = document.querySelectorAll('.classify-merchandise').length;
                            if (target.classList.contains("add-classify-merchandise-size")) {
                                // Tạo một thẻ div mới chứa phần tử mới
                                countSize++;
                                var newDiv = document.createElement('div');
                                newDiv.className = 'classify-merchandise d-flex my-3 size';

                                // Tạo phần tử select mới
                                var selectElement = document.createElement('select');
                                selectElement.className = 'form-control';
                                selectElement.id = 'exampleSelect2';
                                selectElement.name = 'name_attribute[]';

                                // Tạo một option mặc định
                                var defaultOption = document.createElement('option');
                                defaultOption.value = 'null';
                                defaultOption.textContent = 'Chọn phân loại size';
                                selectElement.appendChild(defaultOption);

                                // Lấy giá trị của option được chọn trong select1
                                var groupId = 2;
                                // Thêm option từ danh sách attribute dựa trên groupId
                                @foreach ($attribute as $item)
                                    var item = @json($item);
                                    if (item.attribute_group_id == groupId) {
                                        var option = document.createElement("option");
                                        option.value = '{{ $item->id }}';
                                        option.textContent = '{{ $item->name }}';
                                        selectElement.appendChild(option);
                                    }
                                @endforeach


                                // Tạo nút xóa
                                var deleteButton = document.createElement('button');
                                deleteButton.type = 'button';
                                deleteButton.className = 'delete-classify-merchandise-size';
                                deleteButton.style.borderRadius = '5px';
                                deleteButton.style.cursor = 'pointer';
                                deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';

                                // Thêm select và nút xóa vào thẻ div mới
                                newDiv.appendChild(selectElement);
                                newDiv.appendChild(deleteButton);

                                // Tìm tất cả các phần tử "Phân loại hàng" hiện có
                                var classifyMerchandises = document.querySelectorAll('.classify-merchandise');

                                // Lấy phần tử "Phân loại hàng" cuối cùng và chèn thẻ div mới vào sau nó
                                var lastClassifyMerchandise = classifyMerchandises[classifyMerchandises.length - 1];
                                lastClassifyMerchandise.parentNode.insertBefore(newDiv, lastClassifyMerchandise.nextSibling);
                                console.log(countSize);
                            } else if (target.classList.contains("delete-classify-merchandise-size")) {
                                if (countSize === 1) {
                                    alert("Không thể xóa phân loại cuối cùng!");
                                } else {
                                    console.log(countSize);
                                    target.parentNode.remove(); // Xóa phần tử khi nút xóa được click
                                    countSize--;
                                }
                            }
                        });
                    </script>
                @endsection
            @endsection
