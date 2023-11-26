@extends('layouts.app')
@section('title', __('lang.product_damage'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title"></h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('products.index')}}">@lang('lang.products')</a></li>
                    </ol>
                </div>
            </div>
{{--            <div class="col-md-4 col-lg-4">--}}
{{--                <div class="widgetbar">--}}
{{--                    <a type="button" class="btn btn-primary" href="{{route('getDamageProduct',["id"=> $id ])}}">@lang('lang.remove_damage')</a>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
@endsection
@section('content')
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        {{--                    <h5 class="card-title">@lang('lang.product_damage')</h5>--}}
                    </div>
                    {{-- {{$id}} --}}
                    @livewire('product-options.remove-expiry', ['productId' => $id])
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>

@endsection

@push('javascripts')
<script>
// $(document).on('click', '.check_pass', function(e) {
//     e.preventDefault();
//     swal.fire({
//         title: 'Are you sure?',
//         text: "@lang('lang.adjustment_save')",
//         icon: 'warning',
//     }).then(willDelete => {
//         if (willDelete) {
//             // var check_password = $(this).data('check_password');
//             // var href = $(this).data('href');
//             var data = $(this).serialize();
//             swal.fire({
//                 title: "{!! __('lang.please_enter_your_password') !!}",
//                 input: 'password',
//                 inputAttributes: {
//                     placeholder: "{!! __('lang.type_your_password') !!}",
//                     autocomplete: 'off',
//                     autofocus: true,
//                 },
//             }).then((result) => {
//                 if (result) {
//                     $.ajax({
//                         url: "{{ route('check_password') }}",
//                         method: 'POST',
//                         data: {
//                             value: result
//                         },
//                         dataType: 'json',
//                         success: (data) => {
//                             if (data.success == true) {
//                                  sendData();
//                             } else {
//                                 swal(
//                                     'Failed!',
//                                     'Wrong Password!',
//                                     'error'
//                                 )
//                             }
//                         }
//                     });
//                 }
//             });
//         }
//     });
// });
// function sendData() {
//             // Get the table instance
//             var table = $('#product_table').DataTable();
//             // Initialize an empty array to store the selected data
//             var selectedData = [];
//             var total_shortage_value = document.getElementById('total_shortage_value').value;
//             // Loop through each row in the table
//             table.rows().every(function() {
//                 var rowData = this.row().data();
//                 var quantity_to_be_removed = $('input[name="quantity_to_be_removed"]', this.node()).val();
//                 var expired_current_stock = $('span[name="expired_current_stock"]', this.node()).text();
//                 var date_of_purchase_of_the_expired_stock_removed = $('span[name="date_of_purchase_of_the_expired_stock_removed"]', this.node()).text();
//                 var value_of_removed_stock = $('.value_of_removed_stock', this.node()).text();
//                 var id = $('span[name="product_id"]', this.node()).text();
//                 var variation_id = $('span[name="variation_id"]', this.node()).text();

//                 // Check if actualStock has a value
//                 if (quantity_to_be_removed !== '') {
//                     // Add the required data to the selectedData array
//                     var dataObj = {
//                         id: id,
//                         variation_id : variation_id,
//                         status : "expiry",
//                         expired_current_stock: expired_current_stock,
//                         quantity_to_be_removed: quantity_to_be_removed,
//                         value_of_removed_stocks: value_of_removed_stock,
//                         date_of_purchase_of_expired_stock_removed: date_of_purchase_of_the_expired_stock_removed,
//                     };
//                     selectedData.push(dataObj);
//                 }
//             });
//             // Send the data to the server
//             $.ajax({
//                 type: 'POST',
//                 url: '/product/convolutions/storeStockRemoved',
//                 data: {
//                     selected_data: selectedData,
//                     total_shortage_value: total_shortage_value
//                 },
//                 success: function(response) {
//                     swal(
//                         'Success',
//                         'Operation added successfully!',
//                         'success'
//                     );
//                     location.reload();
//                 },
//                 error: function(xhr, status, error) {
//                     swal(
//                         'Error',
//                         'Something went Error',
//                         'error'
//                     );
//                 }
//             });
//         }
// </script>
@endpush


