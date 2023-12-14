@extends('layouts.app')
@section('title', __('site.Sale_Screen'))
@push('css')
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css') }}" />
@endpush

@section('content')
    @livewire('invoices.create')
@endsection
@push('js')
    <script src="{{ asset('salescreen/js/main.js') }}"></script>
    <script src="{{ asset('salescreen/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('salescreen/js/all.min.js') }}"></script>
@endpush
