<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <link rel="shortcut icon" href="{{asset('/uploads/'.$settings['logo'])}}">  --}}
<!-- Start css -->
<!-- Switchery css -->
{{-- <link href="{{ asset('plugins/animate/animate.css') }}" rel="stylesheet" type="text/css"> --}}
<link href="{{ asset('plugins/switchery/switchery.min.css') }}" rel="stylesheet">
<!-- Select2 css -->
<link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css">
<!-- Tagsinput css -->
{{--    <link href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css">--}}
{{--    <link href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css')}}" rel="stylesheet" type="text/css">--}}
<!-- DataTables css -->
<link href="{{asset('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!---->
<!-- Pnotify css -->
<link href="{{ asset('plugins/pnotify/css/pnotify.custom.min.css')}}" rel="stylesheet" type="text/css">

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/icons.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">

<!-- Responsive Datatable css -->
<link href="{{asset('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/style.default.css')}}" id="theme-stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('css/dropzone.css')}}">
<link rel="stylesheet" href="{{asset('js/cropperjs/cropper.min.css') }}">
<link rel="stylesheet" href="{{asset('css/style2.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('js/select/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/crop/crop.css') }}">
{{-- <script src="{{asset('js/jquery.min.js')}}"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript" src="{{asset('js/toastr/toastr.min.js')}}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="{{asset('js/jquery-ui.css')}}">
<style>
    .error-help-block{
        color:red;
    }
    input[type="text"],input[type="month"],input[type="number"],textarea{
       border:2px solid #cececf !important;
    }
{{--    @if(request()->segment(2) == 'invoices')--}}
{{--    /* -- Horizontal Navbar -- */--}}
{{--    .horizontal-nav {--}}
{{--        background-color: transparent;--}}
{{--        border-color: transparent;--}}
{{--        /* -- Dropdown Mega Menu -- */--}}
{{--        /* -- Dropdown Mega Menu -- */--}}
{{--        /* -- Mega Menu -- */--}}
{{--    }--}}
{{--    .horizontal-nav .dropdown-menu {--}}
{{--        top: 0;--}}
{{--        padding: 0;--}}
{{--    }--}}
{{--    .horizontal-nav .navbar-collapse {--}}
{{--        overflow-y: auto !important;--}}
{{--    }--}}
{{--    .horizontal-nav .mega-menu-col .mega-menu-col-title,--}}
{{--    .horizontal-nav .dropdown .dropdown-toggle {--}}
{{--        padding: 12px 30px 12px 12px;--}}
{{--    }--}}
{{--    .horizontal-nav .mega-menu-col .mega-menu-col-title:before,--}}
{{--    .horizontal-nav .dropdown .dropdown-toggle:before {--}}
{{--        float: right;--}}
{{--        content: "";--}}
{{--        font-size: 16px;--}}
{{--        font-weight: 700;--}}
{{--        position: absolute;--}}
{{--        right: 8px;--}}
{{--    }--}}
{{--    .horizontal-nav .mega-menu-col.on .mega-menu-col-title:before,--}}
{{--    .horizontal-nav .dropdown.on > .dropdown-toggle:before {--}}
{{--        transform: rotate(-270deg);--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu {--}}
{{--        float: none !important;--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu li {--}}
{{--        float: none;--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu li .mega-menu-col-title,--}}
{{--    .horizontal-nav .horizontal-menu li a {--}}
{{--        max-width: inherit;--}}
{{--        padding: 8px 10px;--}}
{{--        font-weight: 400;--}}
{{--        display: block;--}}
{{--        cursor: pointer;--}}
{{--        font-size: 16px;--}}
{{--        line-height: 20px;--}}
{{--        color: #282828;--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu li .mega-menu-col-title img,--}}
{{--    .horizontal-nav .horizontal-menu li a img {--}}
{{--        filter: invert(0.6) sepia(1) saturate(1) hue-rotate(185deg);--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu li a:hover,--}}
{{--    .horizontal-nav .horizontal-menu li a:focus, .horizontal-nav .horizontal-menu li.active > a,--}}
{{--    .horizontal-nav .horizontal-menu li .mega-menu-col-title:hover,--}}
{{--    .horizontal-nav .horizontal-menu li .mega-menu.dropdown-menu .mega-menu-col .active > a,--}}
{{--    .horizontal-nav .horizontal-menu li .dropdown-menu li.active > a,--}}
{{--    .horizontal-nav .horizontal-menu li .dropdown-menu li a:hover,--}}
{{--    .horizontal-nav .horizontal-menu li .dropdown-menu li a:focus,--}}
{{--    .horizontal-nav .horizontal-menu li .mega-menu .mega-menu-col ul li a:hover,--}}
{{--    .horizontal-nav .horizontal-menu li .mega-menu .mega-menu-col ul li a:focus {--}}
{{--        color: #6e81dc;--}}
{{--        background-color: transparent;--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu li a:hover img,--}}
{{--    .horizontal-nav .horizontal-menu li a:focus img, .horizontal-nav .horizontal-menu li.active > a img,--}}
{{--    .horizontal-nav .horizontal-menu li .mega-menu-col-title:hover img,--}}
{{--    .horizontal-nav .horizontal-menu li .mega-menu.dropdown-menu .mega-menu-col .active > a img,--}}
{{--    .horizontal-nav .horizontal-menu li .dropdown-menu li.active > a img,--}}
{{--    .horizontal-nav .horizontal-menu li .dropdown-menu li a:hover img,--}}
{{--    .horizontal-nav .horizontal-menu li .dropdown-menu li a:focus img,--}}
{{--    .horizontal-nav .horizontal-menu li .mega-menu .mega-menu-col ul li a:hover img,--}}
{{--    .horizontal-nav .horizontal-menu li .mega-menu .mega-menu-col ul li a:focus img {--}}
{{--        filter: invert(0.62) sepia(1) saturate(4.5) hue-rotate(199deg);--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu > li:first-child > a {--}}
{{--        border-top: 0;--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu .dropdown .mega-menu.dropdown-menu,--}}
{{--    .horizontal-nav .horizontal-menu .dropdown .dropdown-menu {--}}
{{--        float: none;--}}
{{--        position: relative;--}}
{{--        left: 0;--}}
{{--        box-shadow: 0px 0px 0px;--}}
{{--        border-radius: 0px 0px 0px;--}}
{{--        border: 0;--}}
{{--        background-color: transparent;--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu .dropdown .dropdown-menu {--}}
{{--        padding-left: 28px;--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu .dropdown .dropdown-menu .dropdown-menu {--}}
{{--        padding-left: 18px;--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu .dropdown .mega-menu.dropdown-menu .mega-menu-row {--}}
{{--        float: none;--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu .dropdown .mega-menu.dropdown-menu .mega-menu-row .mega-menu-col {--}}
{{--        padding: 0;--}}
{{--    }--}}
{{--    .horizontal-nav .horizontal-menu .dropdown .mega-menu.dropdown-menu .mega-menu-row .mega-menu-col-title {--}}
{{--        font-size: 14px;--}}
{{--    }--}}

{{--    /* -- Mobile Navbar -- */--}}
{{--    .horizontal-nav.mobile-navbar .navbar-collapse {--}}
{{--        position: fixed;--}}
{{--        overflow-x: hidden;--}}
{{--        display: block;--}}
{{--        z-index: 99;--}}
{{--        width: 100%;--}}
{{--        height: 390px !important;--}}
{{--        max-height: 100%;--}}
{{--        left: 100%;--}}
{{--        top: 71px;--}}
{{--        margin: 0;--}}
{{--        background-color: #ffffff;--}}
{{--        box-shadow: 0px 0px 30px 0px rgba(0, 0, 0, 0.1);--}}
{{--        transition: all 0.2s ease-in-out;--}}
{{--        border-bottom: 1px solid rgba(0, 0, 0, 0.05);--}}
{{--    }--}}
{{--    .horizontal-nav.mobile-navbar .navbar-collapse.show {--}}
{{--        left: 0;--}}
{{--    }--}}
{{--    .horizontal-nav.mobile-navbar .navbar-collapse .mega-menu-col {--}}
{{--        width: 100%;--}}
{{--        max-width: 100%;--}}
{{--    }--}}
{{--    .horizontal-nav.mobile-navbar .horizontal-menu {--}}
{{--        padding: 15px;--}}
{{--        margin: 0;--}}
{{--    }--}}
{{--    }--}}
{{--    --}}
{{--    @else--}}
{{--        @media (max-width: 991px) {--}}
{{--        /* -- Horizontal Navbar -- */--}}
{{--        .horizontal-nav {--}}
{{--            background-color: transparent;--}}
{{--            border-color: transparent;--}}
{{--            /* -- Dropdown Mega Menu -- */--}}
{{--            /* -- Dropdown Mega Menu -- */--}}
{{--            /* -- Mega Menu -- */--}}
{{--        }--}}
{{--        .horizontal-nav .dropdown-menu {--}}
{{--            top: 0;--}}
{{--            padding: 0;--}}
{{--        }--}}
{{--        .horizontal-nav .navbar-collapse {--}}
{{--            overflow-y: auto !important;--}}
{{--        }--}}
{{--        .horizontal-nav .mega-menu-col .mega-menu-col-title,--}}
{{--        .horizontal-nav .dropdown .dropdown-toggle {--}}
{{--            padding: 12px 30px 12px 12px;--}}
{{--        }--}}
{{--        .horizontal-nav .mega-menu-col .mega-menu-col-title:before,--}}
{{--        .horizontal-nav .dropdown .dropdown-toggle:before {--}}
{{--            float: right;--}}
{{--            content: "";--}}
{{--            font-size: 16px;--}}
{{--            font-weight: 700;--}}
{{--            position: absolute;--}}
{{--            right: 8px;--}}
{{--        }--}}
{{--        .horizontal-nav .mega-menu-col.on .mega-menu-col-title:before,--}}
{{--        .horizontal-nav .dropdown.on > .dropdown-toggle:before {--}}
{{--            transform: rotate(-270deg);--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu {--}}
{{--            float: none !important;--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu li {--}}
{{--            float: none;--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu li .mega-menu-col-title,--}}
{{--        .horizontal-nav .horizontal-menu li a {--}}
{{--            max-width: inherit;--}}
{{--            padding: 8px 10px;--}}
{{--            font-weight: 400;--}}
{{--            display: block;--}}
{{--            cursor: pointer;--}}
{{--            font-size: 16px;--}}
{{--            line-height: 20px;--}}
{{--            color: #282828;--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu li .mega-menu-col-title img,--}}
{{--        .horizontal-nav .horizontal-menu li a img {--}}
{{--            filter: invert(0.6) sepia(1) saturate(1) hue-rotate(185deg);--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu li a:hover,--}}
{{--        .horizontal-nav .horizontal-menu li a:focus, .horizontal-nav .horizontal-menu li.active > a,--}}
{{--        .horizontal-nav .horizontal-menu li .mega-menu-col-title:hover,--}}
{{--        .horizontal-nav .horizontal-menu li .mega-menu.dropdown-menu .mega-menu-col .active > a,--}}
{{--        .horizontal-nav .horizontal-menu li .dropdown-menu li.active > a,--}}
{{--        .horizontal-nav .horizontal-menu li .dropdown-menu li a:hover,--}}
{{--        .horizontal-nav .horizontal-menu li .dropdown-menu li a:focus,--}}
{{--        .horizontal-nav .horizontal-menu li .mega-menu .mega-menu-col ul li a:hover,--}}
{{--        .horizontal-nav .horizontal-menu li .mega-menu .mega-menu-col ul li a:focus {--}}
{{--            color: #6e81dc;--}}
{{--            background-color: transparent;--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu li a:hover img,--}}
{{--        .horizontal-nav .horizontal-menu li a:focus img, .horizontal-nav .horizontal-menu li.active > a img,--}}
{{--        .horizontal-nav .horizontal-menu li .mega-menu-col-title:hover img,--}}
{{--        .horizontal-nav .horizontal-menu li .mega-menu.dropdown-menu .mega-menu-col .active > a img,--}}
{{--        .horizontal-nav .horizontal-menu li .dropdown-menu li.active > a img,--}}
{{--        .horizontal-nav .horizontal-menu li .dropdown-menu li a:hover img,--}}
{{--        .horizontal-nav .horizontal-menu li .dropdown-menu li a:focus img,--}}
{{--        .horizontal-nav .horizontal-menu li .mega-menu .mega-menu-col ul li a:hover img,--}}
{{--        .horizontal-nav .horizontal-menu li .mega-menu .mega-menu-col ul li a:focus img {--}}
{{--            filter: invert(0.62) sepia(1) saturate(4.5) hue-rotate(199deg);--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu > li:first-child > a {--}}
{{--            border-top: 0;--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu .dropdown .mega-menu.dropdown-menu,--}}
{{--        .horizontal-nav .horizontal-menu .dropdown .dropdown-menu {--}}
{{--            float: none;--}}
{{--            position: relative;--}}
{{--            left: 0;--}}
{{--            box-shadow: 0px 0px 0px;--}}
{{--            border-radius: 0px 0px 0px;--}}
{{--            border: 0;--}}
{{--            background-color: transparent;--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu .dropdown .dropdown-menu {--}}
{{--            padding-left: 28px;--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu .dropdown .dropdown-menu .dropdown-menu {--}}
{{--            padding-left: 18px;--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu .dropdown .mega-menu.dropdown-menu .mega-menu-row {--}}
{{--            float: none;--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu .dropdown .mega-menu.dropdown-menu .mega-menu-row .mega-menu-col {--}}
{{--            padding: 0;--}}
{{--        }--}}
{{--        .horizontal-nav .horizontal-menu .dropdown .mega-menu.dropdown-menu .mega-menu-row .mega-menu-col-title {--}}
{{--            font-size: 14px;--}}
{{--        }--}}

{{--        /* -- Mobile Navbar -- */--}}
{{--        .horizontal-nav.mobile-navbar .navbar-collapse {--}}
{{--            position: fixed;--}}
{{--            overflow-x: hidden;--}}
{{--            display: block;--}}
{{--            z-index: 99;--}}
{{--            width: 100%;--}}
{{--            height: 390px !important;--}}
{{--            max-height: 100%;--}}
{{--            left: 100%;--}}
{{--            top: 71px;--}}
{{--            margin: 0;--}}
{{--            background-color: #ffffff;--}}
{{--            box-shadow: 0px 0px 30px 0px rgba(0, 0, 0, 0.1);--}}
{{--            transition: all 0.2s ease-in-out;--}}
{{--            border-bottom: 1px solid rgba(0, 0, 0, 0.05);--}}
{{--        }--}}
{{--        .horizontal-nav.mobile-navbar .navbar-collapse.show {--}}
{{--            left: 0;--}}
{{--        }--}}
{{--        .horizontal-nav.mobile-navbar .navbar-collapse .mega-menu-col {--}}
{{--            width: 100%;--}}
{{--            max-width: 100%;--}}
{{--        }--}}
{{--        .horizontal-nav.mobile-navbar .horizontal-menu {--}}
{{--            padding: 15px;--}}
{{--            margin: 0;--}}
{{--        }--}}
{{--    }--}}
{{--    @endif--}}
</style>

