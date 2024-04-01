@extends('master_user')
@section('login')
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    {{-- allert notification --}}
                    @if (session('notification'))
                        <div class="alert alert-danger text-center">
                            {{ session('notification') }}
                        </div>
                    @endif
                    @if (session('login_success'))
                        <div class="alert alert-success text-center">
                            {{ session('login_success') }}
                        </div>
                    @endif
                    {{-- allert notification end --}}
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <h4 class="mt-1 mb-5 pb-1">Thế Anh Mobile</h4>
                                    </div>

                                    <form action="" method="post">
                                        @csrf
                                        <p class="text-center">Vui Lòng Đăng nhập tài khoản của bạn</p>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example11">Email</label>
                                            <input type="email" name="email" id="form2Example11" class="form-control"
                                                placeholder="Phone number or email address" />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Mật khẩu</label>
                                            <input type="password" name="password" id="form2Example22"
                                                class="form-control" />
                                        </div>
                                        <div class="d-flex flex-column text-center pt-1 mb-4 pb-1">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                                type="submit">Đăng nhập</button>
                                            <a class="text-muted" href="{{ route('user.mail-active') }}">Kích hoạt tài khoản</a>
                                            <a class="text-muted" href="{{ route('user.mail-password') }}">Quên mật khẩu</a>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Nếu bạn không có tài khoản</p>
                                            <button type="button" class="btn btn-outline-danger">
                                                <a href="{{ route('register') }}">Đăng ký</a>
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4 text-center">Thế Anh Mobile</h4>
                                    <p class="small mb-0">Số điện thoại: 0949191750</p>
                                    <p> Địa chỉ: 41 Phố Nguyễn Hoàng, Mỹ Đình 2, Từ Liêm, Hà Nội</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Design Block -->

    <!-- remmove card -->
    <script src="{{ url('assets-user') }}/js/cart.js"></script>
    <!-- remmove card -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
@endsection
