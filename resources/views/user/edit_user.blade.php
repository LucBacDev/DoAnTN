@extends('master_user')
@section('register')
    <section class="h-100 bg-image" style="background-color: #eee;">
        <div class="mask d-flex align-items-center h-100">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-4">
                                <h2 class="text-uppercase text-center mb-2">TẠO TÀI KHOẢN</h2>
                                <form method="post" action="{{ route('update-user',Auth::id())}}">
                                    @csrf
                                    <div class="form-outline mb-3">
                                        <label class="form-label" for="form3Example1cg">Họ và tên</label>
                                        <input name="full_name" type="text" id="form3Example1cg"
                                            class="form-control form-control-lg" value="{{Auth::user()->full_name}}" />
                                        @error('full_name')
                                            <div class="alert alert-danger cl-red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-outline mb-2">
                                        <label for="exampleFormControlTextarea1" class="form-label">Địa chỉ</label>
                                        <textarea name="address" class="form-control" id="exampleFormControlTextarea1" rows="3">{{Auth::user()->address}}</textarea>
                                        @error('address')
                                            <div class="alert alert-danger cl-red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-outline mb-2">
                                        <label for="exampleFormControlTextarea1" class="form-label">Số điện thoại</label>
                                        <input type="number" class="form-control" name="phone" id="exampleFormControlTextarea1" value="{{Auth::user()->phone}}">
                                        @error('phone')
                                        <div class="alert alert-danger cl-red">{{ $message }}</div>
                                    @enderror
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <button type="submit"
                                            class="btn btn-success btn-block btn-lg gradient-custom-2 text-body">Sửa
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <link rel="stylesheet" href="{{ url('assets-user') }}/css/style.css">
@endsection
