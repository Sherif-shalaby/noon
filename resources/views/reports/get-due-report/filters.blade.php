<div class="card-body">
    <form action="{{ route('products.index') }}" method="get">
        <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                <div class="input-wrapper">
                    {!! Form::select('category_id', $categories, null, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.category'),
                    ]) !!}
                </div>
            </div>
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                <div class="input-wrapper">
                    {!! Form::select('store_id', $stores, null, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.store'),
                    ]) !!}
                </div>
            </div>
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                <div class="input-wrapper">
                    {!! Form::select('unit_id', $units, null, ['class' => 'form-control select2', 'placeholder' => __('lang.unit')]) !!}
                </div>
            </div>
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                <div class="input-wrapper">
                    {!! Form::select('brand_id', $brands, null, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.brand'),
                    ]) !!}
                </div>
            </div>
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                <div class="input-wrapper">
                    {!! Form::select('created_by', $users, null, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.created_by'),
                    ]) !!}
                </div>
            </div>
            {{-- <div class="col-2"></div> --}}
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                    <i class="fa fa-eye"></i> {{ __('Search') }}</button>
            </div>
        </div>
    </form>
</div>
