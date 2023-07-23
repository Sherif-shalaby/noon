$(document).on('click', '.add_date', function() {
    let index = $('#important_date_index').val();

    $('#important_date_index').val(index + 1);

    $.ajax({
        method: 'GET',
        url: '/customer/get-important-date-row',
        data: {
            index: index
        },
        success: function(result) {
            $('#important_date_table tbody').prepend(result);
            $( ".datepicker" ).datepicker({});
        },
    });
});
$(document).on("click", ".remove_row", function () {
    row_id = $(this).closest("tr").data("row_id");
    $(this).closest("tr").remove();
});