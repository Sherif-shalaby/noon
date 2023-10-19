<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBrandModalLabel">{{__('lang.add_to_money_safe')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => 'moneysafe.post-add-money-to-safe', 'method' => 'post', 'files' => true,'id' =>'safe-money-form' ]) !!}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" value="{{$money_safe_id}}" name="money_safe_id"/>
                            {!! Form::label('source_type', __('lang.source_type').'*', []) !!} <br>
                            {!! Form::select('source_type', ['user' => __('lang.user'), 'pos' => __('lang.pos'), 'store' => __('lang.store'), 'safe' => __('lang.safe')], null, ['class' => 'select2 form-control','placeholder' => __('lang.please_select'),'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('source_of_payment', __('lang.source_of_payment'), []) !!} <br>
                            {!! Form::select('source_id', $users, null, ['class' => 'select2 form-control', 'placeholder' => __('lang.please_select'), 'id' => 'source_id', 'required']) !!}
                        </div>
                        <div class="form-group">
                            <label for="store_id">@lang('lang.store') .*</label>
                            {!! Form::select(
                                'store_id',
                                $stores,null,
                                ['class' => 'form-control select2 category','placeholder'=>__('lang.please_select'),'required']
                            ) !!}
                            @error('store_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
{{--         
                        <div class="form-group">
                            <label for="currency_id">@lang('lang.currency') .*</label>
                            {!! Form::select(
                                'currency_id',
                                !empty($settings['currency']) ? $selected_currencies:$selected_currencies,null,
                                ['class' => 'form-control select2 category','placeholder'=>__('lang.please_select'),'required']
                            ) !!}
                            @error('currency_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}
                        <div class="form-group ">
                            <label for="amount">@lang('lang.amount') .* .{{$currency_symbol}} </label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="text" required
                                       class="form-control"
                                       placeholder="@lang('lang.amount')"
                                       name="amount"
                                       value="{{ old('amount') }}" required >
                                @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('job', __('lang.job')) !!}
                            {!! Form::select('job_type_id', $jobs
                            , null, ['class' => 'form-control select2', 'required', 'placeholder' => __('lang.please_select')]) !!}
                            @error('job_type_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror    
                        </div>
                        <div class="form-group">
                            <label for="transaction_date">@lang('lang.date')</label>
                            {!! Form::text('transaction_date', @format_date(date('Y-m-d')), ['class' => 'form-control datepicker', 'placeholder' => __('lang.date'),'required']) !!}
                        </div>
                        <div class="form-group ">
                            <label for="details">@lang('lang.details') .*</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="text"
                                       class="form-control"
                                       placeholder="@lang('lang.details')"
                                       name="details"
                                       value="{{ old('details') }}" >
                                @error('details')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('lang.close')}}</button>
                <button type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>