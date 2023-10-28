@extends('layouts.app')
@section('title', __('site.show_invoice'))
@push('css')
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('site.show_invoice')
                </h4>
                <div class="breadcrumb-list">
                    <ul
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif">
                            <a style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">
                                / @lang('lang.dashboard')
                            </a>
                        </li>
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                            aria-current="page">@lang('site.show_invoice')</li>
                    </ul>
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
