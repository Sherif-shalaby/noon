<div class="row text-center">
    <div class="col-md-12">
        <h4>@lang('lang.payment_details')</h4>
    </div>

</div>
<div class="col-md-12">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>@lang('lang.amount')</th>
                <th>@lang('lang.payment_date')</th>
                <th>@lang('lang.payment_type')</th>
                <th>@lang('lang.image')</th>
{{--                @if(!empty($show_action))--}}
{{--                    <th>@lang('lang.action')</th>--}}
{{--                @endif--}}

            </tr>
            </thead>

            @foreach ($payments as $payment)
                <tr>
                    <td>{{($payment->amount)}}</td>
                    <td>{{@format_date($payment->paid_on)}}</td>
                    <td>{{$payment_type_array[$payment->method]}}</td>
                    <td>
                        <!-- Image thumbnail -->
                        <img src="{{asset('uploads/'.$payment->photo)}}" alt="Image"  width="20%" data-toggle="modal" data-target="#imageModal" data-fullsize="{{asset('uploads/'.$payment->photo)}}">

                        <!-- Modal -->
                        <div class="modal fade mod" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <img class="img-fluid" id="modalImg" src=""  alt="Fullsize Image">
                            </div>
                            </div>
                        </div>
                        </div>


                    </td>
{{--                    @if(!empty($show_action))--}}
{{--                        <td>--}}
{{--                            <div class="btn-group">--}}
{{--                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"--}}
{{--                                        aria-haspopup="true" aria-expanded="false">@lang('lang.action')--}}
{{--                                    <span class="caret"></span>--}}
{{--                                    <span class="sr-only">Toggle Dropdown</span>--}}
{{--                                </button>--}}
{{--                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">--}}
{{--                                    @can('sale.pay.create_and_edit')--}}
{{--                                        <li>--}}
{{--                                            <a data-href="{{action('TransactionPaymentController@edit', $payment->id)}}"--}}
{{--                                               data-container=".view_modal" class="btn btn-modal"><i--}}
{{--                                                    class="dripicons-document-edit"></i> @lang('lang.edit')</a>--}}
{{--                                        </li>--}}
{{--                                    @endcan--}}
{{--                                    @can('sale.pay.delete')--}}
{{--                                        <li>--}}
{{--                                            <a data-href="{{action('TransactionPaymentController@destroy', $payment->id)}}"--}}
{{--                                               data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"--}}
{{--                                               class="btn text-red delete_item"><i class="fa fa-trash"></i>--}}
{{--                                                @lang('lang.delete')</a>--}}
{{--                                        </li>--}}
{{--                                    @endcan--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                    @endif--}}
                </tr>
            @endforeach
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){
      // Set the fullsize image source when modal is shown
      $('#imageModal').on('show.bs.modal', function (event) {
        var thumbnail = $(event.relatedTarget); // Thumbnail that triggered the modal
        var fullsizeImage = thumbnail.data('fullsize'); // Extract info from data-* attributes
        $('#modalImg').attr('src', fullsizeImage); // Set the src attribute of the modal image
      });
    
    });
  </script>
