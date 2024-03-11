@extends('layouts.app')
@section('title', __('lang.sales_report'))


@section('page_title')
    تقرير حركة صنف
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
            style="text-decoration: none;color: #596fd7" href="">/ @lang('lang.reports')</a></li>
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        تقرير حركة صنف
    </li>
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
    <div class="animate-in-page">

        <div class="contentbar  mb-0 pb-0">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            {{-- <h5 class="card-title">@lang('lang.products')</h5> --}}
                            <h5 class="card-title"> تقرير حركة صنف</h5>
                        </div>
                        <div class="card-body">
                            <form action="/getProductReport" method="get" role="search" autocomplete="off">
                                <div class="row">

                                    {{-- @include('products.filters')  --}}
                                    <div class="col" id="type">
                                        <p class="mg-b-10"> ابحث عن طريق اسم المخزن</p>
                                        <select class="form-control select2 js-example-basic-single" name="store"
                                            required>
                                            <option value="">
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
                                        <p class="mg-b-10"> ابحث عن طريق المنتج</p>
                                        <select class="form-control select2 js-example-basic-single" name="product"
                                            required>
                                            <option value="">
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
                                                name="start_at" placeholder="YYYY-MM-DD" type="date" required>
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
                                                value="{{ $end_at ?? '' }}" placeholder="YYYY-MM-DD" type="date"
                                                required>
                                        </div><!-- input-group -->
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col ">
                                        {{-- <input type="button" class="btn btn-primary"  value="تقرير" onclick="{{route('getProductReport')}}" /> --}}
                                        {{-- <input type="button" class="btn btn-primary" value="تقرير" onclick="window.location.href = '{{ route('getProductReport') }}'" /> --}}
                                        <button class="btn btn-primary">بحث</button>

                                    </div>


                                </div>
                            </form>




















                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                            <br>
                            @if (isset($results))
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-bordered">
                                        <thead>
                                            <tr>

                                                <th>تاريخ العمليه </th>
                                                <th>اسم المنتج</th>
                                                <th>اسم المخزن</th>
                                                <th> نوع العمليه </th>
                                                <th>الكمية </th>
                                                <th>الرصيد </th>
                                                {{-- <th>العميل </th>
                                            <th>المورد </th>
                                            <th>رقم الهاتف </th> --}}

                                                {{-- <th>@lang('lang.action')</th>  --}}
                                            </tr>
                                        </thead>

                                        <tbody>


                                            @foreach ($results as $result)
                                                <tr
                                                    @if ($result->type == 'بيع') class="table-danger" @else class="table-success" @endif>
                                                    <td>{{ $result->created_at }}</td>
                                                    <td>{{ $result->name }}</td>
                                                    <td>{{ $result->store_name }}</td>
                                                    <td>{{ $result->type }}</td>
                                                    <td>{{ $result->quantity }}</td>
                                                    <td>{{ $result->Final_balance }}</td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                            @endif
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
    </div>
    <!-- End Contentbar -->
@endsection
