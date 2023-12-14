<div class="card-body">
    <form action="{{route('reports.add_stock')}}" method="get">
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('product_name', __('lang.product_name'))  !!}
                    {!! Form::text(
                        'product_name', request()->product_name,
                        ['class' => 'form-control','placeholder'=>__('lang.product_name'),'wire:model' => 'product_name']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('product_sku', __('lang.sku'))  !!}
                    {!! Form::text(
                        'product_sku',request()->product_sku,
                        ['class' => 'form-control','placeholder'=>__('lang.sku'),'wire:model' => 'product_sku']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('product_symbol', __('lang.product_symbol'))  !!}
                    {!! Form::text(
                        'product_symbol',request()->product_symbol,
                        ['class' => 'form-control','placeholder'=>__('lang.product_symbol'),'wire:model' => 'product_symbol']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('category_id', __('lang.category'))  !!}
                    {!! Form::select(
                        'category_id',
                        $categories,request()->category_id,
                        ['class' => 'form-control select2 category','placeholder'=>__('lang.please_select'),'id' => 'categoryId']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('subcategory_id1', __('lang.subcategory')." 1")  !!}
                    {!! Form::select(
                        'subcategory_id1',
                        $subcategories,request()->subcategory_id1,
                        ['class' => 'form-control select2 subcategory','placeholder'=>__('lang.please_select'),'id' => 'subcategory_id1']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('subcategory_id2', __('lang.subcategory')." 2")  !!}
                    {!! Form::select(
                        'subcategory_id2',
                        $subcategories,request()->subcategory_id2,
                        ['class' => 'form-control select2 subcategory2','placeholder'=>__('lang.please_select'),'id' => 'subCategoryId2' ]
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('subcategory_id3', __('lang.subcategory')." 3")  !!}
                    {!! Form::select(
                        'subcategory_id3',
                        $subcategories,request()->subcategory_id3,
                        ['class' => 'form-control select2 subcategory3','placeholder'=>__('lang.please_select') ,'id' => 'subCategoryId3']
                    ) !!}
                </div>
            </div>
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
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('created_by', __('lang.created_by'))  !!}
                    {!! Form::select(
                        'created_by',
                        $users,request()->created_by,
                        ['class' => 'form-control select2',' data-name' => 'created_by','placeholder'=>__('lang.please_select'),'wire:model' => 'created_by']
                    ) !!}
                </div>
            </div>
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
            <div class="col-md-2">
                {!! Form::label('purchase_type', __('lang.purchase_type') . ':*', []) !!}
                {!! Form::select('purchase_type', ['import' =>  __('lang.import'), 'local' => __('lang.local')],request()->purchase_type ,
                ['class' => 'form-control select2', 'placeholder' => __('lang.please_select')]) !!}
            </div>
            <div class="col-md-2">
                {!! Form::label('payment_status', __('lang.payment_status') . ':*', []) !!}
                {!! Form::select('payment_status', $payment_status_array, request()->payment_status,
                ['class' => 'form-control select2', 'data-live-search' => 'true',  'placeholder' => __('lang.please_select')]) !!}
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="due_date">{{__('lang.payment_date')}}</label>
                    {!! Form::date(
                        'due_date', null,
                        ['class' => 'form-control','placeholder'=>__('lang.due_date')]
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="from">{{__('site.From')}}</label>
                    {!! Form::date(
                        'from', request()->from  ,
                        ['class' => 'form-control','placeholder'=>__('lang.from'),'wire:model' => 'from']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="to">{{__('site.To')}}</label>
                    {!! Form::date(
                        'to', request()->to ?? date('Y-m-d'),
                        ['class' => 'form-control','placeholder'=>__('lang.to')]
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                        <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
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
