@extends('layouts.app')
@section('title', __('lang.add_transfer'))
@push('css')
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css') }}" />
@endpush

@section('page_title')
    @lang('lang.add_transfer')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.add_transfer')</li>
@endsection


@section('content')
    @livewire('transfer.create', ['id' => $id])
@endsection
@push('javascripts')
@endpush
