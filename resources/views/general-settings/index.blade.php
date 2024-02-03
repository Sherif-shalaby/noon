@extends('layouts.app')
@section('title', __('lang.general_settings'))

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush

@section('page_title')
    @lang('lang.general_settings')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif   active" aria-current="page">
        @lang('lang.general_settings')</li>
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

                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft  mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.1s">
                            {!! Form::label('site_title', __('lang.site_title'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text('site_title', !empty($settings['site_title']) ? $settings['site_title'] : null, [
                                'class' => 'form-control required initial-balance-input m-0',
                            ]) !!}
                        </div>

                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft  hide mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.15s">
                            {!! Form::label('developed_by', __('lang.developed_by'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text('developed_by', !empty($settings['developed_by']) ? $settings['developed_by'] : null, [
                                'class' => 'form-control required initial-balance-input m-0',
                            ]) !!}
                        </div>

                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.2s">
                            {!! Form::label('time_format', __('lang.time_format'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
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

                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.25s">
                            {!! Form::label('language', __('lang.language'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                {!! Form::select('language', $languages, !empty($settings['language']) ? $settings['language'] : null, [
                                    'class' => 'form-control select2',
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.3s">
                            {!! Form::label('currency', __('lang.currency'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">

                                {!! Form::select('currency', $currencies, !empty($settings['currency']) ? $settings['currency'] : null, [
                                    'class' => 'form-control currency select2',
                                    'placholder' => __('lang.please_select'),
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.35s">
                            {!! Form::label('dollar_exchange', __('lang.dollar_exchange'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text('dollar_exchange', !empty($settings['dollar_exchange']) ? $settings['dollar_exchange'] : null, [
                                'class' => 'form-control required initial-balance-input m-0',
                            ]) !!}
                        </div>

                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.4s">
                            {!! Form::label('start_date', __('lang.start_date'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::date('start_date', !empty($settings['start_date']) ? $settings['start_date'] : date('Y-m-d'), [
                                'class' => 'form-control required initial-balance-input m-0',
                            ]) !!}
                        </div>
                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.45s">
                            {!! Form::label('end_date', __('lang.end_date'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::date('end_date', !empty($settings['end_date']) ? $settings['end_date'] : null, [
                                'class' => 'form-control required initial-balance-input m-0',
                            ]) !!}
                        </div>

                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.5s">
                            {!! Form::label('default_payment_type', __('lang.default_payment_type'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
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

                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.55s">
                            {!! Form::label('tax', __('lang.tax'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text('tax', !empty($settings['tax']) ? $settings['tax'] : null, [
                                'class' => 'form-control required initial-balance-input m-0',
                            ]) !!}
                        </div>

                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.6s">
                            {!! Form::label('invoice_lang', __('lang.invoice_lang'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
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

                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.65s">
                            {!! Form::label('Watsapp Numbers', __('lang.watsapp_numbers'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text('watsapp_numbers', !empty($settings['watsapp_numbers']) ? $settings['watsapp_numbers'] : null, [
                                'class' => 'form-control required initial-balance-input m-0',
                            ]) !!}
                        </div>

                        {{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.7s">
                            {!! Form::label('country_id', __('lang.country'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">

                                {!! Form::select('country_id', $countries, !empty($settings['country_id']) ? $settings['country_id'] : null, [
                                    'class' => 'form-control select2',
                                ]) !!}
                            </div>
                        </div>
                        {{--       product sku is start with              --}}
                        <div class="col-sm-6 col-md-3  animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.75s">
                            {!! Form::label('product_sku_start', __('lang.product_sku_start'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text(
                                'product_sku_start',
                                !empty($settings['product_sku_start']) ? $settings['product_sku_start'] : null,
                                ['class' => 'form-control initial-balance-input m-0'],
                            ) !!}
                        </div>
                        @php
                            $currency = \App\Models\Currency::find($settings['currency']);
                            $info = $currency->country . ' - ' . $currency->currency . '(' . $currency->code . ') ' . $currency->symbol;
                        @endphp
                        <div class="col-sm-6 col-md-3 justify-content-end animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.75s">
                            {!! Form::label('loading_cost_currency', __('lang.loading_cost_currency'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                {!! Form::select(
                                    'loading_cost_currency',
                                    ['2' => 'America - Dollars(USD) $', $currency->id => $info],
                                    !empty($settings['loading_cost_currency']) ? $settings['loading_cost_currency'] : null,
                                    ['class' => 'form-control select2 loading_cost_currency', 'placeholder' => __('lang.please_select')],
                                ) !!}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 justify-content-end animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.75s">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                    {{ isset($settings['activate_processing']) && $settings['activate_processing'] == '1' ? 'checked' : '' }}
                                    id="activate_processing" name="activate_processing">
                                <label class="custom-control-label"
                                    for="activate_processing">{{ __('lang.activate_processing') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 justify-content-end animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif update_processing"
                            style="visibility:{{ isset($settings['activate_processing']) && $settings['activate_processing'] == '1' ? 'visible' : 'hidden' }}">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="update_processing"
                                    name="update_processing"
                                    {{ isset($settings['update_processing']) && $settings['update_processing'] == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label"
                                    for="update_processing">{{ __('lang.update_processing') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 justify-content-end animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.8s">
                            {!! Form::label('num_of_digital_numbers', __('lang.num_of_digital_numbers'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text(
                                'num_of_digital_numbers',
                                !empty($settings['num_of_digital_numbers']) ? $settings['num_of_digital_numbers'] : null,
                                ['class' => 'form-control initial-balance-input m-0'],
                            ) !!}
                        </div>
                        <div class="col-sm-6 col-md-3 justify-content-end animate__animated animate__bounceInLeft mb-2  d-flex flex-column  @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                            style="animation-delay: 1.8s">
                            {!! Form::label('keyboord_letter_to_toggle_dollar', __('lang.keyboord_letter_to_toggle_dollar'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : ' mx-2 mb-0 ',
                                'style' => 'font-size: 12px;font-weight: 500;',
                            ]) !!}
                            {!! Form::text(
                                'keyboord_letter_to_toggle_dollar',
                                !empty($settings['keyboord_letter_to_toggle_dollar']) ? $settings['keyboord_letter_to_toggle_dollar'] : null,
                                ['class' => 'form-control initial-balance-input m-0'],
                            ) !!}
                        </div>
                        <div class="col-md-12 d-flex justify-content-center py-2">
                            <div class="col-md-6">
                                @include('general-settings.partials.add_loading_cost')
                            </div>
                        </div>
                        <div class="col-md-12
                            pt-1">
                            <div class="row">
                                <div class="col-md-4 animate__animated animate__bounceInLeft "
                                    style="animation-delay: 1.75s">
                                    <div class="container mt-3">
                                        <div class="row mx-0" style="border: 1px solid #ddd;padding: 30px 0px;">
                                            <div class="col-12">
                                                <label for="projectinput2" class=" justify-content-center d-flex">
                                                    {{ __('lang.letter_header') }}</label>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="variants">
                                                        <div class='file file--upload w-100'>
                                                            <div class="file-input">
                                                                <input type="file" name="file-input"
                                                                    id="file-input-header" class="file-input__input" />
                                                                <label class="file-input__label text-white"
                                                                    for="file-input-header">
                                                                    <i class="fas fa-cloud-upload-alt"></i>&nbsp;
                                                                    <span>Upload file</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="preview-header-container"
                                                    style="display: flex !important;justify-content:center">
                                                    @if (!empty($settings['letter_header']))
                                                        <div class="preview">
                                                            <img src="{{ asset('uploads/' . $settings['letter_header']) }}"
                                                                id="img_header_footer" alt="">
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger delete-btn remove_image"
                                                                data-type="letter_header"><i style="font-size: 16px;"
                                                                    class="fa fa-trash"></i>
                                                            </button>
                                                            <span class="btn btn-sm btn-primary  crop-btn"
                                                                id="crop-header-btn" data-toggle="modal"
                                                                data-target="#headerModal"><i style="font-size: 16px;"
                                                                    class="fas fa-crop"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 animate__animated animate__bounceInLeft "
                                    style="animation-delay: 1.8s">
                                    <div class="container mt-3">
                                        <div class="row mx-0" style="border: 1px solid #ddd;padding: 30px 0px;">
                                            <div class="col-12">
                                                <label for="projectinput2" class='h5 p3 justify-content-center d-flex'>
                                                    {{ __('lang.letter_footer') }}</label>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex justify-content-center align-items-center">

                                                    <div class="variants">
                                                        <div class='file file--upload w-100'>
                                                            <div class="file-input">
                                                                <input type="file" name="file-input"
                                                                    id="file-input-footer" class="file-input__input" />
                                                                <label class="file-input__label text-white"
                                                                    for="file-input-footer">
                                                                    <i class="fas fa-cloud-upload-alt"></i>&nbsp;
                                                                    <span>Upload file</span></label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="preview-footer-container"
                                                    style="display: flex !important;justify-content:center">
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
                                <div class="col-md-4 animate__animated animate__bounceInLeft"
                                    style="animation-delay: 1.85s">
                                    <div class="container mt-3">
                                        <div class="row mx-0" style="border: 1px solid #ddd;padding: 30px 0px;">
                                            <div class="col-12">
                                                <label for="projectinput2" class='h5 p3 justify-content-center d-flex'>
                                                    {{ __('lang.logo') }}</label>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex justify-content-center align-items-center">

                                                    <div class="variants">
                                                        <div class='file file--upload w-100'>
                                                            <div class="file-input">
                                                                <input type="file" name="file-input"
                                                                    id="file-input-logo" class="file-input__input" />
                                                                <label class="file-input__label text-white"
                                                                    for="file-input-logo">
                                                                    <i class="fas fa-cloud-upload-alt"></i>&nbsp;
                                                                    <span>Upload file</span></label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="preview-logo-container"
                                                    style="display: flex !important;justify-content:center">
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
                        <div class="row">
                            {!! Form::label('help_page_content', __('lang.help_page_content'), ['class' => 'h5 text-end d-block']) !!}
                            {!! Form::textarea(
                                'help_page_content',
                                !empty($settings['help_page_content']) ? $settings['help_page_content'] : null,
                                ['class' => 'form-control', 'id' => 'help_page_content'],
                            ) !!}

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
        $(document).ready(function() {
            $(document).on('change', '#activate_processing', function() {
                if ($(this).prop('checked')) {
                    $('.update_processing').css('visibility', 'visible');
                } else {
                    $('.update_processing').css('visibility', 'hidden');
                    $('#update_processing').prop('checked', false);
                }
            });
        });
        $(document).ready(function() {
            $('#currency').on('change', function(e) {
                // Get the selected value from the first dropdown
                var selectedValue = $(this).val();
                console.log(selectedValue);
                // Perform an AJAX request to fetch updated options for the second dropdown based on the selected value
                // Update the 'url' and 'data' parameters with your actual route and data structure
                $.ajax({
                    url: '/get_currency', // Replace with your actual API endpoint
                    method: 'GET',
                    data: {
                        selectedValue: selectedValue
                    },
                    success: function(data) {
                        // Update options for the second dropdown
                        $('#loading_cost_currency').empty();
                        $.each(data, function(key, value) {
                            if (key == '') {
                                $('#loading_cost_currency').append($(
                                    '<option selected>', {
                                        value: key,
                                        text: LANG.please_select
                                    }));
                            } else {
                                $('#loading_cost_currency').append($('<option>', {
                                    value: key,
                                    text: value
                                }));
                            }
                        });
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });
        });
    </script>
@endpush
