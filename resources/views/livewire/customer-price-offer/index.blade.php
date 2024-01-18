 {{-- +++++++++++++++ Style : checkboxes and labels inside selectbox +++++++++++++++ --}}
 <style>
     .selectBox {
         position: relative;
     }

     /* selectbox style */
     .selectBox select {
         width: 100%;
         padding: 0 !important;
         padding-left: 4px;
         padding-right: 4px;
         color: #000;
         border: 1px solid #ccc;
         background-color: #dedede;
         /* height: 39px !important; */
     }

     .overSelect {
         position: absolute;
         left: 0;
         right: 0;
         top: 0;
         bottom: 0;
     }

     #checkboxes {
         display: none;
         border: 1px #dadada solid;
         height: 125px;
         overflow: auto;
         padding-top: 10px;
         /* text-align: end;  */
     }

     #checkboxes label {
         display: block;
         padding: 5px;
     }

     #checkboxes label:hover {
         background-color: #ddd;
     }

     #checkboxes label span {
         font-weight: normal;
     }
 </style>
 <div class="contentbar">
     <div class="row">
         <div class="col-lg-12">
             <div class="card m-b-30">

                 {{-- ++++++++++++++++++++++++++++++ Filters +++++++++++++++++++++++ --}}
                 <div class="col-md-12 no-print">
                     <div class="card">
                         <div class="card-body">
                             <form action="">
                                 <div
                                     class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                     {{-- +++++++++++++++ store filter +++++++++++++++ --}}
                                     <div
                                         class="col-6 col-lg-2 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                         {!! Form::label('store_id', __('lang.store'), [
                                             'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-fit' : 'h5  mx-2 mb-0 width-fit',
                                             'style' => 'font-size: 12px;font-weight: 500;',
                                         ]) !!}
                                         <div class="input-wrapper">
                                             {!! Form::select('store_id', $stores, request()->store_id, [
                                                 'class' => 'form-control width-full',
                                                 'style' => 'height:100%',
                                                 'wire:model' => 'store_id',
                                                 'placeholder' => __('lang.please_select'),
                                                 'data-live-search' => 'true',
                                             ]) !!}
                                         </div>
                                     </div>
                                     {{-- ++++++++++++++++++++++ customer filter ++++++++++++++++++++++ --}}
                                     <div class="col-6 col-lg-2 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                         wire:ignore>
                                         <label
                                             class="mx-2 mb-0 width-fit @if (app()->isLocale('ar')) d-block text-end @endif"
                                             for="customer_id">@lang('lang.customers')</label>
                                         <div class="input-wrapper">
                                             <select class="form-control client width-full" style="height: 100%"
                                                 wire:model="customer_id" id="Client_Select">
                                                 <option value="0 " readonly selected>
                                                     {{ __('lang.please_select') }}
                                                 </option>
                                                 @foreach ($customers as $customer)
                                                     <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                     {{-- +++++++++++++++ start_date filter +++++++++++++++ --}}
                                     <div
                                         class="col-6 col-lg-2 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                         <label for=""
                                             class="mx-2 mb-0 width-fit @if (app()->isLocale('ar')) d-block text-end @endif">{{ __('site.From') }}</label>
                                         <input type="date" class="form-control initial-balance-input mx-3 mx-lg-0"
                                             wire:model="from">

                                     </div>
                                     {{-- +++++++++++++++ end_date filter +++++++++++++++ --}}
                                     <div
                                         class="col-6 col-lg-2 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                         <label
                                             class="mx-2 mb-0 width-fit small-label @if (app()->isLocale('ar')) d-block text-end @endif"
                                             for="">{{ __('site.To') }}</label>
                                         <input type="date" class="form-control initial-balance-input mx-3 mx-lg-0"
                                             wire:model="to">

                                     </div>
                                     {{-- +++++++++++++++ clear_filter Button +++++++++++++++ --}}
                                     <div
                                         class="col-6 col-lg-2 d-flex align-items-center justify-content-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                         <a href="{{ route('customer_price_offer.index') }}"
                                             class="btn btn-danger">@lang('lang.clear_filters')</a>
                                     </div>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
                 {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                 <div class="col-md-3" style="position: relative;z-index: 9;margin-top: 20px">
                     <div class="multiselect col-md-6">
                         <div class="selectBox" onclick="showCheckboxes()">
                             <select class="form-select">
                                 <option>@lang('lang.show_hide_columns')</option>
                             </select>
                             <div class="overSelect"></div>
                         </div>
                         <div id="checkboxes">
                             {{-- +++++++++++++++++ checkbox1 : id +++++++++++++++++ --}}
                             <label for="col1_id">
                                 <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                 <span>#</span> &nbsp;
                             </label>
                             {{-- +++++++++++++++++ checkbox2 : date +++++++++++++++++ --}}
                             <label for="col2_id">
                                 <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                 <span>@lang('lang.date')</span>
                             </label>
                             {{-- +++++++++++++++++ checkbox3 : created_by +++++++++++++++++ --}}
                             <label for="col3_id">
                                 <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                 <span>@lang('lang.created_by')</span>
                             </label>
                             {{-- +++++++++++++++++ checkbox4 : customer +++++++++++++++++ --}}
                             <label for="col4_id">
                                 <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                 <span>@lang('lang.customer')</span>
                             </label>
                             {{-- +++++++++++++++++ checkbox5 : store +++++++++++++++++ --}}
                             <label for="col5_id">
                                 <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                 <span>@lang('lang.store')</span>
                             </label>
                             {{-- +++++++++++++++++ checkbox6 : customer_offer_status +++++++++++++++++ --}}
                             <label for="col6_id">
                                 <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                 <span>@lang('lang.customer_offer_status')</span>
                             </label>
                             {{-- +++++++++++++++++ checkbox7 : quotation_status +++++++++++++++++ --}}
                             <label for="col7_id">
                                 <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                 <span>@lang('lang.quotation_status')</span>
                             </label>
                             {{-- +++++++++++++++++ checkbox8 : quotation_status +++++++++++++++++ --}}
                             <label for="col8_id">
                                 <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                 <span>@lang('lang.action')</span>
                             </label>
                         </div>
                     </div>
                 </div>
                 {{-- ++++++++++++++++++++++++++++++ Table +++++++++++++++++++++++ --}}
                 <div class="card-body">
                     @if (@isset($customer_offer_prices) && !@empty($customer_offer_prices) && count($customer_offer_prices) > 0)
                         <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                             <table class="table table-striped table-bordered table-hover">
                                 <thead>
                                     <tr>
                                         <th class="col1">#</th>
                                         <th class="col2">@lang('lang.date')</th>
                                         {{-- <th class="col1">@lang('lang.reference')</th> --}}
                                         <th class="col3">@lang('lang.created_by')</th>
                                         <th class="col4">@lang('lang.customer')</th>
                                         <th class="col5">@lang('lang.store')</th>
                                         <th class="col6">@lang('lang.customer_offer_status')</th>
                                         <th class="col7">@lang('lang.quotation_status')</th>
                                         <th class="notexport col8">@lang('lang.action')</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($customer_offer_prices as $index => $offer)
                                         <tr>
                                             <td class="col1">{{ $index + 1 }}</td>
                                             <td class="col2">
                                                 <span style="font-size: 12px;font-weight: 600;">
                                                     {{ @format_date($offer->created_at) }}
                                                 </span>
                                             </td>
                                             <td class="col3">
                                                 <span style="font-size: 12px;font-weight: 600;">

                                                     {{ ucfirst($offer->created_by_user->name ?? '') }}
                                                 </span>
                                             </td>
                                             <td class="col4">
                                                 <span style="font-size: 12px;font-weight: 600;">

                                                     @if (!empty($offer->customer))
                                                         {{ $offer->customer->name }}
                                                     @endif
                                                 </span>
                                             </td>
                                             <td class="col5">
                                                 <span style="font-size: 12px;font-weight: 600;">

                                                     {{ ucfirst($offer->store->name ?? '') }}
                                                 </span>
                                             </td>
                                             <td class="col6">
                                                 <span style="font-size: 12px;font-weight: 600;">

                                                     @if (!empty($offer->block_qty))
                                                         @lang('lang.blocked')
                                                     @else
                                                         @lang('lang.not_blocked')
                                                     @endif
                                                 </span>
                                             </td>
                                             <td class="col7">
                                                 <span style="font-size: 12px;font-weight: 600;">

                                                     {{ ucfirst($offer->status) }}
                                                 </span>
                                             </td>
                                             <td class="col8">

                                                 <div class="btn-group">
                                                     <button type="button" style="font-size: 12px;font-weight: 600;"
                                                         class="btn btn-default btn-sm dropdown-toggle"
                                                         data-toggle="dropdown" aria-haspopup="true"
                                                         aria-expanded="false">خيارات
                                                         <span class="caret"></span>
                                                         <span class="sr-only">Toggle Dropdown</span>
                                                     </button>
                                                     <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                         user="menu" x-placement="bottom-end"
                                                         style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                         {{-- ++++++++++++++ edit button ++++++++++++++ --}}
                                                         <li>
                                                             <a href="{{ route('customer_price_offer.edit', $offer->id) }}"
                                                                 class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                     class="dripicons-document-edit"></i>
                                                                 @lang('lang.edit')</a>
                                                         </li>
                                                         {{-- ++++++++++++++ create_invoice button ++++++++++++++ --}}
                                                         <li>
                                                             <a href="{{ route('invoices.edit', $offer->id) }}"
                                                                 class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                                 <i class="dripicons-document-edit"></i>
                                                                 @lang('lang.create_invoice')
                                                             </a>
                                                         </li>

                                                         {{-- ++++++++++++++ delete button ++++++++++++++ --}}
                                                         <form method="POST"
                                                             action="{{ route('customer_price_offer.destroy', $offer->id) }}">
                                                             @csrf
                                                             @method('DELETE')
                                                             <button type="submit"
                                                                 class="btn width-full drop_down_item
                                                                 text-red">
                                                                 @lang('lang.delete') <i class="fa fa-trash"></i>
                                                             </button>
                                                         </form>
                                                         </li>
                                                     </ul>
                                                 </div>
                                             </td>
                                         </tr>
                                     @endforeach
                                 </tbody>
                             </table>
                             <tfoot>
                                 <tr>
                                     <th colspan="12">
                                         <div class="float-right">
                                             {!! $customer_offer_prices->appends(request()->all())->links() !!}
                                         </div>
                                     </th>
                                 </tr>
                             </tfoot>
                         </div>
                     @else
                         <div class="alert alert-danger text-center">
                             {{ __('data_no_found') }}
                         </div>
                     @endif
                 </div>
             </div>
         </div>
     </div>
 </div>
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
