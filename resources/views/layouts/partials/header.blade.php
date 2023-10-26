<!-- Start Topbar -->
{{-- <div class="topbar no-print"> --}}
{{--    <!-- Start container-fluid --> --}}
{{--    <div class="container-fluid"> --}}
{{--        <!-- Start row --> --}}
{{--        <div class="row align-items-center"> --}}
{{--            <!-- Start col --> --}}
{{--            <div class="col-md-12 align-self-center"> --}}
{{--                <div class="togglebar"> --}}
{{--                    <ul class="list-inline mb-0"> --}}
{{--                        <li class="list-inline-item"> --}}
{{--                            <div class="logobar"> --}}
{{--                                <a href="{{url('/')}}" class=""><img src="{{asset('/uploads/'.$settings['logo'])}}" width="45" height="45" class="img-fluid" alt="logo"></a> --}}
{{--                            </div> --}}
{{--                        </li> --}}
{{--                        <li class="list-inline-item"> --}}
{{--                            <div class="searchbar"> --}}
{{--                                <form> --}}
{{--                                    <div class="input-group"> --}}
{{--                                      <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2"> --}}
{{--                                      <div class="input-group-append"> --}}
{{--                                        <button class="btn" type="submit" id="button-addon2"><img src="{{asset('images/svg-icon/search.svg')}}" class="img-fluid" alt="search"></button> --}}
{{--                                      </div> --}}
{{--                                    </div> --}}
{{--                                </form> --}}
{{--                            </div> --}}
{{--                        </li> --}}
{{--                    </ul> --}}
{{--                </div> --}}
{{--                <div class="infobar"> --}}
{{--                    <ul class="list-inline mb-0"> --}}
{{--                        <li class="list-inline-item"> --}}
{{--                            <div class="notifybar"> --}}
{{--                                <a href="https://api.whatsapp.com/send?phone={{$settings['watsapp_numbers']}}"> --}}
{{--                                    <img src="{{asset('images/topbar/whatsapp.jpg')}}" class="img-fluid" alt="notifications" width="45px" height="45px"> --}}
{{--                                </a> --}}
{{--                            </div> --}}
{{--                        </li> --}}
{{--                        <li class="list-inline-item"> --}}
{{--                            <div class="notifybar"> --}}
{{--                                <a href="{{ route('invoices.create') }}"> --}}
{{--                                    <img src="{{asset('images/topbar/cash-machine.png')}}" class="img-fluid" alt="notifications" width="45px" height="45px"> --}}
{{--                                </a> --}}
{{--                            </div> --}}
{{--                        </li> --}}
{{--                        <li class="list-inline-item"> --}}
{{--                            <div class="notifybar"> --}}
{{--                                <a href="javascript:void(0)" id="infobar-notifications-open" class="infobar-icon"> --}}
{{--                                    <img src="{{asset('images/svg-icon/notifications.svg')}}" class="img-fluid" alt="notifications"> --}}
{{--                                    <span class="live-icon"></span> --}}
{{--                                </a> --}}
{{--                            </div> --}}
{{--                        </li> --}}
{{--                        <li class="list-inline-item"> --}}
{{--                            @php --}}
{{--                                $flags=(object)[ --}}
{{--                                    'en'=>'us', --}}
{{--                                    'ar'=>'eg' --}}
{{--                                    ]; --}}
{{--                                $local_code=LaravelLocalization::getCurrentLocale(); --}}
{{--                           @endphp --}}
{{--                            <div class="languagebar"> --}}
{{--                                <div class="dropdown"> --}}
{{--                                  <a class="dropdown-toggle text-black" href="#" role="button" id="languagelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag flag-icon-{{ $flags->$local_code }} flag-icon-squared"></i>&nbsp;{{ LaravelLocalization::getCurrentLocaleNative() }}</a> --}}
{{--                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languagelink"> --}}
{{--                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) --}}
{{--                                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"> --}}
{{--                                            <i class="flag  flag-icon-{{$flags->$localeCode}} flag-icon-squared"></i>{{ $properties['native'] }} --}}
{{--                                        </a> --}}
{{--                                    @endforeach --}}
{{--                                  </div> --}}
{{--                                </div> --}}
{{--                            </div> --}}
{{--                        </li> --}}
{{--                        <li class="list-inline-item"> --}}
{{--                            <div class="profilebar"> --}}
{{--                                <div class="dropdown"> --}}
{{--                                  <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('images/users/profile.svg')}}" class="img-fluid" alt="profile"><span class="feather icon-chevron-down live-icon"></span></a> --}}
{{--                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink"> --}}
{{--                                    <div class="dropdown-item"> --}}
{{--                                        <div class="profilename"> --}}
{{--                                          <h5>Shourya Kumar</h5> --}}
{{--                                          <p>Social Media Strategist</p> --}}
{{--                                        </div> --}}
{{--                                    </div> --}}
{{--                                    <div class="dropdown-item"> --}}
{{--                                        <div class="userbox"> --}}
{{--                                            <ul class="list-inline mb-0"> --}}
{{--                                                <li class="list-inline-item"><a href="#" class="profile-icon"><img src="{{asset('images/svg-icon/user.svg')}}" class="img-fluid" alt="user"></a></li> --}}
{{--                                                <li class="list-inline-item"><a href="#" class="profile-icon"><img src="{{asset('images/svg-icon/email.svg')}}" class="img-fluid" alt="email"></a></li> --}}
{{--                                                <li class="list-inline-item"> --}}
{{--                                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="profile-icon"><img src="{{asset('images/svg-icon/logout.svg')}}" class="img-fluid" alt="logout"></a> --}}
{{--                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" --}}
{{--                                                        style="display: none;"> --}}
{{--                                                        @csrf --}}
{{--                                                    </form> --}}
{{--                                                </li> --}}
{{--                                            </ul> --}}
{{--                                        </div> --}}
{{--                                      </div> --}}
{{--                                  </div> --}}
{{--                                </div> --}}
{{--                            </div> --}}
{{--                        </li> --}}
{{--                        <li class="list-inline-item menubar-toggle" @if (request()->segment(2) == 'invoices') style="display: inline-block;!important;"@endif> --}}
{{--                            <div class="menubar"> --}}
{{--                                <a class="menu-hamburger navbar-toggle bg-transparent" href="javascript:void();" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="true"> --}}
{{--                                    <img src="{{asset('images/svg-icon/collapse.svg')}}" class="img-fluid menu-hamburger-collapse" alt="collapse"> --}}
{{--                                    <img src="{{asset('images/svg-icon/close.svg')}}" class="img-fluid menu-hamburger-close" alt="close"> --}}
{{--                                </a> --}}
{{--                             </div> --}}
{{--                        </li> --}}
{{--                    </ul> --}}
{{--                </div> --}}
{{--            </div> --}}
{{--            <!-- End col --> --}}
{{--        </div> --}}
{{--        <!-- End row --> --}}
{{--    </div> --}}

{{--    <!-- End container-fluid --> --}}
{{-- </div> --}}
<!-- End Topbar -->
<!-- Start Navigationbar -->
{{-- <div class="navigationbar">
    <!-- Start container-fluid -->
    <div class="container-fluid"> --}}
<!-- Start Horizontal Nav -->
<nav class="horizontal-nav mobile-navbar fixed-navbar px-2 py-4 navbar-responsive ">
    <div class="collapse navbar-collapse d-flex  justify-content-between" id="navbar-menu">
        <ul style="width: 100%"
            class="horizontal-menu d-flex flex-wrap justify-content-start @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {{-- ###################### Dashboard : نظرة عامة ###################### --}}
            {{-- @can('dashboard')  --}}
            @if (!empty($module_settings['dashboard']))
                <li class="scroll mx-2 mb-3 p-0">
                    <a class="home-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif align-items-center"
                        style="cursor: pointer">
                        <div style="width: 25px">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 100%" viewBox="0 0 64 64">
                                <defs>
                                    <style>
                                        .cls-2 {
                                            fill: #7c828d
                                        }

                                        .cls-3 {
                                            fill: #b2b9bf
                                        }

                                        .cls-4 {
                                            fill: #b5e0f0
                                        }

                                        .cls-5 {
                                            fill: #00b39b
                                        }

                                        .cls-6 {
                                            fill: #b8453d
                                        }

                                        .cls-8 {
                                            fill: #545465
                                        }

                                        .cls-10 {
                                            fill: #29394a
                                        }
                                    </style>
                                </defs>
                                <g id="_02-control_panal" data-name="02-control panal">
                                    <path d="M63 57v4a2.006 2.006 0 0 1-2 2H3a2.006 2.006 0 0 1-2-2v-4h62z"
                                        style="fill:#6e6e79" />
                                    <path class="cls-2"
                                        d="M13 23v34H1V25a2.006 2.006 0 0 1 2-2zM63 25v32H51V23h10a2.006 2.006 0 0 1 2 2z" />
                                    <path class="cls-3"
                                        d="M51 23v34H13V23h38zm-3 8a4 4 0 0 0-8 0c0 2.21 1.79 2 4 2s4 .21 4-2zm-2 10v-4h-4v4zm-8 0v-4h-4v4zm-2-10a4 4 0 0 0-8 0c0 2.21 1.79 2 4 2s4 .21 4-2zm-6 10v-4h-4v4zm-6-10a4 4 0 0 0-8 0c0 2.21 1.79 2 4 2s4 .21 4-2zm-2 10v-4h-4v4z" />
                                    <path class="cls-4"
                                        d="M44 33c-2.21 0-4 .21-4-2a4 4 0 0 1 8 0c0 2.21-1.79 2-4 2zM32 33c-2.21 0-4 .21-4-2a4 4 0 0 1 8 0c0 2.21-1.79 2-4 2zM20 33c-2.21 0-4 .21-4-2a4 4 0 0 1 8 0c0 2.21-1.79 2-4 2z" />
                                    <path class="cls-5" d="M42 37h4v4h-4zM26 37h4v4h-4z" />
                                    <path class="cls-6" d="M34 37h4v4h-4zM18 37h4v4h-4zM52 10h-5V5a5 5 0 0 1 5 5z" />
                                    <path d="M47 10h5a5 5 0 1 1-5-5z" style="fill:#fc9b28" />
                                    <path class="cls-8" d="M14 19h6v4h-6zM44 19h6v4h-6z" />
                                    <path class="cls-3"
                                        d="M30 15v2a2.006 2.006 0 0 1-2 2H6a2.006 2.006 0 0 1-2-2v-2h26z" />
                                    <path d="M25 15h-8V1h11a2.006 2.006 0 0 1 2 2v12z" style="fill:#029e84" />
                                    <path class="cls-5"
                                        d="M13 15H4V3a2.006 2.006 0 0 1 2-2h11v14zM60 3v14a2.006 2.006 0 0 1-2 2H36a2.006 2.006 0 0 1-2-2V3a2.006 2.006 0 0 1 2-2h22a2.006 2.006 0 0 1 2 2zm-8 7a5 5 0 1 0-5 5 5 5 0 0 0 5-5z" />
                                    <path class="cls-10"
                                        d="M61 22H51v-2h7a3 3 0 0 0 3-3V3a3 3 0 0 0-3-3H36a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h7v2H21v-2h7a3 3 0 0 0 3-3V3a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h7v2H3a3 3 0 0 0-3 3v36a3 3 0 0 0 3 3h58a3 3 0 0 0 3-3V25a3 3 0 0 0-3-3zm-9 2h9a1 1 0 0 1 1 1v31H52zm-2 32H14V24h36zM35 17V3a1 1 0 0 1 1-1h22a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H36a1 1 0 0 1-1-1zm10 3h4v2h-4zM6 2h22a1 1 0 0 1 1 1v11h-3V6h-2v8h-2V8h-2v6h-2V4h-2v10h-2V6h-2v8h-2V8H8v6H5V3a1 1 0 0 1 1-1zM5 17v-1h24v1a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1zm10 3h4v2h-4zM2 25a1 1 0 0 1 1-1h9v32H2zm59 37H3a1 1 0 0 1-1-1v-3h60v3a1 1 0 0 1-1 1z" />
                                    <path class="cls-10"
                                        d="M15.767 33.142c.89.882 2.255.87 3.71.861L20 34H21.007a4.373 4.373 0 0 0 3.226-.863A2.894 2.894 0 0 0 25 31a5 5 0 0 0-10 0 2.894 2.894 0 0 0 .767 2.142zM20 28a3 3 0 0 1 3 3 1.129 1.129 0 0 1-.176.722A3.4 3.4 0 0 1 21 32v-2h-2v2a3.391 3.391 0 0 1-1.824-.282A1.129 1.129 0 0 1 17 31a3 3 0 0 1 3-3zM31.477 34h1.53a4.373 4.373 0 0 0 3.226-.863A2.894 2.894 0 0 0 37 31a5 5 0 0 0-10 0 2.894 2.894 0 0 0 .767 2.142c.889.882 2.258.87 3.71.858zM32 28a3 3 0 0 1 3 3 1.129 1.129 0 0 1-.176.722A3.4 3.4 0 0 1 33 32v-2h-2v2a3.4 3.4 0 0 1-1.824-.282A1.129 1.129 0 0 1 29 31a3 3 0 0 1 3-3zM43.477 34h1.53a4.373 4.373 0 0 0 3.226-.863A2.894 2.894 0 0 0 49 31a5 5 0 0 0-10 0 2.894 2.894 0 0 0 .767 2.142c.89.882 2.257.87 3.71.858zM44 28a3 3 0 0 1 3 3 1.129 1.129 0 0 1-.176.722A3.4 3.4 0 0 1 45 32v-2h-2v2a3.4 3.4 0 0 1-1.824-.282A1.129 1.129 0 0 1 41 31a3 3 0 0 1 3-3zM47 4a6 6 0 1 0 6 6 6.006 6.006 0 0 0-6-6zm3.858 5H48V6.142A4 4 0 0 1 50.858 9zM47 14a3.992 3.992 0 0 1-1-7.858V10a1 1 0 0 0 1 1h3.858A4 4 0 0 1 47 14zM22 42a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1zm-3-4h2v2h-2zM25 41a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1zm2-3h2v2h-2zM33 37v4a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1zm2 1h2v2h-2zM46 36h-4a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1zm-1 4h-2v-2h2zM17 48h6v2h-6zM17 44h6v2h-6zM25 48h6v2h-6zM25 44h6v2h-6zM33 48h6v2h-6zM33 44h6v2h-6zM41 48h6v2h-6zM41 44h6v2h-6zM17 52h30v2H17zM54 27h6v2h-6zM54 35h6v2h-6zM54 43h6v2h-6zM54 51h6v2h-6zM4 27h6v2H4zM4 35h6v2H4zM4 43h6v2H4zM4 51h6v2H4z" />
                                </g>
                            </svg>
                        </div>
                        {{-- <img src="{{ asset('images/topbar/dashboard.png') }}" class="img-fluid pl-1" alt="dashboard"> --}}
                        <span class="mx-2">{{ __('lang.dashboard') }}</span>
                    </a>
                </li>
            @endif
            {{-- @endcan --}}
            {{-- ###################### Products : المنتجات ###################### --}}
            {{-- @can('product_module')  --}}
            @if (!empty($module_settings['product_module']))
                <li class="scroll mx-2 mb-3 p-0">
                    <a class="products-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif align-items-center"
                        style="cursor: pointer">
                        <div style="width: 25px">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 100%" viewBox="0 0 48 48">
                                <g data-name="product analytic">
                                    <path style="fill:#edb996" d="M1 4h32v32H1z" />
                                    <path d="M33 4c0 31.16-.1 30 0 30C18.07 34 4 22.47 4 4z" style="fill:#f6ccaf" />
                                    <path d="M39 32a9 9 0 1 1-14.28-7.28A9 9 0 0 1 39 32z" style="fill:#9fdbf3" />
                                    <path d="M39 32a9 9 0 0 1-1.72 5.28 9 9 0 0 1-12.56-12.56A9 9 0 0 1 39 32z"
                                        style="fill:#b2e5fb" />
                                    <path
                                        d="M44.5 46.5a2.13 2.13 0 0 1-3 0l-6.82-6.82a8.88 8.88 0 0 0 3-3l6.82 6.82a2.12 2.12 0 0 1 0 3z"
                                        style="fill:#374f68" />
                                    <path
                                        d="M44.87 44A2.1 2.1 0 0 1 43 45.12c-1.17 0-1-.14-7.16-6.28a8.68 8.68 0 0 0 1.84-2.16c7.39 7.39 6.96 6.9 7.19 7.32z"
                                        style="fill:#425b72" />
                                    <path style="fill:#db5669" d="M28 10h4v8h-4z" />
                                    <path d="M32 10v6a3 3 0 0 1-3-3v-3z" style="fill:#f26674" />
                                    <path style="fill:#fc6" d="M35 8h4v10h-4z" />
                                    <path d="M39 8c0 8.55-.1 8 0 8a3 3 0 0 1-3-3V8z" style="fill:#ffde76" />
                                    <path style="fill:#9dcc6b" d="M42 4h4v14h-4z" />
                                    <path d="M46 4c0 12.64-.1 12 0 12a3 3 0 0 1-3-3V4z" style="fill:#b5e08c" />
                                    <path style="fill:#a87e6b" d="M12 4h10v8H12z" />
                                    <path d="M22 4v6h-2a6 6 0 0 1-6-6z" style="fill:#be927c" />
                                    <path style="fill:#dad7e5" d="M5 26h10v6H5z" />
                                    <path d="M15 26v5h-4a5 5 0 0 1-5-5z" style="fill:#edebf2" />
                                    <path
                                        d="M38.92 36.5A10 10 0 0 0 34 22.84V22a1 1 0 1 0-2 .2A10 10 0 0 0 20.46 35H2V5h9v7a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5h9v1a1 1 0 0 0 2 0V4a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1v32a1 1 0 0 0 1 1h20.35a10 10 0 0 0 13.15 3.92c6.28 6.27 6.68 7.2 8.5 7.2a3.13 3.13 0 0 0 2.21-5.33zM21 5v6h-8V5zm1 27a8 8 0 1 1 8 8 8 8 0 0 1-8-8zm20.21 13.79-6-6a10.73 10.73 0 0 0 1.58-1.58l6 6a1.12 1.12 0 0 1-1.58 1.58z" />
                                    <path
                                        d="M47 17V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v13h-1V8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v9h-1v-7a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v7a1 1 0 0 0 0 2h20a1 1 0 0 0 0-2zm-18 0v-6h2v6zm7 0V9h2v8zm7 0V5h2v12zM5 25a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm9 6H6v-4h8z" />
                                    <path d="M9 30h2a1 1 0 0 0 0-2H9a1 1 0 0 0 0 2z" />
                                </g>
                            </svg>
                        </div>
                        {{-- <img src="{{ asset('images/topbar/dairy-products.png') }}" class="img-fluid pl-1"
                            alt="widgets">< --}}
                        <span class="mx-2">{{ __('lang.products') }}</span>
                    </a>
                </li>
            @endif
            {{-- @endcan --}}
            {{-- ###################### Cashier : المبيعات ###################### --}}
            {{-- @can('cashier_module') --}}
            @if (!empty($module_settings['cashier_module']))
                <li class="scroll mx-2 mb-3 p-0">
                    <a class="cashier-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                        style="cursor: pointer">
                        {{-- <img
                            src="{{ asset('images/topbar/cashier-machine.png') }}" class="img-fluid pl-1"
                            alt="apps"> --}}
                        <div style="width: 25px">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 100%" viewBox="0 0 64 64">
                                <g data-name="28-Cash register">
                                    <path style="fill:#a8b7d4" d="M29 34v3H7v-3h22z" />
                                    <path style="fill:#5c6979" d="M7 31h3v3H7zM26 31h3v3h-3z" />
                                    <path style="fill:#edf4fa"
                                        d="M40 42v4h-6l.33-4H40zM40 42h5v4h-5zM45 42h5v4h-5zM55.67 42l.33 4h-6v-4h5.67zM55.33 38l.34 4H50v-4h5.33zM45 38h5v4h-5zM40 38h5v4h-5zM40 38v4h-5.67l.34-4H40zM40 34v4h-5.33l.33-4h5zM40 34h5v4h-5zM45 34h5v4h-5zM55 34l.33 4H50v-4h5z" />
                                    <path style="fill:#bd6f08" d="M49 27v2h-8v-6h8v4z" />
                                    <path
                                        d="M34 20h22V4H34zM59 3v18a2.006 2.006 0 0 1-2 2H33a2.006 2.006 0 0 1-2-2V3a2.006 2.006 0 0 1 2-2h24a2.006 2.006 0 0 1 2 2z"
                                        style="fill:#ffad39" />
                                    <path style="fill:#edf4fa" d="M34 4h22v16H34z" />
                                    <path style="fill:#e03e3e" d="M19 55h26v4H19z" />
                                    <path
                                        d="M63 51.37V59a4 4 0 0 1-4 4H5a4 4 0 0 1-4-4v-7.63c0-.13 0-.25.01-.37h61.98c.01.12.01.24.01.37zM45 59v-4H19v4z"
                                        style="fill:#fc9e20" />
                                    <path
                                        d="m55.67 42-.34-4-.33-4H35l-.33 4-.34 4-.33 4h22zm7.28 8.63c.01.13.03.25.04.37H1.01c.01-.12.03-.24.04-.37l2.73-21.88A2.007 2.007 0 0 1 5.77 27H10v4H7v6h22v-6h-3v-4h15v2h8v-2h9.23a2.007 2.007 0 0 1 1.99 1.75z"
                                        style="fill:#febd55" />
                                    <path d="M45 17a8 8 0 0 1-8-8V4h-3v16h22v-3z" style="fill:#c1cfe8" />
                                    <path d="M45 25h4v-2h-8v6h2v-2a2 2 0 0 1 2-2z" style="fill:#9e5d07" />
                                    <path
                                        d="M61 59H12a4 4 0 0 1-4-4v-4H1.01c-.01.12-.01.24-.01.37V59a4 4 0 0 0 4 4h54a4 4 0 0 0 4-4v-2a2 2 0 0 1-2 2z"
                                        style="fill:#e68c15" />
                                    <path
                                        d="M8.694 42.668A4 4 0 0 1 12.681 39H27a1 1 0 0 0 1-1v-1H7v-6h3v-4H5.77a2.007 2.007 0 0 0-1.99 1.75L1.05 50.63c-.01.13-.03.25-.04.37H8zM41 27v2h8l-1.414 1.414a2 2 0 0 1-1.414.586H33.5a1.5 1.5 0 0 1-1.5-1.5 1.5 1.5 0 0 1 1.5-1.5H38v-1z"
                                        style="fill:#fc9e20" />
                                    <path d="M19 55v4h3v-1a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v1h3v-4z"
                                        style="fill:#a81e29" />
                                    <path d="M10 31v3H7v-1h1a1 1 0 0 0 1-1v-1zM26 31v3h3v-1h-1a1 1 0 0 1-1-1v-1z"
                                        style="fill:#393d48" />
                                    <path d="M7 34v3h22v-3h-1a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2H7z" style="fill:#8394b2" />
                                    <path style="fill:#edf4fa" d="M26 27v7H10V14l2 2 2-2 2 2 2-2 2 2 2-2 2 2 2-2v13z" />
                                    <path style="fill:#d6e0eb" d="M10 32h16v2H10z" />
                                    <path
                                        d="M33 24h7v5a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-5h7a3 3 0 0 0 3-3V3a3 3 0 0 0-3-3H33a3 3 0 0 0-3 3v18a3 3 0 0 0 3 3zm15 4h-6v-4h6zM32 3a1 1 0 0 1 1-1h24a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H33a1 1 0 0 1-1-1z" />
                                    <path
                                        d="m63.946 50.505-2.735-21.877A3 3 0 0 0 58.234 26H51v2h7.234a1 1 0 0 1 .993.876l2.735 21.875a5.183 5.183 0 0 1 .038.623V59a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-7.626a5.125 5.125 0 0 1 .038-.621l2.735-21.877A1 1 0 0 1 5.766 28H8v-2H5.766a3 3 0 0 0-2.977 2.628L.054 50.507a7.182 7.182 0 0 0-.054.867V59a5.006 5.006 0 0 0 5 5h54a5.006 5.006 0 0 0 5-5v-7.626a7.24 7.24 0 0 0-.054-.869z" />
                                    <path d="M28 26h11v2H28z" />
                                    <path
                                        d="M7 30a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h22a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1h-2V14a1 1 0 0 0-1.707-.707L24 14.586l-1.293-1.293a1 1 0 0 0-1.414 0L20 14.586l-1.293-1.293a1 1 0 0 0-1.414 0L16 14.586l-1.293-1.293a1 1 0 0 0-1.414 0L12 14.586l-1.293-1.293A1 1 0 0 0 9 14v16zm1 2h1v1H8zm0 4v-1h20v1zm20-4v1h-1v-1zM11 16.414l.293.293a1 1 0 0 0 1.414 0L14 15.414l1.293 1.293a1 1 0 0 0 1.414 0L18 15.414l1.293 1.293a1 1 0 0 0 1.414 0L22 15.414l1.293 1.293a1 1 0 0 0 1.414 0l.293-.293V33H11zM55 33H35a1 1 0 0 0-1 .917l-1 12A1 1 0 0 0 34 47h22a1 1 0 0 0 1-1.083l-1-12A1 1 0 0 0 55 33zm-.753 4H51v-2h3.08zM41 39h3v2h-3zm-2 2h-3.58l.167-2H39zm5-4h-3v-2h3zm2-2h3v2h-3zm-2 8v2h-3v-2zm2 0h3v2h-3zm0-2v-2h3v2zm5-2h3.413l.167 2H51zm-12-4v2h-3.247l.167-2zm-3.746 8H39v2h-3.913zM51 45v-2h3.746l.167 2zM7 50h54v2H7zM3 50h2v2H3zM34 21h22a1 1 0 0 0 1-1V9h-2v10H35V5h20v2h2V4a1 1 0 0 0-1-1H34a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1zM19 54a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h26a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1zm25 4H20v-2h24z" />
                                    <path
                                        d="M13 18h2v2h-2zM17 18h2v2h-2zM13 21h2v2h-2zM17 21h2v2h-2zM13 25h10v2H13zM13 29h10v2H13zM37 7h2v2h-2zM41 7h2v2h-2zM37 10h2v2h-2zM41 10h2v2h-2z" />
                                </g>
                            </svg>
                        </div>
                        <span class="mx-2">{{ __('lang.sells') }}</span>
                    </a>
                </li>
            @endif
            {{-- @endcan --}}
            {{-- ###################### Purchases : المشتريات ###################### --}}
            {{-- @can('stock_module') --}}
            @if (!empty($module_settings['stock_module']))
                <li class="scroll mx-2 mb-3 p-0">
                    <a class="purchases-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                        style="cursor: pointer">
                        <div style="width: 25px">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 100%" viewBox="0 0 512 512"
                                style="enable-background:new 0 0 512 512" xml:space="preserve">
                                <path style="fill:#ff5948" d="M222.584 82.202h84.093v58.734h-84.093z" />
                                <path style="fill:#d44a3c" d="M222.584 82.202h20.898v58.734h-20.898z" />
                                <path style="fill:#ff5948" d="M333.312 82.202h84.093v58.734h-84.093z" />
                                <path style="fill:#d44a3c" d="M333.312 82.202h20.898v58.734h-20.898z" />
                                <path style="fill:#cca38d" d="M40.42 164.122h431.156v265.676H40.42z" />
                                <path style="fill:#a68472" d="M40.42 164.122h20.898v265.676H40.42z" />
                                <path style="fill:#5e5456" d="M199.576 201.394h239.282v228.404H199.576z" />
                                <path style="fill:#ff5948"
                                    d="M199.576 201.394h239.282v41.788H199.576zM84.02 243.179h84.093v186.619H84.02z" />
                                <path style="fill:#d44a3c" d="M84.02 243.179h20.898v186.619H84.02z" />
                                <path style="fill:#ff5948" d="M8.662 225.771h43.886v85.68H8.662z" />
                                <path style="fill:#ffd359" d="M20.126 130.341h471.751v50.153H20.126z" />
                                <path style="fill:#db9840" d="M20.126 130.341h20.898v50.153H20.126z" />
                                <path style="fill:#cca38d"
                                    d="M307.475 429.801h-72.379c-.65 0-1.177-.527-1.177-1.177v-75.317c0-.65.527-1.177 1.177-1.177h72.379c.65 0 1.177.527 1.177 1.177v75.317a1.178 1.178 0 0 1-1.177 1.177z" />
                                <path style="fill:#a68472"
                                    d="M254.816 428.624v-75.317c0-.65.527-1.177 1.177-1.177h-20.898c-.65 0-1.177.527-1.177 1.177v75.317c0 .65.527 1.177 1.177 1.177h20.898a1.178 1.178 0 0 1-1.177-1.177z" />
                                <path style="fill:#cca38d"
                                    d="M402.912 429.801h-72.379c-.65 0-1.177-.527-1.177-1.177v-75.317c0-.65.527-1.177 1.177-1.177h72.379c.65 0 1.177.527 1.177 1.177v75.317a1.178 1.178 0 0 1-1.177 1.177z" />
                                <path style="fill:#a68472"
                                    d="M350.253 428.624v-75.317c0-.65.527-1.177 1.177-1.177h-20.898c-.65 0-1.177.527-1.177 1.177v75.317c0 .65.527 1.177 1.177 1.177h20.898c-.65 0-1.177-.527-1.177-1.177z" />
                                <path style="fill:#cca38d"
                                    d="M402.912 352.131h-72.379c-.65 0-1.177-.527-1.177-1.177v-75.317c0-.65.527-1.177 1.177-1.177h72.379c.65 0 1.177.527 1.177 1.177v75.317a1.178 1.178 0 0 1-1.177 1.177z" />
                                <path style="fill:#a68472"
                                    d="M350.253 350.954v-75.317c0-.65.527-1.177 1.177-1.177h-20.898c-.65 0-1.177.527-1.177 1.177v75.317c0 .65.527 1.177 1.177 1.177h20.898c-.65 0-1.177-.527-1.177-1.177z" />
                                <path
                                    d="M283.194 96.497h-37.616c-4.328 0-7.837 3.512-7.837 7.844s3.509 7.844 7.837 7.844h37.616c4.328 0 7.837-3.512 7.837-7.844 0-4.332-3.509-7.844-7.837-7.844zM393.927 96.497H356.31c-4.328 0-7.837 3.512-7.837 7.844s3.509 7.844 7.837 7.844h37.616c4.328 0 7.837-3.512 7.837-7.844 0-4.332-3.509-7.844-7.836-7.844z" />
                                <ellipse cx="143.496" cy="323.5" rx="7.837" ry="7.844" />
                                <path
                                    d="M504.163 422.123H479.42V291.559c0-4.332-3.509-7.844-7.837-7.844-4.328 0-7.837 3.512-7.837 7.844V422.12h-17.053V201.338c0-4.332-3.509-7.844-7.837-7.844h-239.28c-4.328 0-7.837 3.512-7.837 7.844V422.12h-15.794V243.165c0-4.332-3.509-7.844-7.837-7.844H84.015c-4.328 0-7.837 3.512-7.837 7.844V422.12H48.253V319.349h4.295c4.328 0 7.837-3.512 7.837-7.844v-85.763c0-4.332-3.509-7.844-7.837-7.844h-4.295v-29.639h415.493v64.497c0 4.332 3.509 7.844 7.837 7.844 4.328 0 7.837-3.512 7.837-7.844v-64.497h12.454c4.328 0 7.837-3.512 7.837-7.844v-50.201c0-4.332-3.509-7.844-7.837-7.844h-66.632V82.032c0-4.332-3.509-7.844-7.837-7.844h-84.093c-4.328 0-7.837 3.512-7.837 7.844v40.337h-10.961V82.032c0-4.332-3.509-7.844-7.837-7.844h-84.093c-4.328 0-7.837 3.512-7.837 7.844v40.337h-63.412c-4.328 0-7.837 3.512-7.837 7.844 0 4.332 3.509 7.844 7.837 7.844h71.167c.027 0 .053.004.08.004.027 0 .053-.004.08-.004h83.931c.027 0 .053.004.08.004.027 0 .053-.004.08-.004h26.472c.027 0 .053.004.08.004.027 0 .053-.004.08-.004h83.931c.027 0 .053.004.08.004s.053-.004.08-.004h66.551v34.512h-12.374c-.027 0-.053-.004-.08-.004s-.053.004-.08.004H40.498c-.027 0-.053-.004-.08-.004-.027 0-.053.004-.08.004H27.963v-34.512h82.797c4.328 0 7.837-3.512 7.837-7.844 0-4.332-3.509-7.844-7.837-7.844H20.126c-4.328 0-7.837 3.512-7.837 7.844v50.201c0 4.332 3.509 7.844 7.837 7.844H32.58v29.639H8.663c-4.328 0-7.837 3.512-7.837 7.844v23.458c0 4.332 3.509 7.844 7.837 7.844s7.837-3.512 7.837-7.844v-15.614h28.212v70.074H16.5v-17.331c0-4.332-3.509-7.844-7.837-7.844s-7.837 3.512-7.837 7.844v25.175c0 4.332 3.509 7.844 7.837 7.844h23.918v102.775H7.837c-4.328 0-7.837 3.512-7.837 7.844 0 4.334 3.509 7.846 7.837 7.846H504.162c4.328 0 7.837-3.512 7.837-7.844.001-4.332-3.508-7.845-7.836-7.845zM341.149 89.877h68.42v32.492h-68.42V89.877zm-110.728 0h68.42v32.492h-68.42V89.877zm147.176 301.218 18.655-19.407v38.814l-18.655-19.407zm8.073 31.025h-37.895l18.948-19.712 18.947 19.712zm-18.948-42.338-18.951-19.715h37.903l-18.952 19.715zm-18.952-35.405 18.951-19.715 18.951 19.715H347.77zm8.076 46.718-18.655 19.407v-38.814l18.655 19.407zm40.405-58.34-18.655-19.407 18.655-19.407v38.814zm-29.529-30.72L347.77 282.32h37.903l-18.951 19.715zm-10.876 11.314-18.655 19.407v-38.814l18.655 19.407zM252.338 422.12l18.948-19.712 18.948 19.712h-37.896zm48.478-11.618-18.655-19.407 18.655-19.407v38.814zm-29.531-30.72-18.951-19.715h37.903l-18.952 19.715zm-10.875 11.313-18.655 19.407v-38.814l18.655 19.407zm-52.998-160.999H431.02v5.226H207.412v-5.226zm223.608-20.914v5.224H207.412v-5.224H431.02zm-223.608 41.829H431.02V422.12h-19.095V353.4c0-.183-.017-.362-.027-.541.007-.088.006-.176.01-.262a7.822 7.822 0 0 0 0-.749c-.004-.088-.004-.176-.01-.262.01-.18.027-.358.027-.541v-75.389c0-.183-.017-.362-.027-.541a7.829 7.829 0 0 0-8.389-8.451c-.199-.014-.396-.03-.597-.03h-72.38c-.202 0-.399.017-.598.03a7.829 7.829 0 0 0-8.388 8.451c-.01.18-.027.358-.027.541v75.389c0 .183.017.362.027.541-.007.088-.006.176-.01.262a7.815 7.815 0 0 0 0 .749c.004.088.004.176.01.262-.01.18-.027.358-.027.541v68.72h-5.029V353.4c0-.183-.017-.362-.027-.541a7.829 7.829 0 0 0-8.388-8.451c-.199-.014-.396-.03-.599-.03h-72.38c-.202 0-.4.017-.599.03a7.829 7.829 0 0 0-8.388 8.451c-.01.18-.027.358-.027.541v68.72h-18.668V251.011zm-115.56 0h68.42V422.12h-68.42V251.011z" />
                            </svg>
                        </div>
                        {{-- <img
                            src="{{ asset('images/topbar/warehouse.png') }}" class="img-fluid pl-1"
                            alt="components"> --}}
                        <span class="mx-2">{{ __('lang.stock') }}</span>
                    </a>
                </li>
            @endif
            @if (!empty($module_settings['stock_module']))
                <li class="scroll mx-2 mb-3 p-0">
                    <a class="initial-balance-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                        style="cursor: pointer">
                        <span style="width: 25px;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 100%" viewBox="0 0 60 60">
                                <g data-name="19-Warehouse">
                                    <rect x="18" y="42" width="8" height="4" rx="1" ry="1"
                                        style="fill:#f2f2f2" />
                                    <path
                                        d="M32 38v12a3 3 0 0 1-3 3H15a3 3 0 0 1-3-3V38h20zm-6 7v-2a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1z"
                                        style="fill:#e3a76f" />
                                    <path d="M34 34v3a1 1 0 0 1-1 1h-6l5-5h1a1 1 0 0 1 1 1z" style="fill:#f2f2f2" />
                                    <path style="fill:#c18f5f" d="m32 33-5 5h-5l5-5h5z" />
                                    <path style="fill:#f2f2f2" d="m27 33-5 5h-5l5-5h5z" />
                                    <path style="fill:#c18f5f" d="m22 33-5 5h-5l5-5h5z" />
                                    <path d="m17 33-5 5h-1a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1z" style="fill:#f2f2f2" />
                                    <path style="fill:#c39160" d="M12 38h20v3H12z" />
                                    <g data-name="&lt;Group&gt;">
                                        <path
                                            d="M54 27v29a3 3 0 0 1-3 3H9a3 3 0 0 1-3-3V27zM34 37v-3a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h1v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V38h1a1 1 0 0 0 1-1z"
                                            style="fill:#65b1fc" />
                                        <path
                                            d="M59 19v4a4 4 0 0 1-4 4H5a4 4 0 0 1-4-4v-4zm-4 4a1 1 0 1 0-1 1 1 1 0 0 0 1-1zm-4 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1zm-4 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1zm-4 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1zm-4 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1zm-4 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1zm-4 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1zm-4 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1zm-4 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1zm-4 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1zm-4 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1zm-4 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1zm-4 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1z"
                                            style="fill:#bec3d2" />
                                        <path style="fill:#dce1eb" d="M36 1h4l19 18H1L20 1h16z" />
                                        <circle cx="54" cy="23" r="1" style="fill:#7e8596" />
                                        <circle cx="50" cy="23" r="1" style="fill:#7e8596" />
                                        <circle cx="46" cy="23" r="1" style="fill:#7e8596" />
                                        <circle cx="42" cy="23" r="1" style="fill:#7e8596" />
                                        <circle cx="38" cy="23" r="1" style="fill:#7e8596" />
                                        <circle cx="34" cy="23" r="1" style="fill:#7e8596" />
                                        <circle cx="30" cy="23" r="1" style="fill:#7e8596" />
                                        <circle cx="26" cy="23" r="1" style="fill:#7e8596" />
                                        <circle cx="22" cy="23" r="1" style="fill:#7e8596" />
                                        <circle cx="18" cy="23" r="1" style="fill:#7e8596" />
                                        <circle cx="14" cy="23" r="1" style="fill:#7e8596" />
                                        <circle cx="10" cy="23" r="1" style="fill:#7e8596" />
                                        <circle cx="6" cy="23" r="1" style="fill:#7e8596" />
                                        <path style="fill:#bec3d2"
                                            d="m20 1-2 1.895V19h6V1h-4zM1 19h11V8.579L1 19zM42 2.895V19h6V8.579l-6-5.684zM30 1h6v18h-6z" />
                                        <path style="fill:#4a98f7" d="M6 27h48v3H6z" />
                                        <path
                                            d="M11 39v11a4 4 0 0 0 4 4h14a4 4 0 0 0 4-4V39a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H11a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2zm8.586-5-3 3h-2.172l3-3zm5 0-3 3h-2.172l3-3zm5 0-3 3h-2.172l3-3zM31 50a2 2 0 0 1-2 2H15a2 2 0 0 1-2-2V39h18zm2-13h-3.586l3-3H33zm-22-3h3.586l-3 3H11z"
                                            style="fill:#2b1505" />
                                        <path
                                            d="M25 41h-6a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2zm0 4h-6v-2h6z"
                                            style="fill:#2b1505" />
                                        <path
                                            d="M59.919 18.607c-.008-.019-.026-.033-.035-.052a1.025 1.025 0 0 0-.189-.27l-.007-.011-19-18A1 1 0 0 0 40 0H20a1 1 0 0 0-.688.274l-19 18-.007.011a1.025 1.025 0 0 0-.189.27c-.009.019-.027.033-.035.052A.994.994 0 0 0 0 19v4a5.006 5.006 0 0 0 5 5v28a4 4 0 0 0 4 4h42a4 4 0 0 0 4-4V28a5.006 5.006 0 0 0 5-5v-4a.994.994 0 0 0-.081-.393zM20.4 2H23v13a1 1 0 0 0 2 0V2h4v13a1 1 0 0 0 2 0V2h4v13a1 1 0 0 0 2 0V2h2.6L41 3.325V15a1 1 0 0 0 2 0V5.22l4 3.789V15a1 1 0 0 0 2 0v-4.1l7.49 7.1H3.51L11 10.9V15a1 1 0 0 0 2 0V9.009l4-3.789V15a1 1 0 0 0 2 0V3.325zM53 56a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V28h46zm2-30H5a3 3 0 0 1-3-3v-3h56v3a3 3 0 0 1-3 3z"
                                            style="fill:#2b1505" />
                                        <path
                                            d="M37 41h10.586l-1.293 1.293a1 1 0 1 0 1.414 1.414l3-3a1 1 0 0 0 0-1.414l-3-3a1 1 0 0 0-1.414 1.414L47.586 39H37a1 1 0 0 0 0 2zM36.293 48.707l3 3a1 1 0 0 0 1.414-1.414L39.414 49H49a1 1 0 0 0 0-2h-9.586l1.293-1.293a1 1 0 0 0-1.414-1.414l-3 3a1 1 0 0 0 0 1.414z"
                                            style="fill:#2b1505" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        {{-- <img
                            src="{{ asset('images/topbar/warehouse.png') }}" class="img-fluid pl-1"
                            alt="components"> --}}
                        <span class="mx-2">{{ __('lang.initial_balance') }}</span></a>
                </li>
            @endif
            {{-- @endcan --}}
            {{-- ###################### Purchase_Order : امر شراء ###################### --}}
            <li class="scroll mx-2 mb-3 p-0">
                <a class="purchases-order-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                    style="cursor: pointer">
                    <div style="width: 25px">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 100%" viewBox="0 0 48 48">
                            <g data-name="box exchange money">
                                <path
                                    d="M21 11a10 10 0 0 1-2 6c-5.76 7.67-18 3.54-18-6a10 10 0 0 1 4-8 10 10 0 0 1 16 8z"
                                    style="fill:#fc6" />
                                <path d="M21 11a10 10 0 0 1-2 6A10 10 0 0 1 5 3a10 10 0 0 1 16 8z"
                                    style="fill:#ffde76" />
                                <path style="fill:#edb996" d="M29 29h18v18H29z" />
                                <path d="M47 29c0 16.82-.1 16 0 16-7.54 0-15-5.64-15-16z" style="fill:#f6ccaf" />
                                <path style="fill:#a87e6b" d="M35 29h6v4h-6z" />
                                <path d="M41 29v3h-2a3 3 0 0 1-3-3z" style="fill:#be927c" />
                                <path
                                    d="M11 22A11 11 0 1 0 0 11a11 11 0 0 0 11 11zm0-20a9 9 0 1 1-9 9 9 9 0 0 1 9-9zM47 28H29a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V29a1 1 0 0 0-1-1zm-7 2v2h-4v-2zm6 16H30V30h4v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3h4z" />
                                <path
                                    d="M35 42h-2a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2zM11 14a1 1 0 0 1-1-1 1 1 0 0 0-1-1c-1.66 0-1.21 3 1 3.82a1 1 0 1 0 2 0A3 3 0 0 0 11 10a1 1 0 1 1 1-1 1 1 0 0 0 1 1c1.66 0 1.21-3-1-3.82a1 1 0 1 0-2 0A3 3 0 0 0 11 12a1 1 0 0 1 0 2zM24 44A20 20 0 0 1 4.08 25.49l.21.22a1 1 0 0 0 1.42-1.42l-2-2a1 1 0 0 0-1.42 0l-2 2a1 1 0 0 0 1.42 1.42l.34-.34A22 22 0 0 0 24 46a1 1 0 0 0 0-2zM24 4a20 20 0 0 1 19.92 18.51l-.21-.22a1 1 0 0 0-1.42 1.42c3.08 3.07 2.33 3.09 5.42 0a1 1 0 0 0-1.42-1.42l-.34.34A22 22 0 0 0 24 2a1 1 0 0 0 0 2z" />
                            </g>
                        </svg>
                    </div>
                    {{-- <img src="{{ asset('images/topbar/warehouse.png') }}" class="img-fluid pl-1" alt="components"> --}}
                    <span class="mx-2">{{ __('lang.purchase_order') }}</span>
                </a>
                {{-- <ul class="dropdown-menu"> --}}
                {{-- +++++++++++ purchase_order : index +++++++++++ --}}
                {{-- <li>
                            <a href="{{route('purchase_order.index')}}">
                                <i class="mdi mdi-circle"></i>{{__('lang.show_purchase_order')}}
                            </a>
                        </li> --}}
                {{-- +++++++++++ purchase_order : create +++++++++++ --}}
                {{-- <li>
                            <a href="{{route('purchase_order.create')}}">
                                <i class="mdi mdi-circle"></i>{{__('lang.create_purchase_order')}}
                            </a>
                        </li> --}}
                {{-- </ul> --}}
            </li>
            {{-- ###################### Returns : المرتجعات ###################### --}}
            {{-- @can('return_module')  --}}
            @if (!empty($module_settings['return_module']))
                <li class="scroll mx-2 mb-3 p-0 dropdown">
                    <a href="javaScript:void();"
                        class="d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                        data-toggle="dropdown">
                        {{-- <img src="{{ asset('images/topbar/return.png') }}" class="img-fluid pl-1" alt="pages"> --}}
                        <div style="width: 25px">
                            <svg version="1.1" id="Layer_1" style="width: 100%"
                                xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 64 64"
                                style="enable-background:new 0 0 64 64" xml:space="preserve">
                                <style>
                                    .st1 {
                                        fill: #81d4fa;
                                        stroke: #0277bd;
                                        stroke-linecap: round;
                                        stroke-linejoin: round;
                                        stroke-miterlimit: 10
                                    }
                                </style>
                                <g id="Easy_Returns">
                                    <path class="st1"
                                        d="M32 61.5C17.4 61.5 5.5 49.6 5.5 35c0-.8.7-1.5 1.5-1.5s1.5.7 1.5 1.5C8.5 48 19 58.5 32 58.5S55.5 48 55.5 35 45 11.5 32 11.5c-.8 0-1.5-.7-1.5-1.5s.7-1.5 1.5-1.5c14.6 0 26.5 11.9 26.5 26.5S46.6 61.5 32 61.5z" />
                                    <path class="st1"
                                        d="M35 17.5c-.4 0-.8-.1-1.1-.4l-6-6c-.6-.6-.6-1.5 0-2.1l6-6c.6-.6 1.5-.6 2.1 0 .6.6.6 1.5 0 2.1L31.1 10l4.9 4.9c.6.6.6 1.5 0 2.1-.2.4-.6.5-1 .5z" />
                                    <path d="M46 48.5H18c-.6 0-1-.4-1-1v-17h30v17c0 .6-.4 1-1 1z"
                                        style="fill:#ffa726;stroke:#0277bd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10" />
                                    <path d="M19 46.5h26"
                                        style="fill:none;stroke:#f57c00;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10" />
                                    <path d="M19 32.5h26"
                                        style="fill:none;stroke:#ffcc80;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10" />
                                    <path
                                        style="fill:#eee;stroke:#0277bd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10"
                                        d="M20 40.5h6v4h-6z" />
                                    <path
                                        d="M16 22.5v7c0 .6.4 1 1 1h30c.6 0 1-.4 1-1v-7c0-.6-.4-1-1-1H17c-.6 0-1 .4-1 1z"
                                        style="fill:#ec407a;stroke:#0277bd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10" />
                                    <path d="M18 23.5h28"
                                        style="fill:none;stroke:#f48fb1;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10" />
                                    <path d="M18 28.5h28"
                                        style="fill:none;stroke:#d81b60;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10" />
                                </g>
                            </svg>
                        </div>
                        <span class="mx-2">{{ __('lang.returns') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="return-button" style="cursor: pointer"><i
                                    class="mdi mdi-circle"></i>@lang('lang.sells_return')</a></li>
                    </ul>
                </li>
            @endif
            {{-- @endcan  --}}
            {{-- ###################### Employees : الموظفين ###################### --}}
            {{-- @can('employee_module')  --}}
            @if (!empty($module_settings['employee_module']))
                <li class="dropdown scroll mx-2 mb-3 p-0 ">
                    <a href=""
                        class="d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {{-- <img
                            src="{{ asset('images/topbar/employee.png') }}" class="img-fluid pl-1"
                            alt="widgets"> --}}
                        <div style="width: 25px">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 100%" viewBox="0 0 48 48">
                                <defs>
                                    <style>
                                        .cls-1 {
                                            fill: #dad7e5
                                        }

                                        .cls-4 {
                                            fill: #f6ccaf
                                        }

                                        .cls-5 {
                                            fill: #db5669
                                        }

                                        .cls-6 {
                                            fill: #f26674
                                        }
                                    </style>
                                </defs>
                                <g id="professional_employee" data-name="professional employee">
                                    <path class="cls-1"
                                        d="M47 39.08V47H1c0-7.51-.75-11.39 3-15.06 2.07-2 3.08-2.08 14-5.94l6 6 6-6 10.33 3.65A10 10 0 0 1 47 39.08z" />
                                    <path
                                        d="M47 39.08V45H17.06A13.06 13.06 0 0 1 4 31.94c2.07-2 3.08-2.08 14-5.94l6 6 6-6 10.33 3.65A10 10 0 0 1 47 39.08z"
                                        style="fill:#edebf2" />
                                    <path d="M30 22.29V26l-6 6-6-6v-3.71a8 8 0 0 0 12 0z" style="fill:#edb996" />
                                    <path class="cls-4"
                                        d="M28.35 27.65 24 32l-4-4a1.49 1.49 0 0 1 2.21-1.3c2.19 1.19 3.79 1.69 6.14.95z" />
                                    <path class="cls-5" d="M29 47H19l2-9h6c1.79 8 1.41 6.34 2 9z" />
                                    <path class="cls-6" d="M28.56 45c-4.29 0-6.78-3.5-6-7H27z" />
                                    <path class="cls-4"
                                        d="M32 13c0 4 .32 6.06-1.44 8.57a8 8 0 0 1-12.56.72C15.58 19.54 16 17 16 13a13.37 13.37 0 0 0 11-5 5 5 0 0 0 5 5z" />
                                    <path
                                        d="M32 13c0 4 .32 6.06-1.44 8.57a8 8 0 0 1-10.22-.91C17.76 18.08 18 15.31 18 12.92a13.14 13.14 0 0 0 4.37-1.24A14 14 0 0 0 27 8a5 5 0 0 0 5 5z"
                                        style="fill:#ffdec7" />
                                    <path class="cls-4"
                                        d="M34 17h-2v-4h2a2 2 0 0 1 0 4zM14 17h2v-4h-2a2 2 0 0 0-2 2 2 2 0 0 0 2 2z" />
                                    <path
                                        d="M35 12v1h-3a5 5 0 0 1-5-5 13.28 13.28 0 0 1-4.63 3.68C19.13 13.25 16.76 13 13 13v-1a11 11 0 0 1 22 0z"
                                        style="fill:#be927c" />
                                    <path
                                        d="M19.6 11a2.81 2.81 0 0 1-2.7-3.61c.6-2 1.49-4.39 2.59-5.42A11 11 0 0 0 13 12v1c4.32 0 8.13.38 12.36-3.32A13.22 13.22 0 0 1 19.6 11z"
                                        style="fill:#a87e6b" />
                                    <path class="cls-1"
                                        d="m24 32-6 6-5.49-10.06L18 26l6 6zM35.49 27.94 30 38l-6-6 6-6 5.49 1.94z" />
                                    <path class="cls-5" d="M27 35v3h-6v-3l3-3 3 3z" />
                                    <path class="cls-6" d="M27 35v2h-2a3 3 0 0 1-3-3l2-2z" />
                                    <path class="cls-1" d="M1 47h18v1H1z" />
                                    <path class="cls-5" d="M19 47h10v1H19z" />
                                    <path class="cls-1" d="M29 47h18v1H29z" />
                                    <path
                                        d="M40.66 28.7 31 25.29v-2.65A8.9 8.9 0 0 0 32.94 18H34a3 3 0 0 0 2-5.22c0-17-24-17-24 0A3 3 0 0 0 14 18h1.06A8.9 8.9 0 0 0 17 22.64v2.65L7.34 28.7A11 11 0 0 0 0 39.08V47a1 1 0 0 0 2 0v-7.92a9 9 0 0 1 6-8.49L12.4 29c5.19 10.37 4.76 10 5.6 10 2 0 3.28-6.85 0 7.78a1 1 0 0 0 2 .44L21.8 39h4.4l1.8 8.22a1 1 0 0 0 2-.44c-2.27-10.18-2-8.7-2-9.37 2.87 2.87 2 2.92 7.6-8.41l4.4 1.59a9 9 0 0 1 6 8.49V47a1 1 0 0 0 2 0v-7.92a11 11 0 0 0-7.34-10.38zM24 30.59l-5-5v-1.11a9 9 0 0 0 10 0v1.11zM24 24a7 7 0 0 1-7-7v-3a14.23 14.23 0 0 0 9.39-3.85A6 6 0 0 0 31 13.91V17a7 7 0 0 1-7 7zm10-8h-1v-2h1a1 1 0 0 1 0 2zM24 2a10 10 0 0 1 10 10h-2a4 4 0 0 1-4-4 1 1 0 0 0-1.78-.62A12.36 12.36 0 0 1 16 12h-2A10 10 0 0 1 24 2zM14 14h1v2h-1a1 1 0 0 1 0-2zm4.27 22.31-4-7.94 3.44-1.22L22.59 32zM26 37h-4v-1.59l2-2 2 2zm3.73-.69L25.41 32l4.85-4.85 3.44 1.22z" />
                                    <path
                                        d="M8 45v2a1 1 0 0 0 2 0v-2a1 1 0 0 0-2 0zM38 45v2a1 1 0 0 0 2 0v-2a1 1 0 0 0-2 0z" />
                                </g>
                            </svg>
                        </div>
                        <span class="mx-2">{{ __('lang.employees') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a style="cursor: pointer" class="jobs-button"><i
                                    class="mdi mdi-circle"></i>@lang('lang.jobs')</a>
                        </li>
                        <li><a style="cursor: pointer" class="employees-button"><i
                                    class="mdi mdi-circle"></i>@lang('lang.employees')</a></li>
                        <li><a style="cursor: pointer" class="wages-button"><i
                                    class="mdi mdi-circle"></i>@lang('lang.wages')</a>
                        </li>
                    </ul>
                </li>
            @endif
            {{-- @endcan --}}
            {{-- ###################### Customers : العملاء ###################### --}}
            {{-- @can('customer_module')  --}}
            @if (!empty($module_settings['customer_module']))
                <li class="dropdown scroll mx-2 mb-3 p-0 ">
                    <a href="javaScript:void();"
                        class="d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                        data-toggle="dropdown">
                        {{-- <img src="{{ asset('images/topbar/customer-feedback.png') }}"
                            class="img-fluid pl-1" alt="layouts"> --}}
                        <div style="width: 25px">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 100%" viewBox="0 0 512 512"
                                style="enable-background:new 0 0 512 512" xml:space="preserve">
                                <path style="fill:#d29b6e"
                                    d="m346.254 181.348-40.666-15.25c-6.675-2.503-11.097-10.394-11.097-17.522h-68.409c0 7.128-4.422 15.019-11.097 17.522l-40.666 15.25a25.655 25.655 0 0 0-16.646 24.02v16.427c0 9.446 7.656 17.102 17.102 17.102h171.023c9.446 0 17.102-7.656 17.102-17.102v-16.427a25.656 25.656 0 0 0-16.646-24.02z" />
                                <path style="fill:#e4eaf6"
                                    d="m346.254 181.348-32.892-12.335-42.127 35.106a17.1 17.1 0 0 1-21.897 0l-42.127-35.106-32.892 12.335a25.655 25.655 0 0 0-16.646 24.02v16.427c0 9.446 7.656 17.102 17.102 17.102h171.023c9.446 0 17.102-7.656 17.102-17.102v-16.427a25.653 25.653 0 0 0-16.646-24.02z" />
                                <path style="fill:#f0c087"
                                    d="m317.713 44.497-5.336 80.037a25.653 25.653 0 0 1-10.205 18.817l-17.942 13.456a25.648 25.648 0 0 1-15.392 5.131h-17.102c-5.551 0-10.952-1.8-15.392-5.131l-17.942-13.457a25.655 25.655 0 0 1-10.205-18.817l-5.336-80.037c-1.316-19.741 14.343-36.479 34.13-36.479h46.594c19.785 0 35.443 16.738 34.128 36.48z" />
                                <path style="fill:#5a4146"
                                    d="M283.584 8.017H236.99c-19.786 0-35.446 16.738-34.129 36.479l2.127 31.91c2.941-.202 76.287-5.475 112.206-24.129l.518-7.78c1.316-19.742-14.342-36.48-34.128-36.48z" />
                                <path style="fill:#d29b6e"
                                    d="m217.987 446.434-40.666-15.25c-6.675-2.503-11.097-10.394-11.097-17.522h-68.41c0 7.128-4.422 15.019-11.097 17.522l-40.666 15.25a25.655 25.655 0 0 0-16.646 24.02v16.427c0 9.446 7.656 17.102 17.102 17.102H217.53c9.446 0 17.102-7.656 17.102-17.102v-16.427a25.653 25.653 0 0 0-16.645-24.02z" />
                                <path style="fill:#ff6464"
                                    d="M217.987 446.434 185.095 434.1l-42.127 35.106a17.1 17.1 0 0 1-21.897 0L78.943 434.1l-32.892 12.334a25.655 25.655 0 0 0-16.646 24.02v16.427c0 9.446 7.656 17.102 17.102 17.102H217.53c9.446 0 17.102-7.656 17.102-17.102v-16.427a25.651 25.651 0 0 0-16.645-24.02z" />
                                <path style="fill:#f0c087"
                                    d="m189.445 309.583-5.336 80.037a25.653 25.653 0 0 1-10.205 18.817l-17.942 13.456a25.648 25.648 0 0 1-15.392 5.131h-17.102c-5.551 0-10.952-1.8-15.392-5.131l-17.942-13.457a25.655 25.655 0 0 1-10.205-18.817l-5.336-80.037c-1.316-19.742 14.342-36.48 34.129-36.48h46.594c19.787 0 35.445 16.738 34.129 36.481z" />
                                <path style="fill:#7d5a50"
                                    d="M155.317 273.102h-46.594c-19.786 0-35.446 16.738-34.129 36.479l2.127 31.91c2.941-.202 76.287-5.475 112.206-24.129l.518-7.78c1.316-19.742-14.342-36.48-34.128-36.48z" />
                                <path style="fill:#5a4146"
                                    d="M397.105 273.102c-62.237 0-76.384 67.797-76.96 142.49-.024 3.108 1.881 5.907 4.8 7.215 9.997 4.479 22.118 8.033 35.643 10.342l72.822.036c13.61-2.309 25.805-5.877 35.854-10.378 2.919-1.308 4.824-4.107 4.8-7.215-.574-74.693-14.722-142.49-76.959-142.49z" />
                                <path style="fill:#d29b6e"
                                    d="M482.616 486.881v-10.766a25.655 25.655 0 0 0-12.926-22.274l-38.316-21.894a17.103 17.103 0 0 1-8.617-14.849V401.37H371.45v15.729a17.103 17.103 0 0 1-8.617 14.849l-38.316 21.894a25.653 25.653 0 0 0-12.926 22.274v10.766c0 9.446 7.656 17.102 17.102 17.102h136.818c9.449-.001 17.105-7.657 17.105-17.103z" />
                                <path style="fill:#f0c087"
                                    d="M439.86 341.511v45.333a25.655 25.655 0 0 1-12.455 21.998l-21.502 12.902a17.105 17.105 0 0 1-17.598 0l-21.502-12.902a25.654 25.654 0 0 1-12.455-21.998v-45.333s51.307 0 68.409-17.102l17.103 17.102z" />
                                <path style="fill:#ffd782"
                                    d="m469.691 453.842-24.963-14.264c-4.716 6.692-22.584 30.087-47.623 38.753-25.039-8.666-42.908-32.061-47.624-38.753l-24.963 14.264a25.654 25.654 0 0 0-12.926 22.274v10.766c0 9.446 7.656 17.102 17.102 17.102h136.818c9.446 0 17.102-7.656 17.102-17.102v-10.766a25.648 25.648 0 0 0-12.923-22.274z" />
                                <path
                                    d="m473.657 446.881-18.346-10.484c6.154-1.804 11.912-3.897 17.22-6.275 5.843-2.617 9.587-8.345 9.539-14.591-.345-44.811-5.585-78.3-16.017-102.38-13.816-31.894-37.018-48.065-68.958-48.065s-55.141 16.171-68.96 48.065c-4.095 9.451-7.386 20.36-9.899 32.826l-49.943-34.336v-64.726h77.495c13.851 0 25.119-11.268 25.119-25.119v-16.427c0-13.957-8.78-26.625-21.848-31.526l-40.666-15.25c-2.65-.994-4.644-3.171-5.474-5.79l4.053-3.04a33.636 33.636 0 0 0 13.393-24.696L325.7 45.03c.775-11.616-3.342-23.153-11.295-31.653C306.452 4.876 295.215 0 283.572 0h-46.594c-11.641 0-22.879 4.876-30.831 13.376-7.953 8.501-12.07 20.039-11.296 31.653l5.336 80.037a33.637 33.637 0 0 0 13.393 24.696l4.053 3.04a9.13 9.13 0 0 1-5.474 5.79l-40.666 15.25c-13.068 4.901-21.848 17.57-21.848 31.527v16.427c0 13.851 11.268 25.119 25.119 25.119h77.495v64.726l-57.565 39.576 2.74-41.101c.775-11.616-3.342-23.153-11.295-31.653-7.954-8.5-19.191-13.376-30.833-13.376h-46.594c-11.641 0-22.879 4.876-30.831 13.376-7.953 8.501-12.07 20.039-11.296 31.653l5.336 80.037a33.637 33.637 0 0 0 13.393 24.696l4.053 3.04a9.13 9.13 0 0 1-5.474 5.79l-40.666 15.25c-13.068 4.901-21.848 17.57-21.848 31.527v16.427c0 13.851 11.268 25.119 25.119 25.119H217.52c13.851 0 25.119-11.268 25.119-25.119v-16.427c0-13.957-8.78-26.625-21.848-31.526l-40.666-15.25c-2.65-.994-4.644-3.171-5.474-5.79l4.053-3.04a33.633 33.633 0 0 0 13.393-24.696l1.237-18.544 66.942-46.022 55.08 37.867c-2.016 15.334-3.088 32.639-3.239 52.078-.048 6.247 3.696 11.975 9.54 14.591 5.307 2.378 11.064 4.472 17.219 6.277l-18.344 10.483c-10.464 5.979-16.965 17.181-16.965 29.234v10.766c0 13.851 11.268 25.119 25.119 25.119h136.818c13.851 0 25.119-11.268 25.119-25.119v-10.766c-.001-12.056-6.502-23.258-16.966-29.237zM217.854 24.33c5.006-5.35 11.797-8.297 19.124-8.297h46.594c7.326 0 14.118 2.947 19.124 8.297 5.006 5.351 7.494 12.323 7.007 19.633l-.079 1.182c-27.248 15.519-81.868 21.52-97.167 22.935l-1.608-24.117c-.488-7.31 2-14.282 7.005-19.633zm-4.33 59.764c14.292-1.275 63.014-6.484 94.868-20.461l-2.109 31.631-.001.006c-.883 13.25-12.849 24.446-26.129 24.446h-19.877a8.017 8.017 0 0 0 0 16.034h19.877c8.494 0 16.544-2.698 23.299-7.268a17.606 17.606 0 0 1-6.099 8.456l-17.944 13.456a17.745 17.745 0 0 1-10.582 3.527h-17.102c-3.79 0-7.55-1.253-10.582-3.527L223.2 136.936a17.618 17.618 0 0 1-7.015-12.937l-2.661-39.905zm17.998 79.126a33.878 33.878 0 0 0 20.202 6.734h17.102a33.878 33.878 0 0 0 20.202-6.734l.814-.611a25.332 25.332 0 0 0 7.206 7.933l-36.774 24.516-36.774-24.517a25.319 25.319 0 0 0 7.206-7.933l.816.612zm-65.844 58.575v-16.427c0-7.31 4.599-13.947 11.444-16.513l28.764-10.786 49.943 33.295a8.008 8.008 0 0 0 8.894 0l49.943-33.295 28.764 10.786c6.845 2.566 11.445 9.203 11.445 16.513v16.427c0 5.01-4.076 9.086-9.086 9.086H174.765c-5.011 0-9.087-4.076-9.087-9.086zm-76.091 67.621c5.006-5.35 11.797-8.297 19.124-8.297h46.594c7.326 0 14.118 2.947 19.124 8.297 5.006 5.351 7.494 12.323 7.007 19.633l-.079 1.182c-27.248 15.519-81.868 21.52-97.167 22.935l-1.608-24.117c-.488-7.31 2-14.282 7.005-19.633zm137.018 181.038v16.427c0 5.01-4.076 9.086-9.086 9.086H46.497c-5.01 0-9.086-4.076-9.086-9.086v-16.427c0-7.31 4.599-13.947 11.444-16.513l29.138-10.926c9.545 20.996 30.64 34.781 54.015 34.781 23.374 0 44.47-13.784 54.015-34.782l29.137 10.926c6.846 2.567 11.445 9.204 11.445 16.514zm-55.516-33.348c-7.117 14.913-22.293 24.656-39.081 24.656-16.79 0-31.965-9.743-39.082-24.656a25.255 25.255 0 0 0 9.513-9.412l.816.611a33.878 33.878 0 0 0 20.202 6.734h17.102a33.878 33.878 0 0 0 20.202-6.734l.814-.611a25.265 25.265 0 0 0 9.514 9.412zm-2.005-35.084-17.942 13.457a17.745 17.745 0 0 1-10.582 3.527h-17.102c-3.79 0-7.55-1.253-10.582-3.527l-17.942-13.457a17.618 17.618 0 0 1-7.015-12.937l-2.66-39.906c14.292-1.275 63.014-6.484 94.867-20.461l-4.024 60.367a17.63 17.63 0 0 1-7.018 12.937zm254.186-.054-21.502 12.902a9.074 9.074 0 0 1-9.349 0l-21.502-12.902c-5.281-3.168-8.563-8.964-8.563-15.124v-37.557c5.317-.264 12.787-.818 20.909-1.977 16.975-2.425 29.989-6.522 38.836-12.211l9.733 9.733v42.013c.001 6.159-3.281 11.954-8.562 15.123zm-56.47 36.94c5.439-3.107 9.435-8.108 11.364-13.893l6.006 3.604c3.986 2.391 8.455 3.587 12.924 3.587s8.938-1.196 12.924-3.587l6.006-3.604c1.928 5.786 5.926 10.786 11.363 13.893l4.499 2.571c-4.001 5.367-17.024 21.366-34.79 28.327-17.669-6.934-30.765-22.962-34.787-28.33l4.491-2.568zm-38.649-23.448c.342-42.52 5.149-73.901 14.695-95.935 11.197-25.843 28.941-38.405 54.247-38.405s43.051 12.563 54.247 38.405c9.546 22.034 14.353 53.417 14.695 95.935a.65.65 0 0 1-.06.031c-8.754 3.922-19.426 7.093-30.998 9.254-2.603-1.66-4.214-4.542-4.214-7.647 0-.304-.02-.602-.053-.897l.808-.485c10.083-6.05 16.347-17.113 16.347-28.872v-45.333a8.014 8.014 0 0 0-2.348-5.668l-17.102-17.102a8.016 8.016 0 0 0-11.337 0c-5.652 5.652-18.4 10.152-35.895 12.67-14.252 2.051-26.724 2.084-26.846 2.084a8.017 8.017 0 0 0-8.017 8.017v45.333c0 11.759 6.264 22.823 16.347 28.872l.809.485a8.028 8.028 0 0 0-.053.896c0 3.105-1.611 5.987-4.214 7.647-11.57-2.16-22.246-5.334-30.998-9.254l-.06-.031zm146.438 71.421c0 5.01-4.076 9.086-9.086 9.086H328.685c-5.01 0-9.086-4.076-9.086-9.086v-10.766a17.674 17.674 0 0 1 8.887-15.313l19.811-11.321c3.49 4.939 20.836 27.978 46.263 36.454a7.997 7.997 0 0 0 5.07 0c25.427-8.475 42.772-31.514 46.263-36.454l19.811 11.32c5.481 3.133 8.887 9 8.887 15.313v10.767h-.002z" />
                            </svg>
                        </div>
                        <span class="mx-2">{{ __('lang.customers') }}</span>
                    </a>
                    <ul
                        class="dropdown-menu list-style-none @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        <li><a style="cursor: pointer" class="customers-button"><i
                                    class="mdi mdi-circle"></i>{{ __('lang.customers') }}</a></li>
                        <li><a style="cursor: pointer" class="customer-types-button"><i
                                    class="mdi mdi-circle"></i>{{ __('lang.customer_types') }}</a></li>
                    </ul>
                </li>
            @endif
            {{-- @endcan --}}
            {{-- ###################### customer_price_offer : عرض سعر للعملاء ###################### --}}
            {{-- @can('customer_module')  --}}
            @if (!empty($module_settings['customer_module']))
                <li class="scroll mx-2 mb-3 p-0 ">
                    <a class="customer-price-offer-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                        style="cursor: pointer">
                        {{-- <img src="{{ asset('images/topbar/customer-feedback.png') }}" class="img-fluid pl-1"
                            alt="layouts"> --}}
                        <div style="width: 25px">
                            <svg version="1.1" style="width: 100%" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 256 256"
                                style="enable-background:new 0 0 256 256" xml:space="preserve">
                                <style>
                                    .st0 {
                                        fill: #6dcc6d
                                    }

                                    .st1 {
                                        fill: #ffcd29
                                    }

                                    .st2 {
                                        fill: #55acd5
                                    }

                                    .st5 {
                                        fill: #e9e9ea
                                    }

                                    .st6 {
                                        fill: #f9d0b4
                                    }

                                    .st10 {
                                        fill: #231f20
                                    }
                                </style>
                                <g id="Layer_32">
                                    <path class="st0"
                                        d="M162.1 2.5H93.9c-9.2 0-16.6 7.5-16.6 16.6v29.1c0 9.2 7.5 16.6 16.6 16.6h17.6c2 0 4 1 5.1 2.7l9.9 15.1c.5.8 1.6 1 2.4.5.2-.1.4-.3.5-.5l9.9-15.1c1.1-1.7 3-2.7 5.1-2.7H162c9.2 0 16.6-7.5 16.6-16.6V19.1c.1-9.1-7.3-16.6-16.5-16.6z" />
                                    <path class="st1"
                                        d="M234.9 32.7h-49.8c-2.3 0-4.5.6-6.4 1.9v13.6c0 4.8-2.1 9.4-5.7 12.5v5.4c0 6.7 5.4 12.1 12.1 12.2H198c1.5 0 2.9.8 3.7 2l7.3 11c.4.6 1.2.7 1.8.4.1-.1.3-.2.4-.4l7.3-11c.8-1.2 2.2-2 3.7-2h12.9c6.7 0 12.1-5.4 12.1-12.2V44.9c-.2-6.7-5.6-12.1-12.3-12.2z" />
                                    <path class="st2"
                                        d="M77.3 48.2V34.6c-1.9-1.2-4.1-1.9-6.4-1.9H21.1C14.4 32.8 9 38.2 9 44.9v21.3c0 6.7 5.4 12.1 12.1 12.2H34c1.5 0 2.9.8 3.7 2l7.3 11c.4.6 1.2.7 1.8.4.1-.1.3-.2.4-.4l7.3-11c.8-1.2 2.2-2 3.7-2h12.9c6.7 0 12.1-5.4 12.2-12.2v-5.4c-3.9-3.2-6-7.8-6-12.6z" />
                                    <path
                                        d="M146.6 96.7c-2.5 0-4.9.7-7.1 2-2.5-4.2-7-6.7-11.8-6.8h-7.1c-13.8 0-24.9 11.2-25 25v11.2c2.2-1.8 5.1-2.5 7.8-2.1v-1.2c0-.7.6-1.3 1.3-1.3h.3c4.4.9 17.4 2.5 26.2-8.6.4-.6 1.3-.7 1.8-.2l.1.1c2 2 7.3 6 17.4 6.3.7 0 1.2.6 1.2 1.3v3.6c3.1-.5 6.3.5 8.6 2.7v-18.2c0-7.6-6.1-13.8-13.7-13.8z"
                                        style="fill:#6d6c6b" />
                                    <path
                                        d="M45.2 104.8c-14.8 0-26.7 12-26.8 26.8v18.5c0 3.8.8 7.7 2.4 11.1 1.1 2.5 3.6 4 6.3 4h10.3v-2c-6.4-3.2-10.4-9.8-10.3-17v-8.4c0-1.2 1-2.2 2.2-2.2h.7c5.6 0 10.9-2.5 14.4-6.9.8-.9 2.1-1.1 3.1-.3l.3.3c3.5 4.4 8.8 6.9 14.4 6.9 1.2 0 2.2.9 2.2 2.1v8.8c0 6.8-3.8 13.1-9.8 16.4v2.3h8.6c2.7 0 5.2-1.6 6.3-4 1.6-3.5 2.5-7.3 2.4-11.1v-18.5c0-14.8-12-26.8-26.7-26.8z"
                                        style="fill:#898989" />
                                    <path class="st5"
                                        d="M210 101.5c-14.3 0-26 10.9-26 24.3v8.3c1.3-.8 2.9-1.2 4.4-1.2.4 0 .9 0 1.3.1v-.5s5.6-3.1 5.6-7.9v-.1c0-2.2 1.8-3.9 3.9-3.9.3 0 .6 0 .9.1 6.5 1.4 13.2 1.4 19.6 0 2.1-.5 4.2.7 4.8 2.8.1.3.1.6.1.9v.1c0 4.7 5.6 7.9 5.6 7.9v.5c.4-.1.9-.1 1.3-.1 1.5 0 3.1.4 4.4 1.2v-8.3c.1-13.2-11.6-24.2-25.9-24.2z" />
                                    <path class="st6"
                                        d="M45.7 165.3c-2.9 0-5.7-.7-8.3-2v6.9l2.9 8.4c.2.5.6.8 1.2.8h9c.5 0 1-.3 1.2-.8l2.9-8.4V163c-2.7 1.5-5.8 2.3-8.9 2.3zM231.6 133c-.5 0-.9 0-1.4.1 0 .4.1.8.1 1.3v13.1c0 .4 0 .9-.1 1.3.4.1.9.1 1.4.1 4.4.3 8.2-3 8.5-7.4s-3-8.2-7.4-8.5c-.4-.1-.7-.1-1.1 0zM189.7 134.3c0-.4 0-.9.1-1.3-.4-.1-.9-.1-1.4-.1-4.4-.3-8.2 3-8.5 7.4s3 8.2 7.4 8.5h1.1c.5 0 .9 0 1.4-.1 0-.4-.1-.8-.1-1.3v-13.1z" />
                                    <path class="st6"
                                        d="M224.7 124.7v-.1c0-2.2-1.8-3.9-3.9-3.9-.3 0-.6 0-.9.1-6.5 1.4-13.2 1.4-19.6 0-2.1-.5-4.2.7-4.8 2.8-.1.3-.1.6-.1.9v.1c0 4.7-5.6 7.9-5.6 7.9V147c0 9.8 7.8 18.4 18.3 19.3 12 1.1 22.3-7.8 22.3-18.9v-14.9c-.1.1-5.7-3.1-5.7-7.8zM153.4 125.9c-.5 0-1.1 0-1.6.1 0 .5.1 1.1.1 1.6v16.7c0 .5 0 1.1-.1 1.6 5.5.9 10.7-2.8 11.6-8.3.9-5.5-2.8-10.7-8.3-11.6-.6-.1-1.2-.1-1.7-.1zM103.5 127.6c0-.5 0-1.1.1-1.6-5.5-.9-10.7 2.8-11.6 8.3s2.8 10.7 8.3 11.6c1.1.2 2.3.2 3.4 0 0-.5-.1-1.1-.1-1.6l-.1-16.7z" />
                                    <path class="st6"
                                        d="M151.8 122.4c0-.7-.6-1.2-1.2-1.3-10-.3-15.3-4.3-17.4-6.3-.5-.5-1.3-.5-1.8 0l-.1.1c-8.8 11.1-21.9 9.5-26.2 8.6-.7-.1-1.4.3-1.5 1v19.8c.1 13.4 11 24.1 24.3 24 13.2-.1 23.9-10.8 24-24v-21.5c-.1-.2-.1-.3-.1-.4z" />
                                    <path class="st6"
                                        d="M127.6 168.5c-3.7 0-7.4-.9-10.8-2.6v8.9l3.8 10.9c.2.6.8 1.1 1.5 1.1h11.7c.7 0 1.3-.4 1.5-1.1l3.8-10.9v-9.3c-3.5 2-7.4 3-11.5 3zM62.1 135.7c-5.6 0-10.9-2.5-14.5-6.9-.8-.9-2.1-1.1-3.1-.3l-.3.3c-3.5 4.4-8.8 6.9-14.4 6.9h-.6c-1.2 0-2.2.9-2.2 2.1v8.5c-.1 9.7 7.2 17.9 16.8 19 10.3 1 19.4-6.5 20.4-16.8.1-.6.1-1.2.1-1.7V138c.1-1.4-.9-2.3-2.2-2.3.1 0 0 0 0 0zM208 166.3c-2.3-.2-4.5-.8-6.6-1.7v5.7l2.9 8.4c.2.5.6.8 1.2.8h9c.5 0 1-.3 1.2-.8l2.9-8.4v-5.6c-3.3 1.3-7 1.9-10.6 1.6z" />
                                    <path class="st5"
                                        d="m179.4 246.9-3-53.1c-.2-4.2-3.1-7.7-7.2-8.7l-18.8-4.7-11.3-5.6-3.8 10.9c-.2.6-.8 1.1-1.5 1.1h-11.7c-.7 0-1.3-.4-1.5-1.1l-3.8-10.9-11.3 5.6-18.8 4.7c-4.1 1-7 4.6-7.2 8.7l-3 53.1c-.2 3.4 2.4 6.4 5.9 6.6H173c3.4 0 6.2-2.8 6.2-6.2.2-.1.2-.2.2-.4z" />
                                    <path
                                        d="m249.6 225.1-1.8-31.6c-.5-8.3-6.3-15.4-14.4-17.4l-6.1-1.5-8.7-4.3-2.9 8.4c-.2.5-.6.8-1.2.8h-9c-.5 0-1-.3-1.2-.8l-2.9-8.4-8.7 4.3-6.1 1.5c-6 1.5-10.8 5.8-13.1 11.5 1.7 1.7 2.8 3.9 2.9 6.3l2.1 37h65.7c3 0 5.5-2.4 5.5-5.5-.1-.1-.1-.2-.1-.3z"
                                        style="fill:#b26e3b" />
                                    <path
                                        d="m69.4 176-6.1-1.5-8.7-4.3-2.9 8.4c-.2.5-.6.8-1.2.8h-9c-.5 0-1-.3-1.2-.8l-2.9-8.4-8.7 4.3-6.1 1.5c-8.1 2-13.9 9.1-14.4 17.4L6.4 225c-.2 3 2.1 5.6 5.2 5.8h66l2.1-37c.1-2.4 1.2-4.7 2.9-6.3-2.4-5.7-7.2-10-13.2-11.5z"
                                        style="fill:#fc7783" />
                                    <path class="st1"
                                        d="M225 2c0-.2-.1-.3-.1-.5-.1-.1-.1-.3-.2-.4-.1-.1-.2-.3-.3-.4-1-1-2.5-1-3.5 0-.1.1-.2.2-.3.4-.1.1-.2.3-.2.4-.1.1-.1.3-.1.5s-.1.3-.1.5 0 .3.1.5c0 .2.1.3.1.5.1.2.1.3.2.4.1.1.2.3.3.4 1 .9 2.5.9 3.5 0 .1-.1.2-.2.3-.4.1-.1.2-.3.2-.4.1-.2.1-.3.1-.5s0-.3.1-.5c0-.2 0-.3-.1-.5z" />
                                    <path class="st2"
                                        d="M57 17.4c-.1-.3-.2-.6-.4-.9-.1-.1-.2-.3-.3-.4-1-.9-2.5-.9-3.5 0-.1.1-.2.2-.3.4-.1.1-.2.3-.2.4-.1.2-.1.3-.1.5-.1.3-.1.7 0 1 0 .2.1.3.1.5.1.1.1.3.2.4.1.1.2.3.3.4 1 1 2.5 1 3.5 0 .1-.1.2-.2.3-.4.1-.1.2-.3.2-.4.1-.1.1-.3.1-.5.2-.3.2-.7.1-1z" />
                                    <path
                                        d="M209.8 12.4c-3.8-.7-6.8-3.7-7.5-7.5 0-.1-.1-.2-.2-.1-.1 0-.1.1-.1.1-.7 3.8-3.7 6.8-7.5 7.5-.1 0-.2.1-.1.2 0 .1.1.1.1.1 3.8.7 6.8 3.7 7.5 7.5 0 .1.1.2.2.1.1 0 .1-.1.1-.1.7-3.8 3.7-6.8 7.5-7.5.1 0 .2-.1.1-.2 0 0 0-.1-.1-.1z"
                                        style="fill:#ea4647" />
                                    <path class="st0"
                                        d="M84.1 96.7h-1.8v-1.8c0-1.4-1.1-2.5-2.5-2.5s-2.5 1.1-2.5 2.5v1.8h-1.8c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5h1.8v1.8c0 1.4 1.1 2.5 2.5 2.5s2.5-1.1 2.5-2.5v-1.8h1.8c1.4 0 2.5-1.1 2.5-2.5s-1.1-2.5-2.5-2.5z" />
                                    <path class="st10"
                                        d="M162.1 0H93.9C83.4 0 74.8 8.6 74.8 19.1v29.1c0 10.6 8.6 19.1 19.1 19.1h17.6c1.2 0 2.3.6 3 1.6l9.9 15.1c1.3 1.9 3.9 2.5 5.9 1.2.5-.3.9-.7 1.2-1.2l9.9-15.1c.7-1 1.8-1.6 3-1.6H162c10.6 0 19.1-8.6 19.1-19.1V19.1c.1-10.5-8.5-19.1-19-19.1zm14.1 48.2c0 7.8-6.3 14.1-14.1 14.1h-17.6c-2.9 0-5.6 1.4-7.2 3.9L128 80.3l-9.3-14.1c-1.6-2.4-4.3-3.9-7.2-3.9H93.9c-7.8 0-14.1-6.3-14.1-14.1V19.1C79.8 11.3 86.1 5 93.9 5H162c7.8 0 14.1 6.3 14.1 14.1v29.1z" />
                                    <path class="st10"
                                        d="M234.9 30.2h-49.8c-2.7 0-5.4.8-7.8 2.2-.7.5-1.2 1.3-1.2 2.1v13.6c0 4.1-1.8 8-4.9 10.6-.5.5-.9 1.2-.9 1.9V66c0 8.1 6.6 14.6 14.6 14.7H198c.7 0 1.3.3 1.6.9l7.3 11c1.1 1.7 3.5 2.2 5.2 1.1.4-.3.8-.6 1.1-1.1l7.3-11c.4-.5 1-.9 1.6-.9H235c8.1 0 14.6-6.6 14.6-14.7V44.9c-.1-8.1-6.6-14.6-14.7-14.7zm9.6 35.9c0 5.3-4.3 9.6-9.6 9.7H222c-2.3 0-4.5 1.2-5.8 3.1l-6.2 9.4-6.2-9.4c-1.3-2-3.5-3.1-5.8-3.1h-12.9c-5.3 0-9.6-4.3-9.6-9.7v-4.3c3.7-3.6 5.7-8.5 5.7-13.6V36.1c1.2-.6 2.6-.9 3.9-.9h49.8c5.3 0 9.6 4.3 9.6 9.7v21.2zM84.7 58.9c-3.1-2.7-4.9-6.6-4.9-10.6V34.6c0-.9-.4-1.7-1.2-2.1-2.3-1.5-5-2.2-7.8-2.2H21.1c-8.1 0-14.6 6.6-14.6 14.6v21.3c0 8.1 6.6 14.6 14.6 14.7H34c.7 0 1.3.3 1.6.9l7.3 11c1.1 1.7 3.5 2.2 5.2 1.1.4-.3.8-.6 1.1-1.1l7.3-11c.4-.5 1-.9 1.6-.9H71c8.1 0 14.6-6.6 14.7-14.7v-5.4c-.2-.8-.5-1.5-1-1.9zm-4.2 7.2c0 5.3-4.3 9.6-9.7 9.7H58c-2.3 0-4.5 1.2-5.8 3.1L46 88.3l-6.2-9.4c-1.3-2-3.5-3.1-5.8-3.1H21.1c-5.3 0-9.6-4.3-9.6-9.7V44.9c0-5.3 4.3-9.6 9.6-9.7h49.8c1.4 0 2.7.3 3.9.9v12.1c0 5.1 2.1 10 5.7 13.6v4.3zM154.8 17.9l-54.5.2c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5l54.5-.2c1.4 0 2.5-1.1 2.5-2.5s-1.1-2.5-2.5-2.5zM154.9 31.1l-54.5.2c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5l54.5-.2c1.4 0 2.5-1.1 2.5-2.5s-1.1-2.5-2.5-2.5zM154.9 44.3l-54.5.2c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5l54.5-.2c1.4 0 2.5-1.1 2.5-2.5 0-1.3-1.1-2.4-2.5-2.5zM67.8 200.3c-1.4 0-2.5 1.1-2.5 2.5v28.1c0 1.4 1.1 2.5 2.5 2.5s2.5-1.1 2.5-2.5v-28.1c0-1.4-1.1-2.5-2.5-2.5zM23.6 200.3c-1.4 0-2.5 1.1-2.5 2.5v28.1c0 1.4 1.1 2.5 2.5 2.5s2.5-1.1 2.5-2.5v-28.1c0-1.4-1.1-2.5-2.5-2.5zM55.8 160.9c-.8-.5-1.7-.5-2.5 0-2.4 1.3-5 1.9-7.7 2-2.5 0-5-.6-7.2-1.7-1.2-.6-2.7-.1-3.4 1.1-.2.3-.3.7-.3 1.1v6.9c0 .3 0 .6.1.8l2.9 8.4c.5 1.5 1.9 2.5 3.5 2.5h9c1.6 0 3-1 3.5-2.5l2.9-8.4c.1-.3.1-.5.1-.8V163c.4-.9-.1-1.7-.9-2.1zm-3.7 8.9-2.5 7.2h-7.2l-2.5-7.2V167c4 1.1 8.2 1.1 12.2-.2v3zM231.6 130.5c-.6 0-1.2 0-1.7.1-1.3.2-2.2 1.3-2.1 2.6V148.5c-.1 1.3.8 2.5 2.1 2.7.6.1 1.1.1 1.7.1 6 0 11-4.7 11-10.4s-4.9-10.4-11-10.4zm1.2 15.7v-10.6c2.9.3 5.1 2.9 4.7 5.9-.2 2.4-2.2 4.4-4.7 4.7zM192.2 134.3v-1.1c.1-1.3-.8-2.5-2.1-2.7-.6-.1-1.1-.1-1.7-.1-6 0-11 4.7-11 10.4s4.9 10.4 11 10.4c.6 0 1.2 0 1.7-.1 1.3-.2 2.2-1.3 2.1-2.7v-14.1zm-5 11.9c-2.9-.3-5.1-2.9-4.7-5.9.3-2.5 2.2-4.5 4.7-4.7v10.6z" />
                                    <path class="st10"
                                        d="M231.5 130.4c-1.2-.7-4.3-3-4.3-5.7v-.1c0-1.9-.8-3.8-2.3-5-1.6-1.3-3.6-1.7-5.6-1.3-6.1 1.3-12.4 1.3-18.5 0-2-.5-4 0-5.6 1.3-1.5 1.2-2.4 3.1-2.3 5.1 0 2.7-3.1 5-4.3 5.7-.8.4-1.3 1.3-1.3 2.2V147c0 11.2 9 20.7 20.6 21.8.7.1 1.5.1 2.2.1 5.9 0 11.5-2.1 15.9-6.1 4.4-3.9 6.9-9.5 6.9-15.4v-14.9c-.1-.8-.6-1.7-1.4-2.1zm-3.7 17c0 4.5-2 8.7-5.3 11.7-3.9 3.5-9.1 5.2-14.2 4.7-9-.8-16-8.2-16-16.8v-13.1c2-1.4 5.6-4.7 5.6-9.2v-.2c0-.4.2-.7.5-1 .4-.3.9-.4 1.3-.3 6.8 1.5 13.9 1.5 20.8 0 .5-.1 1 0 1.3.3.3.2.5.6.5 1v.2c0 4.5 3.6 7.8 5.6 9.2l-.1 13.5zM231.8 200.3c-1.4 0-2.5 1.1-2.5 2.5v28.1c0 1.4 1.1 2.5 2.5 2.5s2.5-1.1 2.5-2.5v-28.1c0-1.4-1.1-2.5-2.5-2.5zM187.7 200.3c-1.4 0-2.5 1.1-2.5 2.5v28.1c0 1.4 1.1 2.5 2.5 2.5s2.5-1.1 2.5-2.5v-28.1c0-1.4-1.2-2.5-2.5-2.5zM181.9 246.8l-3-53.1c-.3-5.3-4-9.7-9.1-11l-18.5-4.7-11.1-5.4c-1.2-.6-2.7-.1-3.3 1.1 0 .1-.1.2-.1.3l-3.6 10.3h-10.4l-3.6-10.3c-.5-1.3-1.9-2-3.2-1.5-.1 0-.2.1-.3.1l-11.1 5.4-18.5 4.7c-5.1 1.3-8.8 5.7-9.1 11l-3 53.1c-.3 4.8 3.4 8.9 8.2 9.2H173c4.8 0 8.7-3.9 8.7-8.7.2-.2.2-.3.2-.5zm-6 3c-.7.7-1.7 1.2-2.7 1.2H82.8c-2.1 0-3.7-1.7-3.7-3.7v-.2l3-53.1c.2-3.1 2.3-5.7 5.3-6.4l18.8-4.7c.2 0 .3-.1.5-.2l8.8-4.3 2.9 8.3c.6 1.6 2.1 2.7 3.9 2.7H134c1.7 0 3.3-1.1 3.9-2.7l2.9-8.3 8.8 4.3c.2.1.3.1.5.2l18.8 4.7c3 .7 5.1 3.4 5.3 6.4l3 53.1c-.3 1-.6 2-1.3 2.7zM153.4 123.4c-.7 0-1.3.1-2 .2-1.3.2-2.2 1.3-2.1 2.6 0 .5.1 1 .1 1.5v16.7c0 .5 0 1-.1 1.5-.1 1.3.8 2.4 2.1 2.6 6.9 1.1 13.3-3.6 14.4-10.4s-3.6-13.3-10.4-14.4c-.7-.3-1.4-.3-2-.3zm.9 20.1v-15.1c4.2.5 7.1 4.3 6.6 8.5-.4 3.4-3.1 6.1-6.6 6.6zM106 127.6c0-.5 0-1 .1-1.5.1-1.3-.8-2.4-2.1-2.6-6.9-1.1-13.3 3.6-14.4 10.4-1.1 6.9 3.6 13.3 10.4 14.4.7.1 1.3.2 2 .2s1.3-.1 2-.2c1.3-.2 2.2-1.3 2.1-2.6 0-.5-.1-1-.1-1.5v-16.6zm-5 15.9c-4.2-.5-7.1-4.3-6.6-8.5.4-3.4 3.1-6.2 6.6-6.6v15.1z" />
                                    <path class="st10"
                                        d="M154.3 122.3c0-2-1.7-3.7-3.7-3.7-9.3-.3-14.1-4-15.7-5.6-1.5-1.5-3.9-1.4-5.4 0l-.3.3c-7.8 9.8-19.2 8.7-23.8 7.7-2-.4-4.1.9-4.5 2.9-.1.3-.1.5-.1.8v19.4c0 14.7 11.9 26.7 26.7 26.7s26.7-11.9 26.7-26.7v-21.5l.1-.3zm-5 22c0 12-9.7 21.7-21.7 21.7s-21.7-9.7-21.7-21.7v-18c5.3.8 17.6 1.4 26.4-8.8 2.8 2.4 8.1 5.6 16.9 6.1v20.7z" />
                                    <path class="st10"
                                        d="M146.6 94.2c-2.1 0-4.3.4-6.3 1.3-3.1-3.8-7.7-6-12.6-6.1h-7.1c-15.2 0-27.4 12.3-27.5 27.5v11.2c0 1.4 1.1 2.5 2.5 2.5.6 0 1.1-.2 1.6-.5 1.6-1.4 3.8-1.9 5.9-1.6 1.4.2 2.6-.7 2.9-2.1v-.1c5.3.8 17.6 1.4 26.5-8.8 2.8 2.4 8.1 5.6 16.9 6.1v2.4c0 1.4 1.1 2.5 2.5 2.5h.4c.4-.1.8-.1 1.2-.1 2 0 3.9.8 5.3 2.1 1 1 2.6.9 3.5-.1.4-.5.7-1.1.7-1.7v-18.2c-.1-9-7.4-16.3-16.4-16.3zm11.3 30c-1.1-.4-2.3-.7-3.6-.8v-1.1c0-2-1.7-3.7-3.7-3.7-9.3-.3-14.1-4-15.7-5.6-1.5-1.5-3.9-1.4-5.4 0l-.3.3c-7.8 9.8-19.2 8.7-23.8 7.7-1.1-.2-2.3 0-3.2.8-.5.4-.9.9-1.1 1.5-1.1.1-2.1.3-3.1.6v-7.1c0-12.4 10.1-22.4 22.5-22.5h7.1c4 0 7.7 2.1 9.7 5.5.7 1.2 2.2 1.6 3.4.9 5.3-3.2 12.3-1.5 15.5 3.8 1.1 1.8 1.6 3.8 1.6 5.9l.1 13.8zM129.8 198.4c-.6-.6-1.4-.8-2.3-.7-.2 0-.3.1-.5.1-.2.1-.3.1-.4.2-.1.1-.3.2-.4.3-.1.1-.2.2-.3.4-.1.1-.2.3-.2.4-.1.2-.1.3-.1.5-.1.3-.1.7 0 1 0 .2.1.3.1.5.1.1.1.3.2.4.1.1.2.3.3.4.1.1.2.2.4.3.1.1.3.2.4.2.2.1.3.1.5.1s.3.1.5.1c1.4 0 2.5-1.1 2.5-2.5 0-.6-.3-1.3-.7-1.7zM129.8 211.3c-.6-.6-1.4-.8-2.3-.7-.2 0-.3.1-.5.1-.1.1-.3.1-.4.2-.1.1-.3.2-.4.3-.1.1-.2.2-.3.4-.1.1-.2.3-.2.4-.1.2-.1.3-.1.5-.1.3-.1.7 0 1 0 .2.1.3.1.5.1.1.1.3.2.4.1.1.2.3.3.4.1.1.2.2.4.3.1.1.3.2.4.2.2.1.3.1.5.1s.3 0 .5.1c.7 0 1.3-.3 1.8-.7.9-1 .9-2.5 0-3.5zM129.8 224.2c-.6-.6-1.4-.8-2.3-.7-.2 0-.3.1-.5.1-.2.1-.3.1-.4.2-.1.1-.3.2-.4.3-.1.1-.2.2-.3.4-.1.1-.2.3-.2.4-.1.2-.1.3-.1.5-.1.3-.1.7 0 1 0 .2.1.3.1.5.1.1.1.3.2.4.1.1.2.3.3.4.1.1.2.2.4.3.1.1.3.2.4.2.2.1.3.1.5.1s.3 0 .5.1c.7 0 1.3-.3 1.8-.7.9-.9.9-2.5 0-3.5zM129.8 237.1c-.6-.6-1.4-.8-2.3-.7-.2 0-.3.1-.5.1-.2.1-.3.1-.4.2-.1.1-.3.2-.4.3-.1.1-.2.2-.3.4-.1.1-.2.3-.2.4-.1.2-.1.3-.1.5-.1.3-.1.7 0 1 0 .2.1.3.1.5.1.1.1.3.2.4.1.1.2.3.3.4.1.1.2.2.4.3.1.1.3.2.4.2.2.1.3.1.5.1h.5c1.4 0 2.5-1.1 2.5-2.5 0-.5-.3-1.1-.7-1.6zM156.3 214.6c-1.4 0-2.5 1.1-2.5 2.5v36.4c0 1.4 1.1 2.5 2.5 2.5s2.5-1.1 2.5-2.5v-36.4c0-1.4-1.1-2.5-2.5-2.5zM99 214.6c-1.4 0-2.5 1.1-2.5 2.5v36.4c0 1.4 1.1 2.5 2.5 2.5s2.5-1.1 2.5-2.5v-36.4c0-1.4-1.1-2.5-2.5-2.5zM140.4 163.4c-.8-.5-1.7-.5-2.5 0-3.2 1.7-6.7 2.6-10.3 2.6-3.4 0-6.7-.8-9.7-2.3-1.2-.6-2.7-.1-3.4 1.1-.2.3-.3.7-.3 1.1v8.9c0 .3 0 .6.1.8l3.8 10.9c.6 1.6 2.1 2.7 3.9 2.7h11.7c1.7 0 3.3-1.1 3.9-2.7l3.8-10.9c.1-.3.1-.5.1-.8v-9.3c.1-.9-.3-1.7-1.1-2.1zm-3.8 11-3.5 9.9h-10.4l-3.5-9.9v-4.8c5.6 1.8 11.7 1.7 17.3-.2l.1 5zM65.5 134.6c-.9-.9-2.1-1.4-3.4-1.4v2.5-2.5c-4.9 0-9.4-2.2-12.5-6-1.6-2-4.6-2.3-6.6-.7-.3.2-.5.4-.7.7-3.1 3.9-7.9 6.1-13 6-1.3-.1-2.5.4-3.4 1.3-.9.9-1.4 2.1-1.4 3.4v8.4c0 11 8.4 20.4 19.1 21.5.7.1 1.4.1 2 .1 11.7 0 21.2-9.5 21.2-21.2v-8.8c.1-1.3-.4-2.5-1.3-3.3zm-3.6 12c0 4.6-1.9 8.9-5.3 11.9-3.4 3.1-7.9 4.6-12.4 4.1-8.3-1-14.6-8.1-14.6-16.5v-8c6.3.1 12.4-2.7 16.4-7.5 3.9 4.7 9.7 7.5 15.9 7.5v8.5z" />
                                    <path class="st10"
                                        d="M45.2 102.3c-16.2 0-29.3 13.1-29.3 29.3v18.5c0 4.2.9 8.4 2.7 12.2 1.6 3.3 4.9 5.5 8.6 5.5h10.3c1.4 0 2.5-1.1 2.5-2.5v-2c0-.9-.5-1.8-1.4-2.2-5.5-2.9-9-8.6-9-14.9v-8c6.3.1 12.4-2.7 16.4-7.5 3.9 4.7 9.7 7.5 15.9 7.5v8.4c0 5.9-3.3 11.4-8.5 14.2-.8.4-1.3 1.3-1.3 2.2v2.3c0 1.4 1.1 2.5 2.5 2.5h8.6c3.7 0 7-2.1 8.6-5.5 1.8-3.8 2.7-8 2.7-12.2v-18.5c-.1-16.2-13.2-29.3-29.3-29.3zm24.2 47.8c0 3.5-.8 6.9-2.2 10.1-.7 1.6-2.3 2.6-4.1 2.6h-3.8c4.8-4 7.5-9.9 7.5-16.1v-8.8c0-1.2-.5-2.4-1.4-3.3-.9-.9-2.1-1.4-3.4-1.4-4.9 0-9.4-2.2-12.5-6-1.6-2-4.6-2.3-6.6-.7-.3.2-.5.4-.7.7-3.1 3.9-7.9 6.1-13 6-1.3-.1-2.5.4-3.4 1.3-.9.9-1.4 2.1-1.4 3.4v8.4c0 6.4 2.8 12.4 7.6 16.6h-5c-1.7 0-3.3-1-4.1-2.6-1.5-3.2-2.2-6.6-2.2-10.1v-18.5c0-13.4 10.9-24.3 24.3-24.3s24.3 10.9 24.3 24.3v18.4zM46 177c-1.4 0-2.5 1.1-2.5 2.5v11.2c0 1.4 1.1 2.5 2.5 2.5s2.5-1.1 2.5-2.5v-11.2c0-1.4-1.1-2.5-2.5-2.5zM223.1 198h-7.5c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5h7.5c1.4 0 2.5-1.1 2.5-2.5s-1.2-2.5-2.5-2.5zM210 99c-15.7 0-28.5 12-28.5 26.8v8.3c0 1.4 1.1 2.5 2.5 2.5.4 0 .9-.1 1.2-.3 1-.5 2.1-.8 3.2-.8.3 0 .6 0 .9.1 1.1.2 2.2-.4 2.7-1.5 1.9-1.4 5.8-4.7 5.8-9.4v-.2c0-.4.2-.7.5-1 .4-.3.9-.4 1.3-.3 6.8 1.5 13.9 1.5 20.8 0 .5-.1 1 0 1.3.3.3.2.5.6.5 1v.2c0 4.7 3.9 8 5.8 9.4.4 1 1.5 1.7 2.7 1.5.3 0 .6-.1.9-.1 1.1 0 2.2.3 3.2.8 1.2.7 2.7.3 3.4-.9.2-.4.3-.8.3-1.2v-8.3C238.5 111 225.7 99 210 99zm23.5 31.6c-.6-.1-1.2-.2-1.8-.2l-.1-.1c-1.2-.7-4.3-3-4.3-5.8 0-1.9-.8-3.8-2.3-5-1.6-1.3-3.7-1.8-5.6-1.3-6.1 1.3-12.4 1.3-18.5 0-2-.5-4 0-5.6 1.3-1.5 1.2-2.4 3.1-2.3 5.1 0 2.7-3.1 5-4.3 5.7l-.1.1c-.6 0-1.2.1-1.8.2v-4.8c0-12 10.5-21.8 23.5-21.8s23.5 9.8 23.5 21.8l-.3 4.8zM220 162.5c-.7-.5-1.6-.5-2.4-.2-2.9 1.3-6.2 1.8-9.4 1.5-2-.2-4-.7-5.8-1.5-1.3-.6-2.7 0-3.3 1.3-.1.3-.2.7-.2 1v5.7c0 .3 0 .6.1.8l2.9 8.4c.5 1.5 1.9 2.5 3.5 2.5h9c1.6 0 3-1 3.5-2.5l2.9-8.4c.1-.3.1-.5.1-.8v-5.6c.2-1-.2-1.8-.9-2.2zm-3.9 7.3-2.5 7.2h-7.2l-2.5-7.2v-1.7c1.3.3 2.6.6 3.9.7 2.8.3 5.6 0 8.3-.7v1.7zM219.9 148.4l-3.9-1.6c-1.9-.8-4.1-.4-5.6 1-.2.2-.5.2-.7 0-1.6-1.3-3.7-1.7-5.6-1l-3.9 1.6c-1.3.5-1.9 1.9-1.4 3.2.5 1.3 1.9 1.9 3.2 1.4l3.9-1.6c.2-.1.4 0 .5.1 2.1 1.8 5.1 1.8 7.2 0 .1-.1.3-.2.5-.1l3.9 1.6c1.3.5 2.7-.1 3.2-1.4.6-1.3 0-2.7-1.3-3.2z" />
                                    <path class="st10"
                                        d="m252.1 225-1.8-31.6c-.5-9.4-7.1-17.4-16.3-19.7l-5.9-1.5-8.5-4.2c-1.2-.6-2.7-.1-3.3 1.1 0 .1-.1.2-.1.3l-2.6 7.6h-7.2l-2.6-7.6c-.5-1.3-1.9-2-3.2-1.5-.1 0-.2.1-.3.1l-8.5 4.2-5.9 1.5c-6.7 1.7-12.2 6.5-14.8 13-.4.9-.1 2 .6 2.7 1.3 1.2 2 2.9 2.1 4.7l2.1 37c.1 1.3 1.2 2.4 2.5 2.4h65.7c4.4 0 8-3.6 8-8v-.5zm-5.8 2.5c-.6.6-1.3.9-2.2.9h-63.3l-1.9-34.7c-.1-2.4-1-4.7-2.5-6.6 2.2-4.3 6.1-7.4 10.8-8.6l6.1-1.5c.2 0 .3-.1.5-.2l6.2-3 2 5.8c.5 1.5 1.9 2.5 3.5 2.5h9c1.6 0 3-1 3.5-2.5l2-5.8 6.2 3c.2.1.3.1.5.2l6.1 1.5c7 1.8 12.1 7.9 12.5 15.1l1.8 31.6c.1.9-.2 1.7-.8 2.3zM84.8 186.6c-2.6-6.5-8.1-11.3-14.8-13l-5.9-1.5-8.5-4.2c-1.2-.6-2.7-.1-3.3 1.1 0 .1-.1.2-.1.3l-2.6 7.6h-7.2l-2.6-7.6c-.5-1.3-1.9-2-3.2-1.5-.1 0-.2.1-.3.1l-8.5 4.2-5.9 1.5c-9.2 2.3-15.8 10.3-16.3 19.7L3.9 225c-.2 4.4 3.1 8.2 7.5 8.4H77.5c1.3 0 2.4-1 2.5-2.4l2.1-37c.1-1.8.9-3.4 2.1-4.7.8-.7 1-1.7.6-2.7zm-7.7 7.1-1.9 34.7H11.9c-1.6 0-3-1.3-3-3v-.2l1.8-31.6c.4-7.3 5.5-13.4 12.5-15.1l6.1-1.5c.2 0 .3-.1.5-.2l6.2-3 2 5.8c.5 1.5 1.9 2.5 3.5 2.5h9c1.6 0 3-1 3.5-2.5l2-5.8 6.2 3c.2.1.3.1.5.2l6.1 1.5c4.7 1.2 8.6 4.3 10.8 8.6-1.5 1.9-2.4 4.2-2.5 6.6z" />
                                </g>
                            </svg>
                        </div>
                        <span class="mx-2">{{ __('lang.customer_price_offer') }}</span>
                    </a>
                </li>
            @endif
            {{-- @endcan --}}
            {{-- ###################### suppliers : الموردين ###################### --}}
            {{-- @can('supplier_module')  --}}
            @if (!empty($module_settings['supplier_module']))
                <li class="scroll mx-2 mb-3 p-0 ">
                    <a class="suppliers-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                        style="cursor: pointer">
                        {{-- <img
                            src="{{ asset('images/topbar/inventory.png') }}" class="img-fluid pl-1"
                            alt="widgets"> --}}
                        <div style="width: 25px">
                            <svg version="1.1" style="width: 100%" id="ecommerce_1_"
                                xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 115 115"
                                style="enable-background:new 0 0 115 115" xml:space="preserve">
                                <style>
                                    .st0 {
                                        fill: #ffeead
                                    }

                                    .st1 {
                                        fill: #c9b77d
                                    }

                                    .st2 {
                                        fill: #99734a
                                    }

                                    .st3 {
                                        fill: #ff6f69
                                    }

                                    .st4 {
                                        fill: #96ceb4
                                    }

                                    .st7 {
                                        fill: #71a58a
                                    }

                                    .st8 {
                                        fill: #ffcc5c
                                    }
                                </style>
                                <g id="supply_chain_management_1_">
                                    <path class="st3"
                                        d="M51.775 77.082h-1.187v11.081h3.207v-9.061a2.02 2.02 0 0 0-2.02-2.02z" />
                                    <path class="st8"
                                        d="M28.216 58.344H6.746a5.172 5.172 0 0 0-5.172 5.172v20.498a5.172 5.172 0 0 0 5.172 5.172h26.641v-25.67a5.171 5.171 0 0 0-5.171-5.172z" />
                                    <path class="st4"
                                        d="M28.216 58.343H6.746a5.173 5.173 0 0 0-5.172 5.172v.599h31.813v-.599a5.172 5.172 0 0 0-5.171-5.172z" />
                                    <path class="st3"
                                        d="M47.644 64.141H33.387v25.044h14.399a3.496 3.496 0 0 0 3.496-3.496V67.78a3.638 3.638 0 0 0-3.638-3.639z" />
                                    <path class="st4" d="M1.575 87.703h47.019v2.369H1.575z" />
                                    <path class="st4"
                                        d="M53.011 83.4H48.56c-.876 0-1.586.71-1.586 1.586v3.499c0 .876.71 1.586 1.586 1.586h4.451c.876 0 1.586-.71 1.586-1.586v-3.499c0-.875-.71-1.586-1.586-1.586zM6.089 83.4H1.637c-.876 0-1.586.71-1.586 1.586v3.499c0 .876.71 1.586 1.586 1.586h4.451c.876 0 1.586-.71 1.586-1.586v-3.499A1.585 1.585 0 0 0 6.089 83.4z" />
                                    <path class="st2"
                                        d="M46.897 67.729c-.945 0-1.672.79-1.541 1.675l.952 6.412c.108.726.765 1.266 1.541 1.266h3.433v-9.353h-4.385zM43.905 68.735c-.083-.577-.604-1.006-1.219-1.006h-5.483c-.68 0-1.23.521-1.23 1.163v7.027c0 .642.551 1.163 1.23 1.163h6.495c.746 0 1.32-.622 1.219-1.32l-1.012-7.027z" />
                                    <path class="st7"
                                        d="M21.124 89.098a6.51 6.51 0 0 0-12.434 0c-.297.957.447 1.925 1.449 1.925h9.536c1.002 0 1.746-.968 1.449-1.925z" />
                                    <circle class="st2" cx="14.907" cy="91.029" r="4.594" />
                                    <circle class="st0" cx="14.907" cy="91.029" r="1.709" />
                                    <g>
                                        <path class="st7"
                                            d="M46.621 89.098a6.51 6.51 0 0 0-12.434 0c-.297.957.447 1.925 1.448 1.925h9.536c1.004 0 1.747-.968 1.45-1.925z" />
                                        <circle class="st2" cx="40.405" cy="91.029" r="4.594" />
                                        <circle class="st0" cx="40.405" cy="91.029" r="1.709" />
                                    </g>
                                    <g>
                                        <path class="st7"
                                            d="M81.784 79.443c2.928-1.73 4.898-4.906 4.898-8.549 0-5.488-4.455-9.936-9.951-9.936s-9.951 4.449-9.951 9.936c0 3.6 1.924 6.744 4.796 8.487a7.757 7.757 0 0 0-2.725 5.904c0 .113.012.222.017.333a14.972 14.972 0 0 0 5.851 1.964c.178.021.358.035.537.049.404.032.809.062 1.222.062.525 0 1.044-.027 1.556-.08.191-.02.375-.059.563-.086a14.976 14.976 0 0 0 5.84-2.12c.001-.041.006-.081.006-.122a7.758 7.758 0 0 0-2.659-5.842zM110.153 79.443c2.928-1.73 4.898-4.906 4.898-8.549 0-5.488-4.455-9.936-9.951-9.936s-9.951 4.449-9.951 9.936c0 3.6 1.924 6.744 4.796 8.487a7.754 7.754 0 0 0-2.725 5.904c0 .113.012.222.017.333a14.972 14.972 0 0 0 5.851 1.964c.178.021.358.035.537.049.404.032.809.062 1.222.062.525 0 1.044-.027 1.556-.08.191-.02.375-.059.563-.086a14.976 14.976 0 0 0 5.84-2.12c.001-.041.006-.081.006-.122a7.755 7.755 0 0 0-2.659-5.842z" />
                                    </g>
                                    <g>
                                        <path class="st3"
                                            d="M97.302 84.917c-.37.216-.75.415-1.143.593-.438.2-.886.38-1.35.53.017.134.046.266.046.404 0 1.37-.887 2.546-2.174 3.143a4.436 4.436 0 0 1-.519.203l-.013.004a4.507 4.507 0 0 1-1.343.216c-.473 0-.921-.085-1.343-.216l-.013-.004a4.436 4.436 0 0 1-.519-.203c-1.287-.597-2.174-1.773-2.174-3.143 0-.165.03-.322.055-.48-.45-.154-.886-.334-1.312-.536a12.637 12.637 0 0 1-1.102-.59 9.956 9.956 0 0 0-3.573 7.648c0 .144.016.284.022.427a19.143 19.143 0 0 0 7.491 2.518c.228.027.458.045.688.063.518.042 1.036.079 1.564.079.673 0 1.337-.035 1.992-.102.244-.025.48-.076.721-.11a19.136 19.136 0 0 0 7.477-2.719c.001-.053.008-.104.008-.157a9.95 9.95 0 0 0-3.486-7.568z" />
                                        <path class="st1"
                                            d="M94.809 86.04a12.734 12.734 0 0 1-3.895.615c-.987 0-1.943-.124-2.865-.337a12.62 12.62 0 0 1-1.238-.354c-.025.159-.055.316-.055.48 0 1.37.887 2.546 2.174 3.143.167.077.339.146.519.203l.013.004c.422.131.87.216 1.343.216s.921-.085 1.343-.216l.013-.004c.18-.057.352-.126.519-.203 1.287-.597 2.174-1.773 2.174-3.143.002-.138-.027-.27-.045-.404z" />
                                        <circle class="st0" cx="90.915" cy="74.035" r="12.74" />
                                        <ellipse class="st2" cx="85.635" cy="77.58" rx="1.466"
                                            ry="1.885" />
                                        <ellipse class="st2" cx="95.198" cy="77.58" rx="1.466"
                                            ry="1.885" />
                                        <path class="st2"
                                            d="M90.915 61.294c-7.036 0-12.74 5.704-12.74 12.74 0 1.456.256 2.849.706 4.153l.008-.079c.039-.398.079-.797.175-1.184.145-.583.416-1.126.701-1.655a29.864 29.864 0 0 1 2.104-3.312c2.035-.086 4.101.004 6.126-.216 2.689-.293 5.336-1.216 7.595-2.69a9.438 9.438 0 0 0 3.601 4.789 9.16 9.16 0 0 0 2.185 1.088c.463 1.733.681 3.527.656 5.321a12.675 12.675 0 0 0 1.623-6.214c.001-7.037-5.703-12.741-12.74-12.741z" />
                                    </g>
                                    <g>
                                        <path class="st7"
                                            d="M95.348 32.408a.922.922 0 0 1-.309-1.21l1.922-3.507a.915.915 0 0 0-.896-1.351l-13.837 1.416a.916.916 0 0 0-.725 1.323l6.249 12.426a.916.916 0 0 0 1.621.029l1.492-2.721c.301-.548.984-.568 1.479-.185 4.203 3.245 6.704 9.414 2.684 16.748l-.017.03c-.455.825.447 1.741 1.254 1.255a13.067 13.067 0 0 0 4.763-4.932c3.556-6.486.993-14.821-5.68-19.321z" />
                                    </g>
                                    <g>
                                        <path class="st7"
                                            d="m74.47 96.911-13.905.333a.916.916 0 0 0-.72 1.453l1.822 2.512c.367.506.092 1.133-.465 1.417-4.731 2.411-11.377 2.033-16.287-4.738a.485.485 0 0 1-.02-.028c-.551-.764-1.765-.34-1.671.597a13.057 13.057 0 0 0 2.421 6.415c4.341 5.987 12.971 7.236 19.893 3.129a.922.922 0 0 1 1.226.238l2.348 3.238a.916.916 0 0 0 1.605-.232l4.639-13.113a.916.916 0 0 0-.886-1.221z" />
                                    </g>
                                    <g>
                                        <path class="st7"
                                            d="M35.432 27.495a13.078 13.078 0 0 0-6.779-1.028c-7.346.857-12.658 7.772-12.462 15.819a.924.924 0 0 1-.808.953l-3.972.463a.916.916 0 0 0-.583 1.513l9.167 10.461a.915.915 0 0 0 1.498-.175l6.513-12.29a.916.916 0 0 0-.915-1.339l-3.082.36c-.621.072-1.033-.474-1.008-1.099.212-5.306 3.793-10.917 12.101-11.886l.034-.004c.934-.105 1.159-1.371.296-1.748z" />
                                    </g>
                                    <g>
                                        <path class="st2"
                                            d="M46.058 14.038a.874.874 0 0 0-.874.874v3.886a.874.874 0 1 0 1.748 0v-3.886a.875.875 0 0 0-.874-.874zM72.744 14.038a.874.874 0 0 0-.874.874v3.886a.874.874 0 1 0 1.748 0v-3.886a.875.875 0 0 0-.874-.874z" />
                                        <path class="st3"
                                            d="M77.907 33.653a4.828 4.828 0 0 0-4.831-4.824l-26.683.021a4.828 4.828 0 0 0-4.824 4.831l.012 15.953a4.828 4.828 0 0 0 4.831 4.824l26.683-.02a4.828 4.828 0 0 0 4.824-4.831l-.012-15.954z" />
                                        <path
                                            d="M77.907 33.653a4.828 4.828 0 0 0-4.831-4.824l-26.683.021a4.828 4.828 0 0 0-4.824 4.831l.004 4.608c.23.048.468.073.713.073h1.145a3.5 3.5 0 0 0 3.501-3.501 3.501 3.501 0 0 0 3.501 3.501h1.145a3.5 3.5 0 0 0 3.501-3.501 3.501 3.501 0 0 0 3.501 3.501h1.145a3.5 3.5 0 0 0 3.501-3.501 3.501 3.501 0 0 0 3.501 3.501h1.145a3.5 3.5 0 0 0 3.501-3.501 3.501 3.501 0 0 0 3.501 3.501h1.145c.697 0 1.342-.209 1.888-.56v-4.149z"
                                            style="fill:#e05858" />
                                        <path class="st4"
                                            d="M40.748 19.033c-1.085 0-1.964.88-1.964 1.964v9.005h8.148V19.033h-6.184z" />
                                        <path class="st0" d="M46.932 19.033h8.148v10.969h-8.148z" />
                                        <path class="st4" d="M55.08 19.033h8.148v10.969H55.08z" />
                                        <path class="st0" d="M63.228 19.033h8.148v10.969h-8.148z" />
                                        <path class="st4"
                                            d="M77.56 19.033h-6.184v10.969h8.148v-9.005a1.964 1.964 0 0 0-1.964-1.964z" />
                                        <path class="st7"
                                            d="M38.784 30.003v2.249a3.501 3.501 0 0 0 3.501 3.501h1.145a3.501 3.501 0 0 0 3.501-3.501v-2.249h-8.147z" />
                                        <path class="st1"
                                            d="M46.932 30.003v2.249a3.501 3.501 0 0 0 3.501 3.501h1.145a3.501 3.501 0 0 0 3.501-3.501v-2.249h-8.147z" />
                                        <path class="st7"
                                            d="M55.08 30.003v2.249a3.501 3.501 0 0 0 3.501 3.501h1.145a3.501 3.501 0 0 0 3.501-3.501v-2.249H55.08z" />
                                        <path class="st1"
                                            d="M63.228 30.003v2.249a3.501 3.501 0 0 0 3.501 3.501h1.145a3.501 3.501 0 0 0 3.501-3.501v-2.249h-8.147z" />
                                        <path class="st7"
                                            d="M71.376 30.003v2.249a3.501 3.501 0 0 0 3.501 3.501h1.145a3.501 3.501 0 0 0 3.501-3.501v-2.249h-8.147z" />
                                        <path class="st0"
                                            d="M55.755 40.46h-4.173a2.36 2.36 0 0 0-2.36 2.36v11.628h8.892V42.819a2.358 2.358 0 0 0-2.359-2.359z" />
                                        <g>
                                            <path class="st7"
                                                d="M54.97 41.713h-2.603a1.78 1.78 0 0 0-1.78 1.78v10.955h6.162V43.493a1.779 1.779 0 0 0-1.779-1.78z" />
                                        </g>
                                        <g>
                                            <path class="st0"
                                                d="M72.094 40.917h-7.777a2.278 2.278 0 0 0-2.278 2.278v5.844a2.278 2.278 0 0 0 2.278 2.278h7.777a2.278 2.278 0 0 0 2.278-2.278v-5.844a2.278 2.278 0 0 0-2.278-2.278z" />
                                        </g>
                                        <g>
                                            <path class="st7"
                                                d="M71.418 42.009h-6.426c-1.011 0-1.831.82-1.831 1.831v4.554c0 1.011.82 1.831 1.831 1.831h6.426c1.011 0 1.831-.82 1.831-1.831V43.84c0-1.011-.82-1.831-1.831-1.831z" />
                                        </g>
                                        <g>
                                            <path class="st4"
                                                d="M71.432 42.009h-6.453c-.573 0-1.077.274-1.41.695l9.103 7.018c.354-.337.578-.812.578-1.343v-4.526c-.001-1.018-.814-1.844-1.818-1.844z" />
                                        </g>
                                        <g>
                                            <path class="st8"
                                                d="M73.344 3.145h-28.38a3.038 3.038 0 0 0-3.038 3.038v8.739a3.038 3.038 0 0 0 3.038 3.038h28.38a3.038 3.038 0 0 0 3.038-3.038v-8.74a3.038 3.038 0 0 0-3.038-3.037z" />
                                        </g>
                                        <g>
                                            <path class="st0"
                                                d="M71.658 5.049H46.65a2.438 2.438 0 0 0-2.438 2.438v6.129a2.438 2.438 0 0 0 2.438 2.438h25.009a2.438 2.438 0 0 0 2.438-2.438V7.487a2.439 2.439 0 0 0-2.439-2.438z" />
                                        </g>
                                        <g>
                                            <path class="st0" d="M67.72 41.644h1.035v8.96H67.72z" />
                                        </g>
                                        <g>
                                            <path class="st3"
                                                d="M69.503 8.178h-19.59c-.379 0-.69.31-.69.69 0 .38.31.69.69.69h19.59c.379 0 .69-.31.69-.69a.693.693 0 0 0-.69-.69z" />
                                        </g>
                                        <g>
                                            <path class="st3"
                                                d="M69.503 11.628h-19.59a.693.693 0 0 0-.69.69c0 .38.31.69.69.69h19.59c.379 0 .69-.31.69-.69a.693.693 0 0 0-.69-.69z" />
                                        </g>
                                        <g>
                                            <circle class="st0" cx="55.403" cy="47.909" r=".723" />
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="mx-2">{{ __('lang.suppliers') }}</span>
                    </a>
                </li>
            @endif
            {{-- @endcan --}}
            {{-- ###################### sell car : عربة بيع ###################### --}}
            {{-- @can('sell_car_module')  --}}
            <li class="scroll mx-2 mb-3 p-0 ">
                <a style="cursor: pointer"
                    class="sell-car-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {{-- <img src="{{ asset('images/topbar/warehouse.png') }}" class="img-fluid pl-1" alt="components"> --}}
                    <div style="width: 25px">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 100%" viewBox="0 0 48 48">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: #dad7e5
                                    }

                                    .cls-3 {
                                        fill: #ffde76
                                    }

                                    .cls-7 {
                                        fill: #374f68
                                    }

                                    .cls-8 {
                                        fill: #425b72
                                    }

                                    .cls-13 {
                                        fill: #edebf2
                                    }
                                </style>
                            </defs>
                            <g id="Truck_Delivery" data-name="Truck Delivery">
                                <path class="cls-1"
                                    d="M7.13 34H1v-4h7.36a4 4 0 0 0-1.23 4zM47 30v4h-5.13a4 4 0 0 0-1.23-4zM34.13 34H14.87a4 4 0 0 0-1.23-4h21.72a4 4 0 0 0-1.23 4z" />
                                <path d="M32 12v18H13.64a4 4 0 0 0-5.28 0H2V12z" style="fill:#fc6" />
                                <path class="cls-3" d="M32 12v16H14A10 10 0 0 1 4 18v-6z" />
                                <path d="M47 22v8h-6.36a4 4 0 0 0-5.28 0H32V14h4v6a2 2 0 0 0 2 2z"
                                    style="fill:#db5669" />
                                <path d="M47 22h-9a2 2 0 0 1-2-2v-6h6z" style="fill:#9fdbf3" />
                                <path d="M46.38 21H44a7 7 0 0 1-7-7h5z" style="fill:#b2e5fb" />
                                <path class="cls-7" d="M42 33c0 4.65-6.72 5.53-7.87 1A4 4 0 1 1 42 33z" />
                                <path class="cls-8"
                                    d="M41.27 35.3c-3.82 2.59-8-2.15-5.55-5.57a4 4 0 0 1 5.55 5.57z" />
                                <path class="cls-7" d="M15 33c0 4.65-6.72 5.53-7.87 1A4 4 0 1 1 15 33z" />
                                <path class="cls-8"
                                    d="M14.27 35.3c-3.82 2.59-8-2.15-5.55-5.57a4 4 0 0 1 5.55 5.57z" />
                                <path class="cls-1"
                                    d="M12 33a1 1 0 0 0-2 0 1 1 0 0 0 2 0zM39 33a1 1 0 0 0-2 0 1 1 0 0 0 2 0z" />
                                <path style="fill:#a87e6b" d="M13 17h8v8h-8z" />
                                <path d="M21 17v7h-1a6 6 0 0 1-6-6v-1z" style="fill:#be927c" />
                                <path d="M18 17v2a1 1 0 0 1-2 0v-2z" style="fill:#f6ccaf" />
                                <path d="M47 22v6h-7a6 6 0 0 1-6-6v-8h2v6a2 2 0 0 0 2 2z" style="fill:#f26674" />
                                <path class="cls-3" d="M47 25v2h-2a1 1 0 0 1 0-2z" />
                                <path class="cls-13"
                                    d="M47 30v3c-2.18 0-4.32.25-5.48-1.89a4 4 0 0 0-.88-1.11zM35.36 30a4 4 0 0 0-.88 1.11 3.85 3.85 0 0 1-3.4 1.89H17.92a3.85 3.85 0 0 1-3.4-1.89 4 4 0 0 0-.88-1.11zM8.36 30A4 4 0 0 0 7 33H4a3 3 0 0 1-3-3z" />
                            </g>
                        </svg>
                    </div>
                    <span class="mx-2">{{ __('lang.sell_car') }}</span>
                </a>
            </li>
            {{-- @endcan --}}
            {{-- ###################### settings : الاعدادات ###################### --}}
            {{-- @can('settings_module') --}}
            @if (!empty($module_settings['settings_module']))
                <li class="dropdown menu-item-has-mega-menu scroll mx-2 mb-3 p-0">
                    <a href="javaScript:void();"
                        class="d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                        data-toggle="dropdown">
                        {{-- <img src="{{ asset('images/topbar/settings.png') }}"
                            class="img-fluid pl-1" alt="basic"> --}}
                        <div style="width: 25px">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 100%" viewBox="0 0 48 48">
                                <defs>
                                    <style>
                                        .cls-1 {
                                            fill: #e9edf5
                                        }

                                        .cls-2 {
                                            fill: #cdd2e1
                                        }

                                        .cls-10 {
                                            fill: #190402
                                        }
                                    </style>
                                </defs>
                                <g id="_29-setting" data-name="29-setting">
                                    <rect class="cls-1" x="1" y="5" width="46" height="34" rx="2"
                                        ry="2" />
                                    <path class="cls-1" d="M13 43h22v4H13z" />
                                    <path class="cls-2" d="M17 39h14v4H17z" />
                                    <rect x="5" y="9" width="38" height="26" rx="2" ry="2"
                                        style="fill:#b5efff" />
                                    <path d="M41 9H7a2 2 0 0 0-2 2v3a2 2 0 0 1 2-2h34a2 2 0 0 1 2 2v-3a2 2 0 0 0-2-2z"
                                        style="fill:#80dbff" />
                                    <path
                                        d="M27 1H3a2 2 0 0 0-2 2v24a2 2 0 0 0 2 2h18v5l5-5h1a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2z"
                                        style="fill:#ffde91" />
                                    <path d="M4 27V3a2 2 0 0 1 2-2H3a2 2 0 0 0-2 2v24a2 2 0 0 0 2 2h3a2 2 0 0 1-2-2z"
                                        style="fill:#ffac5a" />
                                    <path
                                        d="M26 17v-4h-3.26a8.285 8.285 0 0 0-.85-2.06l2.3-2.3-2.83-2.83-2.3 2.3A8.285 8.285 0 0 0 17 7.26V4h-4v3.26a8.285 8.285 0 0 0-2.06.85l-2.3-2.3-2.83 2.83 2.3 2.3A8.285 8.285 0 0 0 7.26 13H4v4h3.26a8.285 8.285 0 0 0 .85 2.06l-2.3 2.3 2.83 2.83 2.3-2.3a8.285 8.285 0 0 0 2.06.85V26h4v-3.26a8.285 8.285 0 0 0 2.06-.85l2.3 2.3 2.83-2.83-2.3-2.3a8.285 8.285 0 0 0 .85-2.06zm-11 2a4 4 0 1 1 4-4 4 4 0 0 1-4 4z"
                                        style="fill:#fff" />
                                    <path class="cls-2" d="M42 5v7l-2 2h-2l-2-2V5z" />
                                    <path style="fill:#ff8257" d="M36 27h6v12h-6z" />
                                    <path style="fill:#f05e3a" d="M36 27h6v3h-6z" />
                                    <path class="cls-10"
                                        d="M2 37v-5H0v5a3 3 0 0 0 3 3h13v2h-3a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h22a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-3v-2h5v-2H3a1 1 0 0 1-1-1zm32 9H14v-2h20zm-4-4H18v-2h12zM26 18a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2.522a9.418 9.418 0 0 0-.361-.872L24.9 9.347a1 1 0 0 0 0-1.414L22.067 5.1a1 1 0 0 0-1.414 0l-1.781 1.78A9.418 9.418 0 0 0 18 6.522V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v2.522a9.418 9.418 0 0 0-.872.361L9.347 5.1a1 1 0 0 0-1.414 0L5.1 7.933a1 1 0 0 0 0 1.414l1.78 1.781a9.418 9.418 0 0 0-.358.872H4a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h2.522a9.418 9.418 0 0 0 .361.872L5.1 20.653a1 1 0 0 0 0 1.414l2.83 2.83a1 1 0 0 0 1.414 0l1.781-1.78a9.418 9.418 0 0 0 .872.361V26a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-2.522a9.418 9.418 0 0 0 .872-.361l1.781 1.78a1 1 0 0 0 1.414 0l2.83-2.83a1 1 0 0 0 0-1.414l-1.78-1.781a9.418 9.418 0 0 0 .364-.872zm-4.817 1.767 1.593 1.593-1.416 1.416-1.593-1.593a1 1 0 0 0-1.208-.159 7.327 7.327 0 0 1-1.811.748 1 1 0 0 0-.748.968V25h-2v-2.26a1 1 0 0 0-.748-.968 7.327 7.327 0 0 1-1.811-.748 1 1 0 0 0-1.208.159L8.64 22.776 7.224 21.36l1.593-1.593a1 1 0 0 0 .159-1.208 7.327 7.327 0 0 1-.748-1.811A1 1 0 0 0 7.26 16H5v-2h2.26a1 1 0 0 0 .968-.748 7.327 7.327 0 0 1 .748-1.811 1 1 0 0 0-.159-1.208L7.224 8.64 8.64 7.224l1.593 1.593a1 1 0 0 0 1.208.159 7.327 7.327 0 0 1 1.811-.748A1 1 0 0 0 14 7.26V5h2v2.26a1 1 0 0 0 .748.968 7.327 7.327 0 0 1 1.811.748 1 1 0 0 0 1.208-.159l1.593-1.593 1.416 1.416-1.593 1.593a1 1 0 0 0-.159 1.208 7.327 7.327 0 0 1 .748 1.811 1 1 0 0 0 .968.748H25v2h-2.26a1 1 0 0 0-.968.748 7.327 7.327 0 0 1-.748 1.811 1 1 0 0 0 .159 1.208z" />
                                    <path class="cls-10" d="M15 18a3 3 0 0 1 0-6v-2a5 5 0 1 0 5 5h-2a3 3 0 0 1-3 3z" />
                                    <path class="cls-10"
                                        d="M45 4v2a1 1 0 0 1 1 1v30a1 1 0 0 1-1 1h-2V28h1v-2h-4V15a1 1 0 0 0 .707-.293l2-2A1 1 0 0 0 43 12V5a1 1 0 0 0-1-1H30V3a3 3 0 0 0-3-3H3a3 3 0 0 0-3 3v24a3 3 0 0 0 3 3h17v4a1 1 0 0 0 .617.924A.987.987 0 0 0 21 35a1 1 0 0 0 .707-.293L26.414 30H27a3 3 0 0 0 3-3V14h3v-2h-4a1 1 0 0 0-1 1v14a1 1 0 0 1-1 1h-1a1 1 0 0 0-.707.293L22 31.586V29a1 1 0 0 0-1-1H3a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h24a1 1 0 0 1 1 1v2a1 1 0 0 0 1 1h6v6a1 1 0 0 0 .293.707l2 2A1 1 0 0 0 38 15v11h-4v2h1v4h2v-4h4v11a1 1 0 0 0 1 1h3a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm-8 7.586V6h4v5.586L39.586 13h-1.172z" />
                                    <path class="cls-10" d="M35 34h2v2h-2zM28 8h5v2h-5z" />
                                </g>
                            </svg>
                        </div>
                        <span class="mx-2">{{ __('lang.settings') }}</span>
                    </a>
                    <div class="mega-menu dropdown-menu">
                        <ul class="mega-menu-row" role="menu">
                            {{-- ================= Column 1 ============== --}}
                            <li class="mega-menu-col col-md-3">
                                <ul class="sub-menu">
                                    {{-- ////// اخفاء واظهار اقسام البرنامج ////// --}}
                                    <li>
                                        <a class="modules-button" style="cursor: pointer">
                                            <i class="mdi mdi-circle"></i>@lang('lang.modules')
                                        </a>
                                    </li>
                                    {{-- ////// الاعدادات العامة ////// --}}
                                    <li>
                                        <a class="general_settings-button" style="cursor: pointer">
                                            <i class="mdi mdi-circle"></i>@lang('lang.general_settings')
                                        </a>
                                    </li>
                                    {{-- ////// الخزائن ////// --}}
                                    <li>
                                        <a class="moneysafes-button" style="cursor: pointer">
                                            <i class="mdi mdi-circle"></i>@lang('lang.moneysafes')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {{-- ================= Column 2 ============== --}}
                            <li class="mega-menu-col col-md-3">
                                <ul class="sub-menu">
                                    {{-- ////// المخازن ////// --}}
                                    <li>
                                        <a class="stores-button" style="cursor: pointer">
                                            <i class="mdi mdi-circle"></i>@lang('lang.stores')
                                        </a>
                                    </li>
                                    {{-- ////// العلامة التجاية ////// --}}
                                    <li>
                                        <a class="brands-button" style="cursor: pointer">
                                            <i class="mdi mdi-circle"></i>@lang('lang.brands')
                                        </a>
                                    </li>
                                    {{-- ////// الاقسام ////// --}}
                                    <li>
                                        <a class="categories-button" style="cursor: pointer">
                                            <i class="mdi mdi-circle"></i>@lang('categories.categories')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {{-- ================= Column 3 ============== --}}
                            <li class="mega-menu-col col-md-3">
                                <ul class="sub-menu">
                                    {{-- ////// الالوان ////// --}}
                                    <li>
                                        <a class="colors-button" style="cursor: pointer">
                                            <i class="mdi mdi-circle"></i>@lang('colors.colors')
                                        </a>
                                    </li>
                                    {{-- ////// المقاسات ////// --}}
                                    <li>
                                        <a class="sizes-button" style="cursor: pointer">
                                            <i class="mdi mdi-circle"></i>@lang('sizes.sizes')
                                        </a>
                                    </li>
                                    {{-- ////// الوحدات ////// --}}
                                    <li>
                                        <a class="units-button" style="cursor: pointer">
                                            <i class="mdi mdi-circle"></i>@lang('units.units')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="mega-menu-col col-md-3">
                                <ul class="sub-menu">
                                    {{-- ////////// نقاط البيع للصرافين ////////// --}}
                                    <li>
                                        <a class="stores_pos-button" style="cursor: pointer">
                                            <i class="mdi mdi-circle"></i>@lang('lang.store_pos')
                                        </a>
                                    </li>
                                    {{-- ////////// الضرائب العامة ////////// --}}
                                    <li>
                                        <a class="general-tax-button" style="cursor: pointer">
                                            <i class="mdi mdi-circle"></i>@lang('lang.general_tax')
                                        </a>
                                    </li>
                                    {{-- ////////// ضرائب المنتجات ////////// --}}
                                    <li>
                                        <a class="product_tax-button" style="cursor: pointer">
                                            <i class="mdi mdi-circle"></i>@lang('lang.product_tax')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="mega-menu-col col-md-2">
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{route('branches.index')}}">
                                                <i class="mdi mdi-circle"></i>@lang('lang.branches')
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                        </ul>
                    </div>
                </li>
            @endif
            {{-- @endcan  --}}
            {{-- ###################### reports : التقرير ###################### --}}
            {{-- @can('reports_module') --}}
            @if (!empty($module_settings['reports_module']))
                <li class="dropdown scroll mx-2 mb-3 p-0">
                    <a href="javaScript:void();"
                        class="d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                        data-toggle="dropdown">
                        {{-- <img src="{{ asset('images/topbar/report.png') }}" class="img-fluid pl-1" alt="advanced"> --}}
                        <div style="width: 25px">
                            <svg style="width: 100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"
                                xml:space="preserve">
                                <path fill="#CECECE"
                                    d="M32.035 211.454c-7.535 0-13.665-6.13-13.665-13.665V74.012c0-7.535 6.13-13.665 13.665-13.665h191.931c7.535 0 13.665 6.13 13.665 13.665v123.776c0 7.535-6.13 13.665-13.665 13.665H32.035z" />
                                <path fill="#E2E2E2"
                                    d="M223.965 60.348h-14.667c7.534 0 13.665 6.13 13.665 13.665v123.776c0 7.534-6.13 13.665-13.665 13.665h14.667c7.535 0 13.665-6.13 13.665-13.665V74.012c0-7.534-6.13-13.664-13.665-13.664z" />
                                <path fill="#AFAFAF"
                                    d="M32.035 60.348h14.667c-7.534 0-13.665 6.13-13.665 13.665v123.776c0 7.534 6.13 13.665 13.665 13.665H32.035c-7.535 0-13.665-6.13-13.665-13.665V74.012c0-7.534 6.13-13.664 13.665-13.664z" />
                                <path fill="#63BCE7"
                                    d="M229.221 74.036v123.728a5.28 5.28 0 0 1-5.28 5.28H32.059a5.28 5.28 0 0 1-5.28-5.28V74.036a5.28 5.28 0 0 1 5.28-5.28h191.882a5.28 5.28 0 0 1 5.28 5.28z" />
                                <path fill="#63E2E7"
                                    d="M223.941 68.756h-14.667a5.28 5.28 0 0 1 5.28 5.28v123.728a5.28 5.28 0 0 1-5.28 5.28h14.667a5.28 5.28 0 0 0 5.28-5.28V74.036a5.28 5.28 0 0 0-5.28-5.28z" />
                                <path fill="#6377E7"
                                    d="M32.059 68.756h14.667a5.28 5.28 0 0 0-5.28 5.28v123.728a5.28 5.28 0 0 0 5.28 5.28H32.059a5.28 5.28 0 0 1-5.28-5.28V74.036a5.28 5.28 0 0 1 5.28-5.28z" />
                                <path fill="#CECECE"
                                    d="M128 211.454H8.667l3.053 7.024a17.333 17.333 0 0 0 15.896 10.423h200.769a17.333 17.333 0 0 0 15.896-10.423l3.053-7.024H128z" />
                                <path fill="#E2E2E2"
                                    d="m232.667 211.454-3.053 7.024a17.333 17.333 0 0 1-15.896 10.423h14.667a17.333 17.333 0 0 0 15.896-10.423l3.053-7.024h-14.667z" />
                                <path fill="#AFAFAF"
                                    d="m23.333 211.454 3.053 7.024a17.333 17.333 0 0 0 15.896 10.423H27.615a17.333 17.333 0 0 1-15.896-10.423l-3.053-7.024h14.667z" />
                                <path fill="#707070"
                                    d="m82.442 211.454 4.22 5.388a8.7 8.7 0 0 0 6.85 3.336h68.975a8.7 8.7 0 0 0 6.85-3.336l4.221-5.388H82.442z" />
                                <path fill="#CECECE" d="m186.794 42.538-26.412-26.412H69.206v161.071h117.588z" />
                                <path fill="#F46275" d="M85.276 102.648h19.132v54.698H85.276z" />
                                <path fill="#F8AF23" d="M118.434 93.017h19.132v64.328h-19.132z" />
                                <path fill="#63BCE7" d="M151.592 87.284h19.132v70.061h-19.132z" />
                                <path fill="#F8AF23"
                                    d="M193.308 169.874a7.323 7.323 0 0 0-7.323 7.323v-3.33c0-4.032-3.154-7.491-7.186-7.565a7.323 7.323 0 0 0-7.46 7.322v-3.193a7.323 7.323 0 0 0-14.646 0v-28.189a7.323 7.323 0 0 0-14.646 0v52.698l-9.025-9.025c-2.851-2.851-7.527-3.066-10.43-.268a7.323 7.323 0 0 0-.098 10.452l16.693 16.693a9.765 9.765 0 0 1 2.86 6.904v9.204h51.742v-7.906l3.711-6.349a22.918 22.918 0 0 0 3.131-11.562v-25.887a7.323 7.323 0 0 0-7.323-7.322z" />
                                <g>
                                    <path fill="#F46275"
                                        d="M128 30.915c-13.232 0-23.959 10.727-23.959 23.959S114.768 78.833 128 78.833s23.959-10.727 23.959-23.959H128V30.915z" />
                                    <path fill="#F8AF23"
                                        d="M128 30.915v23.959h23.959c0-13.232-10.727-23.959-23.959-23.959z" />
                                    <g fill="#3F3679">
                                        <path
                                            d="m245.656 219.075 3.053-7.023a1.499 1.499 0 0 0-1.376-2.098h-14.352c3.722-2.766 6.148-7.182 6.148-12.165V74.012c0-8.362-6.803-15.165-15.164-15.165h-35.672v-16.31c0-.398-.158-.779-.439-1.061l-26.412-26.412a1.5 1.5 0 0 0-1.061-.439H69.207a1.5 1.5 0 0 0-1.5 1.5v42.721H32.035c-8.362 0-15.165 6.803-15.165 15.165v123.776c0 4.983 2.427 9.399 6.149 12.165H8.667a1.5 1.5 0 0 0-1.375 2.098l3.053 7.023a18.808 18.808 0 0 0 7.081 8.326H9.32a1.5 1.5 0 1 0 0 3h237.36a1.5 1.5 0 1 0 0-3h-8.105a18.792 18.792 0 0 0 7.081-8.324zm-21.69-157.227c6.707 0 12.164 5.457 12.164 12.165v123.776c0 6.708-5.457 12.165-12.164 12.165h-22.834c.516-1.759.84-3.572.951-5.409h21.859a6.787 6.787 0 0 0 6.779-6.78V74.037a6.787 6.787 0 0 0-6.779-6.78h-35.647v-5.409h35.671zm-31.472 158.39a1.49 1.49 0 0 0-.205.757v6.406h-48.741v-7.704a11.19 11.19 0 0 0-3.3-7.964l-16.692-16.693a5.779 5.779 0 0 1-1.705-4.171 5.781 5.781 0 0 1 1.783-4.141c2.268-2.186 6.005-2.076 8.328.249l9.025 9.024a1.499 1.499 0 0 0 2.561-1.061v-52.698a5.83 5.83 0 0 1 5.822-5.823 5.83 5.83 0 0 1 5.823 5.823v38.149a1.5 1.5 0 1 0 3 0v-9.96a5.83 5.83 0 0 1 5.823-5.823 5.83 5.83 0 0 1 5.822 5.823v12.551a1.5 1.5 0 1 0 3 0v-9.358a5.78 5.78 0 0 1 1.743-4.155c1.125-1.104 2.625-1.672 4.19-1.667 3.15.058 5.713 2.778 5.713 6.065v12.518a1.5 1.5 0 1 0 3 0v-9.188a5.83 5.83 0 0 1 5.822-5.823 5.83 5.83 0 0 1 5.823 5.823v25.887c0 3.794-1.012 7.531-2.926 10.805l-3.709 6.349zm-54.367-6.385a8.198 8.198 0 0 1 2.352 4.824H93.513a7.155 7.155 0 0 1-5.669-2.761l-2.321-2.963h51.705l.899.9zm-68.92-35.156h71.341v12.622l-6.465-6.464c-3.472-3.473-9.094-3.602-12.531-.287a8.76 8.76 0 0 0-2.701 6.273 8.757 8.757 0 0 0 2.584 6.32l4.384 4.384h-93.76a3.785 3.785 0 0 1-3.78-3.78V74.037a3.785 3.785 0 0 1 3.78-3.78h35.647v106.94c.001.828.672 1.5 1.501 1.5zm83.885-44.444V88.784h16.133v67.061h-11.031v-13.604c-.001-3.533-2.094-6.58-5.102-7.988zm8.79-114.505 21.291 21.291h-21.291V19.748zm31.426 148.626a8.773 8.773 0 0 0-5.014 1.57V70.256h35.647a3.784 3.784 0 0 1 3.779 3.78v123.728a3.784 3.784 0 0 1-3.779 3.78H202.13v-24.348c.001-4.864-3.957-8.822-8.822-8.822zM70.707 17.626h88.175v24.912a1.5 1.5 0 0 0 1.5 1.5h24.912v123.879c-1.587-1.865-3.897-3.067-6.467-3.114-2.377-.066-4.643.853-6.347 2.525-.051.05-.101.1-.149.151-1.217-3.417-4.485-5.871-8.314-5.871a8.784 8.784 0 0 0-5.823 2.2v-4.963h12.531a1.5 1.5 0 0 0 1.5-1.5V87.284a1.5 1.5 0 0 0-1.5-1.5h-19.133a1.5 1.5 0 0 0-1.5 1.5v46.171a8.616 8.616 0 0 0-.722-.037c-4.864 0-8.822 3.958-8.822 8.823v33.455H70.707V17.626zM19.87 197.789V74.012c0-6.708 5.457-12.165 12.165-12.165h35.672v5.409H32.059a6.788 6.788 0 0 0-6.78 6.78v123.728a6.788 6.788 0 0 0 6.78 6.78h96.76l5.409 5.409H32.035c-6.708.001-12.165-5.456-12.165-12.164zm-4.434 23.888h29.14a1.5 1.5 0 1 0 0-3H13.478c-.132-.263-.264-.526-.383-.798l-2.141-4.925h70.758l3.77 4.813a10.138 10.138 0 0 0 8.031 3.911h47.035v5.723H27.615a15.826 15.826 0 0 1-12.179-5.724zm212.949 5.723h-33.096v-5.723h5.866a1.5 1.5 0 1 0 0-3h-4.274l1.914-3.275c.463-.792.87-1.613 1.239-2.449h45.012l-2.142 4.926c-.118.272-.25.535-.382.798h-31.098a1.5 1.5 0 1 0 0 3h29.14a15.819 15.819 0 0 1-12.179 5.723z" />
                                        <path
                                            d="M54.845 221.677H65.22a1.5 1.5 0 1 0 0-3H54.845a1.5 1.5 0 1 0 0 3zM27.323 238.374H9.32a1.5 1.5 0 1 0 0 3h18.003a1.5 1.5 0 1 0 0-3zM246.68 238.374h-18.003a1.5 1.5 0 1 0 0 3h18.003a1.5 1.5 0 1 0 0-3zM218.479 238.374H37.521a1.5 1.5 0 1 0 0 3H218.48a1.5 1.5 0 1 0-.001-3zM104.408 101.147H85.276a1.5 1.5 0 0 0-1.5 1.5v54.698a1.5 1.5 0 0 0 1.5 1.5h19.132a1.5 1.5 0 0 0 1.5-1.5v-54.698a1.5 1.5 0 0 0-1.5-1.5zm-1.5 54.698H86.776v-51.698h16.132v51.698zM137.566 91.518h-19.133a1.5 1.5 0 0 0-1.5 1.5v64.328a1.5 1.5 0 0 0 1.5 1.5h19.133a1.5 1.5 0 0 0 1.5-1.5V93.018a1.5 1.5 0 0 0-1.5-1.5zm-1.5 64.327h-16.133V94.518h16.133v61.327zM153.459 54.874c0-14.038-11.421-25.459-25.459-25.459s-25.459 11.421-25.459 25.459S113.962 80.333 128 80.333s25.459-11.421 25.459-25.459zm-3.056-1.5H129.5V32.471c11.19.742 20.161 9.713 20.903 20.903zm-44.862 1.5c0-11.88 9.272-21.635 20.959-22.41v22.41a1.5 1.5 0 0 0 1.5 1.5h22.409C149.635 68.061 139.88 77.333 128 77.333c-12.384 0-22.459-10.075-22.459-22.459z" />
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="mx-2">{{ __('lang.reports') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        {{-- +++++++++++ purchases report +++++++++++ --}}
                        <li>
                            <a class="purchases_report-button" style="cursor: pointer;">
                                <i class="mdi mdi-circle"></i>{{ __('lang.purchases_report') }}
                            </a>
                        </li>
                        {{-- +++++++++++ sales report +++++++++++ --}}
                        <li>
                            <a class="sales-report-button" style="cursor: pointer">
                                <i class="mdi mdi-circle"></i>{{ __('lang.sales_report') }}
                            </a>
                        </li>
                        {{-- +++++++++++ receivable report +++++++++++ --}}
                        <li>
                            <a class="receivable-report-button" style="cursor: pointer">
                                <i class="mdi mdi-circle"></i>{{ __('lang.receivable_report') }}
                            </a>
                        </li>
                        {{-- +++++++++++ payable report +++++++++++ --}}
                        <li>
                            <a class="payable-report-button" style="cursor: pointer;">
                                <i class="mdi mdi-circle"></i>{{ __('lang.payable_report') }}
                            </a>
                        </li>
                        {{-- +++++++++++ customers report +++++++++++ --}}
                        <li>
                            <a style="cursor: pointer" class="customers-report-button">
                                <i class="mdi mdi-circle"></i>{{ __('lang.customers_report') }}
                            </a>
                        </li>
                        {{-- +++++++++++ Daily Report Summary +++++++++++ --}}
                        <li>
                            <a style="cursor: pointer" class="daily-report-summary-button">
                                <i class="mdi mdi-circle"></i>{{ __('lang.daily_report_summary') }}
                            </a>
                        </li>
                        {{-- +++++++++++ Get Due Report +++++++++++ --}}
                        <li>
                            <a style="cursor: pointer" class="get-due-report-button">
                                <i class="mdi mdi-circle"></i>{{ __('lang.get_due_report') }}
                            </a>
                        </li>
                        {{-- +++++++++++ Supplier Report +++++++++++ --}}
                        <li>
                            <a style="cursor: pointer" class="get-supplier-report-button">
                                <i class="mdi mdi-circle"></i>{{ __('lang.supplier_report') }}
                            </a>
                        </li>
                        {{-- +++++++++++ Representative Salary Report +++++++++++ --}}
                        <li>
                            <a class="representative_salary_report-button" style="cursor: pointer">
                                <i class="mdi mdi-circle"></i>{{ __('lang.representative_salary_report') }}
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            {{-- @endcan --}}



        </ul>
    </div>
</nav>
<!-- End Horizontal Nav -->
{{-- </div>
    <!-- End container-fluid -->
</div> --}}
<!-- End Navigationbar -->
{{-- href="{{ route('initial-balance.create') }}" --}}
<script>
    $('.initial-balance-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('initial-balance.create') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.home-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ url('/') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.products-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('products.create') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.cashier-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('pos.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.purchases-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('stocks.create') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.purchases-order-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('purchase_order.create') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.return-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sell_return.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.jobs-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('jobs.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.employees-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('employees.create') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.wages-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('wages.create') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.customers-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('customers.create') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.customer-types-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('customertypes.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.customer-price-offer-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('customer_price_offer.create') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.suppliers-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('suppliers.create') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.sell-car-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sell-car.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.modules-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('getModules') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.general_settings-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('settings.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.moneysafes-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('moneysafe.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.stores-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('store.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.brands-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('brands.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.categories-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sub-categories', 'category') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.colors-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('colors.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.sizes-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sizes.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.units-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('units.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.stores_pos-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('store-pos.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.general-tax-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('general-tax.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.product_tax-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('product-tax.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.purchases_report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('purchases-report.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.sales-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sales-report.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.receivable-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('receivable-report.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.payable-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('payable-report.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.customers-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('customers-report.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.daily-report-summary-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('daily-report-summary.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.get-due-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('get-due-report.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.get-supplier-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('get-supplier-report.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
    $('.representative_salary_report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('representative_salary_report.index') }}"
        document.body.classList.add('animated-element');
        window.location.href = url;
    })
</script>
