<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBrandModalLabel">{{__('lang.edit_customer_type')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => ['moneysafe.update',$moneysafe->id],'method'=>'put','id'=>'money-safe-update-form' ]) !!}
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group ">
                            <label for="name">@lang('lang.name') .*</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="hidden" name="id" value="{{$moneysafe->id}}"/>
                                <input type="text" required
                                       class="form-control"
                                       placeholder="@lang('lang.name')"
                                       name="name"
                                       value="{{$moneysafe->name}}" required >
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group">
                            <label for="store_id">@lang('lang.store') .*</label>
                            {!! Form::select(
                                'store_id',
                                $stores,$moneysafe->store_id,
                                ['class' => 'form-control select2 category','placeholder'=>__('lang.please_select'),'required']
                            ) !!}
                            @error('store_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            <label for="currency_id">@lang('lang.currency') .*</label>
                            {!! Form::select(
                                'currency_id',
                                !empty($settings['currency']) ? $selected_currencies:[],$moneysafe->currency_id,
                                ['class' => 'form-control select2 category','placeholder'=>__('lang.please_select'),'required']
                            ) !!}
                            @error('currency_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            {!! Form::label('type', __('lang.type_of_safe') . ':*') !!}
                            {!! Form::select('type', ['cash' => __('lang.cash'), 'later' => __('lang.later')]
                            , $moneysafe->type, ['class' => 'form-control select2', 'required', 'placeholder' => __('lang.please_select')]) !!}
                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror    
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
{!! JsValidator::formRequest('App\Http\Requests\MoneySafeUpdateRequest','#money-safe-update-form'); !!}
