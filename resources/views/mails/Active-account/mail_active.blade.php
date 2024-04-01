@extends('master_user')
@section('mail-active')
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            @if (session('notification'))
                            <div class="alert alert-danger text-center">
                                {{ session('notification') }}
                            </div>
                        @endif
            <div class="row d-flex justify-content-center align-items-center h-100">
                <form action="{{route('user.authenticate')}}" method="get">
                    @csrf
                    <p class="text-center">Please enter your gmail</p>
                    <div class="form-outline mb-4">
                        <input type="email" name="gmail" id="form2Example11" class="form-control"
                            placeholder=""/>
                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Confirm</button>
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
