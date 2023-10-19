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
                                <div class="row">
                                    {{-- +++++++++++++++ store filter +++++++++++++++ --}}
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {!! Form::label('store_id', __('lang.store'), []) !!}
                                            {!! Form::select('store_id', $stores, request()->store_id, ['class' =>
                                            'form-control', 'wire:model' => 'store_id', 'placeholder' => __('lang.please_select'),'data-live-search'=>"true"]) !!}
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++++ customer filter ++++++++++++++++++++++ --}}
                                    <div class="col-md-2" wire:ignore>
                                        <label for="customer_id" class="text-primary">@lang('lang.customers')</label>
                                        <div class="d-flex justify-content-center">
                                            <select class="form-control client" wire:model="customer_id" id="Client_Select">
                                                <option  value="0 " readonly selected > {{ __('lang.please_select') }} </option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++ start_date filter +++++++++++++++ --}}
                                    <div class="col-2">
                                        <div class="d-flex align-items-center gap-2 flex-wrap flex-lg-nowrap">
                                            <div class=" w-100">
                                                <label for="" class="small-label">{{ __('site.From') }}</label>
                                                <input type="date" class="form-control w-100" wire:model="from">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++ end_date filter +++++++++++++++ --}}
                                    <div class="col-2">
                                        <div class="d-flex align-items-center gap-2 flex-wrap flex-lg-nowrap">
                                            <div class="w-100">
                                                <label for="" class="small-label">{{ __('site.To') }}</label>
                                                <input type="date" class="form-control w-100" wire:model="to">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++ clear_filter Button +++++++++++++++ --}}
                                    <div class="col-md-2">
                                        <br>
                                        <a href="{{route('customer_price_offer.index')}}" class="btn btn-danger mt-2 ml-0">@lang('lang.clear_filters')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- ++++++++++++++++++++++++++++++ Table +++++++++++++++++++++++ --}}
                <div class="card-body">
                    @if (@isset($customer_offer_prices) && !@empty($customer_offer_prices) && count($customer_offer_prices) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
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
                                    @foreach($customer_offer_prices as $offer)
                                        <tr>
                                            <td>{{@format_date($offer->created_at)}}</td>
                                            <td>{{ucfirst($offer->created_by_user->name ?? '')}}</td>
                                            <td>@if(!empty($offer->customer)){{$offer->customer->name}}@endif</td>
                                            <td>{{ucfirst($offer->store->name ?? '')}}</td>
                                            <td>@if(!empty($offer->block_qty)) @lang('lang.blocked') @else @lang('lang.not_blocked')@endif</td>
                                            <td>{{ucfirst($offer->status)}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        {{-- ++++++++++++++ edit button ++++++++++++++ --}}
                                                        <li>
                                                            <a href="{{ route('customer_price_offer.edit', $offer->id) }}" class="btn"><i
                                                                class="dripicons-document-edit"></i> @lang('lang.edit')</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                            {{-- ++++++++++++++ delete button ++++++++++++++ --}}
                                                            <form method="POST" action="{{ route('customer_price_offer.destroy', $offer->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn text-red">
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
                        <div class="alert alert-danger">
                            {{ __('data_no_found') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

