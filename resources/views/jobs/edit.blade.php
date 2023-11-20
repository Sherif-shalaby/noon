<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit">@lang('lang.edit')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['url' => route('jobs.update', $job->id), 'method' => 'put']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="job_title">@lang('lang.job_title')</label>
                            <input type="text" class="form-control" value="{{$job->title}}" name="title" id="title" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pt-2">
                        <h5>@lang('lang.permissions')</h5>
                    </div>
                </div>
                {{-- +++++++++++++++++++ permission +++++++++++++++++++ --}}
                <div class="row">
                    <div class="col-md-12 text-center">
                        {{-- <h3>@lang('lang.user_rights')</h3>  --}}
                    </div>
                    <div class="col-md-12">
                        @include('jobs.partials.permission')
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

{{-- ++++++++++++++++++ script ++++++++++++++++++ --}}
<script>
    $(document ).ready(function()
    {
        console.log("000000000000000000000000000000");
        // +++++++++++++++++++++++++++++++++ Permissions Table +++++++++++++++++++++++++++++++++
        // when checked the "first checkbox" of "sub_module" then check "all checkboxes" in the "same row"
        $('.checked_all').change(function()
        {
            tr = $(this).closest('tr');
            var checked_all = $(this).prop('checked');

            tr.find('.check_box').each(function(item) {
                if (checked_all === true) {
                    $(this).prop('checked', true)
                } else {
                    $(this).prop('checked', false)
                }
            })
        })
        $('.all_module_check_all').change(function()
        {
            var all_module_check_all = $(this).prop('checked');
            $('#permission_table > tbody > tr').each((i, tr) =>
            {
                $(tr).find('.check_box').each(function(item)
                {
                    if (all_module_check_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })
                $(tr).find('.module_check_all').each(function(item) {
                    if (all_module_check_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })
                $(tr).find('.checked_all').each(function(item) {
                    if (all_module_check_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })
            })
        })
        // when check "first checkbox" then check "all checkboxes" in the same column
        $('.module_check_all').change(function() {
            let moudle_id = $(this).closest('tr').data('moudle');
            if ($(this).prop('checked')) {
                $('.sub_module_permission_' + moudle_id).find('.checked_all').prop('checked', true);
                $('.sub_module_permission_' + moudle_id).find('.check_box').prop('checked', true);
            } else {
                $('.sub_module_permission_' + moudle_id).find('.checked_all').prop('checked', false);
                $('.sub_module_permission_' + moudle_id).find('.check_box').prop('checked', false);
            }
        })
        // "details checkboxes" column : when check "details checkbox" Then check "all checkboxes" of "details" column
        $(document).on('change', '.view_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_view').prop('checked', true);
            } else {
                $('.check_box_view').prop('checked', false);
            }
        });
        // "create" column : when check "انشاء checkbox" Then check "all checkboxes" of in the "same row"
        $(document).on('change', '.create_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_create').prop('checked', true);
            } else {
                $('.check_box_create').prop('checked', false);
            }
        });
        // "edit" column : when check "تعديل checkbox" Then check "all checkboxes" of in the "same row"
        $(document).on('change', '.edit_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_edit').prop('checked', true);
            } else {
                $('.check_box_edit').prop('checked', false);
            }
        });
        // "حذف" column : when check "حذف checkbox" Then check "all checkboxes" of in the "same row"
        $(document).on('change', '.delete_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_delete').prop('checked', true);
            } else {
                $('.check_box_delete').prop('checked', false);
            }
        });
        // Check All checkboxes in the same column
        $(document).on('focusout', '.check_in', function() {
            $('.check_in').val($(this).val())
        })
        $(document).on('focusout', '.check_out', function() {
            $('.check_out').val($(this).val())
        })
    });
</script>
