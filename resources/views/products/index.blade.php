@extends('layouts.app')
@section('title', __('lang.products'))
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.products')
                </h4>
                <div class="breadcrumb-list">
                    <ul class="breadcrumb" style="list-style: none">
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">
                                @lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.create') }}">@lang('lang.add_products')</a></li>
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                            aria-current="page">/ @lang('lang.products')</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 ">
                <div
                    class="widgetbar  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        @lang('lang.add_products')
                    </a>
                </div>
            </div>
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
                        <h5 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('lang.products')</h5>
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
                        <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="my-2">
                                <a data-href="{{ url('product/multiDeleteRow') }}" id="delete_all"
                                    data-check_password="{{ url('user/check-password') }}"
                                    class="btn btn-danger text-white delete_all"><i class="fa fa-trash"></i>
                                    @lang('lang.delete_all')</a>
                            </div>
                            <div id="status"></div>
                            <table id="datatable-buttons" class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('lang.image')</th>
                                        <th>@lang('lang.product_name')</th>
                                        <th>@lang('lang.sku')</th>
                                        <th>@lang('lang.select_to_delete')</th>
                                        <th>@lang('lang.stock')</th>
                                        <th>@lang('lang.category')</th>
                                        <th>@lang('lang.subcategories_name')</th>
                                        <th>@lang('lang.height')</th>
                                        <th>@lang('lang.length')</th>
                                        <th>@lang('lang.width')</th>
                                        <th>@lang('lang.size')</th>
                                        {{-- <th>@lang('lang.unit')</th> --}}
                                        <th>@lang('lang.weight')</th>
                                        <th>@lang('lang.stores')</th>
                                        <th>@lang('lang.brand')</th>
                                        {{--                                    <th>@lang('lang.discount')</th> --}}
                                        <th>@lang('added_by')</th>
                                        <th>@lang('updated_by')</th>
                                        <th>@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $index => $product)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><img src="{{ !empty($product->image) ? '/uploads/products/' . $product->image : '/uploads/' . $settings['logo'] }}"
                                                    style="width: 50px; height: 50px;" alt="{{ $product->name }}"></td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>
                                                <input type="checkbox" name="product_selected_delete"
                                                    class="product_selected_delete" value=" {{ $product->id }} "
                                                    data-product_id="{{ $product->id }}" />
                                            </td>
                                            <td>{{ $product->product_stores->sum('quantity_available') }}</td>
                                            <td>{{ $product->category->name ?? '' }}</td>
                                            <td>
                                                {{ $product->subCategory1->name ?? '' }} <br>
                                                {{ $product->subCategory2->name ?? '' }} <br>
                                                {{ $product->subCategory3->name ?? '' }}
                                            </td>
                                            <td>{{ $product->height }}</td>
                                            <td>{{ $product->length }}</td>
                                            <td>{{ $product->width }}</td>
                                            <td><span class="text-primary">{{ $product->size }}</span></td>
                                            {{-- <td>{{!empty($product->unit)?$product->unit->name:''}}</td> --}}
                                            <td>{{ $product->weight }}</td>
                                            <td>
                                                @foreach ($product->stores as $store)
                                                    {{ $store->name }}<br>
                                                @endforeach
                                            </td>
                                            <td>{{ !empty($product->brand) ? $product->brand->name : '' }}</td>
                                            {{--                                    <td> --}}
                                            {{--                                        @foreach ($product->product_prices as $price) --}}
                                            {{--                                        {{$price->price_category." : ".$price->price}} <br> --}}
                                            {{--                                        @endforeach --}}
                                            {{--                                    </td> --}}
                                            {{-- ++++++++++++++++++++++ created_at column ++++++++++++++++++++++ --}}
                                            <td>
                                                @if ($product->created_by > 0 and $product->created_by != null)
                                                    {{ $product->created_at->diffForHumans() }} <br>
                                                    {{ $product->created_at->format('Y-m-d') }}
                                                    ({{ $product->created_at->format('h:i') }})
                                                    {{ $product->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                    <br>
                                                    {{ $product->createBy?->name }}
                                                @else
                                                    {{ __('no_update') }}
                                                @endif
                                            </td>
                                            {{-- ++++++++++++++++++++++ updated_at column ++++++++++++++++++++++ --}}
                                            <td>
                                                @if ($product->edited_by > 0 and $product->edited_by != null)
                                                    {{ $product->updated_at->diffForHumans() }} <br>
                                                    {{ $product->updated_at->format('Y-m-d') }}
                                                    ({{ $product->updated_at->format('h:i') }})
                                                    {{ $product->updated_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                    <br>
                                                    {{ $product->updateBy?->name }}
                                                @else
                                                    {{ __('no_update') }}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">خيارات <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                        user="menu" x-placement="bottom-end"
                                                        style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <li>
                                                            <a data-href="{{ route('products.show', $product->id) }}"
                                                                data-container=".view_modal" class="btn btn-modal">
                                                                <i class="fa fa-eye"></i>
                                                                @lang('lang.view')
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('get_remove_damage', $product->id) }}"
                                                                class="btn"><i class="fa fa-filter"></i>
                                                                @lang('lang.remove_damage')
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="{{ route('products.edit', $product->id) }}"
                                                                class="btn" target="_blank">
                                                                <i class="dripicons-document-edit"></i>
                                                                @lang('lang.update')
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a data-href="{{ route('products.destroy', $product->id) }}"
                                                                class="btn text-red delete_item">
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
                                    <td colspan="12">
                                    </td>
                                </tfoot>
                            </table>
                            <div class="view_modal no-print">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    <div class="view_modal no-print">@endsection
        @push('javascripts')
            <script src="{{ asset('js/product/product.js') }}"></script>
            <script>
                $(document).ready(function() {
                    $('#example').DataTable({
                        dom: "<'row'<'col-md-3 'l><'col-md-5 text-center 'B><'col-md-4'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-4'i><'col-sm-4'p>>",
                        lengthMenu: [10, 25, 50, 75, 100, 200, 300, 400],
                        pageLength: 10,
                        buttons: ['copy', 'csv', 'excel', 'pdf',
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: ":visible:not(.notexport)"
                                }
                            }
                            // ,'colvis'
                        ],
                        "fnDrawCallback": function(row, data, start, end, display) {
                            var api = this.api(),
                                data;
                            // Remove the formatting to get integer data for summation
                            var intVal = function(i) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '') * 1 :
                                    typeof i === 'number' ?
                                    i : 0;
                            };
                            // Total over all pages
                            total = api
                                .column(5)
                                .data()
                                .reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                            // Update status DIV
                            $('#sum').html('<span>' + total + '<span/>');
                        }
                    });
                });
            </script>
            <script>
                $(document).on('click', '#delete_all', function() {
                    var checkboxes = document.querySelectorAll('input[name="product_selected_delete"]');
                    var selected_delete_ids = [];
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].checked) {
                            selected_delete_ids.push(checkboxes[i].value);
                        }
                    }
                    console.log(selected_delete_ids)
                    if (selected_delete_ids.length == 0) {
                        alert(1)
                        swal.fire({
                            title: 'Warning',
                            text: LANG.sorry_you_should_select_products_to_continue_delete,
                            icon: 'warning',
                        })
                    } else {
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
                                    title: "{!! __('lang.please_enter_your_password') !!}",
                                    input: 'password',
                                    inputAttributes: {
                                        placeholder: "{!! __('lang.type_your_password') !!}",
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
                                                            if (result.success ==
                                                                true) {
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
        @endpush
