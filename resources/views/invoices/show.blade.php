@extends('layouts.app')
@section('title', __('site.show_invoice'))
@push('css')

@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('site.show_invoice')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('site.show_invoice')</li>
                    </ol>
                </div>
            </div>

        </div>
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
