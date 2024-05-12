@extends('master')
@section('content')
    <h3>Thông tin bán hàng</h3>
    <div class="tile-body">
        <div id="category-container">
            <div class="form-nhap-phan-loai">
                <label class="control-label">Nhóm phân loại 1</label>
                <p>Tên nhóm phân loại</p>
                <input class="form-control group-input" type="text" name="group" value="{{ old('name') }}"
                    style="border: 2px solid" onkeyup="showGroup()">
                <p class="mt-3">Phân loại hàng</p>
                <div class="classify-merchandise d-flex my-3">
                    <input class="form-control form-classify-merchandise name-input" id="fullnameInput" type="text"
                        name="name" value="{{ old('name') }}" style="border: 2px solid" onkeyup="showName()"
                        data-index="">
                    <button class="delete-classify-merchandise" style="border-radius: 5px;cursor: pointer;">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                <button class="add-classify-merchandise">Thêm phân loại hàng</button>
            </div>
        </div>
        <button id="add-category-button">Thêm nhóm phân loại hàng</button>
        <button id="delete-category-button">Xóa nhóm phân loại hàng</button>
    </div>

    <h3>Danh sách phân loại hàng</h3>
    <div>
        <table id="nameTable" style="border: 3px solid">
            <thead>
                <tr>
                    <td id="displayGroup">Tên</td>
                    <td>Giá</td>
                    <td>Kho Hàng</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="displayName">Loại</td>
                    <td><input type="number" name="price[]" /></td>
                    <td><input type="number" name="stock[]" /></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        function showGroup() {
            var group = document.querySelector(".group-input").value;
            if (group.trim() !== '') {
                document.getElementById("displayGroup").innerText = group;
            } else {
                document.getElementById("displayGroup").innerText = "Tên";
            }
        }

        function showName() {
            var name = document.querySelector(".name-input").value;
            if (name.trim() !== '') {
                document.getElementById("displayName").innerText = name;
            } else {
                document.getElementById("displayName").innerText = "Loại";
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
            var addButton = document.getElementById("add-category-button");
            var deleteButton = document.getElementById("delete-category-button");
            var container = document.getElementById("category-container");
            var tableBody = document.querySelector("#nameTable tbody");
            var count = 0;
            var dem = 0;

            addButton.addEventListener("click", function() {
                var clonedDiv = createCategoryDiv();
                container.appendChild(clonedDiv);
            });

            deleteButton.addEventListener("click", function() {
                var categories = container.querySelectorAll(".form-nhap-phan-loai");
                if (categories.length > 1) {
                    container.removeChild(categories[categories.length - 1]);
                } else {
                    alert("Không thể xóa nhóm phân loại cuối cùng!");
                }
            });

            // Set data-index cho input ban đầu
            var initialNameInput = document.querySelector(".name-input");
            var initialDataIndex = generateRandomIndex();
            setRandomIndex(initialNameInput, initialDataIndex);

            // Thêm data-index cho dòng tr đầu tiên
            var initialTableRow = document.querySelector("#nameTable tbody tr");
            initialTableRow.setAttribute("data-index", initialDataIndex);

            container.addEventListener("click", function(event) {
                var target = event.target;

                if (target.classList.contains("add-classify-merchandise")) {
                    var container = event.target.parentNode;
                    var clonedInput = container.querySelector(".classify-merchandise").cloneNode(true);
                    var newNameInput = clonedInput.querySelector(".name-input"); // Lấy input mới nhất
                    newNameInput.value = ''; // Set input mới thành rỗng

                    // Tạo data-index mới
                    var dataIndex = generateRandomIndex();

                    // Thiết lập thuộc tính data-index cho input mới
                    setRandomIndex(newNameInput, dataIndex);

                    container.appendChild(clonedInput);
                    container.appendChild(container.querySelector(".add-classify-merchandise"));
                    count++;
                    dem++;
                    var newRow = document.createElement("tr");
                    newRow.setAttribute("data-index", dataIndex); // Thiết lập data-index cho dòng tr mới
                    newRow.innerHTML = `
                <td class="display-name">Loại</td>
                <td><input type="number" name="price[]" data-row-index="${dem}" /></td>
                <td><input type="number" name="stock[]" data-row-index="${dem}" /></td>
            `;
                    tableBody.appendChild(newRow);

                    // Thêm sự kiện input để tự động cập nhật giá trị của ô td displayName
                    newNameInput.addEventListener("input", function() {
                        var newName = this.value;
                        var displayNameTd = newRow.querySelector(".display-name");
                        displayNameTd.innerText = newName.trim() !== '' ? newName : "Loại";
                    });
                } else if (target.classList.contains("delete-classify-merchandise")) {
                    var parentDiv = target.parentNode.parentNode;
                    var table = document.getElementById("nameTable");

                    // Lấy data-index của input bị xóa
                    var deletedIndex = target.parentNode.querySelector(".name-input").getAttribute("data-index");

                    // Xóa dòng tr có data-index tương tự
                    var rows = table.getElementsByTagName("tr");

                    if (count == 0) {
                        alert("Không thể xóa phân loại cuối cùng!");
                    } else {
                        for (var i = 0; i < rows.length; i++) {
                            var dataIndex = rows[i].getAttribute("data-index");
                            if (dataIndex === deletedIndex) {
                                table.deleteRow(i);
                                break; // Kết thúc vòng lặp sau khi xóa dòng phù hợp
                            }
                        }
                        parentDiv.removeChild(target.parentNode);
                        count--;
                    }
                }
            });

            function createCategoryDiv() {
                var div = document.createElement("div");
                div.classList.add("form-nhap-phan-loai");
                div.innerHTML = `
            <label class="control-label">Nhóm phân loại </label>
            <p>Tên nhóm phân loại</p>
            <input class="form-control group-input" type="text" name="group" value="{{ old('name') }}" style="border: 2px solid" onkeyup="showGroup()">
            <p class="mt-3">Phân loại hàng</p>
            <div class="classify-merchandise d-flex my-3">
                <input class="form-control form-classify-merchandise name-input" type="text" name="name" value="{{ old('name') }}" style="border: 2px solid" onkeyup="showName()">
                <button class="delete-classify-merchandise" style="border-radius: 5px;cursor: pointer;">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
            <button class="add-classify-merchandise">Thêm phân loại hàng</button>
        `;
                return div;
            }

            function generateRandomIndex() {
                return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
            }

            function setRandomIndex(input, index) {
                input.setAttribute("data-index", index);
            }
        });
    </script>
@endsection
