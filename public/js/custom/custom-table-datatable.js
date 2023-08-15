/*
---------------------------------------
    : Custom - Table Datatable js :
---------------------------------------
*/
"use strict";
$(document).ready(function() {
    /* -- Table - Datatable -- */
    $('#datatable').DataTable({
        responsive: true
    });
    $('#default-datatable').DataTable( {
        "order": [[ 3, "desc" ]],
        responsive: true,
    } );
    var table = $('#datatable-buttons').DataTable({
        // lengthChange: false,
        // responsive: true,
        dom: "<'row'<'col-md-3 'l><'col-md-5 text-center 'B><'col-md-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-4'p>>",
        lengthMenu: [10, 25, 50, 75, 100,200,300,400],
        pageLength: 10 ,
        buttons:
            ['copy', 'csv', 'excel', 'pdf',
            {
            extend: 'print',
            exportOptions: {columns: ":visible:not(.notexport)"}
            }
            // ,'colvis'
            ],


    });
    table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

});
