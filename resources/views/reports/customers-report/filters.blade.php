<form action="{{ route('customers-report.index') }}">
    <div class="row pb-3">
        {{-- ++++++++++++++ start_date filter ++++++++++++++ --}}
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('start_date', __('lang.start_date'), []) !!}
                {!! Form::date('start_date', request()->start_date, ['class' => 'form-control sale_filter']) !!}
            </div>
        </div>
        {{-- ++++++++++++++ start_time filter ++++++++++++++ --}}
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('start_time', __('lang.start_time'), []) !!}
                {!! Form::time('start_time', request()->start_time, [
                    'class' => 'form-control sale_filter
                                    time_picker sale_filter',
                ]) !!}
            </div>
        </div>
        {{-- ++++++++++++++ end_date filter ++++++++++++++ --}}
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('end_date', __('lang.end_date'), []) !!}
                {!! Form::date('end_date', request()->end_date, ['class' => 'form-control sale_filter']) !!}
            </div>
        </div>
        {{-- ++++++++++++++ end_time filter ++++++++++++++ --}}
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('end_time', __('lang.end_time'), []) !!}
                {!! Form::time('end_time', request()->end_time, [
                    'class' => 'form-control sale_filter time_picker
                                    sale_filter',
                ]) !!}
            </div>
        </div>
        {{-- ++++++++++++++ customers filter ++++++++++++++ --}}
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('customer_id', __('lang.customer'), []) !!}
                {!! Form::select('customer_id', $customers, request()->customer_id, [
                    'class' => 'form-control select2 sale_filter',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('store_id', __('lang.store'), []) !!}
                {!! Form::select('store_id', $stores, request()->store_id, [
                    'class' => 'form-control select2 sale_filter',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('pos_id', __('lang.pos'), []) !!}
                {!! Form::select('pos_id', $store_pos, request()->pos_id, [
                    'class' => 'form-control select2 sale_filter',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('product_id', __('lang.product'), []) !!}
                {!! Form::select('product_id', $products, request()->product_id, [
                    'class' => 'form-control select2 sale_filter',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('created_by', __('lang.created_by'), []) !!}
                {!! Form::select('created_by', $users, request()->created_by, [
                    'class' => 'form-control select2',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('payment_status', __('lang.payment_status'), []) !!}
                {!! Form::select('payment_status', $payment_status_array, request()->payment_status, [
                    'class' => 'form-control select2',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>
        <div class="col-md-2 pt-4">
            <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
        </div>
    </div>
</form>
