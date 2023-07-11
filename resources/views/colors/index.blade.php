@extends('layouts.app')
@section('title', __('colors.colors'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('colors.colors')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('colors.colors')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
                        <i class="fa fa-plus"></i> {{ __('Add') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('colors.create')
@endsection
@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('colors.colors')</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('colors.colorname')</th>
                                        <th>@lang('added_by')</th>
                                        <th>@lang('updated_by')</th>
                                        <th>@lang('action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($colors as $index=>$color)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $color->name }}</td>
                                            <td>
                                                @if ($color->user_id  > 0 and $color->user_id != null)
                                                    {{ $color->created_at->diffForHumans() }} <br>
                                                    {{ $color->created_at->format('Y-m-d') }}
                                                    ({{ $color->created_at->format('h:i') }})
                                                    {{ ($color->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                    {{ $color->createBy?->name }}
                                                @else
                                                {{ __('no_update') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($color->last_update  > 0 and $color->last_update != null)
                                                    {{ $color->updated_at->diffForHumans() }} <br>
                                                    {{ $color->updated_at->format('Y-m-d') }}
                                                    ({{ $color->updated_at->format('h:i') }})
                                                    {{ ($color->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                    {{ $color->updateBy?->name }}
                                                @else
                                                   {{ __('no_update') }}
                                                @endif
                                            </td>
                                            <td>
                                                @include('colors.action')
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <tfoot>
                                <tr>
                                    <th colspan="12">
                                        <div class="float-right">
                                            {!! $colors->appends(request()->all())->links() !!}
                                        </div>
                                    </th>
                                </tr>
                            </tfoot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
