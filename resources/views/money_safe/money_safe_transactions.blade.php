@extends('layouts.app')
@section('title', __('lang.watch_moneysafe_transaction'))
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.watch_moneysafe_transaction')
                </h4>
                <div class="breadcrumb-list">
                    <ul style=" list-style: none;"
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/moneysafe') }}">/
                                @lang('lang.moneysafes')</a></li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                            aria-current="page">@lang('lang.watch_moneysafe_transaction')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- End Breadcrumbbar -->
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('lang.watch_moneysafe_transaction')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    @include('money_safe.filters', ['id' => $moneySafeTransactions->id])
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('lang.creation_date')</th>
                                        <th>@lang('lang.source')</th>
                                        <th>@lang('lang.job')</th>
                                        <th>@lang('lang.store')</th>
                                        <th>@lang('lang.type')</th>
                                        <th>@lang('lang.amount') &nbsp; {{ $basic_currency }}</th>
                                        <th>@lang('lang.balance')&nbsp; {{ $basic_currency }}</th>
                                        <th>@lang('lang.amount') &nbsp; {{ $default_currency }}</th>
                                        <th>@lang('lang.balance')&nbsp; {{ $default_currency }}</th>
                                        <th>@lang('added_by')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($moneySafeTransactions->transactions as $index => $msafe_trans)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $msafe_trans->transaction_date }}</td>
                                            <td>@lang('lang.' . $msafe_trans->source_type . '')</td>
                                            <td class="textcenter">
                                                {{ isset($msafe_trans->job_type_id) ? $msafe_trans->job_type->title : '-' }}
                                            </td>
                                            <td>{{ $msafe_trans->store->name }}</td>
                                            <td>@lang('lang.' . $msafe_trans->type . '')</td>
                                            <td>
                                                @if ($msafe_trans->type == 'add_money')
                                                    <span
                                                        class="text-primary">{{ $basic_currency }}&nbsp;{{ @num_format($msafe_trans->amount) }}</span>
                                                @else
                                                    <span
                                                        class="text-danger">{{ $basic_currency }}&nbsp;{{ @num_format($msafe_trans->amount) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $basic_currency }}&nbsp;{{ @num_format($msafe_trans->balance) }}
                                            </td>
                                            <td>
                                                @if ($msafe_trans->type == 'add_money')
                                                    <span
                                                        class="text-primary">{{ $default_currency }}&nbsp;{{ @num_format($moneySafeTransactions->currency->id !== '2' ? $msafe_trans->amount / $settings['dollar_exchange'] : $msafe_trans->amount * $settings['dollar_exchange']) }}</span>
                                                @else
                                                    <span
                                                        class="text-danger">{{ $default_currency }}&nbsp;{{ @num_format($moneySafeTransactions->currency->id !== '2' ? $msafe_trans->amount / $settings['dollar_exchange'] : $msafe_trans->amount * $settings['dollar_exchange']) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($moneySafeTransactions->currency->id !== '2')
                                                    {{ $default_currency }} &nbsp;
                                                    {{ @num_format($msafe_trans->balance / $settings['dollar_exchange']) }}
                                                @else
                                                    {{ $default_currency }} &nbsp;
                                                    {{ @num_format($msafe_trans->balance * $settings['dollar_exchange']) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($msafe_trans->created_by > 0 and $msafe_trans->created_by != null)
                                                    {{ $msafe_trans->created_at->diffForHumans() }} <br>
                                                    {{ $msafe_trans->created_at->format('Y-m-d') }}
                                                    ({{ $msafe_trans->created_at->format('h:i') }})
                                                    {{ $msafe_trans->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                    <br>
                                                    {{ $msafe_trans->createBy?->name }}
                                                @else
                                                    {{ __('no_update') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
    </div>
    <!-- End Rightbar -->
    </div>
@endsection
