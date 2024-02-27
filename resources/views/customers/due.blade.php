@extends('layouts.app')
@section('title', __('lang.dues'))
@push('css')
    <style>
        .table-top-head {
            top: 75px !important;
        }

        .table-scroll-wrapper {
            width: fit-content;
        }

        @media(min-width:1900px) {
            .table-scroll-wrapper {
                width: 100%;
            }
        }

        @media(max-width:991px) {
            .table-top-head {
                top: 75px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 105px !important
            }
        }

        @media(max-width:575px) {
            .table-top-head {
                top: 120px !important
            }
        }

        .wrapper1 {
            margin-top: 8px;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 115px;
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.dues')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.due')</li>
@endsection


@section('content')

    <!-- Start Contentbar -->
    <div class="animate-in-page">
        <div class="contentbar mb-0 pb-0">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h6 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.due')</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        <form action="{{ route('dues') }}" method="get">
                                            <div
                                                class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        {{-- <label for="date">@lang('lang.date')</label> --}}
                                                        <input type="date"
                                                            class="form-control initial-balance-input width-full"
                                                            name="date" id="date" placeholder="@lang('lang.date')">
                                                    </div>

                                                </div>
                                                {{-- <div class="col-3">
                                                <div class="form-group">
                                                    {!! Form::select(
                                                        'city_id',
                                                        $cities,null,
                                                        ['class' => 'form-control select2','placeholder'=>__('lang.cities')]
                                                    ) !!}
                                                </div>
                                            </div> --}}
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <button type="submit" name="submit"
                                                            class="btn btn-primary width-100" title="search">
                                                            <i class="fa fa-eye"></i> {{ __('Search') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width: 1300px;max-height: 90vh;overflow: auto">
                                        <table id="datatable-buttons"
                                            class="table table-striped table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('lang.date')</th>
                                                    <th>@lang('lang.reference')</th>
                                                    <th>@lang('lang.customer')</th>
                                                    <th>@lang('lang.amount')</th>
                                                    <th>@lang('lang.paid')</th>
                                                    <th>@lang('lang.duePaid')</th>
                                                    <th>@lang('lang.total_dues_for_this_customer')</th>
                                                    <th>@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                    $total_paid = 0;
                                                    $total_due = 0;
                                                    $total_dues = 0;
                                                @endphp
                                                @foreach ($dues as $due)
                                                    <tr>
                                                        <td>
                                                            <span class=" d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600">

                                                                {{ $i }}
                                                            </span>

                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.date')">

                                                                {{ @format_date($due->transaction_date) }}
                                                            </span>

                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.reference')">

                                                                {{ $due->invoice_no }}
                                                            </span>

                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.customer')">

                                                                {{ $due->customer->name ?? '' }}
                                                            </span>

                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.amount')">

                                                                {{ @num_format($due->final_total) }}
                                                            </span>

                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip=">@lang('lang.paid')">

                                                                {{ @num_format($due->transaction_payments->sum('amount')) }}
                                                            </span>

                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip=">@lang('lang.duePaid')">
                                                                {{ @num_format($due->final_total - $due->transaction_payments->sum('amount')) }}
                                                            </span>
                                                            @php
                                                                $total_dues += $due->final_total - $due->transaction_payments->sum('amount');
                                                            @endphp
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip=">@lang('lang.total_dues_for_this_customer')">
                                                                {{ $total_dues }}
                                                            </span>
                                                        </td>
                                                        <td class="col18">
                                                            <div class="btn-group">
                                                                <button type="button"
                                                                    class="btn btn-default btn-sm dropdown-toggle"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                    <a data-href="{{ route('customers.pay_due_view', ['id' => $due->id]) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn btn-modal"><i
                                                                            class="dripicons-document-edit"></i>
                                                                        @lang('lang.pay_due')</a>
                                                                    <span class="caret"></span>
                                                                </button>
                                                                {{-- <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                    user="menu" x-placement="bottom-end"
                                                                    style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                    <li>
                                                                        <a data-href="{{ route('customers.pay_due_view', ['id' => $due->id]) }}"
                                                                            data-container=".view_modal"
                                                                            class="btn btn-modal"><i
                                                                                class="dripicons-document-edit"></i>
                                                                            @lang('lang.pay_due')</a>
                                                                    </li> --}}
                                                                {{-- <li class="divider"></li>
                                                                        <li>
                                                                            <a data-href="{{route('customers.destroy', $customer->id)}}"
                                                                                class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                                                @lang('lang.delete')</a>
                                                                    </li> --}}
                                                                {{-- </ul> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                        $total_paid += $due->transaction_payments->sum('amount');
                                                        $total_due += $due->final_total - $due->transaction_payments->sum('amount');
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
    </div>
    <!-- End Contentbar -->
    <div class="view_modal no-print">

    </div>
@endsection
<script></script>
