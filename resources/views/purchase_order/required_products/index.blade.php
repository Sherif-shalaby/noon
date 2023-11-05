@extends('layouts.app')
@section('title', __('lang.required_products'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        {{-- ///////// left side //////////// --}}
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">@lang('lang.required_products')</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('purchase_order.index')}}">@lang('lang.show_purchase_order')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('lang.required_products')</li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {{-- ////////////////////// Filters ////////////////////// --}}
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    @include('purchase_order.partials.filters')
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <form class="form-group" id="productForm" action="{{ route('required-products.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-4 m-auto">
                                        {{-- ++++++++++++++ required products Table ++++++++++ --}}
                                        <table id="productTable" class="table table-striped table-bordered m-auto">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    {{-- "select_all" checkbox --}}
                                                    <th> <input type="checkbox" id="select_all_ids"/> </th>
                                                    <th>@lang('lang.employee_name')</th>
                                                    <th>@lang('lang.date')</th>
                                                    <th>@lang('lang.product_name')</th>
                                                    <th>@lang('lang.store')</th>
                                                    <th>@lang('lang.status')</th>
                                                    <th>@lang('lang.supplier_name')</th>
                                                    <th>@lang('lang.branch_name')</th>
                                                    <th>@lang('lang.purchase_price')</th>
                                                    <th>@lang('lang.required_quantity')</th>
                                                    <th>@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody">
                                                @foreach($requiredProducts as $index=>$requiredProduct)
                                                    <tr>
                                                        <td>{{ $index+1 }}</td>
                                                        <td>
                                                            <input type="checkbox" name="products[{{$index}}][checkbox]" class="checkbox_ids" value="1" />
                                                        </td>
                                                        {{-- +++++++++++++++++ employee_id +++++++++++++++++ --}}
                                                        <td>
                                                            <input  type="hidden" class="form-control" name="products[{{$index}}][employee_id]"
                                                                    value="{{ $requiredProduct->employee_id }}">
                                                            {{ !empty($requiredProduct->employee_id) ? $requiredProduct->employee->employee_name : '' }}
                                                        </td>
                                                        {{-- +++++++++++++++++ order_date +++++++++++++++++ --}}
                                                        <td>
                                                            <input type="hidden" class="form-control" name="products[{{$index}}][order_date]" value="{{ $requiredProduct->order_date }}">
                                                            {{ !empty($requiredProduct->order_date) ? $requiredProduct->order_date : '' }}
                                                        </td>
                                                        {{-- +++++++++++++++++ product_id +++++++++++++++++ --}}
                                                        <td>
                                                            <input type="hidden" class="form-control" name="products[{{$index}}][product_id]" value="{{ $requiredProduct->product_id }}">
                                                            {{ !empty($requiredProduct->product_id) ? $requiredProduct->product->name : '' }}
                                                        </td>
                                                        {{-- +++++++++++++++++ store_id +++++++++++++++++ --}}
                                                        <td>
                                                            <input type="hidden" class="form-control" name="products[{{$index}}][store_id]" id="store_id" value="{{ $requiredProduct->store_id }}">
                                                            {{!empty($requiredProduct->store_id)?$requiredProduct->stores->name:''}}
                                                        </td>
                                                        {{-- +++++++++++++++++ status +++++++++++++++++ --}}
                                                        <td>
                                                            <input type="hidden" class="form-control" name="products[{{$index}}][status]" id="status" value="final">
                                                            {{!empty($requiredProduct->status)?$requiredProduct->status:''}}
                                                        </td>
                                                        {{-- +++++++++++++++++ supplier_id +++++++++++++++++ --}}
                                                        <td>
                                                            <input type="hidden" class="form-control" name="products[{{$index}}][supplier_id]" id="supplier_id" value="{{ $requiredProduct->supplier_id }}">
                                                            {{!empty($requiredProduct->supplier_id)?$requiredProduct->supplier->name:''}}
                                                        </td>
                                                        {{-- +++++++++++++++++ branch_id +++++++++++++++++ --}}
                                                        <td>
                                                            <input type="hidden" class="form-control" name="products[{{$index}}][branch_id]" id="branch_id" value="{{ $requiredProduct->branch_id }}">
                                                            {{!empty($requiredProduct->branch_id)?$requiredProduct->branch->name:''}}
                                                        </td>
                                                        {{-- +++++++++++++++++ purchase_price , dollar_purchase_price +++++++++++++++++ --}}
                                                        <td>
                                                            {{-- dinar_purchase_price --}}
                                                            <input type="hidden" class="form-control" name="products[{{$index}}][purchase_price]" id="purchase_price" value="{{ $requiredProduct->purchase_price }}">
                                                            {{!empty($requiredProduct->purchase_price)?$requiredProduct->purchase_price:''}} <br/>
                                                            {{-- dollar_purchase_price --}}
                                                            <input type="hidden" class="form-control" name="products[{{$index}}][dollar_purchase_price]" id="dollar_purchase_price" value="{{ $requiredProduct->dollar_purchase_price }}">
                                                            {{!empty($requiredProduct->dollar_purchase_price)?$requiredProduct->dollar_purchase_price:''}} $
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="products[{{$index}}][required_quantity]" id="required_quantity"
                                                                    placeholder="@lang('lang.required_quantity')">
                                                        </td>
                                                        {{-- +++++++++++++++++ delete button +++++++++++++++++ --}}
                                                        <td  class="text-center">
                                                            <a href="javascript:void(0)" class="btn btn-xs btn-danger deleteRow">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <br/>
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

@endsection

@push('javascripts')
    <script>
        $(document ).ready(function() {
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
            $('.tbody').on('click','.deleteRow',function(){
                $(this).parent().parent().remove();
            });
        });
    </script>
@endpush
