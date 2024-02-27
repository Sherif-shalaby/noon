@extends('layouts.app')
@section('title', __('lang.add_transfer'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.add_transfer')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('store_transfer.create')}}">@lang('lang.store_transfer')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.all_transfers')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <div class="widgetbar">
                        <a type="button" class="btn btn-primary" href="{{route('store_transfer.create')}}">@lang('lang.store_transfer')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <section class="">
        <div class="col-md-22">
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
                    <h3 class="print-title">@lang('lang.all_transfers')</h3>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-fluid">
                            @include('store_transfer.partials.filters')
                        </div>
                    </div>
                </div>
                <br/>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                            <tr>
                                <th>@lang('lang.date')</th>
                                <th>@lang('lang.reference')</th>
                                <th>@lang('lang.created_by')</th>
                                <th>@lang('lang.approved_at')</th>
                                <th>@lang('lang.received_at')</th>
                                <th>@lang('lang.sender_store')</th>
                                <th>@lang('lang.receiver_store')</th>
                                <th class="sum">@lang('lang.value_of_transaction')</th>
                                <th>@lang('lang.status')</th>
                                <th>@lang('lang.notes')</th>
{{--                                <th class="notexport">@lang('lang.action')</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transfers as $transfer)
                                <tr>
                                    <td>{{@format_date($transfer->transaction_date)}}</td>
                                    <td>{{$transfer->invoice_no}}</td>
                                    <td>{{ucfirst($transfer->created_by_user->name ?? '')}}</td>
                                    <td>@if(!empty($transfer->approved_at)) {{@format_date($transfer->approved_at)}} @endif</td>
                                    <td>@if(!empty($transfer->received_at)) {{@format_date($transfer->received_at)}} @endif</td>
                                    <td>{{ucfirst($transfer->sender_store->name ?? '')}}</td>
                                    <td>{{ucfirst($transfer->receiver_store->name ?? '')}}</td>
                                    <td>{{@num_format($transfer->final_total)}}</td>
                                    <td>@if($transfer->status == 'received'){{__('lang.received')}}@else{{ucfirst($transfer->status)}}@endif
                                    </td>
                                    <td>{{$transfer->notes}}</td>
{{--                                    <td>--}}
{{--                                        <div class="btn-group">--}}
{{--                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"--}}
{{--                                                    aria-haspopup="true" aria-expanded="false">@lang('lang.action')--}}
{{--                                                <span class="caret"></span>--}}
{{--                                                <span class="sr-only">Toggle Dropdown</span>--}}
{{--                                            </button>--}}
{{--                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">--}}
{{--                                                <li>--}}
{{--                                                    <a data-href="{{action('TransferController@show', $transfer->id)}}"--}}
{{--                                                       data-container=".view_modal" class="btn btn-modal"><i class="fa fa-eye"></i>--}}
{{--                                                        @lang('lang.view')</a>--}}
{{--                                                </li>--}}
{{--                                                <li class="divider"></li>--}}
{{--                                                <li>--}}

{{--                                                    <a href="{{action('TransferController@print', $transfer->id)}}?print=true"--}}
{{--                                                       class="btn"><i class="dripicons-print"></i>--}}
{{--                                                        @lang('lang.print')</a>--}}
{{--                                                </li>--}}
{{--                                                <li class="divider"></li>--}}
{{--                                                <li>--}}

{{--                                                    <a href="{{action('TransferController@edit', $transfer->id)}}" class="btn"><i--}}
{{--                                                            class="dripicons-document-edit"></i> @lang('lang.edit')</a>--}}
{{--                                                </li>--}}
{{--                                                <li class="divider"></li>--}}

{{--                                                <li>--}}
{{--                                                    <a data-href="{{action('TransferController@destroy', $transfer->id)}}"--}}
{{--                                                       data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"--}}
{{--                                                       class="btn text-red delete_item"><i class="fa fa-trash"></i>--}}
{{--                                                        @lang('lang.delete')</a>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
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

        <!-- add Payment Modal -->
        {{--    @include('add-stock.partials.add-payment')--}}

    </section>

    <!-- This will be printed -->
    <section class="invoice print_section print-only" id="receipt_section"> </section>
@endsection

@push('javascripts')
    <script src="{{asset('js/transfer.js')}}"></script>
    <script>
        table
            .column( '0:visible' )
            .order( 'desc' )
            .draw();

        $(document).on('click', '#update-status', function(e){
            e.preventDefault();
            if($('#update_status_form').valid()){
                $('#update_status_form').submit();
            }
        })

    </script>
@endpush
