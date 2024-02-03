@extends('layouts.app')
@section('title', __('sizes.sizes'))


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
    @lang('sizes.sizes')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('sizes.sizes')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
            <i class="fa fa-plus"></i> {{ __('Add') }}
        </button>
    </div>
@endsection

@section('content')
    @include('sizes.create')
    <div class="animate-in-page">
        <div class="contentbar">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h6 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('sizes.sizes')</h6>
                        </div>
                        <div class="card-body">
                            @if (@isset($sizes) && !@empty($sizes) && count($sizes) > 0)
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
                                                        <th>@lang('sizes.sizename')</th>
                                                        <th>@lang('added_by')</th>
                                                        <th>@lang('updated_by')</th>
                                                        <th>@lang('action')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sizes as $index => $size)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('sizes.sizename')">
                                                                    {{ $size->name }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.added_by')">

                                                                    @if ($size->user_id > 0 and $size->user_id != null)
                                                                        {{ $size->created_at->diffForHumans() }} <br>
                                                                        {{ $size->created_at->format('Y-m-d') }}
                                                                        ({{ $size->created_at->format('h:i') }})
                                                                        {{ $size->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                        <br>
                                                                        {{ $size->createBy?->name }}
                                                                    @else
                                                                        {{ __('no_update') }}
                                                                    @endif
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.updated_by')">

                                                                    @if ($size->last_update > 0 and $size->last_update != null)
                                                                        {{ $size->updated_at->diffForHumans() }} <br>
                                                                        {{ $size->updated_at->format('Y-m-d') }}
                                                                        ({{ $size->updated_at->format('h:i') }})
                                                                        {{ $size->updated_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                        <br>
                                                                        {{ $size->updateBy?->name }}
                                                                    @else
                                                                        {{ __('no_update') }}
                                                                    @endif
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @include('sizes.action')
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="12">
                                                        <div class="float-right">
                                                            {!! $sizes->appends(request()->all())->links() !!}
                                                        </div>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </div>
                                    </div>
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
@endsection
