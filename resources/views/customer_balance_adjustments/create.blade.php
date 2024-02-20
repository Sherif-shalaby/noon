@extends('layouts.app')
@section('title', __('lang.customer_balance_adjustment'))

@section('page_title')
    @lang('lang.customer_balance_adjustment')
@endsection

@section('breadcrumbs')
    @parent

    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
            href="{{ route('customers.index') }}">@lang('lang.customers')</a></li>
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.customer_balance_adjustment')</li>
@endsection

@section('button')
    <div class="widgetbar  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a type="button" class="btn btn-primary" href="{{ route('stocks.index') }}">@lang('lang.stock')</a>
    </div>
@endsection



@section('content')
    <div class="animate-in-page">

        <section class="forms">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h4>@lang('lang.customer_balance_adjustment')</h4>
                            </div>
                            {!! Form::open([
                                'url' => route('customer-balance-adjustment.store'),
                                'method' => 'post',
                                'id' => 'sms_form',
                                'files' => true,
                            ]) !!}
                            <div class="col-md-12">
                                {!! Form::hidden('customer_id', $customer->id, ['class' => 'form-control', 'id' => 'customer_id']) !!}
                                <div class="row">
                                    {{--                                <div class="col-md-4"> --}}
                                    {{--                                    <div class="form-group"> --}}
                                    {{--                                        {!! Form::label('store_id', __('lang.store'), []) !!} --}}
                                    {{--                                        {!! Form::text('store_id', $stores, false, ['class' => 'form-control --}}
                                    {{--                                        select', 'id' => 'store_id' ,'placeholder' => --}}
                                    {{--                                        __('lang.please_select'), 'required']) !!} --}}
                                    {{--                                    </div> --}}
                                    {{--                                </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('user_id', __('lang.cashier_man'), []) !!}
                                            {!! Form::select('user_id', $users, false, [
                                                'class' => 'form-control
                                                                                                                                                                                                                        select2',
                                                'id' => 'user_id',
                                                'placeholder' => __('lang.please_select'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('customer_id', __('lang.customer'), []) !!}
                                            {!! Form::text('customer_name', $customer->name, [
                                                'class' => 'form-control',
                                                'id' => 'customer_name',
                                                'readonly',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('current_balance', __('lang.current_balance'), []) !!}
                                            {!! Form::text('current_balance', $customer->balance, [
                                                'class' => 'form-control',
                                                'id' => 'current_balance',
                                                'placeholder' => __('lang.current_balance'),
                                                'readonly',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('add_new_balance', __('lang.add_new_balance'), []) !!}
                                            {!! Form::text('add_new_balance', null, [
                                                'class' => 'form-control',
                                                'id' => 'add_new_balance',
                                                'placeholder' => __('lang.add_new_balance'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('new_balance', __('lang.new_balance'), []) !!}
                                            {!! Form::text('new_balance', null, [
                                                'class' => 'form-control',
                                                'id' => 'new_balance',
                                                'placeholder' => __('lang.new_balance'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('current_balance', __('lang.current_dollar_balance') . ' $', []) !!}
                                            {!! Form::text('current_dollar_balance', $customer->dollar_balance, [
                                                'class' => 'form-control',
                                                'id' => 'current_dollar_balance',
                                                'placeholder' => __('lang.current_balance') . ' $',
                                                'readonly',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('add_new_balance', __('lang.add_new_balance') . ' $', []) !!}
                                            {!! Form::text('add_new_dollar_balance', null, [
                                                'class' => 'form-control',
                                                'id' => 'add_new_dollar_balance',
                                                'placeholder' => __('lang.add_new_balance'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('new_balance', __('lang.new_balance') . ' $', []) !!}
                                            {!! Form::text('new_dollar_balance', null, [
                                                'class' => 'form-control',
                                                'id' => 'new_dollar_balance',
                                                'placeholder' => __('lang.new_balance'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        {!! Form::label('notes', __('lang.notes'), []) !!}
                                        {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3]) !!}
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <button type="submit" name="submit" id="print" style="margin: 10px" value="save"
                                    class="btn btn-primary pull-right btn-flat submit">@lang('lang.save')</button>

                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@push('javascripts')
    <script type="text/javascript">
        // $(document).on('change', '#user_id', function(){
        //     let user_id = $(this).val();
        //
        //     $.ajax({
        //         method: 'get',
        //         url: '/cash-in-adjustment/get-cash-details/'+user_id,
        //         data: {  },
        //         success: function(result) {
        //             if(result.store_id){
        //                 $('#store_id').val(result.store_id).selectpicker('refresh');
        //             }
        //             if(result.current_cash){
        //                 __write_number($('#current_cash'), result.current_cash);
        //             }
        //             if(result.cash_register_id){
        //                 $('#cash_register_id').val( result.cash_register_id);
        //             }
        //         },
        //     });
        // })
        $(document).on('change', '#add_new_balance', function() {
            let add_new_balance = __read_number($('#add_new_balance'));
            let current_balance = __read_number($('#current_balance'));

            let new_balance = add_new_balance + current_balance;

            __write_number($('#new_balance'), new_balance);

        });
        $(document).on('change', '#add_new_dollar_balance', function() {
            let add_new_balance = __read_number($('#add_new_dollar_balance'));
            let current_balance = __read_number($('#current_dollar_balance'));

            let new_balance = add_new_balance + current_balance;

            __write_number($('#new_dollar_balance'), new_balance);

        });
    </script>
@endpush
