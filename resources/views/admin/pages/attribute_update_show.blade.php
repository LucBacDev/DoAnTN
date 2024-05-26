@extends('master')
@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Danh Sách Thuộc tính</li>
            <li class="breadcrumb-item"><a href="#">Sửa Thuộc Tính</a></li>
        </ul>
    </div>
    <form class="row" method="post" action="{{ route('admin.attribute_update', $attribute_group->id) }}">
        @csrf
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Sửa Nhóm Phân Loại</h3>
                <div class="tile-body">
                    <div class="form-group col-md-12">
                        <label class="control-label">Tên Nhóm Phân Loại</label>
                        <h3>{{ $attribute_group->name }}</h3>
                    </div>
                    @error('attribute_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="tile-body">
                    @foreach ($attributes as $attribute)
                        <div class="form-group d-flex col-md-12">
                            <label class="control-label" style="width:10%">Tên Phân Loại</label>
                            <input class="form-control form-classify-merchandise name-input" type="text"
                                name="name[]" value="{{ $attribute->name }}" style="border: 2px solid; margin-right: 10px;">
                            <button type="button" class="delete-classify-merchandise" style="border-radius: 5px; cursor: pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            
                        </div>
                    @endforeach
                    <button type="button" class="add-classify-merchandise col-md-12 py-2" style="color: blue">Thêm phân loại hàng</button>
                </div>
                @error('name.*')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Cập nhật</button>
                <a href="{{ route('admin.attribute') }}" class="btn btn-danger">Hủy</a>
            </div>
        </div>
    </form>
@endsection

@section('src')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var count = document.querySelectorAll('.form-classify-merchandise').length;
            var container = document.querySelector('.row');
            var originalInputContainer = document.querySelector('.form-classify-merchandise').parentNode;

            container.addEventListener('click', function(event) {
                var target = event.target;

                if (target.classList.contains("add-classify-merchandise")) {
                    event.preventDefault();
                    // Tạo một bản sao của phần tử phân loại hàng gốc
                    var clonedInputContainer = originalInputContainer.cloneNode(true);

                    // Lấy input mới nhất trong bản sao
                    var newNameInput = clonedInputContainer.querySelector(".name-input");

                    // Thiết lập giá trị của input mới thành rỗng
                    newNameInput.value = '';

                    // Chèn phần tử phân loại hàng mới vào trước nút "Thêm phân loại hàng"
                    target.parentNode.insertBefore(clonedInputContainer, target);
                    count++;
                } else if (target.classList.contains("delete-classify-merchandise") || target.closest('.delete-classify-merchandise')) {
                    // Xóa phần tử phân loại hàng khi nút "Xóa" được nhấn
                    event.preventDefault();

                    var deleteButton = target.closest('.delete-classify-merchandise');
                    var parentDiv = deleteButton.parentNode.parentNode;

                    if (count <= 1) {
                        alert("Không thể xóa phân loại cuối cùng!");
                    } else {
                        parentDiv.removeChild(deleteButton.parentNode);
                        count--;
                    }
                }
            });
        });
    </script>
@endsection
