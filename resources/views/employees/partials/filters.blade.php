<div class="card-body">
    <form  method="get" id="filter_form">
        <div class="row">
            {{-- ++++++++++++++++++ "main_category" filter ++++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::select('category_id', $categories,null, ['class' => 'form-control select2 category','placeholder'=>__('lang.category'),'id' => 'categoryId']
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "sub1_category" filter ++++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::select( 'subcategory_id1', $subcategories,null,
                        ['class' => 'form-control select2 subcategory1','placeholder'=>__('lang.subcategory')." 1",'id' => 'subcategory_id1']
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "sub2_category" filter ++++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::select( 'subcategory_id2', $subcategories,null,
                            ['class' => 'form-control select2 subcategory2','placeholder'=>__('lang.subcategory')." 2",'id' => 'subcategory_id2' ]
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "sub3_category" filter ++++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::select('subcategory_id3', $subcategories,null,
                        ['class' => 'form-control select2 subcategory3','placeholder'=>__('lang.subcategory')." 3" ,'id' => 'subcategory_id3']
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "brand" filter ++++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::select('brand_id',$brands,null,['class' => 'form-control select2 brand','placeholder'=>__('lang.brand') ,'id' => 'brand_id']
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "filter" and "clear filters" button ++++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {{-- ======= "filter" button ======= --}}
                    <button type="button" id="filter_btn" class="btn btn-primary" title="search">
                        <i class="fa fa-eye"></i> {{ __('lang.filter') }}
                    </button>
                    {{-- ======= clear "filters" button ======= --}}
                    {{-- <button class="btn btn-danger mt-0 clear_filters">@lang('lang.clear_filters')</button> --}}
                </div>
            </div>

        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        // +++++++++++++++++++++++++++++++++ clear filters +++++++++++++++++++++++++++++++++
        // $('.clear_filters').on('click', function() {
        //     // Reset the values of the select boxes
        //     $('#categoryId').val('').trigger('change'); // Reset main_category select box
        //     $('#subcategory_id1').val('').trigger('change'); // Reset sub1_category select box
        //     $('#subcategory_id2').val('').trigger('change'); // Reset sub2_category select box
        //     $('#subcategory_id3').val('').trigger('change'); // Reset sub3_category select box
        //     $('#brand_id').val('').trigger('change'); // Reset brand select box
        // });
    });
</script>

