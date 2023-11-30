<div class="card-body">
    {{-- <form action="{{route('products.index')}}" method="get"> --}}
    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">


        {{-- +++++++++++++++ stores filter +++++++++++++++ --}}
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.1s">
            {!! Form::label('store_id', __('lang.store'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper">
                {!! Form::select('store_id', $stores, null, [
                    'class' => 'form-control select2 stores',
                    'placeholder' => __('lang.please_select'),
                    'id' => 'store_id',
                ]) !!}
            </div>
        </div>
        {{-- ++++++++++++++++++++ products filter ++++++++++++++++++++ --}}
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.25s">
            {!! Form::label('product_id', __('lang.product'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper">

                {!! Form::select('product_id', $products, request()->product_id, [
                    'class' => 'form-control select2 products',
                    'placeholder' => __('lang.please_select'),
                    'data-live-search' => 'true',
                ]) !!}
            </div>
        </div>
        {{-- ++++++++++++++++++++ suppliers filter ++++++++++++++++++++ --}}
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.3s">
            {!! Form::label('supplier_id', __('lang.supplier'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="input-wrapper">

                {!! Form::select('supplier_id', $suppliers, request()->supplier_id, [
                    'class' => 'form-control select2 suppliers',
                    'placeholder' => __('lang.please_select'),
                    'data-live-search' => 'true',
                ]) !!}
            </div>
        </div>
        {{-- +++++++++++++++ start_date filter +++++++++++++++ --}}
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.15s">
            {!! Form::label('from', __('site.From'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::datetimeLocal('from', null, [
                'class' => 'form-control initial-balance-input width-full start_date',
            ]) !!}
        </div>
        {{-- +++++++++++++++ end_date filter +++++++++++++++ --}}
        <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.2s">
            {!! Form::label('to', __('site.To'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::datetimeLocal('to', null, [
                'class' => 'form-control  mt-0 initial-balance-input width-full end_date',
            ]) !!}
        </div>
        {{-- ++++++++++++++++++++ stores_pos filter ++++++++++++++++++++ --}}
        {{-- <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('store_pos_id', __('lang.pos'), []) !!}
                    {!! Form::select('store_pos_id', $store_pos, request()->store_pos_id, ['class' =>
                    'form-control select2 stores_pos', 'placeholder' => __('lang.please_select'),'data-live-search'=>"true"]) !!}
                </div>
            </div> --}}

        {{-- ++++++++++++++++++ "filter" and "clear filters" button ++++++++++++++++++ --}}
        <div class="col-md-2 mb-2 d-flex align-items-end justify-content-center animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.35s">
            {{-- ======= "filter" button ======= --}}
            <button type="button" id="filter_btn" class="btn btn-primary" title="search">
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
        // Function to update subcategories based on the selected category ID
        function updateSubcategories() {
            $.ajax({
                method: "get",
                url: "{{ route('payable-report.index') }}",
                // get "all inputFields of form that have name and value"
                data: {
                    store_id: $('body').find('.stores').val(),
                    product_id: $('body').find('.products').val(),
                    supplier_id: $('body').find('.suppliers').val(),
                    // store_pos_id    : $('body').find('.stores_pos').val(),
                    start_date: $('body').find('.start_date').val(),
                    end_date: $('body').find('.end_date').val(),
                },
                success: function(response) {
                    console.log("The Response Data : ");
                    console.log(response)
                    // Clear existing table content
                    $('#datatable-buttons tbody').empty();
                    // +++++++++++++++++++++++++ table content according to filters +++++++++++++++++++++++++++
                    // Assuming response.products is the array of products received from the server response
                    $.each(response, function(index, transactions_stock_line) {
                        // "created_at" in this format "YYYY-MM-DD"
                        var created_at = new Date(transactions_stock_line.created_at)
                            .toLocaleString('en-CA', {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: false
                            });
                        var row = '<tr>' +
                            '<td>' + (transactions_stock_line.invoice_no ?
                                transactions_stock_line.invoice_no : '') + '</td>' +
                            '<td>' + (created_at ? created_at : '') + '</td>' +
                            '<td>' + (transactions_stock_line.supplier ?
                                transactions_stock_line.supplier.name : '') + '</td>' +
                            // '<td>' + (transactions_stock_line.paying_currency_relationship.symbol ? transactions_stock_line.paying_currency_relationship.symbol  : '') + '</td>' +
                            '<td>' + (transactions_stock_line.final_total ?
                                transactions_stock_line.final_total : '') + '</td>' +
                            '<td>' + (transactions_stock_line.created_by_relationship.name ?
                                transactions_stock_line.created_by_relationship.name : '') +
                            '</td>' +
                            '</tr>';
                        $('#datatable-buttons tbody').append(row);
                    });

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
    });
</script>
