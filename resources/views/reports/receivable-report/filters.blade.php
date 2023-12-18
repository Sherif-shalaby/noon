<div class="card-body">
    <form action="{{ route('products.index') }}" method="get">
        <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {{-- +++++++++++++++ payers filter +++++++++++++++ --}}
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                {!! Form::label('payer_id', __('lang.payer'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('payer_id', $payers, null, [
                        'class' => 'form-control select2 payers',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'store_id',
                    ]) !!}
                </div>
            </div>
            {{-- +++++++++++++++++++ receivers filter ++++++++++++++++++++ --}}
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                {!! Form::label('receiver_id', __('lang.receiver'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('receiver_id', $receivers, request()->receiver_id, [
                        'class' => 'form-control select2 receivers',
                        'placeholder' => __('lang.please_select'),
                        'data-live-search' => 'true',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ stores_pos filter ++++++++++++++++++++ --}}
            {{-- <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('store_pos_id', __('lang.pos'), []) !!}
                    {!! Form::select('store_pos_id', $store_pos, request()->store_pos_id, ['class' =>
                    'form-control select2 stores_pos', 'placeholder' => __('lang.please_select'),'data-live-search'=>"true"]) !!}
                </div>
            </div> --}}
            {{-- +++++++++++++++ start_date filter +++++++++++++++ --}}
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
            {{-- ++++++++++++++++++ "filter" and "clear filters" button ++++++++++++++++++ --}}
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                {{-- ======= "filter" button ======= --}}
                <button type="button" id="filter_btn" class="btn btn-primary mt-2" title="search">
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
                    payer_filter: $('body').find('.payers').val(),
                    receiver_filter: $('body').find('.receivers').val(),
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
                    $.each(response, function(index, cash_register_transaction) {
                        // "created_at" in this format "YYYY-MM-DD"
                        var created_at = new Date(cash_register_transaction.created_at);
                        var formattedDate = created_at.toLocaleDateString('en-CA');

                        var row = '<tr>' +
                            '<td>' + (formattedDate ?? "") + '</td>' +
                            // <!-- Accessing the cash_register relationship to get the user's cash_register_id -->
                            '<td>' + (cash_register_transaction.cash_register.cashier
                                .name ?? "") + '</td>' +
                            '<td>' + (cash_register_transaction.amount ?? "") + '</td>' +
                            // <!-- Accessing the cash_register relationship to get the user_id -->
                            '<td>' + (cash_register_transaction.cash_register.store_pos
                                .name ?? "") + '</td>' +
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
