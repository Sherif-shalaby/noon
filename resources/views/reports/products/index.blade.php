@extends('layouts.app')
@section('title', __('lang.product_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.product_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="">@lang('lang.reports')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.product_report')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
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
                        <h5 class="card-title">@lang('lang.product_report')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    @include('reports.products.filters')
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div id="status"></div>
                            <table id="datatable-buttons" class="table dataTable table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('lang.image')</th>
                                    <th>@lang('lang.product_name')</th>
                                    <th>@lang('lang.sku')</th>
                                    <th>@lang('lang.stock')</th>
                                    <th>@lang('lang.balance_return_request')</th>
                                    <th>@lang('lang.category')</th>
                                    <th>@lang('lang.subcategories_name')</th>
                                    <th>@lang('lang.stores')</th>
                                    <th>@lang('lang.brand')</th>
                                    <th>@lang('added_by')</th>
                                    <th>@lang('updated_by')</th>
                                    @if(request()->sell_price_less_purchase_price == 'on')
                                        <th>@lang('actions')</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $index=>$product)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td><img src="{{!empty($product->image)?'/uploads/products/'.$product->image:'/uploads/'.$settings['logo']}}" style="width: 50px; height: 50px;" alt="{{ $product->name }}" ></td>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->sku}}</td>
                                        <td>
                                            @foreach($product->product_stores as $store)
                                                @php
                                                    $unit=!empty($store->variations)?$store->variations:[];
                                                    $amount=0;
                                                @endphp
                                            @endforeach

                                            @forelse($product->variations as $variation)
                                                @if(isset($unit->unit_id) && ($unit->unit_id == $variation->unit_id))
                                                    <span class="product_unit" data-variation_id="{{$variation->id}}" data-product_id="{{$product->id}}">{{$variation->unit->name??''}}  <span class="unit_value">{{$product->product_stores->sum('quantity_available')}}</span></span> <br>
                                                @else
                                                    <span class="product_unit" data-variation_id="{{$variation->id}}" data-product_id="{{$product->id}}">{{$variation->unit->name  ?? ''}} <span class="unit_value">{{$product->product_stores->sum('quantity_available')}}</span></span> <br>
                                                @endif
                                            @empty
                                                <span>{{$product->product_stores->sum('quantity_available')}} </span>
                                            @endforelse
                                        </td>
                                        <td> {{ $product->balance_return_request }}</td>
                                        <td>{{$product->category->name??''}}</td>
                                        <td>
                                            {{$product->subCategory1->name??''}} <br>
                                            {{$product->subCategory2->name??''}} <br>
                                            {{$product->subCategory3->name??''}}
                                        </td>
                                        <td>
                                            @foreach($product->stores as $store)
                                                {{$store->name}}<br>
                                            @endforeach
                                        </td>
                                        <td>{{!empty($product->brand)?$product->brand->name:''}}</td>
                                        {{-- ++++++++++++++++++++++ created_at column ++++++++++++++++++++++ --}}
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
                                        {{-- ++++++++++++++++++++++ updated_at column ++++++++++++++++++++++ --}}
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
                                        <td>
                                            <a type="button" class="btn btn-default btn-sm" href="{{ route('reports.sell_price_less_purchase_price',$product->id) }}">
                                                @lang('lang.view_details')
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
{{--                                <tfoot>--}}

{{--                                <td colspan="4" style="text-align: right">@lang('lang.total')</td>--}}
{{--                                <td id="sum"></td>--}}
{{--                                <td colspan="7"></td>--}}
{{--                                </tfoot>--}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
    <div class="view_modal no-print" >@endsection
@push('javascripts')
<script src="{{ asset('js/product/product.js') }}"></script>
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
</script>

@endpush
