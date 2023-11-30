<div class="card-body">
    <form action="{{ route('reports.daily_sales_report') }}" method="get">
        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">

                {!! Form::label('branch_id', __('lang.branch'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('branch_id', $branches, request()->branch_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'branch_id',
                    ]) !!}
                </div>
            </div>
            @php
                if (!empty(request()->branch_id)) {
                    $stores = \App\Models\Store::where('branch_id', request()->branch_id)->pluck('name', 'id');
                }
            @endphp
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">

                {!! Form::label('store_id', __('lang.store'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('store_id', $stores, request()->store_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'store_id',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-center justify-content-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.2s">
                <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                    <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>

            </div>
        </div>
    </form>
</div>
