{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> --}}
<!-- Core js -->
{{-- <script src="{{asset('js/core.js')}}"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script> --}}
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/modernizr.min.js')}}"></script>
<script src="{{asset('js/detect.js')}}"></script>
<script src="{{asset('js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('js/horizontal-menu.js')}}"></script>
<!-- Switchery js -->
{{-- <script src="{{asset('plugins/switchery/switchery.min.js')}}"></script> --}}
<!-- Datatable js -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
{{--<script src="{{asset('plugins/datatables/jszip.min.js')}}"></script>--}}
<script src="{{asset('plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables/buttons.colVis.min.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/custom/custom-table-datatable.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<script type="text/javascript" src="{{asset('js/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{asset('js/jquery-validation/localization/messages_'. app()->getLocale() .'.js') }}"></script>
<script type="text/javascript" src="{{asset('js/cropperjs/cropper.min.js') }}"></script>
<script type="text/javascript" src="{{asset('js/dropzone.js') }}"></script>
<script type="text/javascript" src="{{asset('js/select/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{asset('js/select/form-select2.js') }}"></script>
<script src="{{asset('js/summernote.min.js')}}" referrerpolicy="origin"></script>
<script type="text/javascript" src="{{asset('js/submitform/submit-form.js') }}"></script>
<script src="{{asset('js/jquery-ui.min.js') }}" ></script>
<script src="{{ asset('js/lang/'.app()->getLocale().'.js') }}"></script>
<script>

</script>


<!-- Pnotify js -->
<script src="{{asset('plugins/pnotify/js/pnotify.custom.min.js')}}"></script>
<script src="{{asset('js/custom/custom-pnotify.js')}}"></script>
<!-- Core js -->
{{-- <script src="{{asset('js/core.js')}}"></script> --}}
<script>
      @if (session('status'))
                new PNotify( {
                    title: '{{ session('status.msg') }} !', text: '{{ session('status.msg') }}',
                    @if (session('status.success') == '1')
                        type: "success"
                    @else
                        type:"Error"
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
            swal({
                title: LANG.are_you_sure,
                text: LANG.are_you_sure_you_wanna_delete_it,
                icon: 'warning',
            }).then(willDelete => {
                if (willDelete) {
                    // var check_password = $(this).data('check_password');
                    var href = $(this).data('href');
                    var data = $(this).serialize();

                    swal({
                        title: "{!!__('lang.please_enter_your_password')!!}",
                        content: {
                            element: "input",
                            attributes: {
                                placeholder:"{!!__('lang.type_your_password')!!}",
                                type: "password",
                                autocomplete: "off",
                                autofocus: true,
                            },
                        },
                        inputAttributes: {
                            autocapitalize: 'off',
                            autoComplete: 'off',
                        },
                        focusConfirm: true
                    }).then((result) => {
                        if (result) {
                            $.ajax({
                                url: '/user/check-password/',
                                method: 'POST',
                                data: {
                                    value: result
                                },
                                dataType: 'json',
                                success: (data) => {

                                    if (data.success == true) {
                                        swal(
                                            'success',
                                            "{!!__('lang.correct_password')!!}",
                                            'success'
                                        );
                                        location.reload();
                                        $.ajax({
                                            method: 'DELETE',
                                            url: href,
                                            dataType: 'json',
                                            data: data,
                                            success: function(result) {
                                                if (result.success == true) {
                                                    new PNotify( {
                                                        title: result.msg, text: 'Check me out! I\'m a notice.', type: 'success'
                                                    });
                                                    setTimeout(() => {
                                                        location
                                                            .reload();
                                                    }, 1500);
                                                    location.reload();
                                                } else {
                                                    // swal(
                                                    //     'Error',
                                                    //     result.msg,
                                                    //     'error'
                                                    // );
                                                    new PNotify( {
                                                        title: result.msg, text: 'Check me out! I\'m a notice.', type: 'error'
                                                    });
                                                }
                                            },
                                        });

                                    } else {
                                        swal(
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
        //make translation open if there is translation when edit
        $(document).ready(function(){
            $('table.editTogle')
                .find("tr")
                .each(function () {
                    if($(this).find('input.translations').val()){
                        $('table.editTogle').removeClass('collapse')
                        return;
                    }
            });
            $('table.editTextareaTogle')
                .find("tr")
                .each(function () {
                    if($(this).find('textarea.translations').val()){
                        $('table.editTextareaTogle').removeClass('collapse')
                        return;
                    }
            });
        });
        $('.select2').select2();
        $('.datepicker').datepicker();
</script>
@stack('javascripts')

