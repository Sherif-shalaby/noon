<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('site.Invoices') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <div dir="ltr" class="d-flex align-items-center justify-content-end  ">
                                    <button id="button-addon2" type="button"
                                        class="btn btn-success rounded-0 input-group-addon">
                                        {{ __('site.search') }}
                                    </button>
                                    <input dir="rtl" type="text" class="form-control h-100"
                                        placeholder="{{ __('site.Search_by_invoice_number') }}"
                                        wire:model='searchinvoiveno'>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <div dir="ltr" class="d-flex align-items-center justify-content-end  ">
                                    <button id="button-addon2" type="button" class="btn btn-success input-group-addon">
                                        {{ __('site.search') }}
                                    </button>
                                    <input dir="rtl" type="text" class="form-control"
                                        placeholder="{{ __('site.Search_by_customer_name') }}"
                                        wire:model='searchemployee'>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <div class="d-flex align-items-center justify-content-end">
                                    <select name="" id="" wire:model='searchemployee'
                                        class=" form-control">
                                        <option value="">{{ __('site.Search_by_customer_name') }}</option>
                                        @foreach (\App\Models\User::get() as $user)
                                            <option value="{{ $user->name }}"> {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="d-flex align-items-end justify-content-between flex-wrap  mb-3">
                                <button class="btn btn-primary btn-sm mb-2 "
                                    wire:click="$set('filter_status','')">{{ __('site.all') }}
                                    {{ App\Models\Invoice::count() }}
                                </button>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
                                <button class="btn btn-success btn-sm mb-2 "
                                    wire:click="$set('filter_status','paid')">{{ __('site.paid') }}
                                    {{ App\Models\Invoice::where('status', 'paid')->count() }}</button>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
                                <button class="btn btn-danger btn-sm mb-2 "
                                    wire:click="$set('filter_status','unpaid')">{{ __('site.spoon') }}
                                    {{ App\Models\Invoice::where('status', 'unpaid')->count() }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3">
                            <div class="d-flex align-items-center gap-2 flex-wrap flex-lg-nowrap">
                                <div class=" w-100">
                                    <label for="" class="small-label">{{ __('site.From') }}</label>
                                    <input type="date" class="form-control w-100" wire:model="from">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex align-items-center gap-2 flex-wrap flex-lg-nowrap">
                                <div class="w-100">
                                    <label for="" class="small-label">{{ __('site.To') }}</label>
                                    <input type="date" class="form-control w-100" wire:model="to">
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (@isset($invoices) && !@empty($invoices) && count($invoices) > 0)

                        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div1"></div>
                        </div>
                        <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div2">
                                <!-- content goes here -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('site.invoice_number') }}</th>
                                                <th>{{ __('site.The_Employee') }}</th>
                                                <th>{{ __('site.Client') }}</th>
                                                <th>{{ __('site.Amount') }}</th>
                                                <th>{{ __('site.Tax') }}</th>
                                                <th>{{ __('site.Total') }}</th>
                                                <th>{{ __('site.Discount') }}</th>
                                                <th>{{ __('site.Cash') }}</th>
                                                <th>{{ __('site.rest') }}</th>
                                                <th>{{ __('site.Status') }}</th>
                                                <th>@lang('added_by')</th>
                                                <th>@lang('updated_by')</th>
                                                <th>{{ __('site.Control') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices as $index => $invoice)
                                                <tr>
                                                    <td>{{ $invoice->id }}</td>
                                                    <td>{{ $invoice->user?->name }}</td>
                                                    <td>{{ $invoice->customer ? $invoice->customer?->name : 'عميل نقدي' }}
                                                    </td>
                                                    <td>{{ $invoice->price }}</td>
                                                    <td>{{ $invoice->tax }}</td>
                                                    <td>{{ $invoice->total }}</td>
                                                    <td>{{ $invoice->discount }}</td>
                                                    <td>{{ $invoice->cash }}</td>
                                                    <td>{{ $invoice->rest }}</td>
                                                    <td>{{ __($invoice->status) }}</td>
                                                    <td>
                                                        @if ($invoice->user_id > 0 and $invoice->user_id != null)
                                                            {{ $invoice->created_at->diffForHumans() }} <br>
                                                            {{ $invoice->created_at->format('Y-m-d') }}
                                                            ({{ $invoice->created_at->format('h:i') }})
                                                            {{ $invoice->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                            <br>
                                                            {{ $invoice->createBy?->name }}
                                                        @else
                                                            {{ __('no_update') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($invoice->last_update > 0 and $invoice->last_update != null)
                                                            {{ $invoice->updated_at->diffForHumans() }} <br>
                                                            {{ $invoice->updated_at->format('Y-m-d') }}
                                                            ({{ $invoice->updated_at->format('h:i') }})
                                                            {{ $invoice->updated_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                            <br>
                                                            {{ $invoice->updateBy?->name }}
                                                        @else
                                                            {{ __('no_update') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @include('invoices.action')
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td>{{ __('site.The_Total') }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ $total }}</td>
                                                <td></td>
                                                <td>{{ $totalcash }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <tfoot>
                                        <tr>
                                            <th colspan="12">
                                                <div class="float-right">
                                                    {!! $invoices->appends(request()->all())->links() !!}
                                                </div>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </div>
                            </div>
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
