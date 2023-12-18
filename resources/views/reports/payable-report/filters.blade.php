<div class="card-body">
    {{-- <form action="{{route('products.index')}}" method="get"> --}}
    <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

        {{-- ++++++++++++++ start_date filter +++++++++++++++ --}}
        <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.1s">

            {!! Form::label('from', __('site.From'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::datetimeLocal('from', null, [
                'class' => 'form-control mt-0 initial-balance-input width-full start_date w-100',
            ]) !!}

        </div>
        {{-- +++++++++++++++ end_date filter +++++++++++++++ --}}
        <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.1s">

            {!! Form::label('to', __('site.To'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::datetimeLocal('to', null, [
                'class' => 'form-control mt-0 initial-balance-input width-full end_date w-100',
            ]) !!}

        </div>
        {{-- ++++++++++++++++++++ branches filter ++++++++++++++++++++ --}}
        <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.1s">
            {!! Form::label('branch_id', __('lang.branch'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper">
                {!! Form::select('branch_id', $branches, null, [
                    'class' => 'form-control select2',
                    'placeholder' => __('lang.please_select'),
                    'id' => 'branch_id',
                ]) !!}
            </div>
        </div>
        {{-- ++++++++++++++++++++ stores filter ++++++++++++++++++++ --}}
        <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.1s">

            {!! Form::label('store_id', __('lang.store'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper">

                {!! Form::select('store_id', [], null, [
                    'class' => 'form-control select2 store',
                    'placeholder' => __('lang.please_select'),
                    'id' => 'store_id',
                ]) !!}
            </div>

        </div>

        {{-- ++++++++++++++++++ "filter" and "clear filters" button ++++++++++++++++++ --}}
        <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.1s">
            {{-- ======= "filter" button ======= --}}
            <button type="button" id="filter_btn" class="btn btn-primary mt-4" title="search">
                <i class="fa fa-eye"></i> {{ __('lang.filter') }}
            </button>
        </div>
    </div>
    {{-- </form> --}}

</div>
<script>
    $(document).ready(function() {
        // ======================== Receivable Report Table ========================
        // +++++++++++++++ updateSubcategories() +++++++++++++++
        function updateSubcategories() {
            $.ajax({
                method: "get",
                url: "{{ route('payable-report.index') }}",
                data: {
                    start_date: $('body').find('.start_date').val(),
                    end_date: $('body').find('.end_date').val(),
                    store_filter: $('body').find('.store').val(),
                },
                success: function(response) {
                    console.log("The Response Data : ");
                    console.log(response);
                    // Clear existing table content
                    $('#datatable-buttons tbody').empty();
                    // +++++++++++++++++++++++++ table content according to filters +++++++++++++++++++++++++++
                    console.log("Wage Transactions Total: ", response
                        .wage_transactions_final_total);
                    console.log("Stock Transactions Total: ", response
                        .stock_transactions_final_total);
                    var row = '<tr>' +
                        '<td><b>@lang('lang.wages')</b></td>' +
                        '<td>' + (response.wage_transactions_final_total !== undefined ? response
                            .wage_transactions_final_total : '') + '</td>' +
                        '<td>';
                    if (response.wage_transactions_final_total !== '') {
                        // Only append the actions if wage_transactions_final_total is defined
                        row +=
                            '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '{{ __('lang.action') }}' +
                            '<span class="caret"></span>' +
                            '</button>' +
                            '<ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">' +
                            '<li>' +
                            '<a href="{{ route('wages.index') }}" class="btn" target="_blank">' +
                            '<i class="fa fa-eye"></i>' +
                            '{{ __('lang.view') }}' +
                            '</a>' +
                            '</li>' +
                            '</ul>';
                    }
                    row += '</td>' +
                        '</tr>';
                    row += '<tr>' +
                        '<td><b>@lang('lang.stock')</b></td>' +
                        '<td>' + (response.stock_transactions_final_total !== undefined ? response
                            .stock_transactions_final_total : '') + '</td>' +
                        '<td>';
                    if (response.stock_transactions_final_total !== '') {
                        // Only append the actions if stock_transactions_final_total is defined
                        row +=
                            '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '{{ __('lang.action') }}' +
                            '<span class="caret"></span>' +
                            '</button>' +
                            '<ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">' +
                            '<li>' +
                            '<a href="{{ route('stocks.index') }}" class="btn" target="_blank">' +
                            '<i class="fa fa-eye"></i>' +
                            '{{ __('lang.view') }}' +
                            '</a>' +
                            '</li>' +
                            '</ul>';
                    }
                    row += '</td>' +
                        '</tr>';
                    row += '<tr>' +
                        '<td>' +
                        '<b>@lang('lang.total')</b>' +
                        '</td>';
                    if (response.wage_transactions_final_total !== '' || response
                        .stock_transactions_final_total !== '') {
                        row += '<td>' + (response.wage_transactions_final_total + response
                            .stock_transactions_final_total) + '</td>';
                    }
                    row += '<td>' + '</td>' +
                        '</tr>';

                    $('#datatable-buttons tbody').append(row);
                },
                error: function(error) {
                    console.error("Error fetching filtered products:", error);
                }
            });
        }
        // when clicking on "filter button" , call "updateSubcategories()" method
        $('#filter_btn').click(function() {
            updateSubcategories();
        });
        // +++++++++++++++++++++++++++++++++ subcategory1 filter +++++++++++++++++++++++++++++++++
        $('#branch_id').change(function(event) {
            var idBranch = this.value;
            // alert(idSubcategory1);
            $('#store_id').html('');
            $.ajax({
                url: "/api/fetch_branch_stores",
                type: 'POST',
                dataType: 'json',
                data: {
                    branch_id: idBranch,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    $('#store_id').html(
                        '<option value="10">{{ __('lang.please_select') }}</option>');
                    $.each(response.branch_id, function(index, val) {
                        console.log(val);
                        $('#store_id').append('<option value="' + val.id + '">' +
                            val.name + '</option>')
                    });
                },
                error: function(error) {
                    console.error("Error fetching filtered stores:", error);
                }

            })
        });
    });
</script>
