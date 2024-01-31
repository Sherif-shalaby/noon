@extends('layouts.app')
@section('title', __('site.show_invoice'))

@section('page_title')
    @lang('site.show_invoice')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('site.show_invoice')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createBrandModal">
            @lang('lang.add_brand_name')
        </button>
    </div>
@endsection

@section('content')
    @livewire('invoices.show', ['id' => $id])
@endsection
{{-- @push('js')
    <script>
        // print
        if (document.getElementById("prt-content")) {
            var btnPrtContent = document.getElementById("btn-prt-content");
            btnPrtContent.addEventListener("click", printDiv);

            function printDiv() {
                var prtContent = document.getElementById("prt-content");
                newWin = window.open("");
                newWin.document.head.replaceWith(document.head.cloneNode(true));
                newWin.document.body.appendChild(prtContent.cloneNode(true));
                setTimeout(() => {
                    newWin.print();
                    newWin.close();
                }, 600);
            }
        }
    </script>
@endpush --}}
