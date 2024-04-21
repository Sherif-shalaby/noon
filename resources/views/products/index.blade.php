@extends('layouts.app')
@section('title', __('lang.products'))
@section('breadcrumbbar')
    {{-- +++++++++++++++ Style : checkboxes and labels inside selectbox +++++++++++++++ --}}
    <style>
        .selectBox {
        position: relative;
        }

        /* selectbox style */
        .selectBox select
        {
            width: 100%;
            padding: 0 !important;
            padding-left: 4px;
            padding-right: 4px;
            color: #000;
            border: 1px solid #ccc;
            background-color: #fff;
            height: 39px !important;
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
        #checkboxes label span
        {
            font-weight: normal;
        }
    </style>
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.products')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('products.create')}}">@lang('lang.add_products')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.products')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('products.create')}}" class="btn btn-primary">
                        @lang('lang.add_products')
                      </a>
                </div>
            </div>
        </div>
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
                        <h5 class="card-title">@lang('lang.products')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    @include('products.filters')
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            {{-- <div class="col-sm-4 pt-4 my-2" style="padding: 0 3.5rem">
                                <a data-href="{{url('product/multiDeleteRow')}}" id="delete_all"
                                   data-check_password="{{url('user/check-password')}}"
                                   class="btn btn-danger text-white delete_all"><i class="fa fa-trash"></i>
                                    @lang('lang.delete_all')</a>
                            </div> --}}
                            <div id="status"></div>
                            {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                            <div class="col-md-3 col-lg-3">
                                <div class="multiselect col-md-12">
                                    <div class="selectBox" onclick="showCheckboxes()">
                                        <select class="form-select form-control form-control-lg">
                                            <option>@lang('lang.show_hide_columns')</option>
                                        </select>
                                        <div class="overSelect"></div>
                                    </div>
                                    {{-- ///////////////// checkboxes ///////////////// --}}
                                    <div id="checkboxes">
                                        {{-- +++++++++++++++++ checkbox1 : image +++++++++++++++++ --}}
                                        <label for="col1_id">
                                            <input type="checkbox" id="col1_id" name="col1" class="checkbox_class" checked="checked" />
                                            <span>@lang('lang.image')</span> &nbsp;
                                        </label>
                                        {{-- +++++++++++++++++ checkbox2 : product_name +++++++++++++++++ --}}
                                        <label for="col2_id">
                                            <input type="checkbox" id="col2_id" name="col2" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.product_name')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox3 : sku +++++++++++++++++ --}}
                                        <label for="col3_id">
                                            <input type="checkbox" id="col3_id" name="col3" class="checkbox_class" checked="checked" />
                                            <span>@lang('lang.sku')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox4 : stock +++++++++++++++++ --}}
                                        <label for="col4_id">
                                            <input type="checkbox" id="col4_id" name="col4"  class="checkbox_class" checked="checked" />
                                            <span>@lang('lang.select_to_delete')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox5 : stock +++++++++++++++++ --}}
                                        <label for="col5_id">
                                            <input type="checkbox" id="col5_id" name="col5" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.stock')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox6 : category +++++++++++++++++ --}}
                                        <label for="col6_id">
                                            <input type="checkbox" id="col6_id" name="col6" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.category') 1</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox7 : category2 +++++++++++++++++ --}}
                                        <label for="col7_id">
                                            <input type="checkbox" id="col7_id" name="col7" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.category') 2</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox7 : category3 +++++++++++++++++ --}}
                                        <label for="col7_id">
                                            <input type="checkbox" id="col19_id" name="col19" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.category') 3</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox7 : category4 +++++++++++++++++ --}}
                                        <label for="col7_id">
                                            <input type="checkbox" id="col20_id" name="col20" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.category') 4</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox8 : height +++++++++++++++++ --}}
                                        <label for="col8_id">
                                            <input type="checkbox" id="col8_id" name="col8"  class="checkbox_class" checked="checked" />
                                            <span>@lang('lang.height')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox9 : length +++++++++++++++++ --}}
                                        <label for="col9_id">
                                            <input type="checkbox" id="col9_id" name="col9" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.length')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox10 : width +++++++++++++++++ --}}
                                        <label for="col10_id">
                                            <input type="checkbox" id="col10_id" name="col10" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.width')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox11 : size +++++++++++++++++ --}}
                                        <label for="col11_id">
                                            <input type="checkbox" id="col11_id" name="col11" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.size')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox12 : weight +++++++++++++++++ --}}
                                        <label for="col12_id">
                                            <input type="checkbox" id="col12_id" name="col12" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.weight')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox13 : basic_unit_for_import_product +++++++++++++++++ --}}
                                        <label for="col13_id">
                                            <input type="checkbox" id="col13_id" name="col13" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.basic_unit_for_import_product')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox14 : stores +++++++++++++++++ --}}
                                        <label for="col14_id">
                                            <input type="checkbox" id="col14_id" name="col14" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.stores')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox15 : brand +++++++++++++++++ --}}
                                        <label for="col15_id">
                                            <input type="checkbox" id="col15_id" name="col15" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.brand')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox16 : added_by +++++++++++++++++ --}}
                                        <label for="col16_id">
                                            <input type="checkbox" id="col16_id" name="col16" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.added_by')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox17 : updated_by +++++++++++++++++ --}}
                                        <label for="col17_id">
                                            <input type="checkbox" id="col17_id" name="col17" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.updated_by')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox18 : action +++++++++++++++++ --}}
                                        <label for="col18_id">
                                            <input type="checkbox" id="col18_id" name="col18" class="checkbox_class"  checked="checked" />
                                            <span>@lang('lang.action')</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br/><br/>
                            {{-- ++++++++++++++++++ Table Columns ++++++++++++++++++ --}}
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="col1">@lang('lang.image')</th>
                                        <th class="col2">@lang('lang.product_name')</th>
                                        <th class="col3">@lang('lang.sku')</th>
                                        <th class="col4">@lang('lang.select_to_delete')</th>
                                        <th class="col5">@lang('lang.stock')</th>
                                        <th class="col6">@lang('lang.category') 1</th>
                                        <th class="col7">@lang('lang.category') 2</th>
                                        <th class="col19">@lang('lang.category') 3</th>
                                        <th class="col20">@lang('lang.category') 4</th>
                                        <th class="col8">@lang('lang.height')</th>
                                        <th class="col9">@lang('lang.length')</th>
                                        <th class="col10">@lang('lang.width')</th>
                                        <th class="col11">@lang('lang.size')</th>
                                        <th class="col12">@lang('lang.weight')</th>
                                        <th class="col13">{{__('lang.basic_unit_for_import_product')}}</th>
                                        <th class="col14">@lang('lang.stores')</th>
                                        <th class="col15">@lang('lang.brand')</th>
                                        <th class="col16">@lang('added_by')</th>
                                        <th class="col17">@lang('updated_by')</th>
                                        <th class="col18">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $index=>$product)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td class="col1"><img src="{{!empty($product->image)?'/uploads/products/'.$product->image:'/uploads/'.$settings['logo']}}" style="width: 50px; height: 50px;" alt="{{ $product->name }}" ></td>
                                            <td class="col2">{{$product->name}}</td>
                                            <td class="col3">{{$product->sku}}
                                                <br>
                                                @foreach($product->variations as $index=>$var)
                                                   - {{$var->sku}}  
                                                @endforeach
                                        
                                            </td>
                                            <td class="col4">
                                                <input type="checkbox" name="product_selected_delete" class="product_selected_delete" value=" {{ $product->id }} " data-product_id="{{ $product->id }}" />
                                            </td>
                                            <td class="col5">
                                                @foreach($product->product_stores as $store)
                                                    @php
                                                        $unit = !empty($store->variations)?$store->variations:[];
                                                        $amount = 0;
                                                    @endphp
                                                @endforeach

                                                @forelse($product->variations as $variation)
                                                    @if(isset($unit->unit_id) && ($unit->unit_id == $variation->unit_id))
                                                        <span class="product_unit" data-variation_id="{{$variation->id}}" data-product_id="{{$product->id}}">{{$variation->unit->name??''}}  <span class="unit_value">{{$product->product_stores->sum('quantity_available')}}</span></span> <br>
                                                    @else
                                                        <span class="product_unit" data-variation_id="{{$variation->id}}" data-product_id="{{$product->id}}">{{$variation->unit->name  ?? ''}} <span class="unit_value">0</span></span> <br>
                                                    @endif
                                                @empty
                                                    <span>{{$product->product_stores->sum('quantity_available')}} </span>
                                                @endforelse
                                            </td>
                                            <td class="col6">{{$product->category->name??''}}</td>
                                            <td class="col7">
                                                {{$product->subCategory1->name??''}}
                                            </td>
                                            <td class="col19">
                                                {{$product->subCategory2->name??''}}
                                            </td>
                                            <td class="col20">
                                                {{$product->subCategory3->name??''}}
                                            </td>
                                            <td class="col8">{{$product->product_dimensions->height??0}}</td>
                                            <td class="col9">{{$product->product_dimensions->length??0}}</td>
                                            <td class="col10">{{$product->product_dimensions->width??0}}</td>
                                            <td class="col11"><span class="text-primary">{{$product->product_dimensions->size??0}}</span></td>
                                            <td class="col12">{{$product->product_dimensions->weight??0}}</td>
                                            <td class="col13">
                                                {{!empty($product->product_dimensions->variations)?
                                                (!empty($product->product_dimensions->variations->unit)?$product->product_dimensions->variations->unit->name:
                                                ''):''}}
                                            </td>
                                            <td class="col14">
                                                @foreach($product->stores as $store)
                                                {{$store->name}}<br>
                                                @endforeach
                                            </td>
                                            <td class="col15">{{!empty($product->brand)?$product->brand->name:''}}</td>
                                            {{-- ++++++++++++++++++++++ created_at column ++++++++++++++++++++++ --}}
                                            <td class="col16">
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
                                            {{-- ++++++++++++++++++++++ updated_at column ++++++++++++++++++++++ --}}
                                            <td class="col17">
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
                                            <td class="col18">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <li>
                                                            <a data-href="{{route('products.show', $product->id)}}" data-container=".view_modal" class="btn btn-modal">
                                                                <i class="fa fa-eye"></i>
                                                                @lang('lang.view')
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a target="_blank" href="{{route('remove_expiry',$product->id)}}"
                                                            class="btn"><i class="fa fa-hourglass-half"></i>
                                                                @lang('lang.remove_expiry')
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a target="_blank" href="{{route('get_remove_damage',$product->id)}}"
                                                            class="btn"><i class="fa fa-filter"></i>
                                                                @lang('lang.remove_damage')
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a target="_blank" href="{{url('add-stock/create?product_id='.$product->id)}}"
                                                            class="btn"><i class="fa fa-plus"></i>
                                                                @lang('lang.add_new_stock')
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="{{route('products.edit', $product->id)}}" class="btn" target="_blank">
                                                                <i class="dripicons-document-edit"></i>
                                                                @lang('lang.update')
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                            <li>
                                                                <a  data-href="{{route('products.destroy', $product->id)}}" class="btn text-red delete_item">
                                                                    <i class="fa fa-trash"></i>
                                                                    @lang('lang.delete')
                                                                </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- @include('products.edit',$product) --}}
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <td colspan="5" style="text-align: right">@lang('lang.total')</td>
                                    <td id="sum"></td>
                                    <td colspan="12"></td>
                                </tfoot>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
<div class="view_modal no-print" >
    @endsection
@push('javascripts')
<script src="{{ asset('js/product/product.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: "<'row'<'col-md-3 'l><'col-md-5 text-center 'B><'col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-4'i><'col-sm-4'p>>",
            lengthMenu: [10, 25, 50, 75, 100,200,300,400],
            pageLength: 10 ,
            buttons:
                ['copy', 'csv', 'excel', 'pdf',
                    {
                        extend: 'print',
                        exportOptions: {columns: ":visible:not(.notexport)"}
                    }
                    // ,'colvis'
                ],
            "fnDrawCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update status DIV
                $('#sum').html('<span>'+ total + '<span/>');
            }
        });
    });
</script>
<script>
    $(document).on('click', '.product_unit', function() {
        var $this=$(this);
        var variation_id=$(this).data('variation_id');
        var product_id=$(this).data('product_id');
        $.ajax({
            type: "get",
            url: "/product/get-unit-store",
            data: {variation_id:variation_id,product_id:product_id},
            success: function (response) {
                $this.closest('td').find('.product_unit').each(function() {
                    $(this).find('.unit_value').text(0); // Change "New Value" to the desired value
                });
                $this.children('.unit_value').text(response.store);
            }
        });
    });
    $(document).on('click', '#delete_all', function() {
        var checkboxes = document.querySelectorAll('input[name="product_selected_delete"]');
        var selected_delete_ids = [];
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selected_delete_ids.push(checkboxes[i].value);

            }
        }
        console.log(selected_delete_ids)
        if (selected_delete_ids.length == 0){
            alert(1)
            swal.fire({
                title: 'Warning',
                text: LANG.sorry_you_should_select_products_to_continue_delete,
                icon: 'warning',
            })
        }else{
            swal.fire({
                title: 'Are you sure?',
                text: LANG.all_transactions_related_to_this_products_will_be_deleted,
                icon: 'warning',
            }).then(willDelete => {
                if (willDelete) {
                    var check_password = $(this).data('check_password');
                    var href = $(this).data('href');
                    var data = $(this).serialize();

                    swal.fire({
                        title: "{!!__('lang.please_enter_your_password')!!}",
                        input: 'password',
                        inputAttributes: {
                            placeholder:"{!!__('lang.type_your_password')!!}",
                            autocomplete: 'off',
                            autofocus: true,
                        },
                    }).then((result) => {
                        if (result) {
                            $.ajax({
                                url: check_password,
                                method: 'POST',
                                data: {
                                    value: result
                                },
                                dataType: 'json',
                                success: (data) => {

                                    if (data.success == true) {
                                        swal.fire(
                                            'Success',
                                            'Correct Password!',
                                            'success'
                                        );
                                        $.ajax({
                                            method: 'POST',
                                            url: "/product/multiDeleteRow",
                                            dataType: 'json',
                                            data: {
                                                "ids": selected_delete_ids
                                            },
                                            success: function(result) {
                                                if (result.success == true) {
                                                    swal.fire(
                                                        'Success',
                                                        result.msg,
                                                        'success'
                                                    );
                                                    setTimeout(() => {
                                                        location
                                                            .reload();
                                                    }, 1500);
                                                    location.reload();
                                                } else {
                                                    swal.fire(
                                                        'Error',
                                                        result.msg,
                                                        'error'
                                                    );
                                                }
                                            },
                                        });

                                    } else {
                                        swal.fire(
                                            'Failed!',
                                            'Wrong Password!',
                                            'error'
                                        )

                                    }
                                }
                            });
                        }
                    });
                }
            });
        }

    });
</script>
<script>
        // +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++
        $(".checkbox_class:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });

        $(".checkbox_class").click(function(){
            var column = "table ." + $(this).attr("name");
            $(column).toggle();
        });
        // +++++++++++++++++ Checkboxs and label inside selectbox : showCheckboxes() method ++++++++++++++
        var expanded = false;
        function showCheckboxes()
        {
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
