<!-- Modal -->
<div class="modal fade show_invoice_modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploaded_files">@lang('lang.files')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang.files')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($uploaded_files as $key => $file)
                                @if (!empty($file))
                                    <tr>
                                        <td> {{ $key+1 }} </td>
                                        <td>
                                            <img src="{{"/uploads/". $file->path}}" alt="photo"  style="width: 250px; border: 2px solid #fff; padding: 4px;">
                                        </td>
                                    </tr>

                                @endif
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">@lang('lang.no_file_uploaded')</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
