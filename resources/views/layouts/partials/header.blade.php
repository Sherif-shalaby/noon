<nav class="navbar no-print navbar-expand-lg bg-white mb-1 py-0"
    style="z-index: 5;background-color: #596fd705 !important">
    <div class="container-fluid">
        <a style="width: 150px;" class="ml-2 d-lg-none" href="index.html">
            <img style="width: 100%" src="{{ asset('images/logo1.png') }}" class="img-fluid" alt="logo">
        </a>
        {{-- <button class="navbar-toggler menu-hamburger" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <img src="{{ asset('images/svg-icon/collapse.svg') }}" class="img-fluid menu-hamburger-collapse"
                alt="collapse">
        </button> --}}
        <button class="navbar-toggler menu-hamburger" id="menu-button">
            <img src="{{ asset('images/svg-icon/collapse.svg') }}" class="img-fluid menu-hamburger-collapse"
                alt="collapse">
        </button>
        {{-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> --}}
        <div class="collapse navbar-collapse" id="menu">
            <ul style="width: 100%"
                class="horizontal-menu navbar-nav d-flex flex-wrap justify-content-start mt-md-0 @if (app()->isLocale('ar')) flex-column flex-md-row-reverse @else flex-row @endif">
                {{-- ###################### Dashboard : نظرة عامة ###################### --}}
                {{-- @can('dashboard')  --}}
                @if (!empty($module_settings['dashboard']))
                    <li class="scroll mx-2 mb-0 p-0" style="height: 40px;">
                        <a target="_blank"
                            class="home-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif align-items-center"
                            href="{{ url('/') }}" style="cursor: pointer;text-decoration: none;height: 100%;">
                            <div style="width: 25px" class="d-flex align-items-center">
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
                                        <path class="cls-6"
                                            d="M34 37h4v4h-4zM18 37h4v4h-4zM52 10h-5V5a5 5 0 0 1 5 5z" />
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
                            <span class="mx-2" style="font-weight: 600">{{ __('lang.dashboard') }}</span>
                        </a>
                    </li>
                @endif
                {{-- @endcan --}}
                {{-- ###################### Products : المنتجات ###################### --}}
                {{-- @can('product_module')  --}}
                @if (!empty($module_settings['product_module']))
                    <li class="scroll mx-2 mb-0 p-0" style="height: 40px;">
                        <a class="products-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif align-items-center"
                            href="{{ route('products.create') }}" target="_blank"
                            style="cursor: pointer;text-decoration: none;height: 100%;">
                            <div style="width: 25px" class="d-flex align-items-center">
                                <img src="{{ asset('images/navbar/products.svg') }}" alt="{{ __('lang.products') }}">
                            </div>
                            {{-- <img src="{{ asset('images/topbar/dairy-products.png') }}" class="img-fluid pl-1"
                            alt="widgets">< --}}
                            <span class="mx-2" style="font-weight: 600">{{ __('lang.products') }}</span>
                        </a>
                    </li>
                @endif
                {{-- @endcan --}}
                {{-- ###################### Cashier : المبيعات ###################### --}}
                {{-- @can('cashier_module') --}}
                @if (!empty($module_settings['cashier_module']))
                    <li class="scroll mx-2 mb-0 p-0" style="height: 40px;">
                        <a class="cashier-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            target="_blank" href="{{ route('pos.index') }}"
                            style="cursor: pointer;text-decoration: none;height: 100%;">
                            {{-- <img
                            src="{{ asset('images/topbar/cashier-machine.png') }}" class="img-fluid pl-1"
                            alt="apps"> --}}
                            <div style="width: 25px" class="d-flex align-items-center">
                                <img src="{{ asset('images/navbar/pos.svg') }}" alt="{{ __('lang.sells') }}">
                            </div>
                            <span class="mx-2" style="font-weight: 600">{{ __('lang.sells') }}</span>
                        </a>
                    </li>
                @endif
                {{-- @endcan --}}
                {{-- ###################### Task 03-01-2024 : Cash : نقدي ###################### --}}
                {{-- @can('cashier_module') --}}
                {{-- @if (!empty($module_settings['cashier_module'])) --}}
                <li class="scroll  mx-2 mb-0 p-0" style="height: 40px;">
                    <a target="_blank"
                        class="cash-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                        href="{{ route('cash.index') }}" style="cursor: pointer;text-decoration: none;height: 100%;">
                        <div style="width: 25px" class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 100%" viewBox="0 0 512 512"
                                style="enable-background:new 0 0 512 512" xml:space="preserve">
                                <path style="fill:#ace5ac"
                                    d="M482.358 363.789H29.642c-11.906 0-21.558-9.651-21.558-21.558V169.768c0-11.906 9.651-21.558 21.558-21.558h452.716c11.906 0 21.558 9.651 21.558 21.558v172.463c0 11.907-9.652 21.558-21.558 21.558z" />
                                <path style="fill:#699e69"
                                    d="M460.8 331.453H51.2c-5.953 0-10.779-4.826-10.779-10.779V191.326c0-5.953 4.826-10.779 10.779-10.779h409.6c5.953 0 10.779 4.826 10.779 10.779v129.347c0 5.954-4.826 10.78-10.779 10.78z" />
                                <path style="fill:#febd4b"
                                    d="M315.284 385.347H196.716c-5.953 0-10.779-4.826-10.779-10.779V137.432c0-5.953 4.826-10.779 10.779-10.779h118.568c5.953 0 10.779 4.826 10.779 10.779v237.137c0 5.953-4.826 10.778-10.779 10.778z" />
                                <path style="fill:#c1c1c1" d="M288.337 385.347h-64.674V126.653h64.674v258.694z" />
                                <path style="fill:#81bc82"
                                    d="M137.432 256c0 14.882-12.065 26.947-26.947 26.947S83.537 270.882 83.537 256s12.065-26.947 26.947-26.947 26.948 12.064 26.948 26.947zm264.084-26.947c-14.883 0-26.947 12.065-26.947 26.947s12.065 26.947 26.947 26.947 26.947-12.065 26.947-26.947-12.065-26.947-26.947-26.947z" />
                                <path
                                    d="M75.453 256c0 19.317 15.715 35.032 35.032 35.032s35.032-15.715 35.032-35.032-15.715-35.032-35.032-35.032S75.453 236.683 75.453 256zm53.894 0c0 10.401-8.463 18.863-18.863 18.863S91.621 266.401 91.621 256s8.463-18.863 18.863-18.863 18.863 8.462 18.863 18.863zm-97.01 64.674V191.326c0-10.401 8.463-18.863 18.863-18.863h107.789a8.082 8.082 0 0 1 8.084 8.084 8.082 8.082 0 0 1-8.084 8.084H51.2a2.697 2.697 0 0 0-2.695 2.695v129.347a2.697 2.697 0 0 0 2.695 2.695h107.789a8.082 8.082 0 0 1 8.084 8.084 8.082 8.082 0 0 1-8.084 8.084H51.2c-10.401.001-18.863-8.462-18.863-18.862zM436.547 256c0-19.317-15.715-35.032-35.032-35.032-19.317 0-35.032 15.715-35.032 35.032s15.715 35.032 35.032 35.032c19.318 0 35.032-15.715 35.032-35.032zm-53.894 0c0-10.401 8.463-18.863 18.863-18.863 10.401 0 18.863 8.463 18.863 18.863 0 10.401-8.463 18.863-18.863 18.863-10.401 0-18.863-8.462-18.863-18.863zm99.705-115.874H334.147v-2.695c0-10.401-8.463-18.863-18.863-18.863H196.716c-10.401 0-18.863 8.463-18.863 18.863v2.695H29.642C13.298 140.126 0 153.424 0 169.768v172.463c0 16.344 13.298 29.642 29.642 29.642h148.211v2.695c0 10.401 8.463 18.863 18.863 18.863h118.568c10.401 0 18.863-8.463 18.863-18.863v-2.695h148.211c16.344 0 29.642-13.298 29.642-29.642V169.768c0-16.344-13.298-29.642-29.642-29.642zM177.853 355.705H29.642c-7.43 0-13.474-6.044-13.474-13.474V169.768c0-7.43 6.044-13.474 13.474-13.474h148.211v199.411zm140.126 18.863a2.697 2.697 0 0 1-2.695 2.695h-18.863V202.105c0-4.466-3.618-8.084-8.084-8.084s-8.084 3.618-8.084 8.084v175.158h-48.505v-56.589c0-4.466-3.618-8.084-8.084-8.084s-8.084 3.618-8.084 8.084v56.589h-18.863a2.697 2.697 0 0 1-2.695-2.695V137.432a2.697 2.697 0 0 1 2.695-2.695h18.863v153.6c0 4.466 3.618 8.084 8.084 8.084s8.084-3.618 8.084-8.084v-153.6h48.505v35.032c0 4.466 3.618 8.084 8.084 8.084s8.084-3.618 8.084-8.084v-35.032h18.863a2.697 2.697 0 0 1 2.695 2.695v237.136zm177.853-32.336c0 7.43-6.044 13.474-13.474 13.474H334.147V156.295h148.211c7.43 0 13.474 6.044 13.474 13.474v172.463zm-16.169-150.906v129.347c0 10.401-8.463 18.863-18.863 18.863H355.166a8.082 8.082 0 0 1-8.084-8.084 8.082 8.082 0 0 1 8.084-8.084H460.8a2.697 2.697 0 0 0 2.695-2.695V191.326a2.697 2.697 0 0 0-2.695-2.695H353.01a8.082 8.082 0 0 1-8.084-8.084 8.082 8.082 0 0 1 8.084-8.084H460.8c10.401 0 18.863 8.463 18.863 18.863z" />
                            </svg>

                        </div>
                        <span class="mx-2" style="font-weight: 600">{{ __('lang.cash') }}</span>
                    </a>
                </li>
                {{-- </li> --}}
                {{-- @endif --}}
                {{-- @endcan --}}
                {{-- ###################### Purchases : المشتريات ###################### --}}
                {{-- @can('stock_module') --}}
                @if (!empty($module_settings['stock_module']))
                    <li class="scroll mx-2 mb-0 p-0" style="height: 40px;">
                        <a target="_blank"
                            class="purchases-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            href="{{ route('stocks.create') }}"
                            style="cursor: pointer;text-decoration: none;height: 100%;">
                            <div style="width: 25px" class="d-flex align-items-center">
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
                            <span class="mx-2" style="font-weight: 600">{{ __('lang.stock') }}</span>
                        </a>
                    </li>
                @endif
                @if (!empty($module_settings['stock_module']))
                    <li class="scroll mx-2 mb-0 p-0" style="height: 40px;">
                        <a target="_blank"
                            class="initial-balance-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            href="{{ route('new-initial-balance.create') }}"
                            style="cursor: pointer;text-decoration: none;height: 100%;">
                            <div style="width: 25px;">
                                <img src="{{ asset('images/navbar/balance.svg') }}"
                                    alt="{{ __('lang.initial_balance') }}">
                            </div>
                            {{-- <img
                            src="{{ asset('images/topbar/warehouse.png') }}" class="img-fluid pl-1"
                            alt="components"> --}}
                            <span class="mx-2" style="font-weight: 600">{{ __('lang.initial_balance') }}</span>
                        </a>
                    </li>
                @endif
                {{-- @endcan --}}
                {{-- ###################### Purchase_Order : امر شراء ###################### --}}
                <li class="scroll mx-2 mb-0 p-0 dropdown" style="height: 40px;">
                    <a href="javaScript:void();"
                        class="d-flex purchases-order-menu align-items-center text-decoration-none @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                        style="height: 100%;" data-toggle="dropdown">
                        <div style="width: 25px" class="d-flex align-items-center">
                            <img src="{{ asset('images/navbar/purchase_order.svg') }}"
                                alt="{{ __('lang.purchase_order') }}">
                        </div>
                        <span class="mx-2" style="font-weight: 600">{{ __('lang.purchase_order') }}</span>
                    </a>
                    <ul
                        class="dropdown-menu list-style-none
                        @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        {{-- ########### purchase_order : اوامر الشراء########### --}}
                        <li class="navbar_item">
                            <a target="_blank"
                                class="purchases-order-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                href="{{ route('purchase_order.index') }}"
                                style="cursor: pointer;font-weight: 600;text-decoration: none;"><i
                                    class="mdi mdi-circle"></i>@lang('lang.show_purchase_order')</a>
                        </li>
                        {{-- ########### required_products : المواد المطلوبة ########### --}}
                        <li class="navbar_item"><a target="_blank"
                                class="required-products-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                href="{{ route('required-products.index') }}"
                                style="cursor: pointer;font-weight: 600;text-decoration: none;"><i
                                    class="mdi mdi-circle"></i>@lang('lang.required_products')</a></li>
                    </ul>
                </li>
                {{-- ###################### Returns : المرتجعات ###################### --}}
                {{-- @can('return_module')  --}}
                @if (!empty($module_settings['return_module']))
                    <li class="scroll mx-2 mb-0 p-0 dropdown" style="height: 40px;">
                        <a href="javaScript:void();"
                            class="d-flex returns-menu align-items-center text-decoration-none @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                            style="height: 100%;" data-toggle="dropdown">
                            {{-- <img src="{{ asset('images/topbar/return.png') }}" class="img-fluid pl-1" alt="pages"> --}}
                            <div style="width: 25px" class="d-flex align-items-center">
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
                            <span class="mx-2" style="font-weight: 600">{{ __('lang.returns') }}</span>
                        </a>
                        <ul
                            class="dropdown-menu list-style-none @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            <li class="navbar_item"><a
                                    class="return-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    target="_blank" href="{{ route('sell_return.index') }}"
                                    style="cursor: pointer;font-weight: 600;text-decoration: none;"><i
                                        class="mdi mdi-circle"></i>@lang('lang.sells_return')</a></li>
                        </ul>
                    </li>
                @endif
                {{-- @endcan  --}}
                {{-- ###################### Supplier Returns :  المرتجعات للموردين ###################### --}}
                @if (!empty($module_settings['return_module']))
                    <li class="scroll mx-2 mb-0 p-0 dropdown" style="height: 40px;">
                        <a href="javaScript:void();"
                            class="d-flex suppliers-returns-menu align-items-center text-decoration-none @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                            style="height: 100%;" data-toggle="dropdown">
                            <div style="width: 25px" class="d-flex align-items-center">
                                <img src="{{ asset('images/navbar/suppliers_returns.svg') }}"
                                    alt="{{ __('lang.supplier_returns') }}">
                            </div>
                            <span class="mx-2" style="font-weight: 600">{{ __('lang.supplier_returns') }}</span>
                        </a>
                        <ul
                            class="dropdown-menu list-style-none @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            <li class="navbar_item">
                                <a class="product-return-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    target="_blank" href="{{ route('suppliers.returns.products') }}"
                                    style="cursor: pointer;font-weight: 600;text-decoration: none;"><i
                                        class="mdi mdi-circle"></i>
                                    @lang('lang.products')
                                </a>
                            </li>
                            <li class="navbar_item">
                                <a class="supplier-return-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                    target="_blank" href="{{ route('suppliers.returns.invoices') }}"
                                    style="cursor: pointer;font-weight: 600;text-decoration: none;">
                                    <i class="mdi mdi-circle"></i>
                                    @lang('lang.invoices')</a>
                            </li>
                        </ul>
                    </li>
                @endif
                {{-- ###################### Employees : الموظفين ###################### --}}
                {{-- @can('employee_module')  --}}
                @if (!empty($module_settings['employee_module']))
                    <li class="dropdown scroll mx-2 mb-0 p-0 " style="height: 40px;">
                        <a href="javaScript:void();"
                            class="d-flex employees-menu align-items-center text-decoration-none @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                            style="height: 100%;" data-toggle="dropdown">
                            {{-- <img
                            src="{{ asset('images/topbar/employee.png') }}" class="img-fluid pl-1"
                            alt="widgets"> --}}
                            <div style="width: 25px" class="d-flex align-items-center">
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
                            <span class="mx-2" style="font-weight: 600">{{ __('lang.employees') }}</span>
                        </a>
                        <ul
                            class="dropdown-menu list-style-none @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            <li class="navbar_item"><a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                    href="{{ route('jobs.index') }}" target="_blank"
                                    class="jobs-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                        class="mdi mdi-circle"></i>@lang('lang.jobs')</a>
                            </li>
                            <li class="navbar_item"><a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                    href="{{ route('employees.create') }}" target="_blank"
                                    class="employees-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                        class="mdi mdi-circle"></i>@lang('lang.employees')</a></li>
                            <li class="navbar_item"><a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                    href="{{ route('wages.create') }}" target="_blank"
                                    class="wages-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                        class="mdi mdi-circle"></i>@lang('lang.wages')</a>
                            </li>
                            {{-- ########### Attendance : الحضور و الانصراف ########### --}}
                            <li class="navbar_item"><a
                                    style="cursor: pointer;font-weight: 600;text-decoration: none;font-size: 12px"
                                    href="{{ route('attendance.index') }}" target="_blank"
                                    class="attendance-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                        class="mdi mdi-circle"></i>@lang('lang.attend_and_leave')</a></li>
                        </ul>
                    </li>
                @endif
                {{-- @endcan --}}
                {{-- ###################### Customers : العملاء ###################### --}}
                {{-- @can('customer_module')  --}}
                @if (!empty($module_settings['customer_module']))
                    <li class="dropdown scroll mx-2 mb-0 p-0 " style="height: 40px;">
                        <a href="javaScript:void();"
                            class="d-flex customers-menu align-items-center text-decoration-none  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                            style="height: 100%;font-weight: 600" data-toggle="dropdown">
                            {{-- <img src="{{ asset('images/topbar/customer-feedback.png') }}"
                            class="img-fluid pl-1" alt="layouts"> --}}
                            <div style="width: 25px" class="d-flex align-items-center">
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
                            <li class="navbar_item"><a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                    href="{{ route('customers.create') }}" target="_blank"
                                    class="customers-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                        class="mdi mdi-circle"></i>{{ __('lang.customers') }}</a></li>
                            <li class="navbar_item"><a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                    href="{{ route('customertypes.index') }}" target="_blank"
                                    class="customer-types-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                        class="mdi mdi-circle"></i>{{ __('lang.customer_types') }}</a></li>
                        </ul>
                    </li>
                @endif
                {{-- @endcan --}}
                {{-- ###################### customer_price_offer : عرض سعر للعملاء ###################### --}}
                {{-- @can('customer_module')  --}}
                @if (!empty($module_settings['customer_module']))
                    <li class="scroll mx-2 mb-0 p-0 " style="height: 40px;">
                        <a class="customer-price-offer-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            href="{{ route('customer_price_offer.create') }}"
                            style="cursor: pointer;font-weight: 600;text-decoration: none;height: 100%;">
                            {{-- <img src="{{ asset('images/topbar/customer-feedback.png') }}" class="img-fluid pl-1"
                            alt="layouts"> --}}
                            <div style="width: 25px" class="d-flex align-items-center">
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
                    <li class="scroll mx-2 mb-0 p-0 " style="height: 40px;">
                        <a class="suppliers-button d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif "
                            href="{{ route('suppliers.create') }}" target="_blank"
                            style="cursor: pointer;font-weight: 600;text-decoration: none;height: 100%;">
                            {{-- <img
                            src="{{ asset('images/topbar/inventory.png') }}" class="img-fluid pl-1"
                            alt="widgets"> --}}
                            <div style="width: 25px" class="d-flex align-items-center">
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
                {{-- ###################### Delivery : التوصيل ###################### --}}
                <li class="dropdown scroll mx-2 mb-0 p-0 " style="height: 40px;">
                    <a href="javaScript:void();"
                        class="d-flex delivery-menu align-items-center text-decoration-none  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                        style="height: 100%;font-weight: 600" data-toggle="dropdown">
                        <div style="width: 25px" class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 100%" viewBox="0 0 64 64"
                                style="enable-background:new 0 0 64 64" xml:space="preserve">
                                <style>
                                    .st0 {
                                        display: none
                                    }

                                    .st1 {
                                        display: inline
                                    }

                                    .st2 {
                                        fill: #f1f2f2
                                    }

                                    .st3 {
                                        fill: #36d7b7
                                    }

                                    .st4 {
                                        fill: none;
                                        stroke: #414042;
                                        stroke-miterlimit: 10
                                    }

                                    .st5,
                                    .st6,
                                    .st7 {
                                        display: inline;
                                        fill: #d1d3d4
                                    }

                                    .st6,
                                    .st7 {
                                        fill: #414042
                                    }

                                    .st7 {
                                        fill: none;
                                        stroke: #414042;
                                        stroke-miterlimit: 10
                                    }

                                    .st8 {
                                        fill: #fff
                                    }

                                    .st9 {
                                        fill: #f5ab35
                                    }

                                    .st10 {
                                        fill: #f9cd86
                                    }

                                    .st11,
                                    .st12 {
                                        display: inline;
                                        fill: #36d7b7
                                    }

                                    .st12 {
                                        fill: #fff
                                    }

                                    .st13,
                                    .st14,
                                    .st16 {
                                        display: inline;
                                        fill: #e6e7e8
                                    }

                                    .st14,
                                    .st16 {
                                        fill: #5edfc5
                                    }

                                    .st16 {
                                        fill: #f7bc5d
                                    }

                                    .st17,
                                    .st18,
                                    .st19 {
                                        display: inline;
                                        fill: #f5ab35
                                    }

                                    .st18,
                                    .st19 {
                                        fill: #b88028
                                    }

                                    .st19 {
                                        fill: #29a189
                                    }

                                    .st20 {
                                        fill: #e6e7e8
                                    }

                                    .st21 {
                                        fill: #bcbec0
                                    }

                                    .st22 {
                                        fill: #58595b
                                    }

                                    .st23 {
                                        fill: #29a189
                                    }

                                    .st24 {
                                        fill: #414042
                                    }

                                    .st25 {
                                        fill: #d1d3d4
                                    }

                                    .st26 {
                                        display: inline;
                                        fill: #bcbec0
                                    }

                                    .st27 {
                                        fill: #f1f2f2
                                    }

                                    .st27,
                                    .st28,
                                    .st34 {
                                        display: inline
                                    }

                                    .st28 {
                                        fill: none;
                                        stroke: #414042;
                                        stroke-linecap: round;
                                        stroke-miterlimit: 10
                                    }

                                    .st34 {
                                        fill: #afefe2
                                    }
                                </style>
                                <g id="icons">
                                    <g id="XMLID_826_">
                                        <path id="XMLID_836_" class="st9"
                                            d="M50 29.7c-.2-.5-.7-.9-1.3-.9h-8v12.6c2.4 0 4.3 1.9 4.3 4.3h7.6v-8.5L50 29.7z" />
                                        <path id="XMLID_835_" class="st24"
                                            d="M43.6 36.3h7c.3 0 .7.1.9.1l1.1.4-2.6-7.1s-.3-1.3-2.5-.9h-5v6.6c.1.5.6.9 1.1.9z" />
                                        <path id="XMLID_812_" class="st4"
                                            d="M48.8 28.8h-8v12.6c2.4 0 4.3 1.9 4.3 4.3" />
                                        <path id="XMLID_832_" class="st2"
                                            d="M53.4 45.6c0 .2-.2.4-.4.4h-3.4c-.2 0-.4-.2-.4-.4v-1.9c0-.2.2-.4.4-.4H53c.2 0 .4.2.4.4v1.9z" />
                                        <path id="XMLID_831_" class="st4"
                                            d="M53.4 45.6c0 .2-.2.4-.4.4h-3.4c-.2 0-.4-.2-.4-.4v-1.9c0-.2.2-.4.4-.4H53c.2 0 .4.2.4.4v1.9z" />
                                        <g id="XMLID_809_">
                                            <g id="XMLID_804_">
                                                <circle id="XMLID_824_" class="st22" cx="23.8" cy="46"
                                                    r="3" />
                                                <circle id="XMLID_823_" class="st4" cx="23.8" cy="46"
                                                    r="3" />
                                                <circle id="XMLID_822_" class="st2" cx="23.8" cy="46"
                                                    r="1.2" />
                                            </g>
                                            <g id="XMLID_817_">
                                                <circle id="XMLID_820_" class="st22" cx="40.7" cy="46"
                                                    r="3" />
                                                <circle id="XMLID_819_" class="st4" cx="40.7" cy="46"
                                                    r="3" />
                                                <circle id="XMLID_818_" class="st2" cx="40.7" cy="46"
                                                    r="1.2" />
                                            </g>
                                            <g id="XMLID_805_">
                                                <circle id="XMLID_816_" class="st22" cx="16.4" cy="46"
                                                    r="3" />
                                                <circle id="XMLID_814_" class="st4" cx="16.4" cy="46"
                                                    r="3" />
                                                <circle id="XMLID_811_" class="st2" cx="16.4" cy="46"
                                                    r="1.2" />
                                            </g>
                                        </g>
                                        <path id="XMLID_815_" class="st4" d="M38.8 43.5H28.2" />
                                        <path id="XMLID_813_" class="st4"
                                            d="M12 45.3c0-2 1.6-3.6 3.6-3.6h8.9c2 0 3.6 1.6 3.6 3.6v.8" />
                                        <path id="XMLID_810_" class="st3" d="M9.9 23.8h28.9v17H9.9z" />
                                        <path id="XMLID_821_" class="st4" d="M38.8 23.8v17H9.9" />
                                        <path id="XMLID_808_" class="st8" d="M12.2 29.5h23.3v4.8H12.2z" />
                                        <path id="XMLID_807_" class="st4" d="M48.4 28.7 41.7 23" />
                                        <path id="XMLID_806_" class="st4" d="M43.9 25v3.1" />
                                        <path id="XMLID_825_" class="st4" d="M9.7 50.3h44.6" />
                                        <path id="XMLID_909_" class="st4" d="M50.1 19.7H37.4" />
                                        <path id="XMLID_911_" class="st4" d="M44.9 16.7H19.3" />
                                        <path id="XMLID_912_" class="st4" d="M27.5 13.7H9.7" />
                                        <path id="XMLID_913_" class="st4" d="M29 13.7h4.1" />
                                        <path id="XMLID_910_" class="st4" d="M31.3 19.7h4" />
                                    </g>
                                </g>
                            </svg>

                        </div>
                        <span class="mx-2">{{ __('lang.delivery') }}</span>
                    </a>
                    <ul
                        class="dropdown-menu list-style-none @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        <li class="navbar_item">
                            <a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                href="{{ route('delivery.index') }}" target="_blank"
                                class="delivery-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <i class="mdi mdi-circle"></i>
                                {{ __('lang.index') }}</a>
                        </li>
                        <li class="navbar_item"><a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                href="{{ route('delivery_plan.plansList') }}" target="_blank"
                                class="plans-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <i class="mdi mdi-circle"></i>
                                {{ __('lang.plans') }}</a></li>
                        {{-- <li><a href="{{route('delivery.create')}}"><i class="mdi mdi-circle"></i>{{__('lang.create')}}</a></li> --}}
                        {{-- <a href="{{route('delivery.maps')}}"><img src="{{asset('images/topbar/inventory.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.delivery')}}</span></a> --}}
                    </ul>
                </li>
                {{-- ###################### sell car : عربة بيع ###################### --}}
                <li class="dropdown scroll mx-2 mb-0 p-0 " style="height: 40px;">
                    <a href="javaScript:void();"
                        class="d-flex sell-car-menu align-items-center text-decoration-none  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                        style="height: 100%;font-weight: 600" data-toggle="dropdown">
                        <div style="width: 25px" class="d-flex align-items-center">
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

                    <ul
                        class="dropdown-menu list-style-none @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        <li class="navbar_item"><a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                href="{{ route('sell-car.index') }}" target="_blank"
                                class="sell-car-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <i class="mdi mdi-circle"></i>
                                @lang('lang.sell_car')</a>
                        </li>
                        <li class="navbar_item"><a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                href="{{ route('delivery.index') }}" target="_blank"
                                class="sell-car-delivery-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <i class="mdi mdi-circle"></i>
                                {{ __('lang.plans') }}</a></li>
                        {{-- <li><a href="{{route('delivery.create')}}"><i class="mdi mdi-circle"></i>{{__('lang.create')}}</a></li> --}}
                        {{-- <a href="{{route('delivery.maps')}}"><img src="{{asset('images/topbar/inventory.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.delivery')}}</span></a> --}}
                    </ul>
                </li>
                {{-- ###################### sell car : عربة بيع ###################### --}}
                <li class="dropdown scroll mx-2 mb-0 p-0 " style="height: 40px;">
                    <a href="javaScript:void();"
                        class="d-flex rep-requests-menu align-items-center text-decoration-none  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                        style="height: 100%;font-weight: 600" data-toggle="dropdown">
                        <div style="width: 25px" class="d-flex align-items-center">
                            <svg version="1.1" style="width: 100%" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 256 256"
                                style="enable-background:new 0 0 256 256" xml:space="preserve">
                                <style>
                                    .st0 {
                                        fill: #382b73
                                    }

                                    .st2 {
                                        fill: #1caee4
                                    }

                                    .st3 {
                                        fill: #009add
                                    }

                                    .st4 {
                                        fill: #d1d3d4
                                    }

                                    .st5 {
                                        fill: #fff
                                    }

                                    .st6 {
                                        fill: #e6e7e8
                                    }

                                    .st7 {
                                        fill: #27c1e6
                                    }
                                </style>
                                <switch>
                                    <g>
                                        <circle class="st0" cx="128" cy="128" r="120" />
                                        <circle cx="128" cy="128" r="102.5" style="fill:#473080" />
                                        <path class="st0"
                                            d="M164.524 130.094c-9.423 0-17.935 3.903-24.007 10.181a30.746 30.746 0 0 0-14.738-4.465l.01-.028-9.353-4.031v-7.385a23.645 23.645 0 0 0 14.321-13.372c.397-.389.783-.79 1.158-1.2a7.596 7.596 0 0 0 6.822-11.956 31.113 31.113 0 0 0 1.337-9.049c0-9.997-4.715-18.893-12.041-24.586l-.018-.014a17.06 17.06 0 0 0-.266-.204l-.008-.006-.27-.202-.019-.014a17.03 17.03 0 0 0-.271-.198h-.001a29.119 29.119 0 0 0-.284-.203l-.007-.005a31.058 31.058 0 0 0-2.03-1.319l-.037-.022c-.08-.047-.16-.095-.241-.141l-.074-.043-.226-.129-.09-.051-.22-.123-.097-.053-.214-.116-.108-.058-.211-.111-.111-.058-.204-.104-.126-.063-.201-.1-.118-.058a20.588 20.588 0 0 0-.212-.103l-.111-.053-.216-.102a4.447 4.447 0 0 0-.121-.055l-.208-.095-.123-.055a19.75 19.75 0 0 0-.213-.094l-.118-.051-.212-.091-.147-.061a33.05 33.05 0 0 0-.701-.282l-.167-.065-.157-.059-.19-.071-.164-.059-.181-.065-.169-.059-.184-.063-.16-.054a14.648 14.648 0 0 0-.194-.064l-.16-.052-.194-.062-.158-.049a15.974 15.974 0 0 0-.205-.062l-.147-.044-.213-.062-.148-.042-.209-.058-.154-.042-.22-.058-.135-.035-.237-.06-.13-.032a16.572 16.572 0 0 0-.238-.056l-.129-.03-.277-.062-.086-.019a33.577 33.577 0 0 0-.338-.071l-.033-.007c-.25-.051-.5-.099-.752-.144l-.072-.013-.301-.052-.106-.017a25.773 25.773 0 0 0-.273-.043l-.109-.016-.265-.039-.131-.018-.249-.033a21.988 21.988 0 0 0-.513-.061l-.248-.027-.145-.015-.235-.022-.149-.013a19.884 19.884 0 0 0-.243-.02l-.138-.011-.254-.018-.132-.009-.257-.015-.132-.007c-.091-.005-.183-.008-.275-.012l-.112-.005a31.9 31.9 0 0 0-.314-.01l-.073-.002c-.127-.003-.254-.006-.382-.007h-.01a26.803 26.803 0 0 0-.783 0l-.071.001-.309.006-.089.002-.299.009-.082.003-.367.016h-.004l-.39.022-.031.002-.334.023-.094.007-.277.023-.101.009-.305.029-.062.006-.374.04-.025.003-.332.04-.108.014-.255.034-.115.016-.279.041-.078.012c-.24.037-.479.076-.717.119l-.104.019a22.96 22.96 0 0 0-.256.047l-.114.022a21.22 21.22 0 0 0-.245.049l-.112.023c-.104.021-.207.043-.311.066l-.037.008-.353.079-.087.02-.256.061-.123.03-.229.057-.119.03-.254.067-.091.024-.34.094-.073.021-.259.075-.131.039-.209.063-.136.042-.213.068-.121.039-.299.099a5.309 5.309 0 0 0-.116.04l-.231.08-.147.052-.184.066-.149.055-.178.066-.149.056-.197.076-.179.07-.245.098-.152.063-.166.069-.166.07-.141.061-.18.078-.126.056c-.216.096-.43.194-.643.295l-.126.06-.18.087-.125.061-.18.089-.117.059-.19.097a25.727 25.727 0 0 0-.474.25l-.084.045-.184.1-.115.063-.183.102-.104.059-.188.107a6.533 6.533 0 0 0-.086.051c-.15.087-.299.176-.448.265l-.005.003-.195.119-.095.058-.185.116-.09.057a33.83 33.83 0 0 0-.197.126l-.051.033c-.224.145-.446.293-.666.444l-.071.048-.192.133a5.002 5.002 0 0 0-.076.054l-.193.137-.063.045c-5.992 4.313-10.388 10.704-12.132 18.118l-.007.032-.06.261-.018.08-.053.244-.02.097-.05.241-.016.083c-.052.261-.101.524-.146.787l-.022.128-.034.204-.025.158a11.803 11.803 0 0 0-.054.363l-.025.177-.028.211-.025.192-.035.291-.017.154-.022.206-.016.162-.02.21-.014.153-.019.229-.011.136-.025.355v.005c-.008.122-.015.245-.021.367l-.006.127-.011.243-.005.137-.008.249-.003.126-.005.263-.002.114-.002.372a36.083 36.083 0 0 0 .004.498l.002.082c.054 2.94.515 5.781 1.331 8.468a7.596 7.596 0 0 0 6.821 11.957c.375.41.761.81 1.158 1.199a23.479 23.479 0 0 0 3.972 6.435 25.1 25.1 0 0 0 1.156 1.243 24.258 24.258 0 0 0 1.675 1.522 23.547 23.547 0 0 0 7.518 4.173h-.001v8.206-.821l-4.677 2.015-4.677 2.015.01.028c-9.539.401-17.96 5.124-23.357 12.261l-.001.001c-.369.488-.724.988-1.064 1.498l-.02.03c-.253.381-.498.767-.735 1.16l-.01.016c-.074.123-.147.246-.219.37l-.022.038c-.228.392-.448.79-.659 1.193l-.023.044c-.061.116-.12.232-.179.349l-.035.069c-.063.125-.124.25-.185.375l-.008.017c-.133.274-.262.551-.387.829l-.022.05a37.17 37.17 0 0 0-.154.351l-.037.086c-.051.119-.102.24-.151.36l-.019.045c-.114.278-.224.558-.331.84l-.029.078a33.48 33.48 0 0 0-.124.337l-.036.101c-.042.117-.083.234-.123.352l-.022.063a31.26 31.26 0 0 0-.276.851l-.032.104a39.586 39.586 0 0 0-.131.44l-.094.334-.027.095a31.09 31.09 0 0 0-.354 1.43l-.071.328-.023.108a27.944 27.944 0 0 0-.191 1.011l-.051.304-.024.149-.048.321-.018.123c-.042.294-.079.589-.112.885l-.016.146a31.49 31.49 0 0 0-.046.466l-.027.306-.012.145a33.019 33.019 0 0 0-.076 1.357l-.005.155-.008.333-.002.127c-.002.153-.004.307-.004.461v14.197a6.773 6.773 0 0 0 6.773 6.773h72.189c5.992 5.709 14.103 9.214 23.032 9.214 18.444 0 33.396-14.952 33.396-33.396.008-18.443-14.944-33.394-33.388-33.394zm-55.897-4.518zm-.317-.006-.232-.007.232.007zm-.922-.043-.209-.015.209.015zm-.295-.021-.189-.015.189.015zm-.287-.024a13.076 13.076 0 0 1-.206-.02l.206.02zm-.273-.026-.259-.028.259.028zm-.376-.042-.146-.018.146.018zm-.28-.035-.13-.017.13.017zm-.271-.037zm-.454-.069-.042-.007.042.007zm-.211-.035-.086-.015.086.015zm-.264-.047a1.627 1.627 0 0 1-.068-.013l.068.013zm-.258-.049a.174.174 0 0 1-.022-.005l.022.005zm-.676-.142-.03-.007.03.007zm-.233-.054a.465.465 0 0 0-.036-.008l.036.008zm-1.149-.302s-.001 0 0 0c-.001 0 0 0 0 0zm5.097.888zm1.199.044.297.002.297-.002-.297.002-.245-.001-.052-.001zm5.757-.634h.002-.002zm-.927.2.027-.005-.027.005zm-.255.049.064-.012a7.668 7.668 0 0 0-.064.012zm-.261.046.079-.013-.079.013zm-.206.034.03-.005-.03.005zm-.462.071.106-.016-.106.016zm-.275.037.134-.018-.134.018zm-.253.032-.027.003.149-.018-.122.015zm-.35.039-.053.006.257-.028a11.61 11.61 0 0 1-.204.022zm-.325.032c.072-.007.143-.013.214-.021l-.214.021zm-.287.024.191-.016-.191.016zm-.296.021.211-.015c-.07.006-.141.01-.211.015zm-.636.033zm-.285.01.234-.008-.234.008zm-.316.006.249-.005-.249.005zm7.156 8.968v1.238-1.238z" />
                                        <g>
                                            <path class="st2"
                                                d="M148.604 180.671H69.302a6.773 6.773 0 0 1-6.773-6.773v-14.197c0-17.077 13.844-30.921 30.921-30.921h31.006c17.077 0 30.921 13.844 30.921 30.921v14.197a6.773 6.773 0 0 1-6.773 6.773z" />
                                            <path class="st3"
                                                d="M141.773 134.083v46.589h6.831a6.773 6.773 0 0 0 6.773-6.773v-14.196c0-10.661-5.395-20.061-13.604-25.62z" />
                                            <path class="st4"
                                                d="m125.789 128.781-9.353-4.03v4.03l-7.482 11.661-7.483-11.661v-4.03l-9.353 4.03 16.835 45.682h.001z" />
                                            <path class="st5"
                                                d="m92.118 128.781 7.069 19.162c.285.773 1.275.99 1.857.408l7.909-7.909-7.482-11.661v-4.031l-9.353 4.031zM125.789 128.781l-7.069 19.162a1.129 1.129 0 0 1-1.857.408l-7.909-7.909 7.482-11.661v-4.031l9.353 4.031z" />
                                            <path class="st6"
                                                d="M108.953 118.578c-2.615 0-5.131-.426-7.482-1.212v11.415l7.482 11.661 7.482-11.661v-11.416a23.52 23.52 0 0 1-7.482 1.213z" />
                                            <path class="st2"
                                                d="m115.217 146.706-4.667 4.667a2.257 2.257 0 0 1-3.193 0l-4.667-4.667 6.263-6.263 6.264 6.263z" />
                                            <path class="st3"
                                                d="M110.55 151.373a2.26 2.26 0 0 1-3.193 0l-1.6-1.6-1.387 12.255 4.583 12.439 4.583-12.439-1.387-12.254-1.599 1.599z" />
                                            <path class="st7"
                                                d="m86.871 148.847 3.982-3.511c.737-.65.35-1.865-.627-1.969l-4.675-.5a1.129 1.129 0 0 1-.941-1.507l4.442-12.259a27.88 27.88 0 0 1 3.081-.282l16.819 45.649-22.165-24.008a1.131 1.131 0 0 1 .084-1.613zM131.036 148.847l-3.982-3.511c-.737-.65-.35-1.865.627-1.969l4.675-.5a1.128 1.128 0 0 0 .941-1.507l-4.442-12.259a27.875 27.875 0 0 0-3.082-.282l-16.819 45.649 22.165-24.008a1.13 1.13 0 0 0-.083-1.613zM136.433 171.288h-15.239a1.587 1.587 0 1 0 0 3.174h15.239a1.587 1.587 0 1 0 0-3.174z" />
                                            <path class="st3"
                                                d="M76.134 180.671v-46.589c-8.209 5.559-13.604 14.959-13.604 25.62v14.196a6.773 6.773 0 0 0 6.773 6.773h6.831z" />
                                            <g>
                                                <circle transform="rotate(-67.723 108.95 81.787)" class="st3"
                                                    cx="108.954" cy="81.791" r="31.119" />
                                                <path class="st5"
                                                    d="M108.953 118.578c-13.023 0-23.58-10.557-23.58-23.58V82.754c0-13.023 10.557-23.58 23.58-23.58 13.023 0 23.58 10.557 23.58 23.58v12.244c.001 13.023-10.556 23.58-23.58 23.58z" />
                                                <path class="st4"
                                                    d="M108.953 118.578c-2.616 0-5.131-.426-7.482-1.212v4.495a23.506 23.506 0 0 0 7.482 1.232c2.618 0 5.129-.445 7.482-1.232v-4.495a23.548 23.548 0 0 1-7.482 1.212z" />
                                                <path class="st5"
                                                    d="M85.373 94.998v-7.369a7.596 7.596 0 1 0 1.29 15.082 23.579 23.579 0 0 1-1.29-7.713zM132.534 87.629v7.369c0 2.701-.455 5.296-1.291 7.713a7.596 7.596 0 1 0 1.291-15.082z" />
                                                <path class="st6"
                                                    d="M108.953 115.192c-13.023 0-23.58-10.557-23.58-23.58v3.386c0 13.023 10.557 23.58 23.58 23.58 13.023 0 23.58-10.557 23.58-23.58v-3.386c.001 13.023-10.556 23.58-23.58 23.58zM85.373 82.754v4.644c9.217-5.373 15.425-15.334 15.47-26.762-9.021 3.31-15.47 11.95-15.47 22.118z" />
                                                <path class="st6"
                                                    d="M121.311 88.238c3.961 0 7.739-.762 11.223-2.112v-3.372c0-13.023-10.557-23.58-23.58-23.58-6.817 0-12.94 2.91-17.245 7.536 4.043 12.491 15.763 21.528 29.602 21.528z" />
                                                <path class="st2"
                                                    d="M90.347 56.845c1.562 15.725 14.828 28.006 30.964 28.006a30.977 30.977 0 0 0 18.607-6.174c-1.562-15.725-14.828-28.007-30.964-28.007a30.99 30.99 0 0 0-18.607 6.175z" />
                                                <path class="st3"
                                                    d="M77.834 81.791c0 1.416.104 2.807.287 4.174C91.229 82.3 100.848 70.277 100.848 56c0-1.416-.104-2.808-.287-4.174-13.108 3.664-22.727 15.687-22.727 29.965z" />
                                                <path class="st2"
                                                    d="M101.777 91.909a2.857 2.857 0 1 1-5.714 0 2.857 2.857 0 0 1 5.714 0zM123.941 91.909a2.857 2.857 0 1 1-5.714 0 2.857 2.857 0 0 1 5.714 0z" />
                                                <g>
                                                    <path class="st6"
                                                        d="M85.373 94.998V90.86a4.365 4.365 0 1 0 0 8.73c.153 0 .298-.03.448-.045a23.662 23.662 0 0 1-.448-4.547zM132.556 94.998V90.86a4.365 4.365 0 0 1 0 8.73c-.153 0-.298-.03-.448-.045.288-1.473.448-2.991.448-4.547z" />
                                                </g>
                                            </g>
                                            <g>
                                                <circle transform="rotate(-76.521 164.518 156.482)" class="st5"
                                                    cx="164.524" cy="156.489" r="33.396" />
                                                <path class="st6"
                                                    d="M167.555 132.269h-.95a.938.938 0 0 1-.893-.649l-.294-.904c-.281-.866-1.506-.866-1.787 0l-.294.904a.939.939 0 0 1-.893.649h-.95c-.91 0-1.289 1.165-.552 1.7l.769.559a.939.939 0 0 1 .341 1.05l-.294.904c-.281.866.71 1.585 1.446 1.05l.769-.559a.94.94 0 0 1 1.104 0l.769.559c.736.535 1.727-.185 1.446-1.05l-.294-.904a.939.939 0 0 1 .341-1.05l.769-.559c.735-.536.357-1.7-.553-1.7zM173.32 138.623l-.294.904c-.281.865.709 1.585 1.446 1.05l.769-.559a.941.941 0 0 1 1.105 0l.769.559c.736.535 1.727-.185 1.446-1.05l-.294-.904a.939.939 0 0 1 .341-1.05l.769-.559c.736-.535.358-1.699-.552-1.699h-.95a.938.938 0 0 1-.893-.649l-.294-.904c-.281-.866-1.506-.866-1.787 0l-.294.904a.939.939 0 0 1-.893.649h-.95c-.91 0-1.289 1.165-.552 1.699l.769.559a.942.942 0 0 1 .339 1.05zM156.101 135.315h-.95a.938.938 0 0 1-.893-.649l-.294-.904c-.281-.866-1.506-.866-1.787 0l-.294.904a.939.939 0 0 1-.893.649h-.95c-.91 0-1.289 1.165-.552 1.699l.769.559a.939.939 0 0 1 .341 1.05l-.294.904c-.281.865.709 1.585 1.446 1.05l.769-.559a.941.941 0 0 1 1.105 0l.769.559c.736.535 1.727-.185 1.446-1.05l-.294-.904a.939.939 0 0 1 .341-1.05l.769-.559c.735-.535.356-1.699-.554-1.699zM139.731 146.041l.769.559a.939.939 0 0 1 .341 1.05l-.294.904c-.281.866.709 1.585 1.446 1.05l.769-.558a.94.94 0 0 1 1.104 0l.769.558c.736.535 1.727-.185 1.446-1.05l-.294-.904a.939.939 0 0 1 .341-1.05l.769-.559c.736-.535.358-1.7-.552-1.7h-.95a.938.938 0 0 1-.893-.649l-.294-.904c-.281-.865-1.506-.865-1.787 0l-.294.904a.94.94 0 0 1-.894.649h-.95c-.91 0-1.288 1.165-.552 1.7zM182.049 146.041l.769.559a.939.939 0 0 1 .341 1.05l-.294.904c-.281.866.71 1.585 1.446 1.05l.769-.558a.94.94 0 0 1 1.104 0l.769.558c.736.535 1.727-.185 1.446-1.05l-.294-.904a.939.939 0 0 1 .341-1.05l.769-.559c.736-.535.358-1.7-.552-1.7h-.95a.94.94 0 0 1-.894-.649l-.294-.904c-.281-.865-1.506-.865-1.787 0l-.294.904a.94.94 0 0 1-.894.649h-.95c-.909 0-1.288 1.165-.551 1.7zM167.555 179.941h-.95a.938.938 0 0 1-.893-.649l-.294-.904c-.281-.866-1.506-.866-1.787 0l-.294.904a.939.939 0 0 1-.893.649h-.95c-.91 0-1.289 1.165-.552 1.7l.769.559a.939.939 0 0 1 .341 1.05l-.294.904c-.281.865.71 1.585 1.446 1.05l.769-.558a.94.94 0 0 1 1.104 0l.769.558c.736.535 1.727-.185 1.446-1.05l-.294-.904a.939.939 0 0 1 .341-1.05l.769-.559c.735-.535.357-1.7-.553-1.7zM155.372 176.699h-.95a.938.938 0 0 1-.893-.649l-.294-.904c-.281-.866-1.506-.866-1.787 0l-.294.904a.939.939 0 0 1-.893.649h-.95c-.91 0-1.289 1.165-.552 1.7l.769.559a.939.939 0 0 1 .341 1.05l-.294.904c-.281.865.709 1.585 1.446 1.05l.769-.559a.941.941 0 0 1 1.105 0l.769.559c.736.535 1.727-.185 1.446-1.05l-.294-.904a.939.939 0 0 1 .341-1.05l.769-.559c.734-.536.356-1.7-.554-1.7zM179.938 176.699h-.95a.938.938 0 0 1-.893-.649l-.294-.904c-.281-.866-1.506-.866-1.787 0l-.293.904a.94.94 0 0 1-.894.649h-.95c-.91 0-1.288 1.165-.552 1.7l.769.559a.939.939 0 0 1 .341 1.05l-.294.904c-.281.865.709 1.585 1.446 1.05l.769-.559a.941.941 0 0 1 1.105 0l.769.559c.736.535 1.727-.185 1.446-1.05l-.294-.904a.939.939 0 0 1 .341-1.05l.769-.559c.734-.536.356-1.7-.554-1.7zM191.391 156.105h-.95a.94.94 0 0 1-.894-.649l-.294-.904c-.281-.866-1.506-.866-1.787 0l-.294.904a.94.94 0 0 1-.894.649h-.95c-.91 0-1.289 1.165-.552 1.7l.769.558a.94.94 0 0 1 .341 1.051l-.294.904c-.281.866.71 1.585 1.446 1.05l.769-.559a.94.94 0 0 1 1.104 0l.769.559c.736.535 1.727-.185 1.445-1.05l-.293-.904a.94.94 0 0 1 .341-1.051l.769-.558c.738-.535.359-1.7-.551-1.7zM187.85 167.793h-.95a.94.94 0 0 1-.894-.649l-.293-.904c-.281-.865-1.506-.865-1.787 0l-.294.904a.939.939 0 0 1-.893.649h-.95c-.91 0-1.288 1.165-.552 1.7l.769.558a.939.939 0 0 1 .341 1.05l-.294.904c-.281.866.71 1.585 1.446 1.05l.769-.558a.94.94 0 0 1 1.104 0l.769.558c.736.535 1.727-.185 1.446-1.05l-.294-.904a.939.939 0 0 1 .341-1.05l.769-.558c.736-.535.357-1.7-.553-1.7zM147.377 167.793h-.95a.94.94 0 0 1-.894-.649l-.294-.904c-.281-.865-1.506-.865-1.787 0l-.294.904a.939.939 0 0 1-.893.649h-.95c-.91 0-1.288 1.165-.552 1.7l.769.558a.939.939 0 0 1 .341 1.05l-.294.904c-.281.866.71 1.585 1.446 1.05l.769-.558a.94.94 0 0 1 1.104 0l.769.558c.736.535 1.727-.185 1.446-1.05l-.294-.904a.939.939 0 0 1 .341-1.05l.769-.558c.736-.535.358-1.7-.552-1.7zM141.24 160.809l.769.559c.737.535 1.727-.185 1.446-1.05l-.294-.904a.94.94 0 0 1 .341-1.051l.769-.558c.736-.535.358-1.7-.552-1.7h-.95a.94.94 0 0 1-.894-.649l-.294-.904c-.281-.866-1.506-.866-1.787 0l-.294.904a.94.94 0 0 1-.894.649h-.95c-.91 0-1.289 1.165-.552 1.7l.769.558a.94.94 0 0 1 .341 1.051l-.294.904c-.281.866.71 1.585 1.446 1.05l.769-.559a.941.941 0 0 1 1.105 0z" />
                                                <g>
                                                    <path class="st2"
                                                        d="m165.418 129.383.294.904a.939.939 0 0 0 .893.649h.95c.91 0 1.288 1.165.552 1.699l-.769.559a.939.939 0 0 0-.341 1.05l.294.904c.281.866-.709 1.585-1.446 1.05l-.769-.559a.94.94 0 0 0-1.104 0l-.769.559c-.736.535-1.727-.185-1.446-1.05l.294-.904a.939.939 0 0 0-.341-1.05l-.769-.559c-.736-.535-.358-1.699.552-1.699h.95a.938.938 0 0 0 .893-.649l.294-.904c.282-.866 1.506-.866 1.788 0zM176.686 132.429l.294.904a.939.939 0 0 0 .893.649h.95c.91 0 1.289 1.165.552 1.7l-.769.559a.939.939 0 0 0-.341 1.05l.294.904c.281.866-.71 1.585-1.446 1.05l-.769-.559a.941.941 0 0 0-1.105 0l-.769.559c-.736.535-1.727-.185-1.446-1.05l.294-.904a.939.939 0 0 0-.341-1.05l-.769-.559c-.736-.535-.358-1.7.552-1.7h.95a.938.938 0 0 0 .893-.649l.294-.904c.283-.866 1.508-.866 1.789 0zM153.964 132.429l.294.904a.939.939 0 0 0 .893.649h.95c.91 0 1.289 1.165.552 1.7l-.769.559a.939.939 0 0 0-.341 1.05l.294.904c.281.866-.71 1.585-1.446 1.05l-.769-.559a.94.94 0 0 0-1.104 0l-.769.559c-.736.535-1.727-.185-1.446-1.05l.294-.904a.939.939 0 0 0-.341-1.05l-.769-.559c-.736-.535-.358-1.7.552-1.7h.95a.938.938 0 0 0 .893-.649l.294-.904c.282-.866 1.507-.866 1.788 0zM144.208 141.456l.294.904a.939.939 0 0 0 .893.649h.95c.91 0 1.288 1.165.552 1.7l-.769.559a.939.939 0 0 0-.341 1.05l.294.904c.281.866-.71 1.585-1.446 1.05l-.769-.559a.94.94 0 0 0-1.104 0l-.769.559c-.736.535-1.727-.185-1.446-1.05l.294-.904a.939.939 0 0 0-.341-1.05l-.769-.559c-.736-.535-.358-1.7.552-1.7h.95a.94.94 0 0 0 .894-.649l.294-.904c.281-.866 1.505-.866 1.787 0zM186.525 141.456l.294.904a.94.94 0 0 0 .894.649h.95c.91 0 1.288 1.165.552 1.7l-.769.559a.939.939 0 0 0-.341 1.05l.294.904c.281.866-.709 1.585-1.446 1.05l-.769-.559a.94.94 0 0 0-1.104 0l-.769.559c-.736.535-1.727-.185-1.446-1.05l.294-.904a.939.939 0 0 0-.341-1.05l-.769-.559c-.736-.535-.358-1.7.552-1.7h.95a.938.938 0 0 0 .893-.649l.294-.904c.281-.866 1.506-.866 1.787 0zM165.418 177.055l.294.904a.939.939 0 0 0 .893.649h.95c.91 0 1.288 1.165.552 1.7l-.769.559a.939.939 0 0 0-.341 1.05l.294.904c.281.866-.709 1.585-1.446 1.05l-.769-.559a.94.94 0 0 0-1.104 0l-.769.559c-.736.535-1.727-.185-1.446-1.05l.294-.904a.939.939 0 0 0-.341-1.05l-.769-.559c-.736-.535-.358-1.7.552-1.7h.95a.938.938 0 0 0 .893-.649l.294-.904c.282-.865 1.506-.865 1.788 0zM153.234 173.813l.294.904a.94.94 0 0 0 .894.649h.95c.91 0 1.288 1.165.552 1.699l-.769.559a.939.939 0 0 0-.341 1.05l.294.904c.281.865-.71 1.585-1.446 1.05l-.769-.558a.94.94 0 0 0-1.104 0l-.769.558c-.736.535-1.727-.185-1.446-1.05l.294-.904a.939.939 0 0 0-.341-1.05l-.769-.559c-.736-.535-.358-1.699.552-1.699h.95a.94.94 0 0 0 .894-.649l.294-.904c.281-.866 1.505-.866 1.786 0zM177.8 173.813l.294.904a.94.94 0 0 0 .894.649h.95c.91 0 1.288 1.165.552 1.699l-.769.559a.939.939 0 0 0-.341 1.05l.294.904c.281.865-.71 1.585-1.446 1.05l-.769-.558a.94.94 0 0 0-1.104 0l-.769.558c-.736.535-1.727-.185-1.446-1.05l.294-.904a.939.939 0 0 0-.341-1.05l-.769-.559c-.736-.535-.358-1.699.552-1.699h.95a.94.94 0 0 0 .894-.649l.294-.904c.281-.866 1.505-.866 1.786 0zM189.254 153.219l.294.904a.94.94 0 0 0 .894.649h.95c.91 0 1.289 1.165.552 1.699l-.769.559a.939.939 0 0 0-.341 1.05l.294.904c.281.865-.709 1.585-1.446 1.05l-.769-.558a.941.941 0 0 0-1.105 0l-.769.558c-.736.535-1.727-.185-1.446-1.05l.294-.904a.939.939 0 0 0-.341-1.05l-.769-.559c-.736-.535-.358-1.699.552-1.699h.95a.94.94 0 0 0 .894-.649l.294-.904c.281-.865 1.506-.865 1.787 0zM185.713 164.907l.294.904a.939.939 0 0 0 .893.649h.95c.91 0 1.288 1.165.552 1.699l-.769.559a.939.939 0 0 0-.341 1.05l.294.904c.281.866-.71 1.585-1.446 1.05l-.769-.559a.94.94 0 0 0-1.104 0l-.769.559c-.736.535-1.727-.185-1.446-1.05l.294-.904a.939.939 0 0 0-.341-1.05l-.769-.559c-.736-.535-.358-1.699.552-1.699h.95a.94.94 0 0 0 .894-.649l.294-.904c.281-.865 1.506-.865 1.787 0zM145.239 164.907l.294.904a.94.94 0 0 0 .894.649h.95c.91 0 1.288 1.165.552 1.699l-.769.559a.939.939 0 0 0-.341 1.05l.294.904c.281.866-.709 1.585-1.446 1.05l-.769-.559a.94.94 0 0 0-1.104 0l-.769.559c-.736.535-1.727-.185-1.446-1.05l.294-.904a.939.939 0 0 0-.341-1.05l-.769-.559c-.736-.535-.358-1.699.552-1.699h.95a.938.938 0 0 0 .893-.649l.294-.904c.282-.865 1.506-.865 1.787 0zM141.581 153.219l.294.904a.94.94 0 0 0 .894.649h.95c.91 0 1.288 1.165.552 1.699l-.769.559a.939.939 0 0 0-.341 1.05l.294.904c.281.865-.709 1.585-1.446 1.05l-.769-.558a.94.94 0 0 0-1.104 0l-.769.558c-.736.535-1.727-.185-1.446-1.05l.294-.904a.939.939 0 0 0-.341-1.05l-.769-.559c-.736-.535-.358-1.699.552-1.699h.95a.94.94 0 0 0 .894-.649l.294-.904c.28-.865 1.505-.865 1.786 0z" />
                                                </g>
                                                <g>
                                                    <circle transform="rotate(-76.638 164.521 156.493)" cx="164.524"
                                                        cy="156.489" style="fill:#ef5a9d" r="14.107" />
                                                    <path
                                                        d="M163.423 164.577a2.365 2.365 0 0 1-1.671-.692l-4.619-4.619a2.362 2.362 0 1 1 3.341-3.341l2.949 2.947 5.975-5.975a2.362 2.362 0 1 1 3.341 3.341l-7.645 7.647a2.369 2.369 0 0 1-1.671.692z"
                                                        style="fill:#e43d91" />
                                                    <path
                                                        d="M163.423 162.906a2.365 2.365 0 0 1-1.671-.692l-4.619-4.619a2.362 2.362 0 1 1 3.341-3.341l2.949 2.947 5.975-5.975a2.362 2.362 0 1 1 3.341 3.341l-7.645 7.647a2.365 2.365 0 0 1-1.671.692z"
                                                        style="fill:#fede3a" />
                                                    <path
                                                        d="m172.738 151.383-7.645 7.647a2.361 2.361 0 0 1-3.342 0l-4.62-4.619c-.024-.025-.041-.053-.064-.079a2.358 2.358 0 0 0 .064 3.263l4.62 4.619a2.365 2.365 0 0 0 3.342 0l7.645-7.647a2.357 2.357 0 0 0 .064-3.263c-.023.026-.039.055-.064.079z"
                                                        style="fill:#f7cb15" />
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </switch>
                            </svg>
                        </div>
                        <span class="mx-2">{{ __('lang.representatives_requests') }}</span>
                    </a>
                    <ul
                        class="dropdown-menu list-style-none @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        <li class="navbar_item">
                            <a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                href="{{ route('representatives.index') }}" target="_blank"
                                class="rep-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <i class="mdi mdi-circle"></i>
                                {{ __('lang.representatives_requests') }}</a>
                        </li>
                        <li class="navbar_item"><a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                href="{{ route('rep_plan.index') }}" target="_blank"
                                class="rep-plans-button d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <i class="mdi mdi-circle"></i>
                                {{ __('lang.plans') }}</a></li>
                        {{-- <li><a href="{{route('delivery.create')}}"><i class="mdi mdi-circle"></i>{{__('lang.create')}}</a></li> --}}
                        {{-- <a href="{{route('delivery.maps')}}"><img src="{{asset('images/topbar/inventory.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.delivery')}}</span></a> --}}
                    </ul>
                </li>

                {{-- @endcan --}}
                {{-- ###################### settings : الاعدادات ###################### --}}
                {{-- @can('settings_module') --}}
                @if (!empty($module_settings['settings_module']))
                    <li class="dropdown menu-item-has-mega-menu scroll mx-2 mb-0 p-0" style="height: 40px;">
                        <a href="javaScript:void();"
                            class="d-flex settings-icon-menu align-items-center text-decoration-none @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                            style="height: 100%;font-weight: 600" data-toggle="dropdown">
                            {{-- <img src="{{ asset('images/topbar/settings.png') }}"
                            class="img-fluid pl-1" alt="basic"> --}}
                            <div style="width: 25px" class="d-flex align-items-center">
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
                                        <rect class="cls-1" x="1" y="5" width="46" height="34"
                                            rx="2" ry="2" />
                                        <path class="cls-1" d="M13 43h22v4H13z" />
                                        <path class="cls-2" d="M17 39h14v4H17z" />
                                        <rect x="5" y="9" width="38" height="26" rx="2"
                                            ry="2" style="fill:#b5efff" />
                                        <path
                                            d="M41 9H7a2 2 0 0 0-2 2v3a2 2 0 0 1 2-2h34a2 2 0 0 1 2 2v-3a2 2 0 0 0-2-2z"
                                            style="fill:#80dbff" />
                                        <path
                                            d="M27 1H3a2 2 0 0 0-2 2v24a2 2 0 0 0 2 2h18v5l5-5h1a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2z"
                                            style="fill:#ffde91" />
                                        <path
                                            d="M4 27V3a2 2 0 0 1 2-2H3a2 2 0 0 0-2 2v24a2 2 0 0 0 2 2h3a2 2 0 0 1-2-2z"
                                            style="fill:#ffac5a" />
                                        <path
                                            d="M26 17v-4h-3.26a8.285 8.285 0 0 0-.85-2.06l2.3-2.3-2.83-2.83-2.3 2.3A8.285 8.285 0 0 0 17 7.26V4h-4v3.26a8.285 8.285 0 0 0-2.06.85l-2.3-2.3-2.83 2.83 2.3 2.3A8.285 8.285 0 0 0 7.26 13H4v4h3.26a8.285 8.285 0 0 0 .85 2.06l-2.3 2.3 2.83 2.83 2.3-2.3a8.285 8.285 0 0 0 2.06.85V26h4v-3.26a8.285 8.285 0 0 0 2.06-.85l2.3 2.3 2.83-2.83-2.3-2.3a8.285 8.285 0 0 0 .85-2.06zm-11 2a4 4 0 1 1 4-4 4 4 0 0 1-4 4z"
                                            style="fill:#fff" />
                                        <path class="cls-2" d="M42 5v7l-2 2h-2l-2-2V5z" />
                                        <path style="fill:#ff8257" d="M36 27h6v12h-6z" />
                                        <path style="fill:#f05e3a" d="M36 27h6v3h-6z" />
                                        <path class="cls-10"
                                            d="M2 37v-5H0v5a3 3 0 0 0 3 3h13v2h-3a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h22a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-3v-2h5v-2H3a1 1 0 0 1-1-1zm32 9H14v-2h20zm-4-4H18v-2h12zM26 18a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2.522a9.418 9.418 0 0 0-.361-.872L24.9 9.347a1 1 0 0 0 0-1.414L22.067 5.1a1 1 0 0 0-1.414 0l-1.781 1.78A9.418 9.418 0 0 0 18 6.522V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v2.522a9.418 9.418 0 0 0-.872.361L9.347 5.1a1 1 0 0 0-1.414 0L5.1 7.933a1 1 0 0 0 0 1.414l1.78 1.781a9.418 9.418 0 0 0-.358.872H4a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h2.522a9.418 9.418 0 0 0 .361.872L5.1 20.653a1 1 0 0 0 0 1.414l2.83 2.83a1 1 0 0 0 1.414 0l1.781-1.78a9.418 9.418 0 0 0 .872.361V26a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-2.522a9.418 9.418 0 0 0 .872-.361l1.781 1.78a1 1 0 0 0 1.414 0l2.83-2.83a1 1 0 0 0 0-1.414l-1.78-1.781a9.418 9.418 0 0 0 .364-.872zm-4.817 1.767 1.593 1.593-1.416 1.416-1.593-1.593a1 1 0 0 0-1.208-.159 7.327 7.327 0 0 1-1.811.748 1 1 0 0 0-.748.968V25h-2v-2.26a1 1 0 0 0-.748-.968 7.327 7.327 0 0 1-1.811-.748 1 1 0 0 0-1.208.159L8.64 22.776 7.224 21.36l1.593-1.593a1 1 0 0 0 .159-1.208 7.327 7.327 0 0 1-.748-1.811A1 1 0 0 0 7.26 16H5v-2h2.26a1 1 0 0 0 .968-.748 7.327 7.327 0 0 1 .748-1.811 1 1 0 0 0-.159-1.208L7.224 8.64 8.64 7.224l1.593 1.593a1 1 0 0 0 1.208.159 7.327 7.327 0 0 1 1.811-.748A1 1 0 0 0 14 7.26V5h2v2.26a1 1 0 0 0 .748.968 7.327 7.327 0 0 1 1.811.748 1 1 0 0 0 1.208-.159l1.593-1.593 1.416 1.416-1.593 1.593a1 1 0 0 0-.159 1.208 7.327 7.327 0 0 1 .748 1.811 1 1 0 0 0 .968.748H25v2h-2.26a1 1 0 0 0-.968.748 7.327 7.327 0 0 1-.748 1.811 1 1 0 0 0 .159 1.208z" />
                                        <path class="cls-10"
                                            d="M15 18a3 3 0 0 1 0-6v-2a5 5 0 1 0 5 5h-2a3 3 0 0 1-3 3z" />
                                        <path class="cls-10"
                                            d="M45 4v2a1 1 0 0 1 1 1v30a1 1 0 0 1-1 1h-2V28h1v-2h-4V15a1 1 0 0 0 .707-.293l2-2A1 1 0 0 0 43 12V5a1 1 0 0 0-1-1H30V3a3 3 0 0 0-3-3H3a3 3 0 0 0-3 3v24a3 3 0 0 0 3 3h17v4a1 1 0 0 0 .617.924A.987.987 0 0 0 21 35a1 1 0 0 0 .707-.293L26.414 30H27a3 3 0 0 0 3-3V14h3v-2h-4a1 1 0 0 0-1 1v14a1 1 0 0 1-1 1h-1a1 1 0 0 0-.707.293L22 31.586V29a1 1 0 0 0-1-1H3a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h24a1 1 0 0 1 1 1v2a1 1 0 0 0 1 1h6v6a1 1 0 0 0 .293.707l2 2A1 1 0 0 0 38 15v11h-4v2h1v4h2v-4h4v11a1 1 0 0 0 1 1h3a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm-8 7.586V6h4v5.586L39.586 13h-1.172z" />
                                        <path class="cls-10" d="M35 34h2v2h-2zM28 8h5v2h-5z" />
                                    </g>
                                </svg>
                            </div>
                            <span class="mx-2">{{ __('lang.settings') }}</span>
                        </a>
                        <div class="mega-menu dropdown-menu settings-menu" style="z-index: 8;">
                            <ul class="mega-menu-row d-flex flex-wrap p-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                style="list-style: none" role="menu">
                                {{-- ================= Column 1 ============== --}}
                                <li class="mega-menu-col col-md-3 p-0">
                                    <ul class="sub-menu p-0" style="list-style: none">
                                        {{-- ////// اخفاء واظهار اقسام البرنامج ////// --}}
                                        <li class="navbar_item">
                                            <a class="modules-button d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif"
                                                href="{{ route('getModules') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>@lang('lang.modules')
                                            </a>
                                        </li>
                                        {{-- ////// الاعدادات العامة ////// --}}
                                        <li class="navbar_item">
                                            <a class="general_settings-button d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif"
                                                href="{{ route('settings.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>@lang('lang.general_settings')
                                            </a>
                                        </li>
                                        {{-- ////// الخزائن ////// --}}
                                        <li class="navbar_item">
                                            <a class="moneysafes-button d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif"
                                                href="{{ route('moneysafe.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>@lang('lang.moneysafes')
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                {{-- ================= Column 2 ============== --}}
                                <li class="mega-menu-col col-md-3 p-0">
                                    <ul class="sub-menu p-0" style="list-style: none">
                                        {{-- ////// المخازن ////// --}}
                                        <li class="navbar_item">
                                            <a class="d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif stores-button"
                                                href="{{ route('store.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>@lang('lang.stores')
                                            </a>
                                        </li>
                                        {{-- ////// العلامة التجاية ////// --}}
                                        <li class="navbar_item">
                                            <a class="d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif brands-button"
                                                href="{{ route('brands.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>@lang('lang.brands')
                                            </a>
                                        </li>
                                        {{-- ////// الاقسام ////// --}}
                                        <li class="navbar_item">
                                            <a class="d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif categories-button"
                                                href="{{ route('sub-categories', 'category') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>@lang('categories.categories')
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                {{-- ================= Column 3 ============== --}}
                                <li class="mega-menu-col col-md-3 p-0">
                                    <ul class="sub-menu p-0" style="list-style: none">
                                        {{-- ////// الالوان ////// --}}
                                        <li class="navbar_item">
                                            <a class="d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif colors-button"
                                                href="{{ route('colors.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>@lang('colors.colors')
                                            </a>
                                        </li>
                                        {{-- ////// المقاسات ////// --}}
                                        <li class="navbar_item">
                                            <a class="d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif sizes-button"
                                                href="{{ route('sizes.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>@lang('sizes.sizes')
                                            </a>
                                        </li>
                                        {{-- ////// الوحدات ////// --}}
                                        <li class="navbar_item">
                                            <a class="d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif units-button"
                                                href="{{ route('units.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>@lang('units.units')
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="mega-menu-col col-md-3 p-0">
                                    <ul class="sub-menu p-0" style="list-style: none">
                                        {{-- ////////// نقاط البيع للصرافين ////////// --}}
                                        <li class="navbar_item">
                                            <a class="d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif stores_pos-button"
                                                href="{{ route('store-pos.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>@lang('lang.store_pos')
                                            </a>
                                        </li>
                                        {{-- ////////// الضرائب العامة ////////// --}}
                                        <li class="navbar_item">
                                            <a class="d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif general-tax-button"
                                                href="{{ route('general-tax.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>@lang('lang.general_tax')
                                            </a>
                                        </li>
                                        {{-- ////////// ضرائب المنتجات ////////// --}}
                                        <li class="navbar_item">
                                            <a class="d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif product_tax-button"
                                                href="{{ route('product-tax.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>@lang('lang.product_tax')
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="mega-menu-col col-md-3 p-0">
                                    <ul class="sub-menu p-0" style="list-style: none">
                                        <li class="navbar_item">
                                            <a style="cursor: pointer;font-weight: 600;text-decoration: none;"
                                                href="{{ route('branches.index') }}" target="_blank"
                                                class="branch-button d-flex @if (app()->isLocale('ar')) width-full text-end flex-row-reverse  @else flex-row text-start @endif text-decoration-none">
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
                    <li class="dropdown scroll mx-2 mb-0 p-0" style="height: 40px;">
                        <a href="javaScript:void();"
                            class="d-flex reports-menu align-items-center text-decoration-none @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif dropdown-toggle"
                            style="height: 100%;font-weight: 600" data-toggle="dropdown">
                            {{-- <img src="{{ asset('images/topbar/report.png') }}" class="img-fluid pl-1" alt="advanced"> --}}
                            <div style="width: 25px" class="d-flex align-items-center">
                                <img src="{{ asset('images/navbar/reports.svg') }}" alt="{{ __('lang.reports') }}">
                            </div>
                            <span class="mx-2">{{ __('lang.reports') }}</span>
                        </a>
                        <div class="mega-menu dropdown-menu settings-menu" style="width: 750px !important;">
                            <ul class="mega-menu-row d-flex flex-wrap p-0
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                style="list-style: none" role="menu">
                                <li class="mega-menu-col col-md-4 p-0">
                                    <ul class="sub-menu p-0" style="list-style: none">
                                        <li class="navbar_item">
                                            <a class="product-report-button d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif"
                                                target="_blank" href="{{ route('reports.products') }}"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none;">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.product_report') }}
                                            </a>
                                        </li>

                                        <li class="navbar_item">
                                            <a class="initial_balance_report-button d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif"
                                                target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none;"
                                                href="{{ route('reports.initial_balance') }}">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.initial_balance') }}
                                            </a>
                                        </li>

                                        {{-- +++++++++++ purchases report +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a class="purchases_report-button d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif"
                                                target="_blank" href="{{ route('reports.add_stock') }}"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none;">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.purchases_report') }}
                                            </a>
                                        </li>

                                        {{-- +++++++++++ Supplier Report +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                                href="{{ route('get-supplier-report.index') }}" target="_blank"
                                                class=" d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif get-supplier-report-button">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.supplier_report') }}
                                            </a>
                                        </li>

                                        {{-- +++++++++++ employees sales report +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                                href="{{ route('sales-per-employee.index') }}" target="_blank"
                                                class=" d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif sales_per_employee-report-button">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.sales_per_employee') }}
                                            </a>
                                        </li>
                                        {{--          Daily Purchase Report           --}}
                                        <li class="navbar_item">
                                            <a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                                href="{{ route('reports.daily_purchase_report') }}" target="_blank"
                                                class=" d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif daily_purchase_report-button">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.daily_purchase_report') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="mega-menu-col col-md-4 p-0">
                                    <ul class="sub-menu p-0" style="list-style: none">
                                        {{-- +++++++++++ sales report +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a class="sales-report-button  d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif"
                                                href="{{ route('sales-report.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.sales_report') }}
                                            </a>
                                        </li>
                                        {{-- +++++++++++ receivable report +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a class="receivable-report-button  d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif"
                                                href="{{ route('receivable-report.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.receivable_report') }}
                                            </a>
                                        </li>
                                        {{-- +++++++++++ payable report +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a class="payable-report-button  d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif"
                                                href="{{ route('payable-report.index') }}" target="_blank"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none;">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.payable_report') }}
                                            </a>
                                        </li>
                                        {{-- +++++++++++ Representative Salary Report +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a class="representative_salary_report-button  d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif"
                                                target="_blank"
                                                href="{{ route('representative_salary_report.index') }}"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i
                                                    class="mdi mdi-circle"></i>{{ __('lang.representative_salary_report') }}
                                            </a>
                                        </li>
                                        {{-- +++++++++++ profit Report +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a class="profit_report-button  d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif"
                                                target="_blank" href="{{ route('profit_report') }}"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i
                                                    class="mdi mdi-circle"></i>{{ __('lang.representative_salary_report') }}
                                            </a>
                                        </li>
                                        {{-- +++++++++++ monthly sales & purchase report +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a class="monthly_sale_and_purchase_report-button  d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif"
                                                target="_blank" href="{{ route('report.monthly_sale_report') }}"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i
                                                    class="mdi mdi-circle"></i>{{ __('lang.monthly_sale_and_purchase_report') }}
                                            </a>
                                        </li>
                                        {{-- +++++++++++ Get Due Report +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a class="store_stock_chart-button  d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif"
                                                target="_blank" href="{{ route('report.store_stock_chart') }}"
                                                style="cursor: pointer;font-weight: 600;text-decoration: none">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.store_stock_chart') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="mega-menu-col col-md-4 p-0">
                                    <ul class="sub-menu p-0" style="list-style: none">
                                        {{-- +++++++++++ customers report +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                                href="{{ route('customers-report.index') }}" target="_blank"
                                                class=" d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif customers-report-button">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.customers_report') }}
                                            </a>
                                        </li>
                                        {{-- +++++++++++ Daily Report Summary +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                                href="{{ route('daily-report-summary.index') }}" target="_blank"
                                                class=" d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif daily-report-summary-button">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.daily_report_summary') }}
                                            </a>
                                        </li>
                                        {{-- +++++++++++ Get Due Report +++++++++++ --}}
                                        <li class="navbar_item">
                                            <a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                                href="{{ route('get-due-report.index') }}" target="_blank"
                                                class=" d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif get-due-report-button">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.get_due_report') }}
                                            </a>
                                        </li>
                                        <li class="navbar_item">
                                            <a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                                href="{{ route('reports.best_seller') }}" target="_blank"
                                                class=" d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif best-seller-button">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.best_seller_report') }}
                                            </a>
                                        </li>
                                        <li class="navbar_item">
                                            <a style="cursor: pointer;font-weight: 600;text-decoration: none"
                                                href="{{ route('reports.daily_sales_report') }}" target="_blank"
                                                class=" d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif daily_sale_report-button">
                                                <i class="mdi mdi-circle"></i>{{ __('lang.daily_sale_report') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                {{-- @endcan --}}
                <li class="scroll  mx-2 mb-0 p-0" style="height: 40px;">
                    <a class="due-button align-items-center d-flex @if (app()->isLocale('ar')) flex-row-reverse  @else flex-row @endif"
                        style="cursor: pointer;font-weight: 600;text-decoration: none;height: 100%;" target="_blank"
                        href="{{ route('dues') }}">
                        <div style="width: 25px" class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"style="width:100%" viewBox="0 0 256 256"
                                xml:space="preserve">
                                <path fill="#AFAFAF"
                                    d="M232.63 155.041c-4.49 12.366-11.121 23.708-19.416 33.585a4.572 4.572 0 0 1-5.793 1.012l-10.4-6.002c-12.296 12.738-28.106 22.091-45.847 26.5v11.983a4.59 4.59 0 0 1-3.794 4.516c-2.497.441-5.017.801-7.548 1.068v-13.716a5.817 5.817 0 0 0-5.817-5.817h-12.029a5.817 5.817 0 0 0-5.817 5.817v13.716a109.272 109.272 0 0 1-7.548-1.068 4.59 4.59 0 0 1-3.794-4.516v-11.983c-17.741-4.409-33.55-13.762-45.847-26.5l-10.4 6.002a4.57 4.57 0 0 1-5.793-1.012c-8.295-9.877-14.926-21.219-19.416-33.585a4.603 4.603 0 0 1 2.024-5.538l10.389-5.991c-4.909-17.113-4.967-35.645 0-52.955l-10.389-6.002a4.588 4.588 0 0 1-2.024-5.526c4.49-12.367 11.121-23.709 19.416-33.585a4.588 4.588 0 0 1 5.793-1.024l10.4 6.002c12.296-12.738 28.106-22.08 45.847-26.489V11.94a4.578 4.578 0 0 1 3.781-4.502 111.929 111.929 0 0 1 38.785 0 4.577 4.577 0 0 1 3.781 4.502v11.994c17.741 4.409 33.55 13.751 45.847 26.489l10.4-6.002a4.587 4.587 0 0 1 5.793 1.024c8.295 9.876 14.926 21.219 19.416 33.585a4.588 4.588 0 0 1-2.024 5.526l-10.389 6.002c4.909 17.101 4.967 35.645 0 52.955l10.389 5.991a4.602 4.602 0 0 1 2.024 5.537z" />
                                <circle fill="#FC5D3D" cx="128" cy="117.033" r="67.169" />
                                <circle fill="#EFEFEF" cx="128" cy="117.033" r="49.917" />
                                <path fill="#13BF6C"
                                    d="m142.99 98.773-20.91 20.91-9.07-9.07a7.36 7.36 0 0 0-10.408 10.408l14.274 14.274a7.36 7.36 0 0 0 10.408 0l26.114-26.114a7.36 7.36 0 0 0 0-10.408 7.358 7.358 0 0 0-10.408 0z" />
                                <path fill="#FC5D3D"
                                    d="M139.831 213.987v37.68h-23.662v-37.68a5.817 5.817 0 0 1 5.817-5.817h12.029a5.816 5.816 0 0 1 5.816 5.817z" />
                                <path fill="#EFEFEF"
                                    d="M140.126 199.14a2.5 2.5 0 0 1 2.028-2.896c37.96-6.689 67.004-39.718 67.004-79.923 0-15.788-4.528-31.084-13.095-44.233a2.5 2.5 0 1 1 4.189-2.729c9.097 13.963 13.905 30.202 13.905 46.962 0 42.675-30.827 77.744-71.137 84.847a2.5 2.5 0 0 1-2.894-2.028zM190.299 64.3a82.374 82.374 0 0 0-4.911-5.363 2.5 2.5 0 1 1 3.535-3.537 87.253 87.253 0 0 1 5.21 5.691 2.498 2.498 0 0 1-.313 3.521 2.497 2.497 0 0 1-3.521-.312zM110.26 200.645a85.362 85.362 0 0 1-30.501-12.918 2.5 2.5 0 0 1 2.804-4.141 80.36 80.36 0 0 0 28.723 12.164 2.5 2.5 0 0 1-1.026 4.895zm-38.664-19.188a87.984 87.984 0 0 1-4.518-4.211 2.498 2.498 0 0 1 0-3.535 2.498 2.498 0 0 1 3.535 0 83.067 83.067 0 0 0 4.26 3.969 2.502 2.502 0 0 1 .25 3.527 2.502 2.502 0 0 1-3.527.25z" />
                                <path fill="#FFCBC3"
                                    d="M130.112 246.066a2.5 2.5 0 0 1-2.5-2.5v-9.404a2.5 2.5 0 1 1 5 0v9.404a2.5 2.5 0 0 1-2.5 2.5zm0-19.404a2.5 2.5 0 0 1-2.5-2.5v-4a2.5 2.5 0 1 1 5 0v4a2.5 2.5 0 0 1-2.5 2.5z" />
                                <path
                                    d="M139.46 118.87a2.496 2.496 0 0 0 0 3.529 2.508 2.508 0 0 0 3.54 0 2.5 2.5 0 0 0 0-3.529c-.94-.951-2.589-.951-3.54 0z" />
                                <path
                                    d="M146.541 111.799c-1.003.98-.968 2.572-.01 3.53.949.95 2.6.95 3.539 0l5.091-5.09c3.801-3.803 3.904-10.056 0-13.94-3.82-3.84-10.091-3.87-13.94 0l-19.14 19.14-7.3-7.31c-3.747-3.747-10.025-3.936-13.95.01-3.771 3.772-3.915 10.004 0 13.94l14.28 14.27c3.69 3.71 9.95 3.991 13.94 0l6.88-6.88c.97-.97.97-2.56 0-3.53-.939-.939-2.59-.949-3.53 0l-6.879 6.88a4.873 4.873 0 0 1-6.88 0l-14.27-14.279a4.862 4.862 0 0 1 0-6.87 4.85 4.85 0 0 1 6.87 0l9.07 9.07c.95.939 2.59.939 3.54 0l20.91-20.91c1.867-1.887 4.966-1.904 6.87 0 1.938 1.938 1.85 5.039 0 6.87l-5.091 5.099zM76.57 38.33a2.512 2.512 0 0 0 .71-3.471c-.73-1.109-2.35-1.449-3.46-.71a2.512 2.512 0 0 0-.71 3.471 2.503 2.503 0 0 0 3.46.71z" />
                                <path
                                    d="M21.021 155.179c4.54 12.51 11.22 24.07 19.85 34.34 2.212 2.638 5.99 3.282 8.97 1.57l8.72-5.03c12.15 12.101 27.29 20.851 43.77 25.3v10.051a7.08 7.08 0 0 0 5.86 6.979c1.84.325 3.669.584 5.48.813v21.757a2.5 2.5 0 0 0 5 0v-37.68c0-1.83 1.49-3.32 3.32-3.32h12.03c1.82 0 3.311 1.49 3.311 3.32v37.68a2.5 2.5 0 0 0 5 0v-21.757a112.58 112.58 0 0 0 5.479-.813 7.089 7.089 0 0 0 5.86-6.979v-10.051c16.479-4.449 31.61-13.199 43.77-25.3l8.73 5.03c2.895 1.677 6.7 1.119 8.96-1.56 8.63-10.28 15.31-21.83 19.85-34.341a7.12 7.12 0 0 0-3.12-8.56l-8.72-5.03a98.489 98.489 0 0 0 3.28-25.27c0-8.57-1.101-17.08-3.28-25.28l8.72-5.04c2.962-1.724 4.286-5.336 3.12-8.54-4.54-12.51-11.22-24.07-19.85-34.35a7.084 7.084 0 0 0-8.96-1.57l-8.73 5.03c-12.149-12.101-27.279-20.84-43.77-25.29V11.229c0-3.439-2.46-6.37-5.851-6.96-12.96-2.3-26.64-2.31-39.649 0a7.053 7.053 0 0 0-5.84 6.96V21.29a97.725 97.725 0 0 0-19.67 7.67c-1.171.586-1.732 2.087-1.07 3.37.676 1.304 2.271 1.657 3.37 1.06a93.165 93.165 0 0 1 20.47-7.74 2.5 2.5 0 0 0 1.9-2.43V11.23c-.01-1 .73-1.87 1.71-2.04 12.41-2.199 25.5-2.199 37.91 0 .989.17 1.729 1.04 1.72 2.04v11.99c0 1.15.78 2.15 1.899 2.43 16.99 4.22 32.43 13.14 44.65 25.8.771.8 2.09.979 3.05.43l10.4-6.01c.87-.49 2-.28 2.63.47 8.26 9.83 14.64 20.88 18.98 32.83.345.958-.082 2.02-.931 2.51l-10.39 6a2.52 2.52 0 0 0-1.15 2.86c2.4 8.33 3.61 17.01 3.61 25.79a93.21 93.21 0 0 1-3.61 25.779c-.31 1.11.16 2.28 1.16 2.86l10.39 5.99c.899.52 1.258 1.638.91 2.53-4.33 11.949-10.71 22.989-18.97 32.819-.632.763-1.76.96-2.62.46l-10.41-6.01c-.97-.56-2.279-.37-3.05.43-12.229 12.67-27.67 21.591-44.65 25.811a2.491 2.491 0 0 0-1.899 2.42v11.99c.01 1.01-.72 1.88-1.73 2.05-1.548.273-3.085.5-4.609.704V213.28c0-4.591-3.73-8.32-8.311-8.32h-3.52v-19.031c37.48-1.308 67.17-32.098 67.17-69.61 0-38.426-31.133-69.659-69.67-69.659-5.78 0-11.53.71-17.1 2.109-1.33.34-2.15 1.7-1.81 3.04.33 1.311 1.72 2.141 3.04 1.811A64.856 64.856 0 0 1 128 51.649c35.896.022 64.67 29.079 64.67 64.67 0 35.71-28.89 64.671-64.67 64.671-35.723 0-64.67-28.912-64.67-64.671 0-22.77 11.64-43.439 31.12-55.289a2.508 2.508 0 0 0 .84-3.44 2.495 2.495 0 0 0-3.44-.83C71.609 69.057 58.33 91.3 58.33 116.319c0 37.342 29.524 68.296 67.17 69.61v19.031h-3.51c-4.59 0-8.32 3.729-8.32 8.32v10.885c-1.518-.2-3.053-.426-4.61-.705a2.072 2.072 0 0 1-1.73-2.05v-11.99c0-1.15-.78-2.14-1.9-2.42-16.99-4.22-32.43-13.15-44.65-25.811-.78-.8-2.09-.989-3.05-.43l-10.4 6c-.897.534-2.009.287-2.63-.46-8.26-9.82-14.64-20.87-18.98-32.82a2.1 2.1 0 0 1 .93-2.52l10.38-5.99c1-.58 1.47-1.75 1.16-2.86-2.4-8.34-3.61-17.01-3.61-25.79 0-8.779 1.21-17.449 3.6-25.779.32-1.11-.15-2.28-1.15-2.86l-10.38-6a2.077 2.077 0 0 1-.93-2.5c4.34-11.96 10.73-23.01 18.98-32.84a2.097 2.097 0 0 1 2.63-.47l10.4 6.01c.96.55 2.28.37 3.05-.43a93.39 93.39 0 0 1 7.96-7.341c1.082-.911 1.207-2.492.34-3.52-.84-1.03-2.49-1.19-3.52-.35a99.806 99.806 0 0 0-7 6.34l-8.73-5.03a7.084 7.084 0 0 0-8.96 1.57c-8.63 10.279-15.31 21.83-19.85 34.35-1.147 3.108.09 6.778 3.13 8.54l8.71 5.04c-2.18 8.2-3.28 16.7-3.28 25.27s1.1 17.07 3.28 25.28l-8.71 5.03c-2.911 1.688-4.314 5.253-3.129 8.55z" />
                                <path
                                    d="M75.58 116.33c0 28.916 23.452 52.41 52.42 52.41 28.941 0 52.41-23.446 52.41-52.41 0-1.38-1.12-2.5-2.49-2.5a2.5 2.5 0 0 0-2.5 2.5c-.02 26.194-21.201 47.41-47.42 47.41-26.173 0-47.42-21.19-47.42-47.41 0-26.157 21.158-47.42 47.43-47.42 19.71 0 37.58 12.409 44.45 30.899.46 1.25 1.95 1.94 3.21 1.471a2.507 2.507 0 0 0 1.479-3.221C169.78 78.274 150.693 63.91 128 63.91c-28.898 0-52.42 23.416-52.42 52.42z" />
                                <path
                                    d="M174.85 108.979a2.492 2.492 0 0 0 2.86 2.08 2.498 2.498 0 0 0 2.08-2.85 2.505 2.505 0 0 0-2.851-2.09c-1.37.204-2.295 1.495-2.089 2.86zM103.01 56.66c1.27-.53 1.87-2 1.34-3.271-.52-1.229-2.02-1.859-3.26-1.34h-.01c-1.27.53-1.88 2-1.34 3.27a2.481 2.481 0 0 0 3.27 1.341z" />
                            </svg>
                        </div>
                        {{-- <img src="{{ asset('images/topbar/warehouse.png') }}" class="img-fluid" alt="components"> --}}
                        <span class="mx-2">{{ __('lang.dues') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</nav>
<!-- End Horizontal Nav -->
{{-- </div>
    <!-- End container-fluid -->
</div> --}}
<!-- End Navigationbar -->
<script>
    const menuButton = document.getElementById('menu-button');
    const menu = document.getElementById('menu');

    menuButton.addEventListener('click', function() {
        if (menu.style.display === 'block') {
            menu.style.display = 'none'
        } else {
            menu.style.display = 'block'
        }
    })

    $('.initial-balance-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('new-initial-balance.create') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.home-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ url('/') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.products-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('products.create') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.cashier-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('pos.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")

    })
    $('.cash-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('cash.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.purchases-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('stocks.create') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.purchases-order-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('purchase_order.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.required-products-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('required-products.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.return-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sell_return.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.product-return-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('suppliers.returns.products') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.supplier-return-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('suppliers.returns.invoices') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.jobs-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('jobs.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.employees-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('employees.create') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.wages-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('wages.create') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.attendance-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('attendance.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.customers-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('customers.create') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.delivery-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('delivery.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.plans-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('delivery_plan.plansList') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.customer-types-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('customertypes.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.customer-price-offer-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('customer_price_offer.create') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.suppliers-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('suppliers.create') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.sell-car-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sell-car.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.sell-car-delivery-button').on('click', function(e) {
        e.preventDefault();
        let url =
            "{{ route('delivery.index') }} "
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.rep-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('representatives.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.rep-plans-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('rep_plan.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.modules-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('getModules') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.general_settings-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('settings.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.moneysafes-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('moneysafe.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.stores-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('store.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.brands-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('brands.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.categories-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sub-categories', 'category') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.colors-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('colors.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.sizes-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sizes.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.units-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('units.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.stores_pos-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('store-pos.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.general-tax-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('general-tax.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.product_tax-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('product-tax.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.product-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('reports.products') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.initial_balance_report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('reports.initial_balance') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.purchases_report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('reports.add_stock') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.sales-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sales-report.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.receivable-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('receivable-report.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.payable-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('payable-report.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.customers-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('customers-report.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.daily-report-summary-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('daily-report-summary.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.get-due-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('get-due-report.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.best-seller-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('reports.best_seller') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.daily_sale_report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('reports.daily_sales_report') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.get-supplier-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('get-supplier-report.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.sales_per_employee-report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sales-per-employee.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.daily_purchase_report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('reports.daily_purchase_report') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.representative_salary_report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('representative_salary_report.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.profit_report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('profit_report') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.monthly_sale_and_purchase_report-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('report.monthly_sale_report') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.store_stock_chart-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('report.store_stock_chart') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.due-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('dues') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
    $('.branch-button').on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('branches.index') }}"
        document.body.classList.add('animated-element');
        // window.location.href = url;
        window.open(url, "_blank")
    })
</script>
