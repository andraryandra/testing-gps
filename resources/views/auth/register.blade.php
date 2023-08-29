@extends('layouts.auth')

@section('auth')
    <!--start content-->
    <main class="authentication-content">
        <div class="container-fluid">
            <div class="authentication-card">
                <div class="card shadow rounded-0 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                            <img src="{{ asset('dashboard/assets/images/error/login-img.jpg') }}" class="img-fluid"
                                alt="">
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body p-4 p-sm-5">
                                <h5 class="card-title">Sign Up</h5>
                                <p class="card-text mb-5">See your growth and get consulting support!</p>
                                <form method="POST" action="{{ route('register') }}" class="form-body">
                                    @csrf

                                    <div class="row g-3">
                                        <div class="col-12 ">
                                            <label for="inputName" class="form-label">Name</label>
                                            <div class="ms-auto position-relative">
                                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                                        class="bi bi-person-circle"></i>
                                                </div>

                                                <input id="inputName" type="text"
                                                    class="form-control radius-30 ps-5 @error('name') is-invalid @enderror"
                                                    name="name" value="{{ old('name') }}" placeholder="Enter Name"
                                                    required autocomplete="name" autofocus>

                                            </div>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="inputEmailAddress" class="form-label">Email Address</label>
                                            <div class="ms-auto position-relative">
                                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                                        class="bi bi-envelope-fill"></i></div>

                                                <input id="inputEmailAddress" type="email"
                                                    class="form-control radius-30 ps-5 @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" placeholder="Email Address"
                                                    required autocomplete="email">
                                            </div>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="inputChoosePassword" class="form-label">Enter Password</label>
                                            <div class="ms-auto position-relative">
                                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                                        class="bi bi-lock-fill"></i></div>

                                                <input id="inputChoosePassword" type="password"
                                                    class="form-control radius-30 ps-5 @error('password') is-invalid @enderror"
                                                    name="password" placeholder="Enter Password" required
                                                    autocomplete="new-password">
                                            </div>

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="password-confirm" class="form-label">Confirm Password</label>
                                            <div class="ms-auto position-relative">
                                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                                        class="bi bi-lock-fill"></i></div>

                                                <input id="password-confirm" type="password"
                                                    class="form-control radius-30 ps-5 @error('password_confirmation') is-invalid @enderror"
                                                    name="password_confirmation" placeholder="Enter Password Again" required
                                                    autocomplete="new-password">


                                            </div>

                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">I Agree to the
                                                    Trems & Conditions</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary radius-30">Sign in</button>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <p class="mb-0">Already have an account? <a href="{{ route('login') }}">Sign
                                                    up here</a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!--end page main-->
@endsection
