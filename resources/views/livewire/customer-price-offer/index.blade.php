<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <br>
                {{-- ++++++++++++++++++++++++++++++ Filters +++++++++++++++++++++++ --}}
                <div class="col-md-12 no-print">
                    <div class="card">
                        <div class="card-body">
                            <form action="">
                                <div
                                    class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {{-- +++++++++++++++ store filter +++++++++++++++ --}}
                                    <div
                                        class="col-md-2 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        {!! Form::label('store_id', __('lang.store'), [
                                            'class' => app()->isLocale('ar') ? 'd-block text-end h5  mx-2 mb-0 width-quarter' : 'h5  mx-2 mb-0 width-quarter',
                                            'style' => 'font-size: 12px;font-weight: 500;',
                                        ]) !!}
                                        <div class="input-wrapper">
                                            {!! Form::select('store_id', $stores, request()->store_id, [
                                                'class' => 'form-control width-full',
                                                'style' => 'height:100%',
                                                'wire:model' => 'store_id',
                                                'placeholder' => __('lang.please_select'),
                                                'data-live-search' => 'true',
                                            ]) !!}
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++++ customer filter ++++++++++++++++++++++ --}}
                                    <div class="col-md-2 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                        wire:ignore>
                                        <label
                                            class="mx-2 mb-0 width-fit @if (app()->isLocale('ar')) d-block text-end @endif"
                                            style="font-size: 12px;font-weight: 500;"
                                            for="customer_id">@lang('lang.customers')</label>
                                        <div class="input-wrapper">
                                            <select class="form-control client width-full" style="height: 100%"
                                                wire:model="customer_id" id="Client_Select">
                                                <option value="0 " readonly selected> {{ __('lang.please_select') }}
                                                </option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++ start_date filter +++++++++++++++ --}}
                                    <div
                                        class="col-2  mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                        <label for="" style="font-size: 12px;font-weight: 500;"
                                            class="mx-2 mb-0 width-fit @if (app()->isLocale('ar')) d-block text-end @endif">{{ __('site.From') }}</label>
                                        <input type="date" class="form-control initial-balance-input m-0"
                                            wire:model="from">

                                    </div>
                                    {{-- +++++++++++++++ end_date filter +++++++++++++++ --}}
                                    <div
                                        class="col-2 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                        <label style="font-size: 12px;font-weight: 500;" for=""
                                            class="small-label">{{ __('site.To') }}</label>
                                        <input type="date" class="form-control initial-balance-input m-0"
                                            wire:model="to">

                                    </div>
                                    {{-- +++++++++++++++ clear_filter Button +++++++++++++++ --}}
                                    <div
                                        class="col-md-2 d-flex align-items-center justify-content-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                        <a href="{{ route('customer_price_offer.index') }}"
                                            class="btn btn-danger">@lang('lang.clear_filters')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- ++++++++++++++++++++++++++++++ Table +++++++++++++++++++++++ --}}
                <div class="card-body">
                    @if (@isset($customer_offer_prices) && !@empty($customer_offer_prices) && count($customer_offer_prices) > 0)
                        <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>@lang('lang.date')</th>
                                        {{-- <th>@lang('lang.reference')</th> --}}
                                        <th>@lang('lang.created_by')</th>
                                        <th>@lang('lang.customer')</th>
                                        <th>@lang('lang.store')</th>
                                        <th>@lang('lang.customer_offer_status')</th>
                                        <th>@lang('lang.quotation_status')</th>
                                        <th class="notexport">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer_offer_prices as $offer)
                                        <tr>
                                            <td>
                                                <span style="font-size: 12px;font-weight: 600;">
                                                    {{ @format_date($offer->created_at) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span style="font-size: 12px;font-weight: 600;">

                                                    {{ ucfirst($offer->created_by_user->name ?? '') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span style="font-size: 12px;font-weight: 600;">

                                                    @if (!empty($offer->customer))
                                                        {{ $offer->customer->name }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <span style="font-size: 12px;font-weight: 600;">

                                                    {{ ucfirst($offer->store->name ?? '') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span style="font-size: 12px;font-weight: 600;">

                                                    @if (!empty($offer->block_qty))
                                                        @lang('lang.blocked')
                                                    @else
                                                        @lang('lang.not_blocked')
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <span style="font-size: 12px;font-weight: 600;">

                                                    {{ ucfirst($offer->status) }}
                                                </span>
                                            </td>
                                            <td>

                                                <div class="btn-group">
                                                    <button type="button" style="font-size: 12px;font-weight: 600;"
                                                        class="btn btn-default btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">خيارات
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                        user="menu" x-placement="bottom-end"
                                                        style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        {{-- ++++++++++++++ edit button ++++++++++++++ --}}
                                                        <li>
                                                            <a href="{{ route('customer_price_offer.edit', $offer->id) }}"
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                    class="dripicons-document-edit"></i>
                                                                @lang('lang.edit')</a>
                                                        </li>
                                                        {{-- ++++++++++++++ create_invoice button ++++++++++++++ --}}
                                                        <li>
                                                            <a href="{{ route('invoices.edit', $offer->id) }}"
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                                <i class="dripicons-document-edit"></i>
                                                                @lang('lang.create_invoice')
                                                            </a>
                                                        </li>

                                                        {{-- ++++++++++++++ delete button ++++++++++++++ --}}
                                                        <form method="POST"
                                                            action="{{ route('customer_price_offer.destroy', $offer->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn width-full drop_down_item
                                                                 text-red">
                                                                @lang('lang.delete') <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <tfoot>
                                <tr>
                                    <th colspan="12">
                                        <div class="float-right">
                                            {!! $customer_offer_prices->appends(request()->all())->links() !!}
                                        </div>
                                    </th>
                                </tr>
                            </tfoot>
                        </div>
                    @else
                        <div class="alert alert-danger text-center">
                            {{ __('data_no_found') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
