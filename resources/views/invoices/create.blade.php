@extends('layouts.app')
@section('title', __('site.Sale_Screen'))
@push('css')
<link rel="stylesheet" href="{{ asset('salescreen/css/main.css') }}" />
<style>
    .customer_drop_down .select2-container {
        width: 75% !important
    }

    /* .form-select {
                height: 100%;
                padding-bottom: 0;
                padding-top: 0;
                background-color: #dedede !important;
                border-radius: 16px;
                border: 2px solid #cececf;
                font-size: 14px;
                font-weight: 500
            }

            .form-select:focus {
                border-color: #cececf !important;
                outline: 0;
                box-shadow: 0 0 0 0 !important;
                background-color: white !important;
            } */

    .select2-container--open .select2-dropdown {
        left: -70px !important
    }
</style>
@endpush

@section('content')
@livewire('invoices.create')
@endsection
@push('js')
<script src="{{ asset('salescreen/js/main.js') }}"></script>
<script src="{{ asset('salescreen/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('salescreen/js/all.min.js') }}"></script>
@endpush