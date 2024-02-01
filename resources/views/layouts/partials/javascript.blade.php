{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> --}}
<!-- Core js -->
{{-- <script src="{{asset('js/core.js')}}"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script> --}}
<script>
    function toggleAccordion(sectionId) {
        const section = document.getElementById(sectionId);
        let arrow = document.querySelector(`.${sectionId}`);

        if (section.style.display === "block") {
            section.style.display = "none";

            // Check if the element exists
            if (arrow) {
                // Remove all children from the "wrap" element
                while (arrow.firstChild) {
                    arrow.removeChild(arrow.firstChild);
                }

                // Create a new <i> element with the desired attributes
                let newIElement = document.createElement('i');
                newIElement.className = 'fas fa-arrow-down';
                newIElement.style.fontSize = '0.8rem';

                // Append the new <i> element to the "wrap" element
                arrow.appendChild(newIElement);
            }
        } else {
            section.style.display = "block";

            // Check if the element exists
            if (arrow) {
                // Remove all children from the "wrap" element
                while (arrow.firstChild) {
                    arrow.removeChild(arrow.firstChild);
                }

                // Create a new <i> element with the desired attributes
                let newIElement = document.createElement('i');
                newIElement.className = 'fas fa-arrow-up';
                newIElement.style.fontSize = '0.8rem';

                // Append the new <i> element to the "wrap" element
                arrow.appendChild(newIElement);
            }
        }
    }

    function toggleProductAccordion(sectionId) {
        const section = document.getElementById(sectionId);
        let arrow = document.querySelector(`.${sectionId}`);

        if (section.style.display === "block") {
            section.style.display = "none";

            // Check if the element exists
            if (arrow) {
                // Remove all children from the "wrap" element
                while (arrow.firstChild) {
                    arrow.removeChild(arrow.firstChild);
                }

                // Create a new <i> element with the desired attributes
                let newIElement = document.createElement('i');
                newIElement.className = 'fas fa-arrow-left d-flex justify-content-center align-items-center';


                newIElement.style.fontSize = '0.8rem';
                newIElement.style.color = 'black';
                newIElement.style.backgroundColor = 'white';
                newIElement.style.width = '20px';
                newIElement.style.height = '20px';
                newIElement.style.borderRadius = '50%';

                // Append the new <i> element to the "wrap" element
                arrow.appendChild(newIElement);
            }
        } else {
            section.style.display = "block";

            // Check if the element exists
            if (arrow) {
                // Remove all children from the "wrap" element
                while (arrow.firstChild) {
                    arrow.removeChild(arrow.firstChild);
                }

                // Create a new <i> element with the desired attributes
                let newIElement = document.createElement('i');
                newIElement.className = 'fas fa-arrow-right d-flex justify-content-center align-items-center';
                newIElement.style.fontSize = '0.8rem';
                newIElement.style.color = 'black';
                newIElement.style.backgroundColor = 'white';
                newIElement.style.width = '20px';
                newIElement.style.height = '20px';
                newIElement.style.borderRadius = '50%';


                // Append the new <i> element to the "wrap" element
                arrow.appendChild(newIElement);
            }
        }
    }

    function toggleFillAccordion(sectionId, sectionArrowId) {
        let sections = document.querySelectorAll(`.${sectionId}`);
        let arrows = document.querySelectorAll(`.${sectionArrowId}`);

        sections.forEach(section => {
            if (section.style.display === "block") {
                section.style.display = "none";


                // Check if the element exists

                arrows.forEach(arrow => {
                    // Remove all children from the "wrap" element
                    while (arrow.firstChild) {
                        arrow.removeChild(arrow.firstChild);
                    }

                    // Create a new <i> element with the desired attributes
                    let newIElement = document.createElement('i');
                    newIElement.className =
                        'fas fa-arrow-down d-flex justify-content-center align-items-center';
                    newIElement.style.fontSize = '0.8rem';
                    newIElement.style.color = 'white';
                    newIElement.style.width = '20px';
                    newIElement.style.height = '20px';
                    newIElement.style.borderRadius = '50%';

                    // Append the new <i> element to the "wrap" element
                    arrow.appendChild(newIElement);

                })

            } else {
                section.style.display = "block";

                // Check if the element exists

                arrows.forEach(arrow => {
                    // Remove all children from the "wrap" element
                    while (arrow.firstChild) {
                        arrow.removeChild(arrow.firstChild);
                    }

                    // Create a new <i> element with the desired attributes
                    let newIElement = document.createElement('i');
                    newIElement.className =
                        'fas fa-arrow-up d-flex justify-content-center align-items-center';
                    newIElement.style.fontSize = '0.8rem';
                    newIElement.style.color = 'white';
                    newIElement.style.width = '20px';
                    newIElement.style.height = '20px';
                    newIElement.style.borderRadius = '50%';


                    // Append the new <i> element to the "wrap" element
                    arrow.appendChild(newIElement);
                })


            }
        });

    }
</script>

<script>
    // Select both elements by their class names
    var div1 = document.querySelector('.div1');
    var div2 = document.querySelector('.div2');

    // Get the width of the "div2" element
    var div2Width = div2.offsetWidth;

    // Set the width of "div1" to the width of "div2"
    div1.style.width = div2Width + 'px';

    document.addEventListener("DOMContentLoaded", function() {
        var wrapper1 = document.querySelector(".wrapper1");
        var wrapper2 = document.querySelector(".wrapper2");

        wrapper1.addEventListener("scroll", function() {
            wrapper2.scrollLeft = wrapper1.scrollLeft;
        });

        wrapper2.addEventListener("scroll", function() {
            wrapper1.scrollLeft = wrapper2.scrollLeft;
        });
    });
</script>

<script>
    const value = localStorage.getItem("showHideDollar");

    var dollarCells = document.getElementsByClassName('dollar-cell');

    for (var i = 0; i < dollarCells.length; i++) {
        if (value === "hide") {
            dollarCells[i].classList.add('showHideDollarCells')
        }
    }

    var exRateCells = document.getElementsByClassName('ex-rate-cell');

    for (var i = 0; i < dollarCells.length; i++) {
        if (value === "hide") {
            exRateCells[i].classList.add('showHideExRateCells')
        }
    }
</script>

<script>
    const value1 = localStorage.getItem("showHideDollar");
    var myExRateCells = document.getElementsByClassName('my-ex-rate-cell');

    for (var i = 0; i < dollarCells.length; i++) {
        if (value1 === "hide") {
            myExRateCells[i].classList.add('showHideMyExRateCell')
        }
    }
</script>

<script>
    document.addEventListener('componentRefreshed', function() {
        // Execute your JavaScript code here after Livewire component refreshes
        const value = localStorage.getItem("showHideDollar");

        var dollarCells = document.getElementsByClassName('dollar-cell');

        for (var i = 0; i < dollarCells.length; i++) {
            if (value === "hide") {
                dollarCells[i].classList.add('showHideDollarCells')
            }
        }

    });
</script>

<script>
    $(document).on("click", ".buttons-collection", function() {
        if (!$(this).hasClass('toggleVisColList')) {
            $(this).addClass('toggleVisColList')
        }

    })
    $(document).on("click", ".toggleVisColList", function() {
        $('.dt-button-collection').toggle()
    })
</script>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/modernizr.min.js') }}"></script>
<script src="{{ asset('js/detect.js') }}"></script>
{{-- <script src="{{ asset('js/jquery.slimscroll.js') }}"></script> --}}
<script src="{{ asset('js/horizontal-menu.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- Switchery js -->
{{-- <script src="{{asset('plugins/switchery/switchery.min.js')}}"></script> --}}
<!-- Datatable js -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
{{-- <script src="{{asset('plugins/datatables/jszip.min.js')}}"></script> --}}
<script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/1.13.6/api/sum().js') }}"></script>
<script src="{{ asset('js/custom/custom-table-datatable.js') }}"></script>


{{-- select library --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> --}}



<script type="text/javascript" src="{{ asset('js/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript"
    src="{{ asset('js/jquery-validation/localization/messages_' . app()->getLocale() . '.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/cropperjs/cropper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>

{{-- select library --}}

<script type="text/javascript" src="{{ asset('js/select/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select/form-select2.js') }}"></script>
<script src="{{ asset('js/summernote.min.js') }}" referrerpolicy="origin"></script>
<script type="text/javascript" src="{{ asset('js/submitform/submit-form.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/lang/' . app()->getLocale() . '.js') }}"></script>
<script></script>


<!-- Pnotify js -->
<script src="{{ asset('plugins/pnotify/js/pnotify.custom.min.js') }}"></script>
<script src="{{ asset('js/custom/custom-pnotify.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>
<!-- Core js -->
{{-- <script src="{{asset('js/core.js')}}"></script> --}}
<script>
    $(document).on("click", "#discount_from_original_price", function() {
        var value = $('#discount_from_original_price').is(':checked') ? 1 : 0;
        $.ajax({
            method: "get",
            url: "/create-or-update-system-property/discount_from_original_price/" + value,
            contentType: "html",
            success: function(result) {
                if (result.success) {
                    // Swal.fire("Success", response.msg, "success");
                    Swal.fire({
                        title: "Success",
                        text: response.status,
                        icon: "success",
                        timer: 1000, // Set the timer to 1000 milliseconds (1 second)
                        showConfirmButton: false // This will hide the "OK" button
                    });

                }
            },
        });
    });

    $(document).on("click", "#clear_all_input_form", function() {
        var value = $('#clear_all_input_form').is(':checked') ? 1 : 0;
        $.ajax({
            method: "get",
            url: "/create-or-update-system-property/clear_all_input_stock_form/" + value,
            contentType: "html",
            success: function(result) {
                if (result.success) {
                    Swal.fire("Success", response.msg, "success");
                }
            },
        });
    });

    document.addEventListener('livewire:load', function() {
        window.addEventListener('initialize-select2', event => {
            $('.select2').select2();
            $('.js-example-basic-multiple').select2({
                placeholder: LANG.please_select,
                tags: true
            });

        });
    });

    @if (session('status'))
        new PNotify({
            title: '{{ session('status.msg') }} !',
            text: '{{ session('status.msg') }}',
            delay: 700,
            @if (session('status.success') == '1')
                type: "success"
            @else
                type: "Error"
            @endif
        });
    @endif

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.delete_item', function(e) {
        e.preventDefault();
        var deletetype = $(this).data('deletetype');
        var title = LANG.are_you_sure;
        if (deletetype == 1) {
            title = LANG.it_will_delete_the_product_and_all_its_operations
        }
        Swal.fire({
            title: title,
            text: LANG.are_you_sure_you_wanna_delete_it,
            icon: 'warning',
        }).then(willDelete => {
            if (willDelete) {
                // var check_password = $(this).data('check_password');
                var href = $(this).data('href');
                var data = $(this).serialize();

                Swal.fire({
                    title: "{!! __('lang.please_enter_your_password') !!}",
                    input: 'password',
                    inputAttributes: {
                        placeholder: "{!! __('lang.type_your_password') !!}",
                        autocomplete: 'off',
                        autofocus: true,
                    },
                }).then((result) => {
                    if (result) {
                        $.ajax({
                            url: '{{ route('check_password') }}',
                            method: 'POST',
                            data: {
                                value: result,
                            },
                            dataType: 'json',
                            success: (data) => {

                                if (data.success == true) {
                                    Swal.fire(
                                        'success',
                                        "{!! __('lang.correct_password') !!}",
                                        'success'
                                    );
                                    // location.reload();
                                    $.ajax({
                                        method: 'DELETE',
                                        url: href,
                                        dataType: 'json',
                                        data: data,
                                        success: function(result) {
                                            if (result.success ==
                                                true) {
                                                new PNotify({
                                                    title: result
                                                        .msg,
                                                    text: 'Check me out! I\'m a notice.',
                                                    type: 'success'
                                                });
                                                setTimeout(() => {
                                                    location
                                                        .reload();
                                                }, 1500);
                                                location.reload();
                                            } else {
                                                new PNotify({
                                                    title: result
                                                        .msg,
                                                    text: 'Check me out! I\'m a notice.',
                                                    type: 'error'
                                                });
                                            }
                                        },
                                    });

                                } else {
                                    Swal.fire(
                                        'Failed!',
                                        'Wrong Password!',
                                        'error'
                                    )

                                }
                            }
                        });
                    }
                });
            }
        });
    });

    //open edit modal for modules
    $(document).on('click', '.btn-modal', function(e) {
        e.preventDefault();
        var container = $(this).data('container');
        $.ajax({
            url: $(this).data('href'),
            dataType: 'html',
            success: function(result) {
                $(container).html(result);
                $('#editModal').modal('show');
                $('.select2').select2();
                $('.datepicker').datepicker();
            },
        });
    });
    //open edit modal for modules
    // $(document).on('click', '.btn-modal', function(e) {
    //     e.preventDefault();
    //     var container = $(this).data('container');
    //     $.ajax({
    //         url: $(this).data('href'),
    //         dataType: 'html',
    //         success: function(result) {
    //             $(container).html(result);
    //             $('#dueModal').modal('show');
    //             // $('.select2').select2();
    //             // $('.datepicker').datepicker();
    //         },
    //     });
    // });
    //make translation open if there is translation when edit
    $(document).ready(function() {
        $('table.editTogle')
            .find("tr")
            .each(function() {
                if ($(this).find('input.translations').val()) {
                    $('table.editTogle').removeClass('collapse')
                    return;
                }
            });
        $('table.editTextareaTogle')
            .find("tr")
            .each(function() {
                if ($(this).find('textarea.translations').val()) {
                    $('table.editTextareaTogle').removeClass('collapse')
                    return;
                }
            });
    });

    // $('.js-example-basic-multiple').select2({
    //     placeholder: LANG.please_select,
    //     tags: true
    // });

    $('.select2').select2();
    $('.datepicker').datepicker();

    // $(document).ready(function() {
    //     // Event handler for key press
    //     $(document).on('keydown', function(event) {
    //         // Check if Ctrl+G is pressed
    //         if (event.ctrlKey && event.key === 'g') {
    //             // Prevent the default Ctrl+G behavior (e.g., find)
    //             event.preventDefault();
    //             $.ajax({
    //                 url: '/toggle-dollar',
    //                 method: 'GET',
    //                 success: function(response) {
    //                     if (response.success) {
    //                         Swal.fire("Success", response.msg, "success");
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // });
</script>

@stack('javascripts')
