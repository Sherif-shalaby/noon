@extends('layouts.app')
@section('title', __('lang.customer'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.customers')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('customers.index')}}">@lang('lang.customers')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.customer') {{$customer->name}}</li>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header d-flex align-items-center">
                        <h4>@lang('lang.employee') </h4>
                        {{--                        <a href="{{action('EmployeeController@sendLoginDetails', $employee->id)}}"--}}
                        {{--                            class="btn btn-primary btn-xs" style="margin-left: 10px;"><i class="fa fa-paper-plane"></i> @lang('lang.send_credentials')</a>--}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="fname">@lang('lang.customer_type') : </label> {{$customer->customer_type->name ?? ''}}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="name">@lang('lang.name') : </label> {{ $customer->name }}

                                    </div>
                                    @php
                                        $emailArray = explode(',', $customer->email);
                                        $phoneArray = explode(',', $customer->phone);
                                        // Remove square brackets from each element in the emailArray
                                        foreach ($emailArray as $key => $email)
                                        {
                                            $emailArray[$key] = str_replace(['[', ']','"'], '', $email);
                                        }
                                        // Remove square brackets from each element in the emailArray
                                        foreach ($phoneArray as $key => $phone)
                                        {
                                            $phoneArray[$key] = str_replace(['[', ']','"'], '', $phone);
                                        }
                                    @endphp
                                    <div class="col-sm-6">
                                        <label for="email">@lang('lang.email') : </label>
                                        @foreach ($emailArray as $email)
                                            {{ $email }}<br>
                                        @endforeach
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="email">@lang('lang.phone') : </label>
                                        @foreach ($phoneArray as $phone)
                                            {{ $phone }}<br>
                                        @endforeach
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="date_of_start_working">@lang('lang.min_amount_in_dollar') : </label>
                                        {{ $customer->min_amount_in_dollar }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="date_of_birth">@lang('lang.max_amount_in_dollar') : </label>
                                        {{ $customer->max_amount_in_dollar }}
                                    </div>


                                    <div class="col-sm-6">
                                        <label for="job_type">@lang('lang.min_amount_in_dinar') : </label>
                                        {{ $customer->min_amount_in_dinar }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.max_amount_in_dinar') : </label>
                                        {{ $customer->max_amount_in_dinar }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.balance_in_dollar') : </label>
                                        {{ $customer->balance_in_dollar }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.balance_in_dinar') : </label>
                                        {{ $customer->balance_in_dinar }}
                                    </div>
                                    @php
                                        $state = \App\Models\State::find($customer->state_id);
                                        $city = \App\Models\City::find($customer->city_id);
                                    @endphp
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.state') : </label>
                                        {{ $state ? $state->name : '' }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.city') : </label>
                                        {{ $city ? $city->name : '' }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.address') : </label>
                                        {{ $customer->address }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.notes') : </label>
                                        {{ $customer->notes }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="thumbnail">
                                    <img src="@if(!empty($customer->image)){{asset('uploads/'.$customer->image)}}@else{{asset('images/default.jpg')}}@endif"
                                         style="" class="img-fluid" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <label for="mobile"> @lang('lang.important_dates')  </label>
                                @if($customer->customer_important_dates)
                                    @foreach($customer->customer_important_dates as $date)
                                        <br>
                                        <div class="col-sm-6">
                                            <label for="important_date">@lang('lang.important_date') : </label>
                                            {{ $date->details }}
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="date">@lang('lang.date') : </label>
                                            {{ $date->date }}
                                        </div>
                                        <br>
                                    @endforeach
                                @endif

                            </div>





                            {{--  --}}
                            {{--  --}}
                            <div class="card-body">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs ml-4 mt-3" role="tablist">
                                        {{-- ++++++++++++ tab 1 : info +++++++++++ --}}
                                        {{-- <li class="nav-item">
                                            <a class="nav-link @if (empty(request()->show)) active @endif" href="#info-sale" role="tab"
                                                data-toggle="tab">@lang('lang.info')</a>
                                        </li> --}}
                                        {{-- ++++++++++++ tab 2 : pending_orders +++++++++++ --}}
                                    
                                        {{-- ++++++++++++ tab 3 : statement_of_account +++++++++++ --}}
                                   
                                          {{-- ++++++++++++ tab 4 : statement_of_account +++++++++++ --}}
                                        <li class="nav-item">
                                            <a class="nav-link  show active" href="#statement-of-sell-account"
                                                role="tab" data-toggle="tab">@lang('lang.statement_of_account') @lang('lang.sell')</a>
                                        </li>
                                    </ul>
                                   
                                    <div class="tab-content">
                                        {{-- ++++++++++++ Tab 1 Content : info : معلومات +++++++++++ --}}
                                         <div role="tabpanel" class="tab-pane fade @if (empty(request()->show))   @endif" id="info-sale">
                                            <br>
                                            <br>
                                            <div class="col-md-12 text-muted">
                                                <div class="row">
                                                    {{-- <input type="hidden" name="supplier_id" id="supplier_id" value="{{ $supplier->id }}"> --}}
                                                    <div class="col-md-6">
                                                        <div class="col-md-12 ">
                                                            <b>@lang('lang.name'):</b>
                                                            {{-- <span class="customer_name_span">{{ $supplier->name }}</span> --}}
                                                        </div>
                
                                                        <div class="col-md-12">
                                                            <b>@lang('lang.company_name'):</b>
                                                            {{-- <span class="customer_company_name_span">{{ $supplier->company_name }}</span> --}}
                                                        </div>
                
                                                        <div class="col-md-12">
                                                            <b>@lang('lang.vat_number'):</b>
                                                            {{-- <span class="customer_vat_number_span">{{ $supplier->vat_number }}</span> --}}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <b>@lang('lang.email'):</b>
                                                            {{-- <span class="customer_email_span">{{ $supplier->email }}</span> --}}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <b>@lang('lang.mobile'):</b>
                                                            {{-- <span class="customer_mobile_span">{{ $supplier->mobile }}</span> --}}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <b>@lang('lang.address'):</b>
                                                            {{-- <span class="customer_address_span">{{ $supplier->address }}</span> --}}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <b>@lang('lang.city'):</b>
                                                            {{-- <span class="customer_city_span">{{ $supplier->city }}</span> --}}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <b>@lang('lang.state'):</b>
                                                            {{-- <span class="customer_state_span">{{ $supplier->state }}</span> --}}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <b>@lang('lang.postal_code'):</b>
                                                            {{-- <span class="customer_postal_code_span">{{ $supplier->postal_code }}</span> --}}
                                                        </div>
                                                        <div class="col-md-12">
                                                            <b>@lang('lang.country'):</b>
                                                            {{-- <span class="customer_country_span">{{ $supplier->country }}</span> --}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                            <div class="thumbnail">
                                                                {{-- <img style="width: 200px; height: 200px;" class="img-fluid"
                                                                    src="@if (!empty($supplier->getFirstMediaUrl('supplier_photo'))) {{ $supplier->getFirstMediaUrl('supplier_photo') }} @endif"
                                                                    alt="Supplier photo"> --}}
                                                            </div>
                
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
          
                                         {{-- ++++++++++++ Tab 4 Content : statement_of_account :  البيع كشف حساب +++++++++++ --}}
                                         <div role="tabpanel" class="tab-pane fade show active "
                                            id="statement-of-sell-account">
                                            <div class="table-responsive">
                                                <table class="table dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>@lang('lang.date')</th>
                                                            <th>رقم الفاتوره</th>
                                                            <th>قيمة الفاتور بالدينار </th>
                                                            <th>قيمة  الفاتور بالدولار</th>
                                                            <th>المدفوع بالدينار</th>
                                                            <th>المدفوع بالدولار</th>
                                                            <th>رصيد العميل بالدولار</th>
                                                            <th>رصيد العميل بالدينار</th>


                                                        </tr>
                                                    </thead>
                
                                                    <tbody>
                                                     
                                                        @foreach ($sell_lines as $line)
                                                        <tr>
                                                         <td>{{$line->transaction_date}}</td>
                                                         <td>{{$line->invoice_no}}</td>
                                                         <td>{{$line->transaction_value_dinar}}</td>
                                                         <td>{{$line->transaction_value_dollar}}</td>  
                                                         <td>{{$line->payment_dinar_value}}</td>  
                                                         <td>{{$line->Payment_dollar_value}}</td>  
                                                        <td>{{$line->DOLLAR_Balance}}</td>  
                                                        <td>{{$line->DINAR_Balance}}</td>  
                                                       
                                                        </tr>
                                                             
                                                            @endforeach
                                                        </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th></th>
                                                            {{-- <th style="text-align: right">@lang('lang.total')</th> --}}
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--  --}}
                            {{--  --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
