@extends('layouts.app')
@section('title', __('lang.initial_balance'))


@section('page_title')
    @lang('lang.initial_balance')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
            style="text-decoration: none;color: #596fd7" href="{{ route('initial-balance.index') }}">/
            @lang('lang.initial_balance')</a>
    </li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.add_initial_balance')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a type="button" class="btn btn-primary" href="{{ route('initial-balance.index') }}">@lang('lang.initial_balance')</a>
    </div>
@endsection


@section('content')
    @livewire('initial-balance.create')
@endsection
