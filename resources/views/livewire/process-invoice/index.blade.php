    <!-- Start Contentbar -->    
    <div class="contentbar">                
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.process_invs')</h5>
                    </div>
                    <div class="card-body">
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('lang.created_at')</th>
                                    <th>@lang('lang.invoice_no')</th>
                                    <th>@lang('lang.customer_name')</th>
                                    <th>@lang('lang.city')</th>
                                    <th>@lang('lang.state')</th>
                                    <th>@lang('lang.phone')</th>
                                    <th>@lang('lang.payment_status')</th>
                                    <th>@lang('lang.amount')</th>
                                    <th>@lang('lang.amount') $</th>
                                    <th>@lang('lang.delivery_date')</th>
                                    <th>@lang('lang.processor')</th>
                                    <th>{{__('lang.process')}}</th>
                                    <th>@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoice as $index=>$inv)
                                <tr style="background-color:{{$inv['is_processed']=="1"?'rgb(221, 253, 185)':'rgb(255, 220, 220)'}} !important">
                                    <td><input type="hidden" wire:model="inv[{{$index}}][id]" value="{{$inv['id']}}"/>
                                        {{ $index+1 }}</td>
                                    <td>{{$inv['created_at']}}</td>
                                    <td>{{$inv['invoice_no']}}</td>
                                    <td>{{$inv['customer_name']}}</td>
                                    <td>{{$inv['city']}}</td>
                                    <td>{{$inv['state']}}</td>
                                    <td>{{$inv['phone']}}</td>
                                    <td>{{$inv['payment_status']}}</td>
                                    <td>{{$inv['amount']}}</td>
                                    <td>{{$inv['dollar_amount']}} $</td>
                                    <td>{{$inv['delivery_date']}}</td>
                                    <td>
                                        {!! Form::select('inv.' . $index.'.employee_id', $employees, $inv['employee_id']??null, [
                                            'class' => ' form-control select2 employee_id',
                                            'data-name' => 'employee_id',
                                            'data-index' => $index,
                                            'placeholder' => __('lang.please_select'),
                                            'wire:model' => 'inv.' . $index.'.employee_id',
                                        ]) !!}
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input  type="checkbox"  class="custom-control-input" id="is_processed{{$index}}" name="is_processed{{$index}}"  {{$inv['is_processed']=="1" ? 'checked' :''}}
                                            wire:change="UpdateStatus({{$index}},{{$inv['id']}})">
                                            <label class="custom-control-label"  for="is_processed{{$index}}" ></label>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
