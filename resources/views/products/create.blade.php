@extends('layouts.app')
@section('title', __('lang.add_products'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.add_products')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('products.index')}}">@lang('lang.products')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.add_products')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start row -->
    <div class="row d-flex justify-content-center">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">
                {!! Form::open([
                    'route' => 'products.store',
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ]) !!}
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::label('class', __('lang.class'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::select(
                            'class_id',
                            [],null,
                            ['class' => 'form-control select2','placeholder'=>__('lang.please_select')]
                        ) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('category', __('lang.category'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::select(
                            'category_id',
                            $categories,null,
                            ['class' => 'form-control select2','placeholder'=>__('lang.please_select')]
                        ) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('subcategory', __('lang.subcategory'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::select(
                            'subcategory_id',
                            $categories,null,
                            ['class' => 'form-control select2','placeholder'=>__('lang.please_select')]
                        ) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('brand', __('lang.brand'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::select(
                            'brand_id',
                            $brands,null,
                            ['class' => 'form-control select2','placeholder'=>__('lang.please_select')]
                        ) !!}
                    </div>


                    <div class="col-md-3">
                        {!! Form::label('name', __('lang.product_name'), ['class'=>'h5 pt-3']) !!}
                        <div class="d-flex justify-content-center">
                            {!! Form::text('product_name', null, [
                                'class' => 'form-control',
                            ]) !!}
                            <button class="btn btn-primary btn-sm ml-2" type="button"
                            data-toggle="collapse" data-target="#translation_table_category"
                            aria-expanded="false" aria-controls="collapseExample">
                            <i class="fas fa-globe"></i>
                        </button>
                         </div>
                         @include('layouts.translation_inputs', [
                            'attribute' => 'name',
                            'translations' => [],
                            'type' => 'category',
                        ])
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('sku', __('lang.product_code'),['class'=>'h5 pt-3']) !!}
                        {!! Form::text('sku',  null, [
                            'class' => 'form-control','placeholder'=>__('product_code')
                        ]) !!}
                    </div>



                    {{-- <div class="col-md-3">
                        {!! Form::label('language', __('lang.language'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::select('language', $languages, !empty($settings['language']) ? $settings['language'] : null, [
                            'class' => 'form-control select2',
                        ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('currency', __('lang.currency'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::select('currency', $currencies, !empty($settings['currency']) ? $settings['currency'] : null, [
                            'class' => 'form-control select2',
                        ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('invoice_lang', __('lang.invoice_lang'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::select(
                            'invoice_lang',
                            $languages + ['ar_and_en' => 'Arabic and English'],
                            !empty($settings['invoice_lang']) ? $settings['invoice_lang'] : null,
                            ['class' => 'form-control select2'],
                        ) !!}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection