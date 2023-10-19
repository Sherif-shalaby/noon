@extends('layouts.app')
@section('title', __('lang.sells_return'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.returns')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.returns')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">

            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.returns')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <ul>
                                <li><a class="font-weight-bold text-decoration-none text-dark font-18"
                                        href="{{ route('sell_return.index') }}"> @lang('lang.sells_return') </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
@endsection
