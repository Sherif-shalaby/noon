<div class="card-body">
    <form action="{{ route('sub-categories', 'category') }}" method="get">
        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">

                <input type="text" name="keyword" value="{{ old('keyword', request()->input('keyword')) }}"
                    class="form-control  mt-0 initial-balance-input width-full" placeholder="{{ __('Searchname') }}">

            </div>
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                <div class="input-wrapper">
                    <select name="status" class="form-control">
                        <option value=" ">--{{ __('select') }}--</option>
                        <option value="1" {{ old('status', request()->input('status')) == '1' ? 'selected' : '' }}>
                            {{ __('Active') }}</option>
                        <option value="0" {{ old('status', request()->input('status')) == '0' ? 'selected' : '' }}>
                            {{ __('Inactive') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                <div class="input-wrapper">
                    <select name="sort_by" class="form-control">
                        <option value="">---</option>
                        <option value="id"
                            {{ old('sort_by', request()->input('sort_by')) == 'id' ? 'selected' : '' }}>
                            {{ __('ID') }}</option>
                        <option value="name"
                            {{ old('sort_by', request()->input('sort_by')) == 'name' ? 'selected' : '' }}>
                            {{ __('Name') }}</option>
                        <option value="created_at"
                            {{ old('sort_by', request()->input('sort_by')) == 'created_at' ? 'selected' : '' }}>
                            {{ __('Created_at') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                <div class="input-wrapper">
                    <select name="order_by" class="form-control">
                        <option value="">---</option>
                        <option value="asc"
                            {{ old('order_by', request()->input('order_by')) == 'asc' ? 'selected' : '' }}>
                            {{ __('Ascending') }}</option>
                        <option value="desc"
                            {{ old('order_by', request()->input('order_by')) == 'desc' ? 'selected' : '' }}>
                            {{ __('Descending') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                <div class="input-wrapper">
                    <select name="limit_by" class="form-control">
                        <option value="">---</option>
                        <option value="10"
                            {{ old('limit_by', request()->input('limit_by')) == '10' ? 'selected' : '' }}>10</option>
                        <option value="20"
                            {{ old('limit_by', request()->input('limit_by')) == '20' ? 'selected' : '' }}>20</option>
                        <option value="50"
                            {{ old('limit_by', request()->input('limit_by')) == '50' ? 'selected' : '' }}>50</option>
                        <option value="100"
                            {{ old('limit_by', request()->input('limit_by')) == '100' ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
            {{-- <div class="col-2"></div> --}}
            <div class="col-4 col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">

                <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                    <i class="fa fa-eye"></i> {{ __('Search') }}</button>

            </div>
        </div>
    </form>
</div>
