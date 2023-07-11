@extends('layouts.app')
@section('title', __('units.units'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('units.units')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('units.units')</li>
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
    @include('units.create')
@endsection
@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('units.units')</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('units.unitname')</th>
                                        <th>@lang('added_by')</th>
                                        <th>@lang('updated_by')</th>
                                        <th>@lang('action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($units as $index=>$unit)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $unit->name }}</td>
                                            <td>
                                                @if ($unit->user_id  > 0 and $unit->user_id != null)
                                                    {{ $unit->created_at->diffForHumans() }} <br>
                                                    {{ $unit->created_at->format('Y-m-d') }}
                                                    ({{ $unit->created_at->format('h:i') }})
                                                    {{ ($unit->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                    {{ $unit->createBy?->name }}
                                                @else
                                                {{ __('no_update') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($unit->last_update  > 0 and $unit->last_update != null)
                                                    {{ $unit->updated_at->diffForHumans() }} <br>
                                                    {{ $unit->updated_at->format('Y-m-d') }}
                                                    ({{ $unit->updated_at->format('h:i') }})
                                                    {{ ($unit->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                    {{ $unit->updateBy?->name }}
                                                @else
                                                   {{ __('no_update') }}
                                                @endif
                                            </td>
                                            <td>
                                                @include('units.action')
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <tfoot>
                                <tr>
                                    <th colspan="12">
                                        <div class="float-right">
                                            {!! $units->appends(request()->all())->links() !!}
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
