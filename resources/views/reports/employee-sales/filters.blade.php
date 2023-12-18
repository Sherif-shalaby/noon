<form action="{{ route('sales-per-employee.index') }}">
    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.1s">

            {!! Form::label('start_date', __('lang.start_date'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::date('start_date', request()->start_date, [
                'class' => 'form-control mt-0 initial-balance-input width-full sale_filter',
            ]) !!}

        </div>
        <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.15s">

            {!! Form::label('start_time', __('lang.start_time'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::time('start_time', request()->start_time, [
                'class' => 'form-control sale_filter time_picker mt-0 initial-balance-input width-full sale_filter',
            ]) !!}

        </div>
        <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.2s">

            {!! Form::label('end_date', __('lang.end_date'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::date('end_date', request()->end_date, [
                'class' => 'form-control mt-0 initial-balance-input width-full sale_filter',
            ]) !!}

        </div>
        <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.25s">

            {!! Form::label('end_time', __('lang.end_time'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::time('end_time', request()->end_time, [
                'class' => 'form-control mt-0 initial-balance-input width-full sale_filter time_picker sale_filter',
            ]) !!}

        </div>

        <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.3s">

            {!! Form::label('employee_id', __('lang.employee'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper">
                {!! Form::select('employee_id', $employees, request()->employee_id, [
                    'class' => 'form-control select2',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>

        <div class="col-4 col-md-2 mb-2 d-flex align-items-end justify-content-center animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.35s">
            <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
        </div>
    </div>
</form>
