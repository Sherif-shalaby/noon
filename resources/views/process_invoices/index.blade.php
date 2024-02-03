@extends('layouts.app')
@section('title', __('lang.process_invoices'))

@push('css')
    <style>
        .table-top-head {
            top: 35px !important;
        }

        .table-scroll-wrapper {
            width: fit-content;
        }

        @media(min-width:1900px) {
            .table-scroll-wrapper {
                width: 100%;
            }
        }

        @media(max-width:991px) {
            .table-top-head {
                top: 35px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 50px !important
            }
        }

        @media(max-width:575px) {
            .table-top-head {
                top: 50px !important
            }
        }

        .wrapper1 {
            margin-top: 35px;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 135px;
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.process_invoices')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.process_invoices')</li>
@endsection

@section('content')
    @livewire('process-invoice.index')
@endsection
