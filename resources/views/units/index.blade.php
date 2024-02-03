@extends('layouts.app')
@section('title', __('units.units'))

@push('css')
    <style>
        .table-top-head {
            top: 32px;
        }

        .rightbar {
            z-index: 2;
        }

        .wrapper1 {
            margin-top: 30px;
        }

        @media(max-width:768px) {
            .wrapper1 {
                margin-top: 140px
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('units.units')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('units.units')</li>
@endsection

@section('button')
    <div class="widgetbar  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
            <i class="fa fa-plus"></i> {{ __('Add') }}
        </button>
    </div>
@endsection

@section('content')
    @include('units.create')
    <div class="animate-in-page">
        <div class="contentbar">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h6 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('units.units')</h6>
                        </div>
                        <div class="card-body">
                            @if (@isset($units) && !@empty($units) && count($units) > 0)
                                <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <div class="div1"></div>
                                </div>
                                <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <div class="div2 table-scroll-wrapper">
                                        <!-- content goes here -->
                                        <div style="min-width:1300px;max-height: 90vh;overflow: auto">
                                            <table id="datatable-buttons" class="table table-striped table-bordered">
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
                                                    @foreach ($units as $index => $unit)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('units.unitname')">

                                                                    {{ $unit->name }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('added_by')">

                                                                    @if ($unit->user_id > 0 and $unit->user_id != null)
                                                                        {{ $unit->created_at->diffForHumans() }} <br>
                                                                        {{ $unit->created_at->format('Y-m-d') }}
                                                                        ({{ $unit->created_at->format('h:i') }})
                                                                        {{ $unit->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                        <br>
                                                                        {{ $unit->createBy?->name }}
                                                                    @else
                                                                        {{ __('no_update') }}
                                                                    @endif
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('updated_by')">

                                                                    @if ($unit->last_update > 0 and $unit->last_update != null)
                                                                        {{ $unit->updated_at->diffForHumans() }} <br>
                                                                        {{ $unit->updated_at->format('Y-m-d') }}
                                                                        ({{ $unit->updated_at->format('h:i') }})
                                                                        {{ $unit->updated_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                        <br>
                                                                        {{ $unit->updateBy?->name }}
                                                                    @else
                                                                        {{ __('no_update') }}
                                                                    @endif
                                                                </span>
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
                                    @else
                                        <div class="alert alert-danger">
                                            {{ __('categories.data_no_found') }}
                                        </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
