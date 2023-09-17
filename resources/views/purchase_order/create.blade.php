@extends('layouts.app')
@section('title', __('lang.create_purchase_order'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.create_purchase_order')</h4> <br/>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('products.index')}}">@lang('lang.purchase_order')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.create_purchase_order')</li>
                    </ol>
                </div>
                <br/>
            </div>
        </div>
    </div>
@endsection
@section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('purchase_order.store') }}" method='post' id='purchase_order_form'>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                {{-- ////////////////// store selectbox : المخزن  ////////////////// --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('store_id', __('lang.store'). ':*', []) !!}
                                        {!! Form::select('store_id', $stores,
                                        session('user.store_id'), ['class' => 'selectpicker form-control',
                                        'data-live-search'=>"true",
                                        'required',
                                        'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                                    </div>
                                </div>
                                {{-- ////////////////// supplier selectbox : المورد  ////////////////// --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('supplier_id', __('lang.supplier'). ':*', []) !!}
                                        {!! Form::select('supplier_id', $suppliers,
                                        null, ['class' => 'selectpicker form-control',
                                        'data-live-search'=>"true", 'required',
                                        'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                                    </div>
                                </div>
                                {{-- ////////////////// product_number inputField : رقم طلب الشراء  ////////////////// --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('po_no', __('lang.po_no'). ':*', []) !!}
                                        {!! Form::text('po_no', $po_no, ['class' => 'form-control','required', 'readonly',
                                        'placeholder' => __('lang.po_no')]) !!}
                                    </div>
                                </div>

                            </div>
                            <br>
                            <br>
                            {{-- ////////////////// search inputField ////////////////// --}}
                            <div class="row">
                                <div class="col-md-8 offset-md-10">
                                    <div class="search-box input-group">
                                        {{-- search icon --}}
                                        {{-- <button type="button" class="btn btn-secondary btn-lg" id="search_button">
                                            <i class="fa fa-search"></i>
                                        </button> --}}
                                        {{-- search inputField --}}
                                        {{-- <input type="text" name="search_product" id="search"
                                            placeholder="@lang('lang.enter_product_name_to_print_labels')"
                                            class="form-control ui-autocomplete-input" autocomplete="off"> --}}
                                        {{-- create product --}}
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#select_products_modal"> <i class="fa fa-plus"></i>
                                            @lang('lang.select_products')
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="modal fade" id="select_products_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                                aria-hidden="true" style="width: 100%;">
                                <div class="modal-dialog modal-lg" role="document" id="select_products_modal">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h4 class="modal-title">@lang( 'lang.select_products' )</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table id="product_selection_table" class="table" style="width: auto">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <input type="checkbox"  id="select_all_ids"/>
                                                        </th>
                                                        <th>@lang('lang.product_name')</th>
                                                        <th>@lang('lang.sku')</th>
                                                        <th>@lang('lang.category')</th>
                                                        <th>@lang('lang.subcategories_name')</th>
                                                        <th>@lang('lang.height')</th>
                                                        <th>@lang('lang.length')</th>
                                                        <th>@lang('lang.width')</th>
                                                        <th>@lang('lang.size')</th>
                                                        <th>@lang('lang.unit')</th>
                                                        <th>@lang('lang.weight')</th>
                                                        <th>@lang('lang.stores')</th>
                                                        <th>@lang('lang.brand')</th>
                                                        <th>@lang('lang.discount')</th>
                                                        <th>@lang('added_by')</th>
                                                        <th>@lang('updated_by')</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($products as $index=>$product)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="ids" class="checkbox_ids" value="{{$product->id}}" />
                                                            </td>
                                                            <td>{{$product->name}}</td>
                                                            <td>{{$product->sku}}</td>
                                                            <td>{{$product->category->name}}</td>
                                                            <td>
                                                                @foreach($product->subcategories as $subcategory)
                                                                    {{$subcategory->name}}<br>
                                                                @endforeach
                                                            </td>
                                                            <td>{{$product->height}}</td>
                                                            <td>{{$product->length}}</td>
                                                            <td>{{$product->width}}</td>
                                                            <td><span class="text-primary">{{$product->size}}</span></td>
                                                            <td>{{!empty($product->unit)?$product->unit->name:''}}</td>
                                                            <td>{{$product->weight}}</td>
                                                            <td>
                                                                @foreach($product->stores as $store)
                                                                    {{$store->name}}<br>
                                                                @endforeach
                                                            </td>
                                                            <td>{{!empty($product->brand)?$product->brand->name:''}}</td>
                                                            <td>
                                                                @foreach($product->product_prices as $price)
                                                                    {{$price->price_category." : ".$price->price}} <br>
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @if ($product->created_by  > 0 and $product->created_by != null)
                                                                    {{ $product->created_at->diffForHumans() }} <br>
                                                                    {{ $product->created_at->format('Y-m-d') }}
                                                                    ({{ $product->created_at->format('h:i') }})
                                                                    {{ ($product->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                                    {{ $product->createBy?->name }}
                                                                @else
                                                                    {{ __('no_update') }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($product->edited_by  > 0 and $product->edited_by != null)
                                                                    {{ $product->updated_at->diffForHumans() }} <br>
                                                                    {{ $product->updated_at->format('Y-m-d') }}
                                                                    ({{ $product->updated_at->format('h:i') }})
                                                                    {{ ($product->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                                    {{ $product->updateBy?->name }}
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

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" id="deleteAllSelectedRecord"  data-dismiss="modal" click="fetchSelectedProducts()">Add All Selected</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'lang.close' )</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table" style="width: auto" >
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">#</th>
                                                <th style="width: 15%">@lang('lang.product_name')</th>
                                                <th style="width: 10%" >@lang('lang.sku')</th>
                                                <th style="width: 10%">@lang('lang.quantity')</th>
                                                <th style="width: 10%">@lang('lang.purchase_price') (@lang('lang.per_piece')) </th>
                                                <th style="width: 15%">@lang('lang.purchase_price_dollar') (@lang('lang.per_piece')) </th>
                                                <th style="width: 10%">@lang('lang.sub_total')</th>
                                                <th style="width: 10%">@lang('lang.currency')</th>
                                                <th style="width: 10%">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody id="search_list">


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- ++++++++++++++++++++++++ final_total inputField ++++++++++++++++++++++++ --}}
                            <div class="col-md-12">
                                <div class="col-md-3 offset-md-8 text-right">
                                    <h3> @lang('lang.total'):
                                        <span class="final_total_span" id="total_subtotal"></span>
                                        <input type="hidden" name="total_subtotal" id="total_subtotal_input" value="0">

                                    </h3>
                                </div>
                            </div>
                            <br>
                            {{-- ++++++++++++++++++++++++ details textarea ++++++++++++++++++++++++ --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('details', __('lang.details'), []) !!}
                                        {!! Form::textarea('details', null, ['class' => 'form-control', 'rows' => 3]) !!}
                                    </div>
                                </div>
                            </div>

                            <button type="submit" name="submit" id="print" style="margin: 10px" value="print"
                                    class="btn btn-primary pull-right btn-flat submit"> @lang('lang.save' )
                            </button>
                        </div>
                    </form>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


</section>
@endsection

@section('javascript')
    <script src="{{asset('js/purchase.js')}}"></script>
    <script type="text/javascript">
        // ++++++++++++++ Function 1 : calculateSubTotal() : Function to calculate the sub-total ++++++++++++++
        function calculateSubTotal()
        {
            var row = $(this).closest('tr');
            var quantity = parseFloat(row.find('.quantity').val());
            var purchasePrice = parseFloat(row.find('.purchase_price').val());
            var purchasePriceDollar = parseFloat(row.find('.purchase_price_dollar').val());

            var subTotal;

            if (purchasePrice == 0) {
                subTotal = (quantity * purchasePriceDollar).toFixed(4);
                console.log("purchasePriceDollar = ",purchasePriceDollar);

            } else {
                subTotal = (quantity * purchasePrice).toFixed(4);
            }

            row.find('.sub_total').val(subTotal);
            // Calculate the total subtotal after updating the sub_total for this row
            calculateTotal();
        }
        // ++++++++++++++ Function 2 : deleteRow() : Function to delete row from table when click on "delete button" ++++++++++++++
        function deleteRow(button)
        {
            // Get the row containing the button
            var row = button.parentNode.parentNode;
            // Get the subTotal value of the row being deleted
            var subTotal = parseFloat(row.querySelector('.sub_total').value);
            // Remove the row from the table
            row.parentNode.removeChild(row);

            // Subtract the deleted row's subTotal from the total subtotal
            updateTotalSubtotal(-subTotal);
        }
        // ++++++++++++++ Function 3 : calculateTotal() : Function to calculate the sum of sub_total rows ++++++++++++++
        function calculateTotal()
        {
            var total = 0;

            // Iterate through each row and add up the sub_total values
            $('.sub_total').each(function () {
                var subTotal = parseFloat($(this).val());
                if (!isNaN(subTotal)) {
                    total += subTotal;
                }
            });

            // Update the total display element
            $('#total_subtotal').text(total.toFixed(4));
            // update "hidden inputField" of "total"
            $('#total_subtotal_input').val(total.toFixed(4));
        }
        // +++++++++++++++++ updateTotalSubtotal() : to update the total subtotal when delete row +++++++++++++++++
        function updateTotalSubtotal(subTotalChange)
        {
            var totalSubtotalElement = $('#total_subtotal');
            var totalSubtotalInput = $('#total_subtotal_input');
            var currentTotal = parseFloat(totalSubtotalElement.text());

            // Subtract the subTotalChange from the current total
            var newTotal = currentTotal + subTotalChange;
            totalSubtotalElement.text(newTotal.toFixed(4));
            totalSubtotalInput.val(newTotal.toFixed(4));
        }
        // ++++++++++++++++ Create Table Of "Orders" ++++++++++++++++
        $(function() {
            // Call the calculateTotal function when the page loads and whenever sub_total values change
            calculateTotal();

            $('.sub_total').on('input', calculateTotal);

            // when click on "all checkboxs" , it will select all checkboxes
            $('#select_all_ids').click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'));
            });
            // Get All "checked" checkboxes
            $('#deleteAllSelectedRecord').click(function(e) {
                e.preventDefault();
                var all_ids = [];
                $('input:checkbox[name=ids]:checked').each(function() {
                    all_ids.push($(this).val());
                });
                $.ajax({
                    url: "{{ route('product.delete') }}",
                    type: "GET",
                    data: {
                        ids: all_ids,
                        _tokens: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        console.log(response);
                        $.each(response, function(key, val) {
                            var currencySign = '';

                            // Check if val.stock_lines is defined and not empty
                            if (val.stock_lines && val.stock_lines.length > 0)
                            {
                                // lastDollarPurchasePrice
                                var lastDollarPurchasePrice = val.stock_lines[val.stock_lines.length - 1].dollar_purchase_price;
                                // lastDinarPurchasePrice
                                var lastDinarPurchasePrice = val.stock_lines[val.stock_lines.length - 1].purchase_price;
                                var lastPurchasePrice = 0.0000;

                                // Check if lastDollarPurchasePrice is defined and not null
                                if (typeof lastDollarPurchasePrice !== 'undefined' && lastDollarPurchasePrice !== null)
                                {
                                    lastPurchasePrice = lastDollarPurchasePrice;
                                    lastDinarPurchasePrice = 0.0000 ;
                                    currencySign = "dollar";
                                }
                                // Check if lastDinarPurchasePrice is defined and not null
                                else if (typeof lastDinarPurchasePrice !== 'undefined' && lastDinarPurchasePrice !== null)
                                {
                                    lastPurchasePrice = lastDinarPurchasePrice;
                                    lastDollarPurchasePrice = 0.0000 ;
                                    currencySign = "dinar";
                                }
                                else
                                {
                                    lastPurchasePrice = 0.0000;
                                    lastDollarPurchasePrice = 0.0000; // Set to 0.0000 when both are null
                                }

                                var output = `
                                        <tr>
                                            <td name='id'>
                                                ${val.id}
                                                <input type="hidden" name="product_id[]" value="${val.id}" id="product_id${val.id}" />
                                            </td>
                                            <td name='name'>${val.name}</td>
                                            <td name='sku'>${val.sku}</td>
                                            <td>
                                                <input class="quantity form-control" type='text' name='quantity[]' class="form-control" value="0" />
                                            </td>
                                            <td>
                                                <input type='text' class="purchase_price form-control" name='purchase_price[]' value="${lastDinarPurchasePrice}" readonly />
                                            </td>
                                            <td>
                                                <input type='text' class="purchase_price_dollar form-control" name='purchase_price_dollar[]' value="${lastDollarPurchasePrice}" readonly />
                                            </td>
                                            <td>
                                                <input type='text' class="form-control sub_total" name='sub_total[]' value="0" readonly />
                                            </td>
                                            <td name='currencySign[]'>${currencySign}</td>
                                            <td>
                                                <button class="btn btn-danger" onclick="deleteRow(this)">Delete</button>
                                            </td>
                                        </tr>

                                    `;

                                $('#search_list').append(output);
                            }
                        });

                        // Bind the calculateSubTotal function to the input fields
                        $('.quantity').on('input', calculateSubTotal);
                        $('.purchase_price').on('input', calculateSubTotal);
                        $('.sub_total').click(calculateSubTotal);
                    }
                });
            });
        });

    </script>
@endsection
