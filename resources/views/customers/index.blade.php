@extends('layouts.app')
@section('title', __('lang.customers'))
@push('css')
{{-- <style>
    .table-scroll-wrapper {
        width: fit-content;
    }

    @media(min-width:1900px) {
        .table-scroll-wrapper {
            width: 100%;
        }
    }

    .wrapper1,
    .wrapper2 {
        overflow-x: scroll;
        overflow-y: hidden;
    }

    .wrapper1 {
        margin-top: 40px;
    }

    @media(max-width:768px) {


        .wrapper1 {
            margin-top: 115px !important;
        }
    }

    .wrapper1 {
        height: 20px;
    }

    .div1 {
        height: 20px;
    }

    .div2 {
        overflow: auto;
        width: fit-content;
    }
</style> --}}
<style>
    .table-top-head {
        top: 30px !important;
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
</style>
@endpush

@section('page_title')
@lang('lang.customers')
@endsection

@section('breadcrumbs')
@parent
<li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
    @lang('lang.customers')</li>
@endsection

@section('button')
<div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        @lang('lang.add_customers')
    </a>
</div>
@endsection


@section('content')
<!-- Start Contentbar -->
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h6 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.customers')</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container-fluid">
                                {{-- @include('customers.filters') --}}
                            </div>
                        </div>
                    </div>
                    {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}

                    {{-- +++++++++++++++++++++++++++ Table +++++++++++++++++++++++++++ --}}
                    <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                        <div class="div1"></div>
                    </div>
                    <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                        <div class="div2 table-scroll-wrapper">
                            <!-- content goes here -->
                            <div style="min-width: 1000px;max-height: 90vh;overflow: auto">
                                <table id="datatable-buttons" class="table table-striped table-bordered hideShowTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="col1">@lang('lang.customer_name')</th>
                                            <th class="col2">@lang('lang.customer_type')</th>
                                            <th class="col3">@lang('lang.email')</th>
                                            <th class="col4">@lang('lang.phone')</th>
                                            <th class="col5">@lang('lang.state')</th>
                                            <th class="col6">@lang('lang.city')</th>
                                            <th class="col7">@lang('lang.min_amount_in_dinar')</th>
                                            <th class="col8">@lang('lang.max_amount_in_dinar')</th>
                                            <th class="col9 dollar-cell showHideDollarCells">
                                                @lang('lang.min_amount_in_dollar')</th>
                                            <th class="col10 dollar-cell showHideDollarCells">
                                                @lang('lang.max_amount_in_dollar')</th>
                                            <th class="col11">@lang('lang.balance_in_dinar')</th>
                                            <th class="col12 dollar-cell showHideDollarCells">
                                                @lang('lang.balance_in_dollar')</th>
                                            <th class="col13">@lang('lang.balance')</th>
                                            <th class="col14">@lang('lang.purchases')</th>
                                            <th class="col15">@lang('lang.discount')</th>
                                            <th class="col16">@lang('lang.points')</th>
                                            <th class="col17">@lang('updated_by')</th>
                                            <th class="col18">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $index => $customer)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="col1">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.customer_name')">
                                                    {{ $customer->name }}
                                                </span>
                                            </td>
                                            <td class="col2">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.customer_type')">
                                                    {{ $customer->customer_type->name }}
                                                </span>
                                            </td>
                                            {{-- Convert the email and phone strings to arrays --}}
                                            @php
                                            $emailArray = explode(',', $customer->email);
                                            $phoneArray = explode(',', $customer->phone);
                                            // Remove square brackets from each element in the emailArray
                                            foreach ($emailArray as $key => $email) {
                                            $emailArray[$key] = str_replace(
                                            ['[', ']', '"'],
                                            '',
                                            $email,
                                            );
                                            }
                                            // Remove square brackets from each element in the emailArray
                                            foreach ($phoneArray as $key => $phone) {
                                            $phoneArray[$key] = str_replace(
                                            ['[', ']', '"'],
                                            '',
                                            $phone,
                                            );
                                            }
                                            @endphp
                                            <td class="col3">
                                                {{-- Iterate over the email array elements --}}
                                                @foreach ($emailArray as $email)
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.email')">
                                                    {{ $email }}<br>
                                                </span>
                                                @endforeach
                                            </td>
                                            <td class="col4">
                                                {{-- Iterate over the phone array elements --}}
                                                @foreach ($phoneArray as $phone)
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.phone')">
                                                    {{ $phone }}<br>
                                                </span>
                                                @endforeach
                                            </td>

                                            @php
                                            $state = \App\Models\State::find($customer->state_id);
                                            $city = \App\Models\City::find($customer->city_id);
                                            @endphp
                                            <td class="col5">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.state')">
                                                    {{ $state ? $state->name : '' }}
                                                </span>
                                            </td>
                                            <td class="col6">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.city')">
                                                    {{ $city ? $city->name : '' }}
                                                </span>
                                            </td>
                                            <td class="col7">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.min_amount_in_dinar')">
                                                    {{ $customer->min_amount_in_dinar }}
                                                </span>
                                            </td>
                                            <td class="col8">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.max_amount_in_dinar')">
                                                    {{ $customer->max_amount_in_dinar }}
                                                </span>
                                            </td>
                                            <td class="col9 dollar-cell showHideDollarCells">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.min_amount_in_dollar')">
                                                    {{ $customer->min_amount_in_dollar }}
                                                </span>
                                            </td>
                                            <td class="col10 dollar-cell showHideDollarCells">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.max_amount_in_dollar')">
                                                    {{ $customer->max_amount_in_dollar }}
                                                </span>
                                            </td>
                                            <td class="col11">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.balance_in_dinar')">
                                                    {{ $customer->balance }}
                                                </span>
                                            </td>
                                            <td class="col12 dollar-cell showHideDollarCells">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.balance_in_dollar')">
                                                    {{ $customer->dollar_balance }}
                                                </span>
                                            </td>
                                            <td class="col13">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.balance')">
                                                    {{ $customer->added_balance }}
                                                </span>
                                            </td>
                                            <td class="col14">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.purchases')">
                                                    {{ $customer->added_balance }}
                                                </span>
                                            </td>
                                            <td class="col15">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.discount')">
                                                    {{ $customer->added_balance }}
                                                </span>
                                            </td>
                                            <td class="col16">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('lang.points')">
                                                    @if ($customer->created_by > 0 and $customer->created_by != null)
                                                    {{ $customer->created_at->diffForHumans() }} <br>
                                                    {{ $customer->created_at->format('Y-m-d') }}
                                                    ({{ $customer->created_at->format('h:i') }})
                                                    {{ $customer->created_at->format('A') == 'AM' ? __('am') : __('pm')
                                                    }}
                                                    <br>
                                                    {{ $customer->createBy?->name }}
                                                    @else
                                                    {{ __('no_update') }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="col17">
                                                <span
                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                    style="font-size: 12px;font-weight: 600"
                                                    data-tooltip="@lang('updated_by')">
                                                    @if ($customer->updated_by > 0 and $customer->updated_by != null)
                                                    {{ $customer->updated_at->diffForHumans() }}
                                                    ({{ $customer->updated_at->format('h:i') }})
                                                    {{ $customer->updated_at->format('Y-m-d') }}
                                                    {{ $customer->updated_at->format('A') == 'AM' ? __('am') : __('pm')
                                                    }}
                                                    <br>
                                                    {{ $customer->updateBy?->name }}
                                                    @else
                                                    <span class=" d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600">
                                                        {{ __('no_update') }}
                                                    </span>
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="col18">
                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn btn-default btn-sm dropdown-toggle d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">خيارات <span
                                                            class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                        user="menu" x-placement="bottom-end"
                                                        style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <li>
                                                            <a href="{{ route('customer_dues', $customer->id) }}"
                                                                class="btn  drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                target="_blank"><i class="dripicons-document-edit"></i>
                                                                @lang('lang.dues')</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('customers.show', $customer->id) }}"
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                target="_blank">
                                                                <i class="fa fa-eye"></i>@lang('lang.view')
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('customers.edit', $customer->id) }}"
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                target="_blank"><i class="dripicons-document-edit"></i>
                                                                @lang('lang.update')</a>
                                                        </li>

                                                        <li>
                                                            <a data-href="{{ route('customers.destroy', $customer->id) }}"
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item"><i
                                                                    class="fa fa-trash"></i>
                                                                @lang('lang.delete')</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('customer-balance-adjustment.create', ['customer_id' => $customer->id]) }}"
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                target="_blank">
                                                                <i class="fa fa-adjust"></i>
                                                                @lang('lang.adjust_customer_balance')</a>
                                                        </li>
                                                    </ul>
                                                </div>
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
        </div>
    </div>
    <!-- End col -->
</div>
<!-- End row -->
<!-- End Contentbar -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Select both elements by their class names
        var div1 = document.querySelector('.div1');
        var div2 = document.querySelector('.div2');

        // Get the width of the "div2" element
        var div2Width = div2.offsetWidth;

        // Set the width of "div1" to the width of "div2"
        div1.style.width = div2Width + 'px';

        document.addEventListener("DOMContentLoaded", function() {
            var wrapper1 = document.querySelector(".wrapper1");
            var wrapper2 = document.querySelector(".wrapper2");

            wrapper1.addEventListener("scroll", function() {
                wrapper2.scrollLeft = wrapper1.scrollLeft;
            });

            wrapper2.addEventListener("scroll", function() {
                wrapper1.scrollLeft = wrapper2.scrollLeft;
            });
        });
</script>
{{-- <script>
    // +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++
        $("input:checkbox:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });

        $("input:checkbox").click(function() {
            var column = "table ." + $(this).attr("name");
            $(column).toggle();
        });
        // +++++++++++++++++ Checkboxs and label inside selectbox : showCheckboxes() method ++++++++++++++
        var expanded = false;

        function showCheckboxes() {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }
</script> --}}
@endsection
