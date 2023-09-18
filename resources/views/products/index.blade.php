@extends('layouts.app')
@section('title', __('lang.products'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.products')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
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
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('lang.image')</th>
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
                                    <th>@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $index=>$product)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td><img src="{{!empty($product->image)?'/uploads/products/'.$product->image:'/uploads/'.$settings['logo']}}" style="width: 50px; height: 50px;" alt="{{ $product->name }}" ></td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->sku}}</td>
                                    <td>{{$product->category->name??''}}</td>
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
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <li>

                                                    <a href="{{route('products.edit', $product->id)}}" class="btn" target="_blank"><i class="dripicons-document-edit"></i> @lang('lang.update')</a>

                                                </li>
                                                <li class="divider"></li>
                                                    <li>
                                                        <a  data-href="{{route('products.destroy', $product->id)}}"
                                                            {{-- data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}}
                                                            class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                            @lang('lang.delete')</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                {{-- @include('products.edit',$product) --}}
                                @endforeach
                                </tbody>
                            </table>
                            <div class="view_modal no-print" >

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
