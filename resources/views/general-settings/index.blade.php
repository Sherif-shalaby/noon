@extends('layouts.app')
@section('title', __('lang.general_settings'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.general_settings')
                    </h4>
                    <div class="breadcrumb-list mb-3">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  "><a
                                    style="text-decoration: none;color: #596fd7"
                                    href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif   active"
                                aria-current="page">@lang('lang.general_settings')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">

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
                    <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                        <div
                            class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('site_title', __('lang.site_title'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text('site_title', !empty($settings['site_title']) ? $settings['site_title'] : null, [
                                'class' => 'form-control required initial-balance-input m-0',
                            ]) !!}
                        </div>

                        <div
                            class="col-md-3 hide d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('developed_by', __('lang.developed_by'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text('developed_by', !empty($settings['developed_by']) ? $settings['developed_by'] : null, [
                                'class' => 'form-control required initial-balance-input my-0',
                            ]) !!}
                        </div>

                        <div
                            class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('time_format', __('lang.time_format'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                {!! Form::select(
                                    'time_format',
                                    ['12' => '12 hours', '24' => '24 hours'],
                                    !empty($settings['time_format']) ? $settings['time_format'] : null,
                                    ['class' => 'form-control select2'],
                                ) !!}
                            </div>
                        </div>

                        <div
                            class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('language', __('lang.language'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                {!! Form::select('language', $languages, !empty($settings['language']) ? $settings['language'] : null, [
                                    'class' => 'form-control select2',
                                ]) !!}
                            </div>
                        </div>

                        <div
                            class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('currency', __('lang.currency'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">

                                {!! Form::select('currency', $currencies, !empty($settings['currency']) ? $settings['currency'] : null, [
                                    'class' => 'form-control select2',
                                    'placholder' => __('lang.please_select'),
                                ]) !!}
                            </div>
                        </div>

                        <div
                            class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('dollar_exchange', __('lang.dollar_exchange'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text('dollar_exchange', !empty($settings['dollar_exchange']) ? $settings['dollar_exchange'] : null, [
                                'class' => 'form-control required initial-balance-input my-0',
                            ]) !!}
                        </div>

                        <div
                            class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('start_date', __('lang.start_date'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::date('start_date', !empty($settings['start_date']) ? $settings['start_date'] : date('Y-m-d'), [
                                'class' => 'form-control required initial-balance-input m-0',
                            ]) !!}
                        </div>
                        <div
                            class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('end_date', __('lang.end_date'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::date('end_date', !empty($settings['end_date']) ? $settings['end_date'] : null, [
                                'class' => 'form-control required initial-balance-input m-0',
                            ]) !!}
                        </div>

                        <div
                            class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('default_payment_type', __('lang.default_payment_type'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">

                                {!! Form::select(
                                    'default_payment_type',
                                    ['cash' => __('lang.cash'), 'later' => __('lang.later')],
                                    !empty($settings['default_payment_type']) ? $settings['default_payment_type'] : null,
                                    [
                                        'class' => 'form-control select2',
                                    ],
                                ) !!}
                            </div>
                        </div>

                        <div
                            class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('tax', __('lang.tax'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text('tax', !empty($settings['tax']) ? $settings['tax'] : null, [
                                'class' => 'form-control required initial-balance-input my-0',
                            ]) !!}
                        </div>

                        <div
                            class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('invoice_lang', __('lang.invoice_lang'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">

                                {!! Form::select(
                                    'invoice_lang',
                                    $languages + ['ar_and_en' => 'Arabic and English'],
                                    !empty($settings['invoice_lang']) ? $settings['invoice_lang'] : null,
                                    ['class' => 'form-control select2'],
                                ) !!}
                            </div>
                        </div>

                        <div
                            class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {!! Form::label('Watsapp Numbers', __('lang.watsapp_numbers'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text('watsapp_numbers', !empty($settings['watsapp_numbers']) ? $settings['watsapp_numbers'] : null, [
                                'class' => 'form-control required initial-balance-input m-0',
                            ]) !!}
                        </div>

                        {{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
                        <div
                            class="col-md-3 d-flex mb-2 align-items-center  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <label for="country-dd"
                                class=" mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif">@lang('lang.country')</label>
                            <div class="input-wrapper">
                                <select id="country-dd" name="country" class=" initial-balance-input my-0"
                                    style="width: 100%;border-radius: 12px;border:2px solid #ccc">
                                    @foreach ($countries as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 pt-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <div class="container mt-3">
                                            <div class="row mx-0" style="border: 1px solid #ddd;padding: 30px 0px;">
                                                <div class="col-12">
                                                    <label for="projectinput2" class="h5 p3 justify-content-center d-flex">
                                                        {{ __('lang.letter_header') }}</label>
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
                                                                                <i
                                                                                    class="fas fa-cloud-upload-alt"></i>&nbsp;
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="container mt-3">
                                            <div class="row mx-0" style="border: 1px solid #ddd;padding: 30px 0px;">
                                                <div class="col-12 p3 justify-content-center d-flex">
                                                    <label for="projectinput2" class='h5'>
                                                        {{ __('lang.letter_footer') }}</label>

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
                                                                                <i
                                                                                    class="fas fa-cloud-upload-alt"></i>&nbsp;
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
                                <div class="col-md-12 p-0">
                                    <div class="form-group">
                                        <div class="container mt-3">
                                            <div class="row mx-0" style="border: 1px solid #ddd;padding: 30px 0px;">
                                                <div class="col-12 p3 justify-content-center d-flex">
                                                    <label for="projectinput2" class='h5'>
                                                        {{ __('lang.logo') }}</label>
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
                                                                                <i
                                                                                    class="fas fa-cloud-upload-alt"></i>&nbsp;
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
                                        {!! Form::label('help_page_content', __('lang.help_page_content'), ['class' => 'h5 pt-5']) !!}
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
    </script>
@endpush
