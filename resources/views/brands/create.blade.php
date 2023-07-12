<!-- Modal -->
<div class="modal fade" id="exampleStandardModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">Add Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => 'brands.store', 'method' => 'post', 'files' => true,'id'=>'brand-form' ]) !!}
            <div class="modal-body">
                <div class="form-group">
                {{-- <input type="text" class="form-control" id="validationServer02" placeholder="Brand Name" value="" required> --}}
                    {!! Form::label('name', __( 'lang.brand_name' ) . ':*') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __( 'lang.brand_name' ), 'required'
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