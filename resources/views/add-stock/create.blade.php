@extends('layouts.app')
@section('title', __('lang.add_stock'))
@push('css')
<!-- Main Faile Css  -->
<link rel="stylesheet" href="{{ asset('salescreen/css/main.css') }}" />
<style>
    /* .select2-selection__rendered {
                                                            width: 100px;
                                                        } */
    .initial-balance-input {
        padding: 0 10px
    }

    .extra_store_accordion .select2-selection__rendered {
        width: 100%;
    }

    .categories_drop_down .select2-container--open {
        left: -85px !important;
        font-size: 12px !important
    }

    .categories_drop_down .select2-selection__rendered {
        font-size: 12px !important;
        display: flex !important
    }

    .store_drop_down .select2-container {
        width: 95% !important
    }

    .form-select {
        height: 100%;
        padding-bottom: 0;
        padding-top: 0;
        background-color: #dedede !important;
        border-radius: 16px;
        border: 2px solid #cececf;
        font-size: 14px;
        font-weight: 500
    }

    .form-select:focus {
        border-color: #cececf !important;
        outline: 0;
        box-shadow: 0 0 0 0 !important;
        background-color: white !important;
    }

    .initial-balance-input {
        border: 2px solid #cececf;
        font-size: 14px;
        font-weight: 500
    }

    .accordion-button:focus {
        border: none !important;
        outline: none !important
    }
</style>
@endpush

@section('page_title')
@lang('lang.stock')
@endsection

@section('breadcrumbs')
@parent
<li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
    @lang('lang.add-stock')</li>
@endsection

@section('button')
<div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
    <a type="button" class="btn btn-primary" href="{{ route('stocks.index') }}">@lang('lang.stock')</a>
</div>
@endsection


@section('content')
@livewire('add-stock.create')

@endsection


@push('javascripts')
<script>
    document.addEventListener('livewire:load', function () {
    // Hook into Livewire's lifecycle to reapply JS changes after any Livewire updates
    Livewire.hook('message.processed', (message, component) => {

$('.formatted_number').each(function() {
// Remove commas for raw number
let rawValue = $(this).val().replace(/,/g, '');

// Format the number with commas
let formattedValue = Number(rawValue).toLocaleString();
$(this).val(formattedValue);
});
    })})

</script>
@endpush
