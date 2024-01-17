@extends('layouts.app')
@section('title', __('lang.general_settings'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar pb-3">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.general_settings')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.general_settings')</li>
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
                    'route' => 'settings.updateGeneralSettings',
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ]) !!}
                <div class="row">

                    <div class="col-md-3">
                        {!! Form::label('site_title', __('lang.site_title'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::text('site_title', !empty($settings['site_title']) ? $settings['site_title'] : null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="col-md-3 hide">
                        {!! Form::label('developed_by', __('lang.developed_by'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::text('developed_by', !empty($settings['developed_by']) ? $settings['developed_by'] : null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('time_format', __('lang.time_format'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::select(
                            'time_format',
                            ['12' => '12 hours', '24' => '24 hours'],
                            !empty($settings['time_format']) ? $settings['time_format'] : null,
                            ['class' => 'form-control select2'],
                        ) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('language', __('lang.language'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::select('language', $languages, !empty($settings['language']) ? $settings['language'] : null, [
                            'class' => 'form-control select2',
                        ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('currency', __('lang.currency'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::select('currency', $currencies, !empty($settings['currency']) ? $settings['currency']: null, [
                            'class' => 'form-control select2','placholder'=>__('lang.please_select')
                        ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('dollar_exchange', __('lang.dollar_exchange'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::text('dollar_exchange', !empty($settings['dollar_exchange']) ? $settings['dollar_exchange'] : null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('start_date', __('lang.start_date'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::date('start_date', !empty($settings['start_date']) ? $settings['start_date'] : date('Y-m-d'), [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('end_date', __('lang.end_date'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::date('end_date', !empty($settings['end_date']) ? $settings['end_date'] : null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('default_payment_type', __('lang.default_payment_type'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::select('default_payment_type',['cash'=>__('lang.cash'),'later'=>__('lang.later')], !empty($settings['default_payment_type']) ? $settings['default_payment_type'] : null, [
                            'class' => 'form-control select2',
                        ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('tax', __('lang.tax'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::text('tax', !empty($settings['tax']) ? $settings['tax'] : null, [
                            'class' => 'form-control',
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
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('Watsapp Numbers', __('lang.watsapp_numbers'),['class'=>'h5 pt-3']) !!}
                        {!! Form::text('watsapp_numbers', !empty($settings['watsapp_numbers']) ? $settings['watsapp_numbers'] : null, [
                            'class' => 'form-control'
                        ]) !!}
                    </div>
                    {{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
                    <div class="col-md-3">
                        {!! Form::label('country_id', __('lang.country'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::select(
                            'country_id',
                            $countries,
                            !empty($settings['country_id']) ? $settings['country_id'] : null,
                            ['class' => 'form-control select2'],
                        ) !!}
                    </div>
                                {{--       product sku is start with              --}}
                    <div class="col-md-3">
                        {!! Form::label('product_sku_start', __('lang.product_sku_start'), ['class'=>'h5 pt-3']) !!}
                        {!! Form::text(
                            'product_sku_start',!empty($settings['product_sku_start']) ? $settings['product_sku_start'] : null,
                            ['class' => 'form-control'],
                        ) !!}
                    </div>
                    <div class="col-md-3 pt-5">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" {{isset($settings['activate_processing']) && $settings['activate_processing']=="1" ? 'checked' :''}} id="activate_processing" name="activate_processing">
                            <label class="custom-control-label" for="activate_processing">{{__('lang.activate_processing')}}</label>
                        </div>
                    </div>
                    <div class="col-md-3 pt-5 update_processing" style="visibility:{{isset($settings['activate_processing']) && $settings['activate_processing']=="1"?'visible':'hidden'}}">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="update_processing" name="update_processing" {{isset($settings['update_processing']) && $settings['update_processing']==1 ? 'checked' :''}}>
                            <label class="custom-control-label"  for="update_processing" >{{__('lang.update_processing')}}</label>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <div class="col-md-12 pt-5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <div class="container mt-3">
                                        <div class="row mx-0" style="border: 1px solid #ddd;padding: 30px 0px;">
                                            <div class="col-12">
                                                <label for="projectinput2" class="h5 p3 justify-content-center d-flex"> {{ __('lang.letter_header') }}</label>
                                            </div>
                                            <div class="col-5">
                                                <div class="mt-3">
                                                    <div class="row">
                                                        <div class="col-10 offset-1">
                                                            <div class="variants">
                                                                <div class='file file--upload w-100'>
                                                                    <div class="file-input">
                                                                        <input type="file" name="file-input"
                                                                            id="file-input-header"
                                                                            class="file-input__input" />
                                                                        <label class="file-input__label"
                                                                            for="file-input-header">
                                                                            <i class="fas fa-cloud-upload-alt"></i>&nbsp;
                                                                            <span>Upload file</span></label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 offset-1 ">
                                                <div class="preview-header-container">
                                                    @if (!empty($settings['letter_header']))
                                                        <div class="preview">
                                                            <img src="{{ asset('uploads/' . $settings['letter_header']) }}"
                                                                id="img_header_footer" alt="">
                                                            <button type="button"
                                                                class="btn btn-xs btn-danger delete-btn remove_image"
                                                                data-type="letter_header"><i style="font-size: 25px;"
                                                                    class="fa fa-trash"></i></button>
                                                            <span class="btn btn-xs btn-primary  crop-btn"
                                                                id="crop-header-btn" data-toggle="modal"
                                                                data-target="#headerModal"><i style="font-size: 25px;"
                                                                    class="fas fa-crop"></i></span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12 pt-5">
                                <div class="form-group">
                                    <div class="container mt-3">
                                        <div class="row mx-0" style="border: 1px solid #ddd;padding: 30px 0px;">
                                            <div class="col-12 p3 justify-content-center d-flex">
                                            <label for="projectinput2" class='h5'> {{ __('lang.letter_footer') }}</label>

                                            </div>
                                            <div class="col-5">
                                                <div class="mt-3">
                                                    <div class="row">
                                                        <div class="col-10 offset-1">
                                                            <div class="variants">
                                                                <div class='file file--upload w-100'>
                                                                    <div class="file-input">
                                                                        <input type="file" name="file-input"
                                                                            id="file-input-footer"
                                                                            class="file-input__input" />
                                                                        <label class="file-input__label"
                                                                            for="file-input-footer">
                                                                            <i class="fas fa-cloud-upload-alt"></i>&nbsp;
                                                                            <span>Upload file</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 offset-1">
                                                <div class="preview-footer-container">
                                                    @if (!empty($settings['letter_footer']))
                                                        <div class="preview">
                                                            <img src="{{ asset('uploads/' . $settings['letter_footer']) }}"
                                                                id="img_letter_footer" alt="">
                                                            <button type="button"
                                                                class="btn btn-xs btn-danger delete-btn remove_image"
                                                                data-type="letter_footer"><i style="font-size: 25px;"
                                                                    class="fa fa-trash"></i></button>

                                                            <span class="btn btn-xs btn-primary  crop-btn"
                                                                id="crop-footer-btn" data-toggle="modal"
                                                                data-target="#footerModal"><i style="font-size: 25px;"
                                                                    class="fas fa-crop"></i></span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 pt-5">
                                <div class="form-group">
                                    <div class="container mt-3">
                                        <div class="row mx-0" style="border: 1px solid #ddd;padding: 30px 0px;">
                                            <div class="col-12 p3 justify-content-center d-flex">
                                                <label for="projectinput2" class='h5'> {{ __('lang.logo') }}</label>
                                            </div>
                                            <div class="col-5">
                                                <div class="mt-3">
                                                    <div class="row">
                                                        <div class="col-10 offset-1">
                                                            <div class="variants">
                                                                <div class='file file--upload w-100'>
                                                                    <div class="file-input">
                                                                        <input type="file" name="file-input"
                                                                            id="file-input-logo"
                                                                            class="file-input__input" />
                                                                        <label class="file-input__label"
                                                                            for="file-input-logo">
                                                                            <i class="fas fa-cloud-upload-alt"></i>&nbsp;
                                                                            <span>Upload file</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 offset-1">
                                                <div class="preview-logo-container">
                                                    @if (!empty($settings['logo']))
                                                        <div class="preview">
                                                            <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                                                id="img_logo_footer" alt="">
                                                            <button type="button"
                                                                class="btn btn-xs btn-danger delete-btn remove_image "
                                                                data-type="logo"><i style="font-size: 25px;"
                                                                    class="fa fa-trash"></i></button>
                                                            <span class="btn btn-xs btn-primary  crop-btn"
                                                                id="crop-logo-btn" data-toggle="modal"
                                                                data-target="#logoModal"><i style="font-size: 25px;"
                                                                    class="fas fa-crop"></i></span>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-1"></div>
                                <div class="col-md-10">
                                <div class="form-group">
                                    {!! Form::label('help_page_content', __('lang.help_page_content'), ['class'=>'h5 pt-5']) !!}
                                    {!! Form::textarea(
                                        'help_page_content',
                                        !empty($settings['help_page_content']) ? $settings['help_page_content'] : null,
                                        ['class' => 'form-control', 'id' => 'help_page_content'],
                                    ) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div id="cropped_logo_images"></div>
                    <div id="cropped_header_images"></div>
                    <div id="cropped_footer_images"></div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                </div>
                {!! Form::close() !!}
            </div>
            @include('general-settings.crop_modals')
        </div>
    </div>

@endsection
@push('javascripts')
    <link rel="stylesheet" href="//fastly.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    <script src="{{ asset('css/crop/crop-setting.js') }}"></script>


    <script>
        // edit Case
        @if (!empty($settings['letter_header']) && isset($settings['letter_header']))
            document.getElementById("crop-header-btn").addEventListener('click', () => {

                console.log(("#headerModal"))
                setTimeout(() => {
                    launchHeaderCropTool(document.getElementById("img_header_footer"));
                }, 500);
            });
            let deleteHeaderBtn = document.getElementById("deleteBtn");
            if (deleteHeaderBtn) {
                deleteHeaderBtn.addEventListener('click', () => {
                    if (window.confirm('Are you sure you want to delete this image?')) {
                        $("#preview").remove();
                    }
                });
            }
        @endif
        // edit Case
        @if (!empty($settings['letter_footer']) && isset($settings['letter_footer']))
            document.getElementById("crop-footer-btn").addEventListener('click', () => {

                console.log(("#footerModal"))
                setTimeout(() => {
                    launchCropTool(document.getElementById("img_letter_footer"));
                }, 500);
            });
            let deleteFooterBtn = document.getElementById("deleteBtn");
            if (deleteFooterBtn) {
                deleteFooterBtn.getElementById("deleteBtn").addEventListener('click', () => {
                    if (window.confirm('Are you sure you want to delete this image?')) {
                        $("#preview").remove();
                    }
                });
            }
        @endif

        // edit Case
        @if (!empty($settings['logo']) && isset($settings['logo']))
            document.getElementById("crop-logo-btn").addEventListener('click', () => {

                console.log(("#logoModal"))
                setTimeout(() => {
                    launchLogoCropTool(document.getElementById("img_logo_footer"));
                }, 500);
            });
            let deleteLogoBtn = document.getElementById("deleteBtn");
            if (deleteLogoBtn) {
                deleteLogoBtn.getElementById("deleteBtn").addEventListener('click', () => {
                    if (window.confirm('Are you sure you want to delete this image?')) {
                        $("#preview").remove();
                    }
                });
            }
        @endif
        $(document).ready(function () {
            $(document).on('change', '#activate_processing', function() {
                if ($(this).prop('checked')) {
                    $('.update_processing').css('visibility', 'visible');
                }else{
                    $('.update_processing').css('visibility', 'hidden');
                    $('#update_processing').prop('checked',false);
                }
            });
        });
    </script>
@endpush
