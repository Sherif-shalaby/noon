@include('layouts.partials.css')
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Raleway, sans-serif;
    }

    body {
        background: linear-gradient(90deg, #C7C5F4, #776BCC);
        max-height: 100vh;
        overflow: hidden;
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        width: 100% !important;
    }

    @media (min-width: 576px) {
        .container {
            max-width: 100% !important;
        }
    }

    @media (min-width: 768px) {
        .container {
            max-width: 100% !important;
        }
    }

    @media (min-width: 992px) {
        .container {
            max-width: 100% !important;
        }
    }

    @media (min-width: 1200px) {
        .container {
            max-width: 100% !important;
        }
    }


    .screen {
        background: linear-gradient(90deg, #5D54A4, #7C78B8);
        position: relative;
        height: 600px;
        width: 30%;
        box-shadow: 0px 0px 24px #5C5696;
    }

    .screen__content {
        z-index: 1;
        position: relative;
        height: 100%;
    }

    .screen__background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
        -webkit-clip-path: inset(0 0 0 0);
        clip-path: inset(0 0 0 0);
    }

    .screen__background__shape {
        transform: rotate(45deg);
        position: absolute;
    }

    .screen__background__shape1 {
        height: 520px;
        width: 520px;
        background: #FFF;
        top: -50px;
        right: 120px;
        border-radius: 0 72px 0 0;
    }

    .screen__background__shape2 {
        height: 220px;
        width: 220px;
        background: #6C63AC;
        top: -172px;
        right: 0;
        border-radius: 32px;
    }

    .screen__background__shape3 {
        height: 540px;
        width: 190px;
        background: linear-gradient(270deg, #5D54A4, #6A679E);
        top: -24px;
        right: 0;
        border-radius: 32px;
    }

    .screen__background__shape4 {
        height: 400px;
        width: 200px;
        background: #7E7BB9;
        top: 420px;
        right: 50px;
        border-radius: 60px;
    }

    .login {
        width: 80%;
        padding: 30px;
        /* padding-top: 80px; */
    }

    .login__field {
        padding: 15px 0px;
        position: relative;
    }

    .login__icon {
        position: absolute;
        top: 30px;
        color: #7875B5;
    }

    .login__input {
        border: none;
        border-bottom: 2px solid #D1D1D4;
        background: none;
        padding: 10px;
        padding-left: 24px;
        font-weight: 700;
        width: 90%;
        transition: .2s;
    }

    .login__input:active,
    .login__input:focus,
    .login__input:hover {
        outline: none;
        border-bottom-color: #6A679E;
    }

    .login__submit {
        background: #fff;
        font-size: 14px;
        margin-top: 15px;
        padding: 16px 20px;
        border-radius: 26px;
        border: 1px solid #D4D3E8;
        text-transform: uppercase;
        font-weight: 700;
        display: flex;
        align-items: center;
        width: 100%;
        color: #4C489D;
        box-shadow: 0px 2px 2px #5C5696;
        cursor: pointer;
        transition: .2s;
    }

    .login__submit:active,
    .login__submit:focus,
    .login__submit:hover {
        border-color: #6A679E;
        outline: none;
    }

    .button__icon {
        font-size: 24px;
        margin-left: auto;
        color: #7875B5;
    }

    .social-login {
        position: absolute;
        height: 140px;
        width: 160px;
        text-align: center;
        bottom: 0px;
        right: 0px;
        color: #fff;
    }

    .social-icons {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .social-login__icon {
        padding: 20px 10px;
        color: #fff;
        text-decoration: none;
        text-shadow: 0px 0px 8px #7875B5;
    }

    .social-login__icon:hover {
        transform: scale(1.5);
    }

    .login__footer {
        position: absolute;
        bottom: 0;
        height: 35px;
        left: 0;
        right: 0;
    }
</style>
<div class="container">
    <div class="screen animate__animated animate__rotateIn">
        <div class="screen__content ">
            <form class="login" method="POST" action="{{ route('login') }}">
                @csrf
                <div style="width: 125px;height:125px">

                    <img src="{{ asset('uploads/' . $settings['logo']) }}" alt="logo" class="img-fluid">
                    {{-- <img style="width: 100%" src="{{ asset('images/logo1.png') }}" alt="" class="img-fluid"> --}}
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input name="email" id="email" type="email"
                        class="login__input {{ $errors->has('email') ? ' is-invalid' : '' }}"
                        placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input name="password" id="password" type="password"
                        class="login__input {{ $errors->has('password') ? ' is-invalid' : '' }}"
                        placeholder="{{ __('Password') }}" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <a href="{{ route('password.request') }}" style="font-size: 11px" class="text-muted"><i
                        class="mdi mdi-lock me-1"></i>
                    {{ __('auth.forgot') }}</a>
                {{-- <button class="btn btn-light " type="button" id="password-addon"><i
                        class="mdi mdi-eye-outline"></i></button> --}}
                <button type="submit" class="button login__submit">
                    <span class="button__text"> {{ __('Login') }}</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>
                {{-- <p>Don't have an account ? <a href="{{ route('register') }}" class="fw-medium text-primary">
                        Signup
                        now </a>
                </p> --}}
                {{-- <p>
                    <a href="{{ route('register') }}" class="fw-medium text-primary mt-2"
                        style="font-size: 13px;font-weight: 700;">
                        <span class="text-black">
                            Or
                        </span>
                        Signup now </a>
                </p> --}}
            </form>
            <div class="social-login">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('Remember Me') }}
                </label>


                {{-- <p>©
                    <script>
                        document.write(new Date().getFullYear())
                    </script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                    Themesbrand
                </p> --}}
            </div>
        </div>
        <div class="screen__background">
            <span class=" screen__background__shape screen__background__shape4"></span>
            <span class="animate__animated  screen__background__shape screen__background__shape3"></span>
            <span class="animate__animated  screen__background__shape screen__background__shape2"></span>
            <span class="animate__animated  screen__background__shape screen__background__shape1"></span>
        </div>
    </div>
    <div class="login__footer">
        @include('layouts.partials.footer')
    </div>
</div>





{{-- @section('content') --}}
{{-- <div class="container">
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
                                height="34"> --}}



{{-- <img src="images2/profile-img.png" alt="" class="img-fluid"> --}}



{{-- </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="auth-logo">

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
                    <p>Don't have an account ? <a href="{{ route('register') }}" class="fw-medium text-primary">
                            Signup
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
</div> --}}
{{-- @endsection --}}
{{-- </html> --}}
