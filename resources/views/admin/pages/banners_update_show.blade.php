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
            <form class="row" method="post" enctype="multipart/form-data">
              @csrf
              <div class="form-group col-md-3">
                <label class="control-label">Tên Banner</label>
                <input class="form-control" type="text" name="name" value="{{$banner->name}}">
                @error('name')
                <div class="alert alert-danger cl-red">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group col-md-3 ">
                <label for="exampleSelect1" class="control-label">Trạng Thái</label>
                <select class="form-control" id="" name="status">
                  <option>-- Chọn trạng thái--</option>             
                  <option value="0" {{ $banner->status == 0 ? 'selected' : '' }}>Ẩn</option>
                  <option value="1" {{ $banner->status == 1 ? 'selected' : '' }}>Hiện</option>
              </select>
              </div>
              
              <div class="form-group col-md-3 ">
                <label for="exampleSelect1" class="control-label">Danh Mục</label>
                <select name="category_id" class="form-control" id="">
                  <option>-- Chọn danh mục --</option>
                  @foreach ($category as $value)
                  <option value="{{ $value->id }}"
                      {{ $value->id == $banner->id ? 'selected' : '' }}>{{ $value->name }}
                  </option>
              @endforeach
                 
                </select>
              </div>
              <div class="form-group col-md-12 m-3" style="height: 240px; width: 480px; overflow: hidden;">
                <label class="control-label pr-1">Ảnh:</label>
                <input type="file" id="imageInput" name="image"/>
                <img id="previewImage" src="{{ url('image_brands') }}/{{ $banner->image }}" alt=""
                     style="object-fit: cover; max-width: 100%; max-height: 100%;">
                <div id="uploadedImageContainer" style="height: 240px; width: 480px; overflow: hidden; display: none;">
                    <!-- Hiển thị ảnh đã tải lên ở đây -->
                </div>
            </div>
            </div>
            <div class="table-td-center">
              <button type="submit" class="btn btn-success">Lưu</button>
              <button type="submit" class="btn btn-danger">Hủy</button>
            </div>
          </form>
        </div>
        </div>
@endsection
<script>
  document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('imageInput').addEventListener('change', function() {
          var input = this;
          var previewImage = document.getElementById('previewImage');
          var uploadedImageContainer = document.getElementById('uploadedImageContainer');
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                  previewImage.style.display = 'none';
                  uploadedImageContainer.style.display = 'block';
                  uploadedImageContainer.innerHTML = '<img src="' + e.target.result + '" alt="Uploaded Image" style="object-fit: cover; max-width: 100%; max-height: 100%;">';
              };
              reader.readAsDataURL(input.files[0]);
          }
      });
  });
</script>