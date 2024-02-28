@extends('layouts.app')
@section('title', __('lang.add_transfer'))

@section('page_title')
    @lang('lang.add_transfer')
@endsection
@push('css')
    <style>
        .table-top-head {
            top: 96px !important;
        }

        .wrapper1 {
            margin-top: 25px;
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 280px !important
            }

            .wrapper1 {
                margin-top: 110px !important;
            }
        }

        .input-wrapper .dropdown-menu.show {
            left: -57px !important;
            width: 150px
        }

        .dropdown-menu.inner li {
            padding: 0 !important
        }
    </style>
@endpush

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('store_transfer.create') }}">/ @lang('lang.store_transfer')</a>
    </li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.all_transfers')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a type="button" class="btn btn-primary" href="{{ route('store_transfer.create') }}">@lang('lang.store_transfer')</a>
    </div>
@endsection


@section('content')
    <div class="animate-in-page">
        <section class=" mb-0 pb-0">
            <div class="col-md-12">
                <div class="card mb-0">
                    <div
                        class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h6 class="print-title">@lang('lang.all_transfers')</h6>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    @include('store_transfer.partials.filters')
                                </div>
                            </div>
                        </div>

                        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div1"></div>
                        </div>
                        <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div2 table-scroll-wrapper">
                                <!-- content goes here -->
                                <div style="min-width: 1300px;min-height:50vh;max-height: 90vh;overflow: auto;">
                                    <table id="datatable-buttons" class="table  table-striped table-bordered dataTable">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.date')</th>
                                                <th>@lang('lang.reference')</th>
                                                <th>@lang('lang.created_by')</th>
                                                {{--                                <th>@lang('lang.approved_at')</th> --}}
                                                {{--                                <th>@lang('lang.received_at')</th> --}}
                                                <th>@lang('lang.sender_store')</th>
                                                <th>@lang('lang.receiver_store')</th>
                                                <th class="sum">@lang('lang.value_of_transaction')</th>
                                                <th class="sum dollar-cell">@lang('lang.value_of_transaction') $</th>
                                                <th>@lang('lang.status')</th>
                                                <th>@lang('lang.notes')</th>
                                                {{--                                <th class="notexport">@lang('lang.action')</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transfers as $transfer)
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.date')">
                                                            {{ @format_date($transfer->transaction_date) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.reference')">
                                                            {{ $transfer->invoice_no }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.created_by')">
                                                            {{ ucfirst($transfer->created_by_user->name ?? '') }}
                                                        </span>
                                                    </td>
                                                    {{--                                    <td>@if (!empty($transfer->approved_at)) {{@format_date($transfer->approved_at)}} @endif</td> --}}
                                                    {{--                                    <td>@if (!empty($transfer->received_at)) {{@format_date($transfer->received_at)}} @endif</td> --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.sender_store')">
                                                            {{ ucfirst($transfer->sender_store->name ?? '') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.receiver_store')">
                                                            {{ ucfirst($transfer->receiver_store->name ?? '') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.value_of_transaction')">
                                                            {{ @num_format($transfer->final_total) }}
                                                        </span>
                                                    </td>
                                                    <td class="dollar-cell">
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.value_of_transaction')">
                                                            {{ @num_format($transfer->dollar_final_total) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.status')">

                                                            @if ($transfer->status == 'received')
                                                                {{ __('lang.received') }}@else{{ ucfirst($transfer->status) }}
                                                            @endif

                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.notes')">
                                                            {{ $transfer->notes }}
                                                        </span>
                                                    </td>
                                                    {{--                                    <td> --}}
                                                    {{--                                        <div class="btn-group"> --}}
                                                    {{--                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" --}}
                                                    {{--                                                    aria-haspopup="true" aria-expanded="false">@lang('lang.action') --}}
                                                    {{--                                                <span class="caret"></span> --}}
                                                    {{--                                                <span class="sr-only">Toggle Dropdown</span> --}}
                                                    {{--                                            </button> --}}
                                                    {{--                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu"> --}}
                                                    {{--                                                <li> --}}
                                                    {{--                                                    <a data-href="{{action('TransferController@show', $transfer->id)}}" --}}
                                                    {{--                                                       data-container=".view_modal" class="btn btn-modal"><i class="fa fa-eye"></i> --}}
                                                    {{--                                                        @lang('lang.view')</a> --}}
                                                    {{--                                                </li> --}}
                                                    {{--                                                <li class="divider"></li> --}}
                                                    {{--                                                <li> --}}

                                                    {{--                                                    <a href="{{action('TransferController@print', $transfer->id)}}?print=true" --}}
                                                    {{--                                                       class="btn"><i class="dripicons-print"></i> --}}
                                                    {{--                                                        @lang('lang.print')</a> --}}
                                                    {{--                                                </li> --}}
                                                    {{--                                                <li class="divider"></li> --}}
                                                    {{--                                                <li> --}}

                                                    {{--                                                    <a href="{{action('TransferController@edit', $transfer->id)}}" class="btn"><i --}}
                                                    {{--                                                            class="dripicons-document-edit"></i> @lang('lang.edit')</a> --}}
                                                    {{--                                                </li> --}}
                                                    {{--                                                <li class="divider"></li> --}}

                                                    {{--                                                <li> --}}
                                                    {{--                                                    <a data-href="{{action('TransferController@destroy', $transfer->id)}}" --}}
                                                    {{--                                                       data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}}
                                                    {{--                                                       class="btn text-red delete_item"><i class="fa fa-trash"></i> --}}
                                                    {{--                                                        @lang('lang.delete')</a> --}}
                                                    {{--                                                </li> --}}
                                                    {{--                                            </ul> --}}
                                                    {{--                                        </div> --}}
                                                    {{--                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th style="text-align: right">@lang('lang.total')</th>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- add Payment Modal -->
            {{--    @include('add-stock.partials.add-payment') --}}

        </section>
    </div>

    <!-- This will be printed -->
    <section class="invoice print_section print-only" id="receipt_section"> </section>
@endsection

@push('javascripts')
    <script src="{{ asset('js/transfer.js') }}"></script>
    <script>
        table
            .column('0:visible')
            .order('desc')
            .draw();

        $(document).on('click', '#update-status', function(e) {
            e.preventDefault();
            if ($('#update_status_form').valid()) {
                $('#update_status_form').submit();
            }
        })
    </script>
@endpush
