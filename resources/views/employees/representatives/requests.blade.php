@extends('layouts.app')
@section('title', __('lang.employees'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.employees')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        {{--                        <li class="breadcrumb-item active"><a href="#">@lang('lang.employees')</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.representatives')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a class="btn btn-primary" href="{{ route('employees.create') }}">@lang('lang.add_employee')</a>
                    {{--                    <a style="color: white" href="{{ action('EmployeeController@create') }}" class="btn btn-info"><i --}}
                    {{--                            class="dripicons-plus"></i> --}}
                    {{--                        @lang('lang.add_new_employee')</a> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
                    <h4 class="print-title">@lang('lang.employees')</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container-fluid">
                                @include('employees.representatives.filters')
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                                <tr>
                                    <th>@lang('lang.invoice_no')</th>
                                    <th>@lang('lang.employee_name')</th>
                                    <th>@lang('lang.stores')</th>
                                    <th>@lang('lang.pos')</th>
                                    <th>@lang('lang.customers')</th>
                                    <th>@lang('lang.date')</th>
                                    <th>@lang('lang.amount')</th>
                                    <th>@lang('lang.remaining')</th>
                                    <th>@lang('lang.product')</th>
                                    <th>@lang('lang.quantity')</th>
                                    <th>@lang('lang.unit')</th>
                                    <th>@lang('lang.purchase_price')  </th>
                                    <th>@lang('lang.sell_price')  </th>
                                    <th class="notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $key => $transaction)
                                    <tr>
                                        <td>{{ $transaction->invoice_no }}</td>
                                        <td>
                                            {{ !empty($transaction->employee->user) ? $transaction->employee->user->name : '' }}
                                        </td>
                                        <td>
                                            {{ !empty($transaction->store) ? $transaction->store->name : '' }}
                                        </td>
                                        <td>
                                            {{ !empty($transaction->store_pos) ? $transaction->store_pos->name : '' }}
                                        </td>
                                        <td>
                                            {{ !empty($transaction->customer) ? $transaction->customer->name : '' }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d') }}
                                        </td>
                                        <td>{{ @number_format($transaction->final_total) }} <br>
                                            {{ @number_format($transaction->dollar_final_total) }} $</td>
                                        <td>{{ @number_format($transaction->dinar_remaining) }} <br>
                                            {{ @number_format($transaction->dollar_remaining) }} $</td>
                                        <td>
                                            @if ($transaction->transaction_sell_lines)
                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                    {{ $sellLine->product->name ?? '' }} <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $transaction->quantity??0 }}</td>
                                        <td>
                                            @if ($transaction->transaction_sell_lines)
                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                    {{ $sellLine->variation->unit->name ?? '' }} <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if ($transaction->transaction_sell_lines)
                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                    {{ $sellLine->purchase_price ?? 0 }} , {{ $sellLine->dollar_purchase_price ?? 0 }} $  <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if ($transaction->transaction_sell_lines)
                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                    {{ $sellLine->sell_price ?? 0 }},{{ $sellLine->dollar_sell_price ?? 0 }}$  <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                user="menu">';
                                                <li>
                                                    <a href="{{ route('employees.show', $transaction->id) }}"
                                                        class="btn"><i class="fa fa-eye"></i>
                                                        @lang('lang.view') </a>
                                                </li>
                                                <li class="divider"></li>

                                                {{-- <li>
                                                    <a href="{{ route('employees.edit', $transaction->id) }}"
                                                        target="_blank" class="btn edit_employee"><i
                                                            class="fa fa-pencil-square-o"></i>
                                                        @lang('lang.edit')</a>
                                                </li>
                                                <li class="divider"></li> --}}
                                                <li>
                                                    <a data-href="{{ route('representatives.destroy', $transaction->id) }}"
                                                        class="btn delete_item text-red delete_item"><i
                                                            class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>
                                                {{-- @if (!empty($transaction->job_type) && $transaction->job_type->title == 'Representative')
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{ route('employees.add_points') }}"
                                                            class="btn add_point"><i class="fa fa-plus"></i>
                                                            @lang('lang.add_points')
                                                        </a>
                                                    </li>
                                                @endif --}}
                                            </ul>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
