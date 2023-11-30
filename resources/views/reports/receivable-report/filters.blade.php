<div class="card-body">
    <form action="{{ route('products.index') }}" method="get">
        <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {{-- +++++++++++++++ store filter +++++++++++++++ --}}
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
            {{-- ++++++++++++++++++++ customer filter ++++++++++++++++++++ --}}
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                {!! Form::label('customer_id', __('lang.customer'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">

                    {!! Form::select('customer_id', $customers, request()->customer_id, [
                        'class' => 'form-control select2 customers',
                        'placeholder' => __('lang.please_select'),
                        'data-live-search' => 'true',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ stores_pos filter ++++++++++++++++++++ --}}
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.2s">
                {!! Form::label('store_pos_id', __('lang.pos'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">

                    {!! Form::select('store_pos_id', $store_pos, request()->store_pos_id, [
                        'class' => 'form-control select2 stores_pos',
                        'placeholder' => __('lang.please_select'),
                        'data-live-search' => 'true',
                    ]) !!}
                </div>
            </div>
            {{-- +++++++++++++++ start_date filter +++++++++++++++ --}}
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.25s">
                {!! Form::label('from', __('site.From'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                {!! Form::datetimeLocal('from', null, [
                    'class' => 'form-control start_date  mt-0 initial-balance-input width-full',
                ]) !!}
            </div>
            {{-- +++++++++++++++ end_date filter +++++++++++++++ --}}
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.3s">
                {!! Form::label('to', __('site.To'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                {!! Form::datetimeLocal('to', null, ['class' => 'form-control end_date  mt-0 initial-balance-input width-full']) !!}
            </div>
            {{-- ++++++++++++++++++ "filter" and "clear filters" button ++++++++++++++++++ --}}
            <div class="col-md-2 mb-2 d-flex align-items-end justify-content-center animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.35s">
                {{-- ======= "filter" button ======= --}}
                <button type="button" id="filter_btn" class="btn btn-primary" title="search">
                    <i class="fa fa-eye"></i> {{ __('lang.filter') }}
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        // ======================== Receivable Report Table ========================
        // +++++++++++++++ updateSubcategories() +++++++++++++++
        // Function to update subcategories based on the selected category ID
        function updateSubcategories() {
            $.ajax({
                method: "get",
                url: "{{ route('receivable-report.index') }}",
                // get "all inputFields of form that have name and value"
                data: {
                    store_id: $('body').find('.stores').val(),
                    customer_id: $('body').find('.customers').val(),
                    store_pos_id: $('body').find('.stores_pos').val(),
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
                    $.each(response, function(index, transaction_sell_line) {
                        // "created_at" in this format "YYYY-MM-DD"
                        var created_at = new Date(transaction_sell_line.created_at)
                            .toLocaleDateString('en-CA');
                        var row = '<tr>' +
                            '<td>' + (created_at ? created_at : '') + '</td>' +
                            '<td>' + (transaction_sell_line.invoice_no ?
                                transaction_sell_line.invoice_no : '') + '</td>' +
                            '<td>' + (transaction_sell_line.customer ? transaction_sell_line
                                .customer.name : '') + '</td>' +
                            '<td>' + (transaction_sell_line.status ? transaction_sell_line
                                .status : '') + '</td>' +
                            '<td>' + (transaction_sell_line.payment_status ?
                                transaction_sell_line.payment_status : '') + '</td>' +
                            '<td>' + (transaction_sell_line.final_total ?
                                transaction_sell_line.final_total : '') + '</td>' +
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
