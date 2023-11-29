<div class="card-body">
    <form action="{{route('reports.daily_sales_report')}}" method="get">
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('branch_id', __('lang.branch'))  !!}
                    {!! Form::select(
                        'branch_id',
                        $branches,request()->branch_id,
                        ['class' => 'form-control select2','placeholder'=>__('lang.please_select'), 'id' => 'branch_id']
                    ) !!}
                </div>
            </div>
            @php
                if(!empty(request()->branch_id)){
                    $stores = \App\Models\Store::where('branch_id',request()->branch_id)->pluck('name', 'id');
                }
            @endphp
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('store_id', __('lang.store'))  !!}
                    {!! Form::select(
                        'store_id',
                        $stores, request()->store_id,
                        ['class' => 'form-control select2','placeholder'=>__('lang.please_select'), 'id' => 'store_id']
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

