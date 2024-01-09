<div class="card-body">
    <form action="{{route('suppliers.returns.invoices')}}" method="get">
        <div class="row">
            {{-- ++++++++++++++++ product_name filter ++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('product_name', __('lang.product_name'))  !!}
                    {!! Form::text(
                        'product_name', request()->product_name,
                        ['class' => 'form-control','placeholder'=>__('lang.product_name'),'wire:model' => 'product_name']
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++ product_symbol filter ++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('product_symbol', __('lang.product_symbol'))  !!}
                    {!! Form::text(
                        'product_symbol',request()->product_symbol,
                        ['class' => 'form-control','placeholder'=>__('lang.product_symbol'),'wire:model' => 'product_symbol']
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++ category filter ++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('category_id', __('lang.category').' 1')  !!}
                    {!! Form::select(
                        'category_id',
                        $categories,request()->category_id,
                        ['class' => 'form-control select2 category','placeholder'=>__('lang.please_select'),'id' => 'categoryId']
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++ subcategory1 filter ++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('subcategory_id1', __('lang.category')." 2")  !!}
                    {!! Form::select(
                        'subcategory_id1',
                        $subcategories1,request()->subcategory_id1,
                        ['class' => 'form-control select2 subcategory','placeholder'=>__('lang.please_select'),'id' => 'subcategory_id1']
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++ subcategory2 filter ++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('subcategory_id2', __('lang.category')." 3")  !!}
                    {!! Form::select(
                        'subcategory_id2',
                        $subcategories2,request()->subcategory_id2,
                        ['class' => 'form-control select2 subcategory2','placeholder'=>__('lang.please_select'),'id' => 'subCategoryId2' ]
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++ subcategory3 filter ++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('subcategory_id3', __('lang.category')." 4")  !!}
                    {!! Form::select(
                        'subcategory_id3',
                        $subcategories3,request()->subcategory_id3,
                        ['class' => 'form-control select2 subcategory3','placeholder'=>__('lang.please_select') ,'id' => 'subCategoryId3']
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++ suppliers filter ++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('supplier_id', __('lang.supplier'))  !!}
                    {!! Form::select(
                        'supplier_id',
                        $suppliers,request()->supplier_id,
                        ['class' => 'form-control select2','placeholder'=>__('lang.please_select'), 'data-name' => 'supplier_id','wire:model' => 'supplier_id']
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++ brands filter ++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('brand_id', __('lang.brand'))  !!}
                    {!! Form::select(
                        'brand_id',
                        $brands, request()->brand_id,
                        ['class' => 'form-control select2','placeholder'=>__('lang.please_select'), 'data-name' => 'brand_id','wire:model' => 'brand_id']
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++ submit button ++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary width-100 mt-4" title="search">
                        <i class="fa fa-eye"></i> {{ __('lang.filter') }}
                    </button>
                    <a href="{{route('suppliers.returns.invoices')}}" class="btn btn-danger mt-2">@lang('lang.clear_filters')</a>

                </div>
            </div>
        </div>
    </form>
</div>
@push('javascripts')
    <script>
        $(document).ready(function() {
            $('select').on('change', function(e) {

                var name = $(this).data('name');
                var index = $(this).data('index');
                var select2 = $(this); // Save a reference to $(this)
                Livewire.emit('listenerReferenceHere',{
                    var1 :name,
                    var2 :select2.select2("val") ,
                    var3:index
                });

            });
        });
    </script>
@endpush
