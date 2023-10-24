@extends('layouts.app')
@section('title', __('lang.initial_balance'))
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="animate__animated  animate__backInRight">
                <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.initial_balance')
                </h4>

                <div class="breadcrumb-list">
                    <ul
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                @lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                style="text-decoration: none;color: #596fd7" href="{{ route('initial-balance.index') }}">/
                                @lang('lang.initial_balance')</a>
                        </li>
                        <li class="breadcrumb @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                            aria-current="page">@lang('lang.add_initial_balance')</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 animate__animated  animate__backInLeft">
                <div
                    class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <a type="button" class="btn btn-primary"
                        href="{{ route('initial-balance.index') }}">@lang('lang.initial_balance')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @livewire('initial-balance.create')

@endsection
@push('javascripts')
    <script></script>
@endpush
