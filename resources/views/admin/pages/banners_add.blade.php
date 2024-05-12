@extends('master')
@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Danh Sách Banners</li>
            <li class="breadcrumb-item"><a href="#">Thêm Mới Banner</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Thêm Mới Banner</h3>
                <div class="tile-body">
                    <form href="{{ route('admin.banners_create') }}" class="row" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-12">
                            <label class="control-label">Tên Banner</label>
                            <input class="form-control" type="text" name="name">
                            @error('name')
                                <div class="alert alert-danger cl-red">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label class="control-label">Trạng Thái</label><br>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_hidden"
                                    value="0">
                                <label class="form-check-label" for="status_hidden">Ẩn</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_visible"
                                    value="1">
                                <label class="form-check-label" for="status_visible">Hiện</label>
                            </div>
                            @error('status')
                                <div class="alert alert-danger cl-red">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleSelect1" class="control-label">Danh Mục</label>
                            <select name="category_id" class="form-control" id="">
                                <option>-- Chọn danh mục --</option>
                                @foreach ($Category as $item)
                                    <option value="{{ $item->id }}" checked>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="alert alert-danger cl-red">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label class="control-label pr-1">Ảnh:</label>
                            <input type="file" id="imageInput" name="image" />
                            <div id="imagePreview" class="m-3"></div>
                            @error('image')
                                <div class="alert alert-danger cl-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="table-td-center">
                            <button type="submit" class="btn btn-success">Lưu</button>
                            <a href="{{ route('admin.attribute') }}" type="submit" class="btn btn-danger">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('imageInput').addEventListener('change', function(event) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.innerHTML = ''; // Clear previous preview

                var file = event.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.setAttribute('src', e.target.result);
                        img.setAttribute('alt', 'Preview Image');
                        img.setAttribute('class', 'img-fluid'); // Optional: adjust class for styling
                        imagePreview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endsection
