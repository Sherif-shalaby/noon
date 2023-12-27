@extends('layouts.app')
@section('title', __('site.Sale_Screen'))
@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('salescreen/css/normalize.css')}}" /> --}}
    <!-- Bootstrap -->
    {{-- <link rel="stylesheet" href="{{ asset('salescreen/css/bootstrap.rtl.min.css')}}" /> --}}
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('salescreen/css/all.min.css')}}" /> --}}
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css') }}" />
    <style>
        .customer_drop_down .select2-container {
            width: 75% !important
        }
    </style>
@endpush
@section('content')
    {{--    {{dd($id)}} --}}
    @livewire('invoices.edit', ['id' => $id])
@endsection
@push('js')
    <script src="{{ asset('salescreen/js/main.js') }}"></script>
    <script src="{{ asset('salescreen/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('salescreen/js/all.min.js') }}"></script>
@endpush
