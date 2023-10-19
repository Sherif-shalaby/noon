@extends('layouts.app')
@section('title', __('lang.return_sell'))
@section('breadcrumbbar')
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">@lang('lang.return_sell')</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('lang.return_sell')</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
        </div>
    </div>
</div>
@endsection

@section('content')
    @livewire('returns.sell.create', ['id' => $id])
@endsection

