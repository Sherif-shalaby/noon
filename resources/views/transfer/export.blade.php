@extends('layouts.app')
@section('title', __('lang.add_transfer'))
@push('css')
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css') }}" />
@endpush
@php
    $sell_car = \App\Models\SellCar::find($id);
@endphp


@section('page_title')
    @lang('lang.add_transfer')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
            href="">@lang('lang.add_transfer')</a></li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        {{ $sell_car->car_name }}</li>
@endsection


@section('content')
    @livewire('transfer.export', ['id' => $id])
@endsection
@push('javascripts')
@endpush
