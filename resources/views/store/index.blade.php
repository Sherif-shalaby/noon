@extends('layouts.app')
@section('title', __('lang.stores'))

@push('css')
    <style>
        .table-top-head {
            top: 85px !important;
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
                top: 85px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 125px !important
            }
        }

        @media(max-width:575px) {
            .table-top-head {
                top: 85px !important
            }
        }

        .rightbar {
            z-index: 2;
        }

        .wrapper1 {
            margin-top: 35px;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 90px;
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.stores')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
            style="text-decoration: none;color: #596fd7" href="#">/ @lang('lang.settings')</a></li>
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.stores')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-store"
            href="{{ route('store.create') }}">@lang('lang.add_store')</button>
    </div>
@endsection


@section('content')
    <div class="animate-in-page">

        <!-- Start Contentbar -->
        <div class="contentbar mb-0 pb-0">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.stores')</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        <form action="{{ route('store.index') }}" method="get" id="filters_form"
                                            class="mb-0">
                                            <div
                                                class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                {{-- ++++++++++++++++++++ branches filter ++++++++++++++++++++ --}}
                                                <div class="col-2 p-1  d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                                    style="animation-delay: 1.15s">
                                                    {!! Form::label('branch_id', __('lang.branch'), [
                                                        'class' => 'mb-0',
                                                    ]) !!}
                                                    <div class="input-wrapper">

                                                        {!! Form::select('branch_id', $branches, request()->branch_id, [
                                                            'class' => 'form-control select2 store',
                                                            'placeholder' => __('lang.please_select'),
                                                            'id' => 'branch_id',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                {{-- ++++++++++++++++++++ stores filter ++++++++++++++++++++ --}}
                                                {{-- <div class="col-2 p-1  d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                                                    style="animation-delay: 1.15s">
                                                    {!! Form::label('store_id', __('lang.store'), [
                                                        'class' => 'mb-0',
                                                    ]) !!}
                                                    <div class="input-wrapper ">
                                                        {!! Form::select('store_id', [], request()->store_id, [
                                                            'class' => 'form-control select2 store',
                                                            'placeholder' => __('lang.please_select'),
                                                            'id' => 'store_id',
                                                        ]) !!}
                                                    </div>
                                                </div> --}}
                                                <div class="col-6 col-md-3 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-row-reverse"
                                                    style="animation-delay: 1.15s">
                                                    <button type="submit" name="submit" class="btn btn-primary"
                                                        title="search" style="font-size: 14px;font-weight: 400">
                                                        <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
                                                    <a href="{{ route('store.index') }}" class="btn btn-danger px-1 mx-1"
                                                        style="font-size: 14px;font-weight: 400">@lang('lang.clear_filters')</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width:1300px;max-height: 90vh;overflow: auto">
                                        <table id="datatable-buttons" class="table dataTable">
                                            <thead>
                                                <tr>
                                                    <th>@lang('lang.name')</th>
                                                    <th>@lang('lang.branch')</th>
                                                    <th>@lang('lang.phone_number')</th>
                                                    <th>@lang('lang.email')</th>
                                                    <th>@lang('lang.manager_name')</th>
                                                    <th>@lang('lang.manager_mobile_number')</th>
                                                    <th class="notexport">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($stores as $store)
                                                    <tr>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.name')">

                                                                {{ $store->name }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.branch')">

                                                                {{ !empty($store->branch) ? $store->branch->name : '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.phone_number')">

                                                                {{ $store->phone_number }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.email')">

                                                                {{ $store->email }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.manager_name')">

                                                                {{ $store->manager_name }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.manager_mobile_number')">

                                                                {{ $store->manager_mobile_number }}
                                                            </span>
                                                        </td>
                                                        <td class="no-print">
                                                            <div class="btn-group">
                                                                <button type="button"
                                                                    class="btn btn-default btn-sm dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    aria-expanded="false">خيارات
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                    user="menu" x-placement="bottom-end"
                                                                    style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                    <li>
                                                                        <a data-href="{{ route('store.edit', $store->id) }}"
                                                                            data-container=".view_modal"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                                class="dripicons-document-edit"></i>
                                                                            @lang('lang.edit')</a>
                                                                    </li>

                                                                    <li>
                                                                        <a data-href="{{ route('store.destroy', $store->id) }}"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif delete_item text-red delete_item"><i
                                                                                class="fa fa-trash"></i>
                                                                            @lang('lang.delete')</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('store.create')

@endsection
<div class="view_modal no-print"></div>
@push('javascripts')
    <script>
        // +++++++++++++++++++++++++++++++++ branches and stores filter +++++++++++++++++++++++++++++++++
        $('#branch_id').change(function(event) {
            var idBranch = this.value;
            // alert(idSubcategory1);
            $('#store_id').html('');
            $.ajax({
                url: "/api/fetch_branch_stores",
                type: 'POST',
                dataType: 'json',
                data: {
                    branch_id: idBranch,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    $('#store_id').html('<option value="">{{ __('lang.store') }}</option>');
                    // $.each(response.branch_id,function(index, val)
                    $.each(response.store_id, function(index, val) {
                        console.log("id = " + val.id, "value = " + val.name);
                        $('#store_id').append('<option value="' + val.id + '">' + val.name +
                            '</option>')
                    });
                },
                error: function(error) {
                    console.error("Error fetching filtered stores:", error);
                }
            })
        });
    </script>
@endpush
