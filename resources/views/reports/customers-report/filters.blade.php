<form action="{{ route('customers-report.index') }}">
    <div class="row pb-3  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.1s">

            {!! Form::label('start_date', __('lang.start_date'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::date('start_date', request()->start_date, [
                'class' => 'form-control mt-0 initial-balance-input width-full sale_filter',
            ]) !!}

        </div>
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.15s">

            {!! Form::label('start_time', __('lang.start_time'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::time('start_time', request()->start_time, [
                'class' => 'form-control mt-0 initial-balance-input width-full sale_filter time_picker sale_filter',
            ]) !!}

        </div>
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.2s">

            {!! Form::label('end_date', __('lang.end_date'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::date('end_date', request()->end_date, [
                'class' => 'form-control mt-0 initial-balance-input width-full sale_filter',
            ]) !!}

        </div>
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.25s">

            {!! Form::label('end_time', __('lang.end_time'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::time('end_time', request()->end_time, [
                'class' => 'form-control mt-0 initial-balance-input width-full sale_filter time_picker sale_filter',
            ]) !!}

        </div>

        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.3s">

            {!! Form::label('customer_id', __('lang.customer'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper">
                {!! Form::select('customer_id', $customers, request()->customer_id, [
                    'class' => 'form-control select2 sale_filter',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.35s">

            {!! Form::label('store_id', __('lang.store'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper">
                {!! Form::select('store_id', $stores, request()->store_id, [
                    'class' => 'form-control select2 sale_filter',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.4s">

            {!! Form::label('pos_id', __('lang.pos'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper">
                {!! Form::select('pos_id', $store_pos, request()->pos_id, [
                    'class' => 'form-control select2 sale_filter',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.45s">

            {!! Form::label('product_id', __('lang.product'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper">
                {!! Form::select('product_id', $products, request()->product_id, [
                    'class' => 'form-control select2 sale_filter',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.5s">

            {!! Form::label('created_by', __('lang.created_by'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper">
                {!! Form::select('created_by', $users, request()->created_by, [
                    'class' => 'form-control select2',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.55s">

            {!! Form::label('payment_status', __('lang.payment_status'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper">
                {!! Form::select('payment_status', $payment_status_array, request()->payment_status, [
                    'class' => 'form-control select2',
                    'placeholder' => __('lang.all'),
                ]) !!}
            </div>
        </div>
        <div class="col-md-2 mb-2 d-flex align-items-center justify-content-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.6s ">
            <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
        </div>
    </div>
</form>
