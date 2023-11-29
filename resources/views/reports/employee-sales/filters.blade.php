<form action="{{ route('sales-per-employee.index') }}">
    <div class="row pb-3">
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('start_date', __('lang.start_date'), []) !!}
                {!! Form::date('start_date', request()->start_date, ['class' => 'form-control sale_filter']) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('start_time', __('lang.start_time'), []) !!}
                {!! Form::time('start_time', request()->start_time, [
                    'class' => 'form-control sale_filter
                                    time_picker sale_filter',
                ]) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('end_date', __('lang.end_date'), []) !!}
                {!! Form::date('end_date', request()->end_date, ['class' => 'form-control sale_filter']) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('end_time', __('lang.end_time'), []) !!}
                {!! Form::time('end_time', request()->end_time, [
                    'class' => 'form-control sale_filter time_picker
                                    sale_filter',
                ]) !!}
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('employee_id', __('lang.employee'), []) !!}
                {!! Form::select('employee_id', $employees, request()->employee_id, [
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
