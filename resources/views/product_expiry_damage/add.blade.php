@extends('layouts.app')
@section('title', __('lang.product_damage'))

@push('css')
    <style>
        .table-top-head {
            top: 20px !important;
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
                top: 20px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 20px !important
            }
        }

        @media(max-width:575px) {
            .table-top-head {
                top: 20px !important
            }
        }

        .wrapper1 {
            margin-top: 35px;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 115px;
            }
        }
    </style>
@endpush

@section('page_title')

@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
            style="text-decoration: none;color: #596fd7" href="{{ route('products.index') }}">
            @lang('lang.products')</a></li>
@endsection


@section('content')
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                    </div>
                    @livewire('product-options.remove-damage', ['productId' => $id])
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>

@endsection
