@extends('layouts.app')
@section('title', __('lang.sales_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                {{-- <h4 class="page-title">@lang('lang.sales_report')</h4> --}}
                <h4 class="page-title">تقرير حركة صنف</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
                        {{-- <li class="breadcrumb-item active" aria-current="page">@lang('lang.sales_report')</li> --}}
                        <li class="breadcrumb-item active" aria-current="page">تقرير حركة صنف</li>
                    </ol>
                </div>
            </div>
            {{-- <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('products.create')}}" class="btn btn-primary">
                        @lang('lang.add_products')
                      </a>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
@section('content')
    {{-- <!-- Start row -->
    <div class="row d-flex justify-content-center">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">


            </div>
        </div>
    </div> --}}
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        {{-- <h5 class="card-title">@lang('lang.products')</h5> --}}
                        <h5 class="card-title"> تقرير حركة صنف</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">


                            {{-- @include('products.filters')  --}}
                            <div class="col" id="type">
                                <p class="mg-b-10"> ابحث عن طريق اسم المخزن</p><select
                                    class="form-control select2 js-example-basic-single" name="whearhouse" required>
                                    <option value="{{ $type ?? 'اختر اسم المخزن' }}" selected>
                                        {{ $type ?? 'اختر اسم المخزن' }}
                                    </option>

                                    <?php
                                    $stores = DB::table('stores')->select('id', 'name')->get();
                                    foreach ($stores as $store) {
                                        echo "<option value='" . $store->id . "' > $store->name </option>";
                                    }
                                    ?>

                                </select>
                            </div>



                            <div class="col" id="type">
                                <p class="mg-b-10"> ابحث عن طريق المنتج</p><select
                                    class="form-control select2 js-example-basic-single" name="whearhouse" required>
                                    <option value="{{ $type ?? 'اختر اسم المنتج' }}" selected>
                                        {{ $type ?? 'اختر اسم المنتج' }}
                                    </option>

                                    <?php
                                    $products = DB::table('products')->select('id', 'name')->get();
                                    foreach ($products as $product) {
                                        echo "<option value='" . $product->id . "' > $product->name </option>";
                                    }
                                    ?>

                                </select>
                            </div>




                            <div class="col-lg-3" id="start_at">
                                <label for="exampleFormControlSelect1">من تاريخ</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div><input class="form-control fc-datepicker" value="{{ $start_at ?? '' }}"
                                        name="start_at" placeholder="YYYY-MM-DD" type="date">
                                </div>
                            </div>




                            <div class="col-lg-3" id="end_at">
                                <label for="exampleFormControlSelect1">الي تاريخ</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div><input class="form-control fc-datepicker" name="end_at"
                                        value="{{ $end_at ?? '' }}" placeholder="YYYY-MM-DD" type="date">
                                </div><!-- input-group -->
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col ">
                                <input type="button" class="btn btn-primary"  value="تقرير" onclick="" />
                            </div>


                        </div>




















                        {{-- @if (session()->has('report')) --}}
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <br>
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>تاريخ العمليه </th>
                                        <th>اسم المنتج</th>
                                        <th>اسم المخزن</th>
                                        <th> نوع العمليه </th>
                                        <th>الكمية </th>
                                        <th>الرصيد </th>
                                        <th>العميل </th>
                                        <th>المورد </th>
                                        <th>رقم الهاتف </th>

                                        {{-- <th>@lang('lang.action')</th>  --}}
                                    </tr>
                                </thead>

                                <tbody>
                                    {{--     @foreach ($all_products as $index => $product)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td title="اسم المنتج">{{$product->name}}</td>

                                            @php
                                                // ++++++++++++++++++++ sell_price_var ++++++++++++++++++++
                                                $sell_price_var = 0;
                                                $sell_price_var = 0;
                                                // ++++++++++++++++++++ sell_quantity_var ++++++++++++++++++++
                                                $sell_quantity = 0;
                                                // ++++++++++++++++++++ sell_store_var ++++++++++++++++++++
                                                $sell_store = 0;
                                                foreach ($product->sell_lines as $key => $sellLine)
                                                {
                                                    // =========== sell_quantity ===========
                                                    $sell_quantity = $sell_quantity + ($sellLine->quantity - $sellLine->quantity_returned);
                                                    // =========== sell_price ===========
                                                    if (!empty($sellLine->sell_price))
                                                    {
                                                        $sell_price_var = $sell_price_var + $sellLine->sell_price;
                                                    }
                                                    else
                                                    {
                                                        $sell_price_var = $sell_price_var + ($sellLine->dollar_sell_price * $sellLine->exchange_rate);
                                                    }
                                                    // =========== store ===========
                                                    foreach ($product->stock_lines as $key => $stock_line)
                                                    {
                                                        $sell_store = ($stock_line->quantity - $stock_line->quantity_sold ) + ( $stock_line->quantity_returned );
                                                    }
                                                }
                                             @endphp
                                            {{-- ++++++++++ مبلغ المبيعات ++++++++++ --}}
                                    {{-- <td title="مبلغ المبيعات"> {{ number_format($sell_price_var,num_of_digital_numbers()) }}</td>
                                            {{-- ++++++++++ الكمية المباعة +++++++++ --}}
                                    {{-- <td title="الكمية المباعة"> {{ $sell_quantity }} </td> --}}
                                    {{-- ++++++++++ في المخزن ++++++++++ --}}
                                    {{-- <td title="في المخزن">{{ $sell_store }}</td> --}}
                                    {{-- @foreach ($product->stock_lines as $stockLine)
                                                {{-- ++++++++++ مبلغ المشتريات ++++++++++ --}}
                                    {{-- <td>
                                                    @if (!empty($stockLine->purchase_price))
                                                        @php
                                                            $purchase_price_var = $purchase_price_var + $stockLine->purchase_price;
                                                        @endphp
                                                        {{  number_format( $purchase_price_var , num_of_digital_numbers() ) }}
                                                    @elseif( !empty($stockLine->dollar_purchase_price) )
                                                        @php
                                                            $last_exchange_rate = $stockLine->transaction->transaction_payments->last()->exchange_rate;
                                                            $purchase_price_var = $purchase_price_var + $stockLine->dollar_purchase_price * $last_exchange_rate;
                                                        @endphp
                                                        {{  number_format( ( $purchase_price_var ) , num_of_digital_numbers() ) }}
                                                    @endif
                                                </td> --}}
                                    {{-- ++++++++++ الكمية المشتراة++++++++++ --}}
                                    {{-- <td>
                                                    {{ number_format($stockLine->quantity,num_of_digital_numbers()) }}
                                                </td> --}}
                                    {{-- ++++++++++ في المخزن ++++++++++ --}}
                                    {{-- <td>
                                                    {{ number_format( ( $stockLine->quantity - $stockLine->quantity_sold ) + ( $stockLine->quantity_returned ) , num_of_digital_numbers()) }}
                                                </td> --}}
                                    {{-- @endforeach  --}}
                                    {{-- ++++++++++++++++++++++++++ Actions +++++++++++++++++++ --}}
                                    {{-- <td>
                                                <div class="btn-group">
                                                    <div class="bn-group">
                                                        <a href="{{ route('invoices.show', $product->id) }}" title="{{ __('Show') }}"
                                                            class=" btn btn-info btn-sm text-white mx-1">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm " data-toggle="modal" title="{{ __('Delete') }}"
                                                            data-target="#delete{{ $product->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal fade" id="delete{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">{{ __('site.Delete_an_invoice?') }}</h5>
                                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {{ __('site.Are_you_sure_to_delete_an_invoice?') }}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('site.Close') }}</button>
                                                                    <button click='delete({{ $product->id }})' type="button" class="btn btn-primary" data-dismiss="modal">{{ __('site.yes') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td> --}}
                                    </tr>
                                    {{-- @include('products.edit',$product) --}}
                                    {{-- @endforeach --}}


                                </tbody>
                            </table>
                            {{-- @endif --}}
                            <div class="view_modal no-print">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection
