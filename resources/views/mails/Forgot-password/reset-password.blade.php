@extends('master_user')
@section('authenticate')
<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        @if (session('notification'))
        <div class="alert alert-danger text-center">
            {{ session('notification') }}
        </div>
        @endif
        <div class="row d-flex justify-content-center align-items-center h-100">
            <form action="{{ route('user.check-password', ['gmail'=>$gmail,'token'=>$token])}}" method="get">
                @csrf
                <p class="text-center">Please enter your new password</p>
                <div class="form-outline mb-2">
                    <label class="form-label" for="form3Example4cg">Enter The New Password</label>
                    <input type="password" name="password" id="form3Example4cg" class="form-control form-control-lg" />
                    @error('password')
                    <div class="alert alert-danger cl-red">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-outline mb-2">
                    <label class="form-label" for="form3Example4cdg">Re-Enter The New Password</label>
                    <input type="password" name="confirmpassword" id="form3Example4cdg"
                        class="form-control form-control-lg" />
                    @error('confirmpassword')
                    <div class="alert alert-danger cl-red">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex flex-column text-center pt-1 mb-4 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                        type="submit">Change</button>
                </div>
            </form>

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