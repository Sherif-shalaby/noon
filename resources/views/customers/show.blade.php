@extends('layouts.app')
@section('title', __('lang.customer'))

@section('page_title')
@lang('lang.customers')
@endsection

@section('breadcrumbs')
@parent
<li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"><a
        style="text-decoration: none;color: #596fd7" href="{{ route('customers.index') }}">/
        @lang('lang.customers')</a>
</li>
<li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
    @lang('lang.customer') {{ $customer->name }}
</li>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-1">
                <div
                    class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                    <h6>@lang('lang.employee') </h6>
                    {{-- <a href="{{action('EmployeeController@sendLoginDetails', $employee->id)}}" --}} {{--
                        class="btn btn-primary btn-xs" style="margin-left: 10px;"><i class="fa fa-paper-plane"></i>
                        @lang('lang.send_credentials')</a> --}}
                </div>
                <div class="card-body">
                    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div class="col-md-10">
                            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div
                                    class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="fname">@lang('lang.customer_type')
                                    </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        {{ $customer->customer_type->name ?? '' }}
                                    </span>
                                </div>
                                <div
                                    class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="name">@lang('lang.name')</label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        {{ $customer->name }}
                                    </span>
                                </div>
                                @php
                                $emailArray = explode(',', $customer->email);
                                $phoneArray = explode(',', $customer->phone);
                                // Remove square brackets from each element in the emailArray
                                foreach ($emailArray as $key => $email) {
                                $emailArray[$key] = str_replace(['[', ']', '"'], '', $email);
                                }
                                // Remove square brackets from each element in the emailArray
                                foreach ($phoneArray as $key => $phone) {
                                $phoneArray[$key] = str_replace(['[', ']', '"'], '', $phone);
                                }
                                @endphp
                                <div
                                    class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="email">@lang('lang.email') </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        @foreach ($emailArray as $email)
                                        {{ $email }}<br>
                                        @endforeach
                                    </span>
                                </div>
                                <div
                                    class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="email">@lang('lang.phone') </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        @foreach ($phoneArray as $phone)
                                        {{ $phone }}<br>
                                        @endforeach
                                    </span>
                                </div>

                                <div
                                    class="col-sm-6 dollar-cell showHideDollarCells d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="date_of_start_working">@lang('lang.min_amount_in_dollar') </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        {{ $customer->min_amount_in_dollar }}
                                    </span>
                                </div>
                                <div
                                    class="col-sm-6 dollar-cell showHideDollarCells d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="date_of_birth">@lang('lang.max_amount_in_dollar') </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        {{ $customer->max_amount_in_dollar }}
                                    </span>
                                </div>


                                <div
                                    class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="job_type">@lang('lang.min_amount_in_dinar') </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        {{ $customer->min_amount_in_dinar }}
                                    </span>
                                </div>
                                <div
                                    class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="mobile">@lang('lang.max_amount_in_dinar') </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        {{ $customer->max_amount_in_dinar }}
                                    </span>
                                </div>
                                <div
                                    class="col-sm-6 dollar-cell showHideDollarCells d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="mobile">@lang('lang.balance_in_dollar') </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        {{ $customer->balance_in_dollar }}
                                    </span>
                                </div>
                                <div
                                    class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="mobile">@lang('lang.balance_in_dinar') </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        {{ $customer->balance_in_dinar }}
                                    </span>
                                </div>
                                @php
                                $state = \App\Models\State::find($customer->state_id);
                                $city = \App\Models\City::find($customer->city_id);
                                @endphp
                                <div
                                    class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="mobile">@lang('lang.state') </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        {{ $state ? $state->name : '' }}
                                    </span>
                                </div>
                                <div
                                    class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="mobile">@lang('lang.city') </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        {{ $city ? $city->name : '' }}
                                    </span>
                                </div>
                                <div
                                    class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="mobile">@lang('lang.address') </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        {{ $customer->address }}
                                    </span>
                                </div>
                                <div
                                    class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                        for="mobile">@lang('lang.notes') </label> :
                                    <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                        {{ $customer->notes }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <img src="@if (!empty($customer->image)) {{ asset('uploads/' . $customer->image) }}@else{{ asset('images/default.jpg') }} @endif"
                                    style="" class="img-fluid" />
                            </div>
                        </div>
                    </div>
                    <div class="row  ">
                        <div
                            class="col-md-12 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <label for="mobile" style="font-size: 16px;font-weight: 500" class="mx-2 mb-0">
                                @lang('lang.important_dates') </label>
                            @if ($customer->customer_important_dates)
                            @foreach ($customer->customer_important_dates as $date)
                            <div
                                class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label style="font-size: 16px;font-weight: 500" class="mb-0 mx-2"
                                    for="important_date">@lang('lang.important_date') </label> :
                                <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                    {{ $date->details }}
                                </span>
                            </div>
                            <div
                                class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label style="font-size: 16px;font-weight: 500" class="mb-0 mx-2"
                                    for="date">@lang('lang.date') </label> :
                                <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                    {{ $date->date }}
                                </span>
                            </div>
                            @endforeach
                            @endif

                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs ml-4 mt-3" role="tablist">
                            {{-- ++++++++++++ tab 1 : info +++++++++++ --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link @if (empty(request()->show)) active @endif" href="#info-sale"
                                    role="tab" data-toggle="tab">@lang('lang.info')</a>
                            </li> --}}
                            {{-- ++++++++++++ tab 2 : pending_orders +++++++++++ --}}

                            {{-- ++++++++++++ tab 3 : statement_of_account +++++++++++ --}}

                            {{-- ++++++++++++ tab 4 : statement_of_account +++++++++++ --}}
                            <li class="nav-item">
                                <a class="nav-link  show active" href="#statement-of-sell-account" role="tab"
                                    data-toggle="tab">@lang('lang.statement_of_account') @lang('lang.sell')</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            {{-- ++++++++++++ Tab 1 Content : info : معلومات +++++++++++ --}}
                            <div role="tabpanel" class="tab-pane fade @if (empty(request()->show))  @endif"
                                id="info-sale">
                                <br>
                                <br>
                                <div class="col-md-12 text-muted">
                                    <div class="row">
                                        {{-- <input type="hidden" name="supplier_id" id="supplier_id"
                                            value="{{ $supplier->id }}"> --}}
                                        <div class="col-md-6">
                                            <div class="col-md-12 ">
                                                <b>@lang('lang.name'):</b>
                                                {{-- <span class="customer_name_span">{{ $supplier->name }}</span> --}}
                                            </div>

                                            <div class="col-md-12">
                                                <b>@lang('lang.company_name'):</b>
                                                {{-- <span class="customer_company_name_span">{{ $supplier->company_name
                                                    }}</span> --}}
                                            </div>

                                            <div class="col-md-12">
                                                <b>@lang('lang.vat_number'):</b>
                                                {{-- <span class="customer_vat_number_span">{{ $supplier->vat_number
                                                    }}</span> --}}
                                            </div>
                                            <div class="col-md-12">
                                                <b>@lang('lang.email'):</b>
                                                {{-- <span class="customer_email_span">{{ $supplier->email }}</span>
                                                --}}
                                            </div>
                                            <div class="col-md-12">
                                                <b>@lang('lang.mobile'):</b>
                                                {{-- <span class="customer_mobile_span">{{ $supplier->mobile }}</span>
                                                --}}
                                            </div>
                                            <div class="col-md-12">
                                                <b>@lang('lang.address'):</b>
                                                {{-- <span class="customer_address_span">{{ $supplier->address }}</span>
                                                --}}
                                            </div>
                                            <div class="col-md-12">
                                                <b>@lang('lang.city'):</b>
                                                {{-- <span class="customer_city_span">{{ $supplier->city }}</span> --}}
                                            </div>
                                            <div class="col-md-12">
                                                <b>@lang('lang.state'):</b>
                                                {{-- <span class="customer_state_span">{{ $supplier->state }}</span>
                                                --}}
                                            </div>
                                            <div class="col-md-12">
                                                <b>@lang('lang.postal_code'):</b>
                                                {{-- <span class="customer_postal_code_span">{{ $supplier->postal_code
                                                    }}</span> --}}
                                            </div>
                                            <div class="col-md-12">
                                                <b>@lang('lang.country'):</b>
                                                {{-- <span class="customer_country_span">{{ $supplier->country }}</span>
                                                --}}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12">
                                                <div class="thumbnail">
                                                    {{-- <img style="width: 200px; height: 200px;" class="img-fluid"
                                                        src="@if (!empty($supplier->getFirstMediaUrl('supplier_photo'))) {{ $supplier->getFirstMediaUrl('supplier_photo') }} @endif"
                                                        alt="Supplier photo"> --}}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button id="confirmSelected" class="btn btn-primary">تأكيد المطابقة</button>
                            {{-- ++++++++++++ Tab 4 Content : statement_of_account : البيع كشف حساب +++++++++++ --}}
                            <div role="tabpanel" class="tab-pane fade show active " id="statement-of-sell-account">
                                <div class="table-responsive">
                                    <table class="table dataTable">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.date')</th>
                                                <th>رقم الفاتوره</th>
                                                <th>قيمة الفاتور بالدينار </th>
                                                <th>قيمة الفاتور بالدولار</th>
                                                <th>المدفوع بالدينار</th>
                                                <th>المدفوع بالدولار</th>
                                                <th>رصيد العميل بالدولار</th>
                                                <th>رصيد العميل بالدينار</th>
                                                <th>
                                                    <input type="checkbox" id="select-all-checkbox"> المطابقه
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($sell_lines as $line)
                                            <tr>
                                                <td>{{ $line->transaction_date }}</td>
                                                <td>{{ $line->invoice_no }}</td>
                                                <td>{{ $line->transaction_value_dinar }}</td>
                                                <td>{{ $line->transaction_value_dollar }}</td>
                                                <td>{{ $line->payment_dinar_value }}</td>
                                                <td>{{ $line->Payment_dollar_value }}</td>
                                                <td>{{ $line->DOLLAR_Balance }}</td>
                                                <td>{{ $line->DINAR_Balance }}</td>
                                                <td>
                                                    @if ($line->IS_CONFIRMED == 0)
                                                    <input type="checkbox" name="confirm_checkbox[]"
                                                        value="{{ $line->payment_id }}">
                                                    @elseif ($line->IS_CONFIRMED == 1)
                                                    <i class="fas fa-check-circle fa-2x" style="color: green;"></i>
                                                    @endif

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- --}}
                {{-- --}}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            $('#select-all-checkbox').click(function() {
                $('input[name="confirm_checkbox[]"]').prop('checked', $(this).prop('checked'));
            });

            $('#confirmSelected').click(function() {
                var selectedIds = [];
                $('input[name="confirm_checkbox[]"]:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length > 0) {
                    $.ajax({
                        url: '/updateConfirmStatus', // Replace with your route
                        method: 'POST',
                        data: {
                            ids: selectedIds
                        },
                        success: function(response) {
                            // Display success message
                            alert(response.message);

                            // Reload the window
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.error(error);
                        }
                    });
                } else {
                    alert('Please select at least one item.');
                }
            });
        });
</script>
@endsection
