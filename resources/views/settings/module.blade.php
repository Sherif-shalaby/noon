@extends('layouts.app')
@section('title', __('lang.modules'))
@section('breadcrumbbar')
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.modules')
                    </h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="index.html">/ @lang('lang.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="#">/ @lang('lang.settings')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                                aria-current="page">@lang('lang.modules')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">
        <div class="contentbar">
            <div class="col-md-12  no-print">
                <div class="card">
                    <div
                        class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h4>@lang('lang.modules')</h4>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['url' => route('updateModule'), 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                        <div class="row">
                            @foreach ($modules as $key => $name)
                                <div class="col-md-4 @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                    <div class="i-checks">
                                        <label for="{{ $loop->index }}"><strong>{{ __('lang.' . $key) }}</strong></label>
                                        <input id="{{ $loop->index }}" name="module_settings[{{ $key }}]"
                                            type="checkbox" @if (!empty($module_settings[$key])) checked @endif value="1"
                                            class="">
                                    </div>

                                </div>
                            @endforeach
                        </div>
                        <br>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script></script>
@endsection
