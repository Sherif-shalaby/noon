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
                                                    <th>@lang('lang.supplier_name')</th>
                                                    <th>@lang('lang.branch_name')</th>
                                                    <th>@lang('lang.last_purchase_date')</th>
                                                    <th>@lang('lang.product_price')</th>
                                                    <th>@lang('lang.required_quantity')</th>
                                                    <th>@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            {{-- <tbody>
                                                @foreach($employee_products as $index=>$product)
                                                    <tr>
                                                        <td>{{ $index+1 }}</td>
                                                        <td>
                                                            <input type="checkbox" name="ids[]" class="checkbox_ids" value="{{$product->id}}" />
                                                        </td>
                                                        <td>{{$product->name}}</td>
                                                        <td>{{$product->sku}}</td>
                                                        <td>{{$product->category->name??''}}</td>
                                                        <td>
                                                            {{$product->subCategory1->name??''}} <br>
                                                            {{$product->subCategory2->name??''}} <br>
                                                            {{$product->subCategory3->name??''}}
                                                        </td>
                                                        <td>{{!empty($product->brand)?$product->brand->name:''}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody> --}}
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
        });
    </script>
@endpush
