<!-- Modal -->
<div class="modal fade" id="editBrandModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => ['brands.update',$brand->id],'method'=>'put','id'=>'brand-update-form' ]) !!}
                    @csrf
                    @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="id" value="{{$brand->id}}"/>
                    {!! Form::label('name', __( 'lang.brand_name' ) . ':*') !!}
                    {!! Form::text('name', $brand->name, ['class' => 'form-control', 'placeholder' => __( 'lang.brand_name' ), 'required'
                    ]);
                    !!}
                    @error('name')
                        <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\BrandUpdateRequest','#brand-update-form'); !!}

{{-- <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script> --}}

