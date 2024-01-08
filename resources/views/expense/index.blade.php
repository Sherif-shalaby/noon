@extends('layouts.app')
@section('title', __('lang.expenses'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="print-title">@lang('lang.expenses')</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <br>
                                <div class="table-responsive">
                                    <table class="table" style="width: auto" id="expense_table">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.expense_category')</th>
                                                <th>@lang('lang.beneficiary')</th>
                                                <th>@lang('lang.store')</th>
                                                <th class="sum">@lang('lang.amount_paid')</th>
                                                <th>@lang('lang.created_by')</th>
                                                <th>@lang('lang.creation_date')</th>
                                                <th>@lang('lang.payment_date')</th>
                                                <th>@lang('lang.next_payment_date')</th>
                                                <th>@lang('lang.store') @lang('lang.paid_by')</th>
                                                <th>@lang('lang.source_of_payment')</th>
                                                {{-- <th>@lang('lang.files')</th> --}}
                                                <th class="notexport">@lang('lang.action')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            {{-- Use Blade syntax to loop through $expenses --}}
                                            @foreach ($expenses as $expense)
                                                <tr>
                                                    <td>{{ $expense->expense_category->name }}</td>
                                                    <td>{{ $expense->expense_beneficiary->name }}</td>
                                                    <td>{{ $expense->store }}</td>
                                                    <td>{{ $expense->final_total }}</td>
                                                    <td>{{ $expense->created_by }}</td>
                                                    <td>{{ $expense->creation_date }}</td>
                                                    <td>{{ $expense->payment_date }}</td>
                                                    <td>{{ $expense->next_payment_date }}</td>
                                                    <td>{{ $expense->paid_by }}</td>
                                                    <td>{{ $expense->source_name }}</td>
                                                    <td> {{-- Add your logic for files column here --}}</td>
                                                    {{-- <td>{!! $expense->action !!}</td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right"><strong>@lang('lang.total')</strong></td>
                                                <td class="sum"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
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
        </div>
    </div>
@endsection

@section('javascript')
    <script>
         // Add your JavaScript logic here...
    </script>
@endsection
