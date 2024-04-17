<form action="{{route('store_transfer.index')}}">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('sender_store_id', __('lang.sender_store'). ':', []) !!}
                {!! Form::select('sender_store_id', $stores,
                null, ['class' => 'selectpicker form-control', 'data-live-search'=>"true",
                'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('receiver_store_id', __('lang.receiver_store'). ':', []) !!}
                {!! Form::select('receiver_store_id', $stores,
                null, ['class' => 'selectpicker form-control', 'data-live-search'=>"true",
                'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('start_date', __('lang.start_date'), []) !!}
                {!! Form::text('start_date', request()->start_date, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('start_time', __('lang.start_time'), []) !!}
                {!! Form::text('start_time', request()->start_time, ['class' => 'form-control time_picker sale_filter']) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('end_date', __('lang.end_date'), []) !!}
                {!! Form::text('end_date', request()->end_date, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('end_time', __('lang.end_time'), []) !!}
                {!! Form::text('end_time', request()->end_time, ['class' => 'form-control time_picker sale_filter']) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                    <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
            </div>
        </div>
    </div>
</form>
