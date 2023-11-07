@extends('layouts.app')
@section('title', __('lang.create_purchase_order'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.create_purchase_order')</h4> <br />
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            {{-- <li class="breadcrumb-item"><a href="{{route('purchase_order.index')}}">@lang('lang.purchase_order')</a></li> --}}
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.create_purchase_order')</li>
                        </ul>
                    </div>
                </div>
                {{-- +++++++ "show_purchase_order" button +++++++ --}}
                <div
                    class="col-md-4  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <div class="widgetbar">
                        <a href="{{ route('purchase_order.index') }}" class="btn btn-primary">
                            @lang('lang.show_purchase_order')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('content')
    <livewire:purchase-order.create />
@endsection

{{-- @section('javascript')
    <script src="{{asset('js/purchase.js')}}"></script>
    <script type="text/javascript">
        // ++++++++++++++ Function 1 : calculateSubTotal() : Function to calculate the sub-total ++++++++++++++
        // function calculateSubTotal()
        // {
        //     var row = $(this).closest('tr');
        //     var quantity = parseFloat(row.find('.quantity').val());
        //     var purchasePrice = parseFloat(row.find('.purchase_price').val());
        //     var purchasePriceDollar = parseFloat(row.find('.purchase_price_dollar').val());
        //     var subTotal;
        //     if (purchasePrice == 0) {
        //         subTotal = (quantity * purchasePriceDollar).toFixed(4);
        //         console.log("purchasePriceDollar = ",purchasePriceDollar);
        //     } else {
        //         subTotal = (quantity * purchasePrice).toFixed(4);
        //     }
        //     row.find('.sub_total').val(subTotal);
        //     // Calculate the total subtotal after updating the sub_total for this row
        //     calculateTotal();
        // }
        // ++++++++++++++ Function 2 : deleteRow() : Function to delete row from table when click on "delete button" ++++++++++++++
        // function deleteRow(button)
        // {
        //     // Get the row containing the button
        //     var row = button.parentNode.parentNode;
        //     // Get the subTotal value of the row being deleted
        //     var subTotal = parseFloat(row.querySelector('.sub_total').value);
        //     // Remove the row from the table
        //     row.parentNode.removeChild(row);

        //     // Subtract the deleted row's subTotal from the total subtotal
        //     updateTotalSubtotal(-subTotal);
        // }
        // ++++++++++++++ Function 3 : calculateTotal() : Function to calculate the sum of sub_total rows ++++++++++++++
        // function calculateTotal()
        // {
        //     var total = 0;

        //     // Iterate through each row and add up the sub_total values
        //     $('.sub_total').each(function () {
        //         var subTotal = parseFloat($(this).val());
        //         if (!isNaN(subTotal)) {
        //             total += subTotal;
        //         }
        //     });

        //     // Update the total display element
        //     $('#total_subtotal').text(total.toFixed(4));
        //     // update "hidden inputField" of "total"
        //     $('#total_subtotal_input').val(total.toFixed(4));
        // }
        // +++++++++++++++++ updateTotalSubtotal() : to update the total subtotal when delete row +++++++++++++++++
        // function updateTotalSubtotal(subTotalChange)
        // {
        //     var totalSubtotalElement = $('#total_subtotal');
        //     var totalSubtotalInput = $('#total_subtotal_input');
        //     var currentTotal = parseFloat(totalSubtotalElement.text());

        //     // Subtract the subTotalChange from the current total
        //     var newTotal = currentTotal + subTotalChange;
        //     totalSubtotalElement.text(newTotal.toFixed(4));
        //     totalSubtotalInput.val(newTotal.toFixed(4));
        // }
        // ++++++++++++++++ Create Table Of "Orders" ++++++++++++++++
        // $(function() {
        //     // Call the calculateTotal function when the page loads and whenever sub_total values change
        //     calculateTotal();

        //     $('.sub_total').on('input', calculateTotal);

        //     // when click on "all checkboxs" , it will select all checkboxes
        //     $('#select_all_ids').click(function() {
        //         $('.checkbox_ids').prop('checked', $(this).prop('checked'));
        //     });
        //     // Get All "checked" checkboxes
        //     $('#deleteAllSelectedRecord').click(function(e) {
        //         e.preventDefault();
        //         var all_ids = [];
        //         $('input:checkbox[name=ids]:checked').each(function() {
        //             all_ids.push($(this).val());
        //         });
        //         $.ajax({
        //             url: "{{ route('product.delete') }}",
        //             type: "GET",
        //             data: {
        //                 ids: all_ids,
        //                 _tokens: "{{ csrf_token() }}",
        //             },
        //             success: function(response) {
        //                 console.log(response);
        //                 $.each(response, function(key, val) {
        //                     var currencySign = '';
        //                     console.log("we are outSide if condition");

        //                     // Check if val.stock_lines is defined and not empty
        //                     if (val.stock_lines && val.stock_lines.length > 0)
        //                     {
        //                         // lastDollarPurchasePrice
        //                         var lastDollarPurchasePrice = val.stock_lines[val.stock_lines.length - 1].dollar_purchase_price;
        //                         // lastDinarPurchasePrice
        //                         var lastDinarPurchasePrice = val.stock_lines[val.stock_lines.length - 1].purchase_price;
        //                         var lastPurchasePrice = 0.0000;

        //                         // Check if lastDollarPurchasePrice is defined and not null
        //                         if (typeof lastDollarPurchasePrice !== 'undefined' && lastDollarPurchasePrice !== null)
        //                         {
        //                             lastPurchasePrice = lastDollarPurchasePrice;
        //                             lastDinarPurchasePrice = 0.0000 ;
        //                             currencySign = "dollar";
        //                         }
        //                         // Check if lastDinarPurchasePrice is defined and not null
        //                         else if (typeof lastDinarPurchasePrice !== 'undefined' && lastDinarPurchasePrice !== null)
        //                         {
        //                             lastPurchasePrice = lastDinarPurchasePrice;
        //                             lastDollarPurchasePrice = 0.0000 ;
        //                             currencySign = "dinar";
        //                         }
        //                         else
        //                         {
        //                             lastPurchasePrice = 0.0000;
        //                             lastDollarPurchasePrice = 0.0000; // Set to 0.0000 when both are null
        //                         }
        //                     }
        //                     else
        //                     {
        //                         lastDollarPurchasePrice = 0.0000;
        //                         // lastDinarPurchasePrice
        //                         lastDinarPurchasePrice = 0.0000;
        //                         lastPurchasePrice = 0.0000;
        //                     }
        //                     console.log("we are inside if condition");
        //                     // +++++++++++++++++++++ all products +++++++++++++++++++++
        //                     var output = `
        //                             <tr>
        //                                 <td name='id'>
        //                                     ${val.id}
        //                                     <input type="hidden" name="product_id[]" value="${val.id}" id="product_id${val.id}" />
        //                                 </td>
        //                                 <td name='name'>${val.name}</td>
        //                                 <td name='sku'>${val.sku}</td>
        //                                 <td>
        //                                     <input class="quantity form-control" type='text' name='quantity[]' class="form-control" value="0" />
        //                                 </td>
        //                                 <td>
        //                                     <input type='text' class="purchase_price form-control" name='purchase_price[]' value="${lastDinarPurchasePrice}" readonly />
        //                                 </td>
        //                                 <td>
        //                                     <input type='text' class="purchase_price_dollar form-control" name='purchase_price_dollar[]' value="${lastDollarPurchasePrice}" readonly />
        //                                 </td>
        //                                 <td>
        //                                     <input type='text' class="form-control sub_total" name='sub_total[]' value="0" readonly />
        //                                 </td>
        //                                 <td name='currencySign[]'>${currencySign}</td>
        //                                 <td>
        //                                     <button class="btn btn-danger" onclick="deleteRow(this)">Delete</button>
        //                                 </td>
        //                             </tr>

        //                         `;

        //                     $('#search_list').append(output);
        //                 });

        //                 // Bind the calculateSubTotal function to the input fields
        //                 $('.quantity').on('input', calculateSubTotal);
        //                 $('.purchase_price').on('input', calculateSubTotal);
        //                 $('.sub_total').click(calculateSubTotal);
        //             }
        //         });
        //     });
        // });

    </script>
@endsection --}}
