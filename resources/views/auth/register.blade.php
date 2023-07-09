@include('layouts.partials.css')

{{-- @section('content') --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="row justify-content-center">
            <div class="">
                <div class="card overflow-hidden" style="margin-top: 30px">
                    <div class="bg-primary bg-soft" style="background-color: rgba(161, 174, 240, 0.25)!important;">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4">
                                    <h5 class="text-primary">{{ __('Register') }}</h5>
                                    <p>Get your free Skote account now.</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0"> 
                        <div>
                            <a href="index.html">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="p-2">
                            <form class="needs-validation" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="useremail" class="form-label">Email</label>
                                    <input id="email" type="text" class="form-control @error('name') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="name" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="invalid-feedback">
                                        Please Enter Email
                                    </div>      
                                </div>
        
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="invalid-feedback">
                                        Please Enter Username
                                    </div>  
                                </div>
        
                                <div class="mb-3">
                                    <label for="userpassword" class="form-label">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="invalid-feedback">
                                        Please Enter Password
                                    </div>       
                                </div>
                                <div class="mb-3">
                                    <label for="userpassword" class="form-label">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    <div class="invalid-feedback">
                                        Please Enter Password
                                    </div>       
                                </div>
            
                                <div class="mt-4 d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                                </div>        
                                <div class="mt-4 text-center">
                                    <p class="mb-0">By registering you agree to the Skote <a href="#" class="text-primary">Terms of Use</a></p>
                                </div>
                            </form>
                        </div>
    
                    </div>
                </div>
                <div class="mt-5 text-center">
                    
                    <div>
                        <p>Already have an account ? <a href="{{route('login')}}" class="fw-medium text-primary"> Login</a> </p>
                        <p>© <script>document.write(new Date().getFullYear())</script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{{-- @endsection --}}
