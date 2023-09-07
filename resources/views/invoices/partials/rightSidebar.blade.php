<div class="col-xl-3">
    <div class="card-app">
        <div class="d-flex  align-items-center   mt-1 body-card-app pt-2">
            <input type="text" wire:model.defer="client_phone" id=""
                   class="form-control w-60" placeholder="{{ __('بحث برقم العميل') }}">
{{--            <input readonly type="text" class="{{ $client ? '' : 'd-none' }} form-control w-25"--}}
{{--                   value="{{ $client?->name }}">--}}
            <button wire:click='getClient'
                    class="btn btn-sm btn-primary">{{ __('Search') }}</button>
        </div>
        <div class="mb-1 body-card-app pt-2" wire:ignore>
            <label for="" class="text-primary">العملاء</label>
            <div class="d-flex justify-content-center">
                <select class="form-control client" wire:model="client_id" id="Client_Select" wire:change="refreshSelect">
                    <option  value="0 " readonly selected >اختر </option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-sm ml-2 text-white" style="background-color: #6e81dc;" data-toggle="modal" data-target="#add_customer"><i class="fas fa-plus"></i></button>
            </div>
            @error('client_id')<span class="text-danger">{{ $message }}</span>@enderror
            @include('customers.quick_add')
        </div>
        <div class="title-card-app text-start mt-3">
            الاجماليات
        </div>
        <div class="body-card-app pt-2">
            <div class="row ">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('dollar_grand_total','الاجمالي بالدولار', ['class' => 'text-primary']) !!}
                        {!! Form::number('dollar_grand_total', $total_dollar, ['class' => 'form-control', 'data-live-search' => 'true', 'readonly', 'placeholder' => __('lang.dollar_price'), 'wire:model' => 'total_dollar']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('grand_total', 'الاجمالي بالدينار', ['class' => 'text-primary']) !!}
                        {!! Form::number('grand_total', $total, ['class' => 'form-control', 'data-live-search' => 'true', 'readonly', 'placeholder' => __('lang.price'), 'wire:model' => 'total']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('dollar_discount', 'الخصم دولار', ['class' => 'text-primary']) !!}
                        {!! Form::number('dollar_discount', null,['class'=>'form-control','','wire:model' => 'discount_dollar','wire:change' => 'changeDollarTotal']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('discount', 'الخصم دينار', ['class' => 'text-primary']) !!}
                        {!! Form::number('discount', null,['class'=>'form-control','wire:model' => 'discount', 'wire:change' => 'changeTotal']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('dollar_final_total', 'النهائي دولار', ['class' => 'text-primary']) !!}
                        {!! Form::number('dollar_final_total', $dollar_final_total,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('final_total', 'النهائي دينار', ['class' => 'text-primary']) !!}
                        {!! Form::number('final_total', $final_total,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('dollar_amount', 'الواصل دولار', ['class' => 'text-primary']) !!}
                        {!! Form::number('dollar_amount', null,['class'=>'form-control','','wire:model' => 'dollar_amount']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('amount', 'الواصل دينار', ['class' => 'text-primary']) !!}
                        {!! Form::number('amount', null,['class'=>'form-control  ','','wire:model' => 'amount']) !!}
                    </div>
                </div>
            </div>
{{--            <div class="d-flex align-items-center gap-2 mb-2 justify-content-end">--}}
{{--                <label for="" class="text-primary">{{ __('كاش') }}:</label>--}}
{{--                <input type="number" class="form-control w-50" wire:model="cash" max="{{ $total }}">--}}
{{--            </div>--}}
{{--            <div class="d-flex align-items-center gap-2 mb-2 justify-content-end">--}}
{{--                <label for="" class="text-primary">--}}
{{--                    {{ __('المتبقى') }}--}}
{{--                </label>--}}
{{--                <input type="number" readonly class="form-control w-50" wire:model="rest">--}}
{{--            </div>--}}
            <div class="row hide-print">
                <div class="col-xl-4 me-auto">
                    <div class=" btns-control row my-3 row-gap-24">
                        <div class="col-sm-4">
                            <button data-method="cash" style="width: 78px" type="button"
                                    class="btn btn-success payment-btn"  wire:click="submit"
                                    id="cash-btn" ><i class="fa-solid fa-money-bill"></i>
                                @lang('lang.pay')</button>
{{--                            @include('invoices.partials.payment')--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
