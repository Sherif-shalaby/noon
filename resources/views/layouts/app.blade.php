@php
    $local_code = LaravelLocalization::getCurrentLocale();
@endphp
<!DOCTYPE html>
<html lang="{{ $local_code }}">
{{-- dir="rtl" --}}

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Theta is a bootstrap & laravel admin dashboard template">
    <meta name="keywords"
        content="admin, admin dashboard, admin panel, admin template, analytics, bootstrap 4, crm, laravel admin, responsive, sass support, ui kits">
    <meta name="author" content="Themesbox17">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@yield('title')</title>
    <!-- Fevicon -->
    @include('layouts.partials.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    @stack('css')
    <link rel="stylesheet" href="{{ url('css/front-style.css') }}">
    <!-- End css -->
    @livewireStyles
</head>

<body class="horizontal-layout relative">

    <div class="overlay">
        <div style="width: 55%;overflow: hidden;position: relative;">
            <img style="width: 100%;z-index: 10;position: relative;" src="{{ asset('images/logo2.png') }}"
                alt="logo">
            <span class="box"></span>
        </div>
        {{-- <div style="width: 55%;overflow: hidden;position: absolute;top: 0;left: 0;">
            <img class="arrow-down" src="{{ asset('images/arrow-down-1.png') }}" alt="logo">
            <img style="width: 100%;z-index: 10;position: absolute;" src="{{ asset('images/arrow-up-1.png') }}"
                alt="logo">
            <img style="width: 100%;z-index: 10;position: relative;" src="{{ asset('images/word1.png') }}"
                alt="logo">
        </div> --}}
    </div>


    {{-- <body class="horizontal-layout"> --}}
    <!-- Start Infobar Notifications Sidebar -->
    <div id="infobar-notifications-sidebar" class="infobar-notifications-sidebar">
        <div class="infobar-notifications-sidebar-head d-flex w-100 justify-content-between">
            <h4>Notifications</h4><a href="javascript:void(0)" id="infobar-notifications-close"
                class="infobar-notifications-close"><img src="{{ asset('images/svg-icon/close.svg') }}"
                    class="img-fluid menu-hamburger-close" alt="close"></a>
        </div>
        <div class="infobar-notifications-sidebar-body">
            <ul class="nav nav-pills nav-justified" id="infobar-pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-messages-tab" data-toggle="pill" href="#pills-messages"
                        role="tab" aria-controls="pills-messages" aria-selected="true">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-emails-tab" data-toggle="pill" href="#pills-emails" role="tab"
                        aria-controls="pills-emails" aria-selected="false">Emails</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-actions-tab" data-toggle="pill" href="#pills-actions" role="tab"
                        aria-controls="pills-actions" aria-selected="false">Actions</a>
                </li>
            </ul>
            <div class="tab-content" id="infobar-pills-tabContent">
                <div class="tab-pane fade show active" id="pills-messages" role="tabpanel"
                    aria-labelledby="pills-messages-tab">
                    <ul class="list-unstyled">
                        <li class="media">
                            <img class="mr-3 align-self-center rounded-circle"
                                src="{{ asset('images/users/girl.svg') }}" alt="Generic placeholder image">
                            <div class="media-body">
                                <h5>Amy Adams<span class="badge badge-success">1</span><span class="timing">Jan
                                        22</span></h5>
                                <p>Hey!! What are you doing tonight ?</p>
                            </div>
                        </li>
                        <li class="media">
                            <img class="mr-3 align-self-center rounded-circle" src="{{ asset('images/users/boy.svg') }}"
                                alt="Generic placeholder image">
                            <div class="media-body">
                                <h5>James Simpsons<span class="badge badge-success">2</span><span class="timing">Feb
                                        15</span></h5>
                                <p>What's up ???</p>
                            </div>
                        </li>
                        <li class="media">
                            <img class="mr-3 align-self-center rounded-circle" src="{{ asset('images/users/men.svg') }}"
                                alt="Generic placeholder image">
                            <div class="media-body">
                                <h5>Mark Witherspoon<span class="badge badge-success">3</span><span class="timing">Mar
                                        03</span></h5>
                                <p>I will be late today in office.</p>
                            </div>
                        </li>
                        <li class="media">
                            <img class="mr-3 align-self-center rounded-circle"
                                src="{{ asset('images/users/women.svg') }}" alt="Generic placeholder image">
                            <div class="media-body">
                                <h5>Jenniffer Wills<span class="badge badge-success">4</span><span class="timing">Apr
                                        05</span></h5>
                                <p>Venture presentation is ready.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="pills-emails" role="tabpanel" aria-labelledby="pills-emails-tab">
                    <ul class="list-unstyled">
                        <li class="media">
                            <span class="mr-3 align-self-center img-icon">N</span>
                            <div class="media-body">
                                <h5>Nelson Smith<span class="timing">Jan 22</span></h5>
                                <p><span class="badge badge-danger-inverse">WORK</span>Salary has been processed.
                                </p>
                            </div>
                        </li>
                        <li class="media">
                            <span class="mr-3 align-self-center img-icon">C</span>
                            <div class="media-body">
                                <h5>Courtney Cox<i class="feather icon-star text-warning ml-2"></i><span
                                        class="timing">Feb 15</span></h5>
                                <p><span class="badge badge-success-inverse">URGENT</span>New product launching...
                                </p>
                            </div>
                        </li>
                        <li class="media">
                            <span class="mr-3 align-self-center img-icon">R</span>
                            <div class="media-body">
                                <h5>Rachel White<span class="timing">Mar 03</span></h5>
                                <p><span class="badge badge-secondary-inverse">ORDER</span><span
                                        class="badge badge-info-inverse">SHOPPING</span>Your order has been...</p>
                            </div>
                        </li>
                        <li class="media">
                            <span class="mr-3 align-self-center img-icon">F</span>
                            <div class="media-body">
                                <h5>Freepik<span class="timing">Mar 03</span></h5>
                                <p><a href="#" class="badge badge-primary mr-2">VERIFY NOW</a>New Sign
                                    verification req...</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="pills-actions" role="tabpanel" aria-labelledby="pills-actions-tab">
                    <ul class="list-unstyled">
                        <li class="media">
                            <span class="mr-3 action-icon badge badge-success-inverse"><i
                                    class="feather icon-check"></i></span>
                            <div class="media-body">
                                <h5 class="action-title">Payment Success !!!</h5>
                                <p class="my-3">We have received your payment toward ad Account : 9876543210.
                                    Your Ad
                                    is Running.</p>
                                <p><span class="badge badge-danger-inverse">INFO</span><span
                                        class="badge badge-info-inverse">STATUS</span><span class="timing">Today,
                                        09:39 PM</span></p>
                            </div>
                        </li>
                        <li class="media">
                            <span class="mr-3 action-icon badge badge-primary-inverse"><i
                                    class="feather icon-calendar"></i></span>
                            <div class="media-body">
                                <h5 class="action-title">Nobita Applied for Leave.</h5>
                                <p class="my-3">Nobita applied for leave due to personal reasons on 22nd Feb.</p>
                                <p><span class="badge badge-success">APPROVE</span><span
                                        class="badge badge-danger">REJECT</span><span class="timing">Yesterday,
                                        05:25
                                        PM</span></p>
                            </div>
                        </li>
                        <li class="media">
                            <span class="mr-3 action-icon badge badge-danger-inverse"><i
                                    class="feather icon-alert-triangle"></i></span>
                            <div class="media-body">
                                <h5 class="action-title">Alert</h5>
                                <p class="my-3">There has been new Log in fron your account at Melbourne. Mark it
                                    safe or report.</p>
                                <p><i class="feather icon-check text-success mr-3"></i><a href="#"
                                        class="text-muted">Report Now</a><span class="timing">5 Jan 2019, 02:13
                                        PM</span></p>
                            </div>
                        </li>
                        <li class="media">
                            <span class="mr-3 action-icon badge badge-warning-inverse"><i
                                    class="feather icon-award"></i></span>
                            <div class="media-body">
                                <h5 class="action-title">Congratulations !!!</h5>
                                <p class="my-3">Your role in the organization has been changed from Editor to
                                    Chief
                                    Strategist.</p>
                                <p><span class="badge badge-danger-inverse">ACTIVITY</span><span class="timing">10
                                        Jan
                                        2019, 08:49 PM</span></p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Containerbar -->
    <div id="containerbar" class="pl-3 pr-3 bg-white">

        @include('layouts.partials.header')

        {{-- @php
            $notifications = \App\Models\BalanceRequestNotification::orderby('created_at', 'desc')->get();
            $notification_count = \App\Models\BalanceRequestNotification::orderby('created_at', 'desc')
                ->where('isread', 0)
                ->count();
        @endphp --}}
        @include('layouts.partials.leftbar')

        <!-- Start Rightbar -->
        <div class="rightbar">
            <!-- Start Topbar Mobile -->
            <div class="topbar-mobile">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="mobile-logobar">
                            <a href="index.html" class="mobile-logo">
                                <img src="{{ asset('images/logo.svg') }}" class="img-fluid" alt="logo">
                            </a>
                        </div>
                        <div class="mobile-togglebar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="topbar-toggle-icon">
                                        <a class="topbar-toggle-hamburger" href="javascript:void();">
                                            <img src="{{ asset('images/svg-icon/horizontal.svg') }}"
                                                class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                            <img src="{{ asset('images/svg-icon/verticle.svg') }}"
                                                class="img-fluid menu-hamburger-vertical" alt="verticle">
                                        </a>
                                    </div>
                                </li>
                                <li class="list-inline-item" id="toggle-responsive-nav">
                                    <div class="menubar">
                                        <a class="menu-hamburger navbar-toggle bg-transparent"
                                            href="javascript:void();" data-toggle="collapse"
                                            data-target="#navbar-menu" aria-expanded="true">

                                            <img src="{{ asset('images/svg-icon/collapse.svg') }}"
                                                class="img-fluid menu-hamburger-collapse" alt="collapse">
                                            <img src="{{ asset('images/svg-icon/close.svg') }}"
                                                class="img-fluid menu-hamburger-close" alt="close">
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Topbar Mobile -->
            @yield('breadcrumbbar')
            @yield('content')
        </div>
        <!-- End Rightbar -->

        @include('layouts.partials.footer')
    </div>
    <!-- End Containerbar -->
    <!-- Start js -->
    @include('layouts.partials.javascript')

    @yield('javascript')

    @livewireScripts

    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts /> --}}
    @stack('js')
    <script>
        window.addEventListener('swal:modal', event => {
            Swal.fire({
                title: event.detail.message,
                text: event.detail.text,
                icon: event.detail.type,
            });
        });

        window.addEventListener('swal:confirm', event => {
            Swal.fire({
                    title: event.detail.message,
                    text: event.detail.text,
                    icon: event.detail.type,
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.livewire.emit('remove');
                    }
                });
        });

        window.addEventListener('load', function() {
            var loaderWrapper = document.querySelector('.loading');
            loaderWrapper.style.display = 'none'; // Hide the loader once the page is fully loaded
        });

        // window.addEventListener("beforeunload", (event) => {
        //     document.body.classList.add('animated-element');
        // });
        let toggleButton = document.getElementById('toggle-responsive-nav')
        let navbarMenu = document.getElementById('navbar-menu')
    </script>

    {{-- <script src="https://unpkg.com/swup@4"></script>
    <script>
        const swup = new Swup();
    </script> --}}
    {{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        $(document).ready(function() {
            // $('.online-balance-badge').hide();
        })
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        var obj = new Object();
        var notificationContents = [];
        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });
        var channel = pusher.subscribe('order-channel');
        channel.bind('new-order', function(data) {
            // if(data.product_id){
            // }
            if (data) {

                let badge_count = parseInt($('.online-balance-badge').text()) + 1;
                alert(badge_count)
                $('.online-balance-badge').text(badge_count);
                $('.online-balance-badge').show();
            }
        });
    </script> --}}
    <script>
        // Wait for the DOM content to be fully loaded
        document.addEventListener("DOMContentLoaded", function() {
            // Set overflow to hidden initially
            document.body.style.overflowY = "hidden";
            document.body.style.height = "100vh";

            // Remove overflow hidden after 1.5 seconds
            setTimeout(function() {
                document.body.style.overflowY = "auto"; // Or "visible" depending on your requirements
                document.body.style.height = "fit-content"; // Or "visible" depending on your requirements
            }, 500);
        });
    </script>


</body>

<!-- Mirrored from themesbox.in/admin-templates/theta/html/light-horizontal/page-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 03 Jul 2023 09:24:31 GMT -->

</html>
