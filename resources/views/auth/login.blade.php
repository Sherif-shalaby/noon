@include('layouts.partials.css')
{{-- @section('content') --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card overflow-hidden" style="margin-top: 30px">
                <div class="bg-primary bg-soft" style="background-color: rgba(161, 174, 240, 0.25)!important;">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-4">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p>Sign in to continue to Skote.</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ asset('uploads/' . $settings['logo']) }}" alt="logo" class="img-fluid"
                                height="34">
                            {{-- <img src="images2/profile-img.png" alt="" class="img-fluid"> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="auth-logo">
                        {{-- <a href="index.html" class="auth-logo-light">
                            <div class="avatar-md profile-user-wid mb-4">
                                <span class="avatar-title rounded-circle bg-light">
                                    <img src="images2/logo-light.svg" alt="" class="rounded-circle"
                                        height="34">
                                </span>
                            </div>
                        </a> --}}

                        {{-- <a href="index.html" class="auth-logo-dark">
                            <div class="avatar-md profile-user-wid mb-4">
                                <span class="avatar-title rounded-circle bg-light">
                                    <img src="images2/logo.svg" alt="" class="rounded-circle" height="34">
                                </span>
                            </div>
                        </a> --}}
                    </div>
                    <div class="p-2">
                        <form class="form-horizontal"method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>

                                <div class="input-group auth-pass-inputgroup">
                                    <input id="email" type="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('Password') }}</label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input id="password" type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                    <button class="btn btn-light " type="button" id="password-addon"><i
                                            class="mdi mdi-eye-outline"></i></button>
                                </div>
                            </div>

                            <div class="form-check">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            <div class="mt-3 d-grid">
                                <button class="btn btn-primary waves-effect waves-light" type="submit">
                                    {{ __('Login') }}</button>
                            </div>



                            <div class="mt-4 text-center">
                                <a href="{{ route('password.request') }}" class="text-muted"><i
                                        class="mdi mdi-lock me-1"></i> {{ __('auth.forgot') }}</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="mt-5 text-center">

                <div>
                    <p>Don't have an account ? <a href="{{ route('register') }}" class="fw-medium text-primary"> Signup
                            now </a> </p>
                    <p>©
                        <script>
                            document.write(new Date().getFullYear())
                        </script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                        Themesbrand
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
{{-- @endsection --}}
{{-- </html> --}}
