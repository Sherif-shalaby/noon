@extends('layouts.app')
@section('title', __('site.Invoices'))
@push('css')

@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('site.Invoices')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('site.Invoices')</li>
                    </ol>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('content')
  <livewire:invoices.index />
@endsection
@push('js')

@endpush
