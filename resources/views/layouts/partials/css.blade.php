<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
<!-- Start css -->
<!-- Switchery css -->
{{-- <link href="{{ asset('plugins/animate/animate.css') }}" rel="stylesheet" type="text/css"> --}}
{{-- <link href="{{ asset('plugins/switchery/switchery.min.css') }}" rel="stylesheet"> --}}
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
<link rel="stylesheet" href="{{asset('js/toastr/toastr.min.css')}}" id="theme-stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/style.default.css')}}" id="theme-stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('css/dropzone.css')}}">
<link rel="stylesheet" href="{{asset('js/cropperjs/cropper.min.css') }}">
<link rel="stylesheet" href="{{asset('css/style2.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('js/select/select2.min.css') }}">
{{-- <script src="{{asset('js/jquery.min.js')}}"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript" src="{{asset('js/toastr/toastr.min.js')}}"></script>
<style>
    .error{
        color: red;
    /* position: absolute; */
    /* top: 70px; */
    }
</style>

<style>
    #name-error{
        color:red;
    }
</style>
