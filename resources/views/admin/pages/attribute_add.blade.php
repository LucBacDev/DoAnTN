@extends('master')
@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Danh Sách Thuộc tính</li>
            <li class="breadcrumb-item"><a href="#">Thêm Thuộc Tính</a></li>
        </ul>
    </div>
    <form class="row" method="post">
        @csrf
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Tạo Mới Nhóm Phân Loại</h3>
                <div class="tile-body">
                    <div class="form-group col-md-12">
                        <label class="control-label">Tên Nhóm Phân Loại</label>
                        <input class="form-control group-input" type="text" name="group" value="{{ old('name') }}" style="border: 2px solid">
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="tile-body">
                    <div class="form-group d-flex col-md-12">    
                        <label class="control-label" style="width:10%">Tên Phân Loại</label>
                        <input class="form-control form-classify-merchandise name-input" type="text" name="name" value="{{ old('name') }}" style="border: 2px solid; margin-right: 10px;">
                        <button class="delete-classify-merchandise" style="border-radius: 5px; cursor: pointer;">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <button class="add-classify-merchandise col-md-12 py-2" style="color: blue">Thêm phân loại hàng</button>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{ route('admin.attribute') }}" class="btn btn-danger">Hủy</a>
            </div>
        </div>
    </form>
@endsection

@section('src')
    <script>
       document.addEventListener("DOMContentLoaded", function() {
    var count = 0;
    var container = document.querySelector('.row');

    container.addEventListener('click', function(event) {
        var target = event.target;

        if (target.classList.contains("add-classify-merchandise")) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của nút submit
            console.log("avasd");
            var clonedInput = document.querySelector(".form-classify-merchandise").cloneNode(true);
            var newNameInput = clonedInput.querySelector(".name-input");
            newNameInput.value = '';
            container.appendChild(clonedInput);
            count++;
        } else if (target.classList.contains("delete-classify-merchandise")) {
            var parentDiv = target.parentNode.parentNode;
            if (count === 0) {
                alert("Không thể xóa phân loại cuối cùng!");
            } else {
                parentDiv.removeChild(target.parentNode);
                count--;
            }
        }
    });
});

    </script>
@endsection
