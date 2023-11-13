<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <link rel="shortcut icon" href="{{asset('/uploads/'.$settings['logo'])}}">  --}}
<!-- Start css -->
<link href="{{ asset('plugins/animate/animate.css') }}" rel="stylesheet" type="text/css">
<!-- Select2 css -->
<link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css">
<!-- Tagsinput css -->
{{--    <link href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css">--}}
{{--    <link href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css')}}" rel="stylesheet" type="text/css">--}}
<!-- DataTables css -->
<link href="{{asset('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!---->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

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
<!-- Switchery css -->
<link href="{{ asset('plugins/switchery/switchery.min.css') }}" rel="stylesheet">
<style>
    .error-help-block{
        color:red;
    }
    input[type="text"],input[type="month"],input[type="number"],textarea,.custom-select {
       border:2px solid #cececf !important;
    }
</style>
<style>
    .print-only {
    display: none;
    }

    @media print {
        .no-print {
            display: none;
        }

        .print-only {
            display: block;
        }
        .ui-pnotify-container{
            display: none !important;
        }
        @livewireScripts {
        display: none !important;
        }
    }
</style>

