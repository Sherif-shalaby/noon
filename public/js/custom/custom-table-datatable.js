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
        dom: '<"top"lB><"bottom"frtip>',
        lengthMenu: [10, 25, 50, 75, 100,200,300,400],
        pageLength: 10 ,
        buttons:
            ['copy', 'csv', 'excel', 'pdf',
            {
            extend: 'print',
            exportOptions: {
                columns: ":visible:not(.notexport)"
            }
        }],
        
       
    });
    table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-12:eq(0)');

});
