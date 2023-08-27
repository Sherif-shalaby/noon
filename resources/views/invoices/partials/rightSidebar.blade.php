<div class="col-xl-3">
    <div class="card-app">
        <div class="d-flex  align-items-center   mt-1 body-card-app pt-2">
            <input type="text" wire:model.defer="client_phone" id=""
                   class="form-control w-60" placeholder="{{ __('بحث برقم العميل') }}">
            <input readonly type="text" class="{{ $client ? '' : 'd-none' }} form-control w-25"
                   value="{{ $client?->name }}">
            <button wire:click='getClient'
                    class="btn btn-sm btn-primary">{{ __('Search') }}</button>
        </div>
        <div class="mb-1 body-card-app pt-2" wire:ignore>
            <label for="" class="text-primary">العملاء</label>
            <select class="form-control client" wire:model="client_id">
                <option  value="0 " readonly selected >اختر </option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
            @error('client_id')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="title-card-app text-start mt-3">
            الاجماليات
        </div>
        <div class="body-card-app pt-2">
            <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                <label for="" class="text-primary">
                    مبلغ الفاتورة:
                </label>
                <input readonly type="number" id="" class="form-control  w-50"
                       value="{{ $price }}">
            </div>
            <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                <label for="" class="text-primary">
                    الخصم:
                </label>
                <input type="number" class="form-control w-50" wire:model="discount" wire:change="changeTotal" >
            </div>
            <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                <label for="" class="text-primary">
                    الاجمالي بعد الخصم:
                </label>
                <input type="number" class="form-control w-50" readonly wire:model="total_after_discount">
            </div>
            <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                <label for="" class="text-primary">
                    الضريبة:
                </label>
                <input type="number" name="" id="" value="0.00"
                       class="form-control w-50">
            </div>
            <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                <label for="" class="text-danger">
                    الاجمالي النهائي:
                </label>
                <input type="number" id="" readonly class="form-control text-danger w-50" wire:model="total">
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
                                    class="btn btn-success payment-btn" data-toggle="modal" data-target="#add-payment"  wire:click="showModal" data-backdrop="static" data-keyboard="false"
                                    id="cash-btn" ><i class="fa-solid fa-money-bill"></i>
                                @lang('lang.pay')</button>
                            @include('invoices.partials.payment')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
