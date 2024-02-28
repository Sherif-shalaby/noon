<div class="card-body">

    <form action="{{ route('store_transfer.index') }}">
        <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-6 col-md-1 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column position-relative"
                style="animation-delay: 1.15s;z-index: 9999;">

                {!! Form::label('sender_store_id', __('lang.sender_store'), [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper w-100">
                    {!! Form::select('sender_store_id', $stores, null, [
                        'class' => 'selectpicker form-control',
                        'data-live-search' => 'true',
                        'style' => 'width: 80%',
                        'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-md-1 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column position-relative"
                style="animation-delay: 1.15s;z-index: 9999;">

                {!! Form::label('receiver_store_id', __('lang.receiver_store'), [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper w-100">
                    {!! Form::select('receiver_store_id', $stores, null, [
                        'class' => 'selectpicker form-control',
                        'data-live-search' => 'true',
                        'style' => 'width: 80%',
                        'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>

            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">

                {!! Form::label('start_date', __('lang.start_date'), [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper w-100">
                    {!! Form::text('start_date', request()->start_date, [
                        'class' => 'form-control m-0 initial-balance-input width-full',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">

                {!! Form::label('start_time', __('lang.start_time'), [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper w-100">
                    {!! Form::text('start_time', request()->start_time, [
                        'class' => 'form-control m-0 initial-balance-input width-full time_picker sale_filter',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">

                {!! Form::label('end_date', __('lang.end_date'), [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper w-100">
                    {!! Form::text('end_date', request()->end_date, [
                        'class' => 'form-control m-0 initial-balance-input width-full',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">

                {!! Form::label('end_time', __('lang.end_time'), [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper w-100">
                    {!! Form::text('end_time', request()->end_time, [
                        'class' => 'form-control m-0 initial-balance-input width-full time_picker sale_filter',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-row-reverse"
                style="animation-delay: 1.15s">
                <button type="submit" name="submit" class="btn btn-primary px-1"
                    style="font-size: 14px;font-weight: 400" title="search">
                    <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
            </div>
        </div>
    </form>
</div>
