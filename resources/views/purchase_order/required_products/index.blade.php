@extends('layouts.app')
@section('title', __('lang.required_products'))


@push('css')
    <style>
        th {
            position: sticky;
            top: 0;
        }

        .table-top-head {
            top: 0;
        }

        .wrapper1 {
            margin-top: -15px;
        }

        @media(max-width:768px) {


            .wrapper1 {
                margin-top: 115px !important;
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.required_products')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('purchase_order.index') }}">/ @lang('lang.show_purchase_order')</a>
    </li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.required_products')</li>
@endsection

@section('content')
    <div class="animate-in-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="row">
                                {{-- ////////////////////// Filters ////////////////////// --}}
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        @include('purchase_order.required_products.partials.filters')
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <form class="form-group" id="productForm"
                                        action="{{ route('required-products.store') }}" method="POST"
                                        enctype="multipart/form-data" style="margin-top: 25px">
                                        @csrf
                                        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif"
                                            style="margin-top:25px ">
                                            <div class="div1"></div>
                                        </div>
                                        <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                            <div class="div2 table-scroll-wrapper">
                                                <!-- content goes here -->
                                                <div style="min-width: 1200px;max-height: 90vh;overflow: auto">
                                                    {{-- ++++++++++++++ required products Table ++++++++++ --}}
                                                    <table id="datatable-buttons"
                                                        class="table table-striped table-bordered table-hover m-auto @if (app()->isLocale('ar')) dir-rtl @endif">
                                                        <thead>
                                                            <tr>
                                                                <th class="col1">#</th>
                                                                {{-- "select_all" checkbox --}}
                                                                <th class="col2"> <input type="checkbox"
                                                                        id="select_all_ids" />
                                                                    <span class="d-none">
                                                                        @lang('lang.select_all')
                                                                    </span>
                                                                </th>
                                                                <th class="col3">@lang('lang.employee_name')</th>
                                                                <th class="col4">@lang('lang.date')</th>
                                                                <th class="col5">@lang('lang.product_name')</th>
                                                                <th class="col6">@lang('lang.store')</th>
                                                                <th class="col7">@lang('lang.status')</th>
                                                                <th class="col8">@lang('lang.supplier_name')</th>
                                                                <th class="col9">@lang('lang.branch_name')</th>
                                                                <th class="col10">@lang('lang.purchase_price')</th>
                                                                <th class="col11">@lang('lang.required_quantity')</th>
                                                                <th class="col12">@lang('lang.action')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tbody">
                                                            @foreach ($requiredProducts as $index => $requiredProduct)
                                                                <tr>
                                                                    <td class="col1">
                                                                        <span
                                                                            class=" d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600">
                                                                            {{ $index + 1 }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="col2">
                                                                        <span
                                                                            class=" d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600">

                                                                            <input type="checkbox"
                                                                                name="products[{{ $index }}][checkbox]"
                                                                                class="checkbox_ids" value="1" />
                                                                        </span>
                                                                    </td>
                                                                    {{-- +++++++++++++++++ employee_id +++++++++++++++++ --}}
                                                                    <td class="col3">
                                                                        <span
                                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600"
                                                                            data-tooltip="@lang('lang.employee_name')">
                                                                            <input type="hidden" class="form-control"
                                                                                name="products[{{ $index }}][employee_id]"
                                                                                value="{{ $requiredProduct->employee_id }}">
                                                                            {{ !empty($requiredProduct->employee_id) ? $requiredProduct->employee->employee_name : '' }}
                                                                        </span>
                                                                    </td>
                                                                    {{-- +++++++++++++++++ order_date +++++++++++++++++ --}}
                                                                    <td class="col4">
                                                                        <span
                                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600"
                                                                            data-tooltip="@lang('lang.date')">
                                                                            <input type="hidden" class="form-control"
                                                                                name="products[{{ $index }}][order_date]"
                                                                                value="{{ $requiredProduct->order_date }}">
                                                                            {{ !empty($requiredProduct->order_date) ? $requiredProduct->order_date : '' }}
                                                                        </span>
                                                                    </td>
                                                                    {{-- +++++++++++++++++ product_id +++++++++++++++++ --}}
                                                                    <td class="col5">
                                                                        <span
                                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600"
                                                                            data-tooltip="@lang('lang.product_name')">
                                                                            <input type="hidden" class="form-control"
                                                                                name="products[{{ $index }}][product_id]"
                                                                                value="{{ $requiredProduct->product_id }}">
                                                                            {{-- {{ !empty($requiredProduct->product_id) ? $requiredProduct->product->name : '' }} --}}
                                                                            {{ !empty($requiredProduct->product_id) && !is_null($requiredProduct->product) ? $requiredProduct->product->name : '' }}
                                                                        </span>
                                                                    </td>
                                                                    {{-- +++++++++++++++++ store_id +++++++++++++++++ --}}
                                                                    <td class="col6">
                                                                        <span
                                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600"
                                                                            data-tooltip="@lang('lang.store')">
                                                                            <input type="hidden" class="form-control"
                                                                                name="products[{{ $index }}][store_id]"
                                                                                id="store_id"
                                                                                value="{{ $requiredProduct->store_id }}">
                                                                            {{ !empty($requiredProduct->store_id) ? $requiredProduct->stores->name : '' }}
                                                                        </span>
                                                                    </td>
                                                                    {{-- +++++++++++++++++ status +++++++++++++++++ --}}
                                                                    <td class="col7">
                                                                        <span
                                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600"
                                                                            data-tooltip="@lang('lang.status')">
                                                                            <input type="hidden" class="form-control"
                                                                                name="products[{{ $index }}][status]"
                                                                                id="status" value="final">
                                                                            {{ !empty($requiredProduct->status) ? $requiredProduct->status : '' }}
                                                                        </span>
                                                                    </td>
                                                                    {{-- +++++++++++++++++ supplier_id +++++++++++++++++ --}}
                                                                    <td class="col8">
                                                                        <span
                                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600"
                                                                            data-tooltip="@lang('lang.supplier_name')">

                                                                            <input type="hidden" class="form-control"
                                                                                name="products[{{ $index }}][supplier_id]"
                                                                                id="supplier_id"
                                                                                value="{{ $requiredProduct->supplier_id }}">
                                                                            {{ !empty($requiredProduct->supplier_id) ? $requiredProduct->supplier->name : '' }}
                                                                        </span>
                                                                    </td>
                                                                    {{-- +++++++++++++++++ branch_id +++++++++++++++++ --}}
                                                                    <td class="col9">
                                                                        <span
                                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600"
                                                                            data-tooltip="@lang('lang.branch_name')">

                                                                            <input type="hidden" class="form-control"
                                                                                name="products[{{ $index }}][branch_id]"
                                                                                id="branch_id"
                                                                                value="{{ $requiredProduct->branch_id }}">
                                                                            {{ !empty($requiredProduct->branch_id) ? $requiredProduct->branch->name : '' }}
                                                                        </span>
                                                                    </td>
                                                                    {{-- +++++++++++++++++ purchase_price , dollar_purchase_price +++++++++++++++++ --}}
                                                                    <td class="col10">
                                                                        <span
                                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600"
                                                                            data-tooltip="@lang('lang.purchase_price')">

                                                                            {{-- dinar_purchase_price --}}
                                                                            <input type="hidden" class="form-control"
                                                                                name="products[{{ $index }}][purchase_price]"
                                                                                id="purchase_price"
                                                                                value="{{ $requiredProduct->purchase_price }}">
                                                                            {{ !empty($requiredProduct->purchase_price) ? $requiredProduct->purchase_price : '' }}
                                                                        </span>
                                                                        <br />
                                                                        {{-- dollar_purchase_price --}}
                                                                        <span class="dollar-cell">
                                                                            <input type="hidden" class="form-control"
                                                                                name="products[{{ $index }}][dollar_purchase_price]"
                                                                                id="dollar_purchase_price"
                                                                                value="{{ $requiredProduct->dollar_purchase_price }}">
                                                                            {{ !empty($requiredProduct->dollar_purchase_price) ? $requiredProduct->dollar_purchase_price : '' }}
                                                                            $
                                                                        </span>
                                                                        </span>
                                                                    </td>
                                                                    <td class="col11">
                                                                        <span
                                                                            class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                            style="font-size: 12px;font-weight: 600"
                                                                            data-tooltip="@lang('lang.required_quantity')">
                                                                            <input type="text" class="form-control"
                                                                                name="products[{{ $index }}][required_quantity]"
                                                                                id="required_quantity"
                                                                                placeholder="@lang('lang.required_quantity')">
                                                                        </span>
                                                                    </td>
                                                                    {{-- +++++++++++++++++ delete button +++++++++++++++++ --}}
                                                                    <td class="text-center col12">
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-xs btn-danger deleteRow">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <th class="table_totals">@lang('lang.totals')</th>
                                                                <td class="sum_footer">
                                                                    {{ @num_format($purchase_price_sum) }}</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                </div>


                                {{-- +++++++++++++ save Button +++++++++++ --}}
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <div class="text-right">
                                            <input type="submit" id="submit-btn" class="btn btn-primary"
                                                value="@lang('lang.save')" name="submit">
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@push('javascripts')
    <script>
        $(document).ready(function() {
            // when click on "selectAll" checkbox
            $('.checked_all').change(function() {
                tr = $(this).closest('tr');
                var checked_all = $(this).prop('checked');

                tr.find('.check_box').each(function(item) {
                    if (checked_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })
            })
            // ======================================== Checkboxes of "products" table ========================================
            // when click on "all checkboxs" , it will checked "all checkboxes"
            $('#select_all_ids').click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'));
            });
            // +++++++++++++ Delete Row in required_product +++++++++++++
            $('.tbody').on('click', '.deleteRow', function() {
                $(this).parent().parent().remove();
            });
        });
    </script>
    <script>
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
    </script>
@endpush
