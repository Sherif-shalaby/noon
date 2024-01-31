@extends('layouts.app')
@section('title', __('categories.add_categorie_name'))

@section('page_title')
    @lang('categories.add_categorie_name')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
            style="text-decoration: none;color: #596fd7" href="{{ route('sub-categories', 'category') }}">/
            @lang('categories.categories')</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">@lang('categories.add_categorie_name')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a href="{{ route('sub-categories', 'category') }}" class="btn btn-primary">
            <i class="fa fa-arrow-left"></i>
            @lang('Back')
        </a>
    </div>
@endsection

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h6 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('categories.categories')</h6>
                    </div>
                    <div class="card-body">
                        <form class="form ajaxform" action="{{ route('categories.store') }}" method="post"
                            enctype="multipart/form-data" id='product-form'>
                            @csrf
                            <div class="form-body">
                                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <div class="col-md-4 ">
                                        <div
                                            class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label class="modal-label-width" for="name">@lang('categories.categorie_name')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <input type="text" required
                                                    class="form-control initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                                                    style="width: 100%" placeholder="@lang('categories.categorie_name')" name="name"
                                                    value="{{ old('name') }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <button class="add-button d-flex justify-content-center align-items-center"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#translation_table_category" aria-expanded="false"
                                                    aria-controls="collapseExample">
                                                    <i class="fas fa-globe"></i>
                                                </button>
                                            </div>
                                            @include('layouts.translation_inputs', [
                                                'attribute' => 'name',
                                                'translations' => [],
                                                'type' => 'category',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label class="modal-label-width" for="parent_id">@lang('categories.parent')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <select name="parent_id"
                                                    class="select p-0 initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                                                    style="width:100%;border-radius:16px;border:2px solid #cececf"
                                                    id="my-select">
                                                    <option value="" selected disabled readonly>
                                                        ---{{ __('select') }}---
                                                    </option>
                                                    <option value="1">Category 1</option>
                                                    <option value="2">Category 2</option>
                                                    <option value="3">Category 3</option>
                                                    <option value="4">Category 4</option>
                                                    {{-- <div class="form-group">

                                                    {!! Form::label('parent_id', __('lang.parent_category') . ':') !!}
                                                    {!! Form::select('parent_id', [
                                                        '0' => 'Category 1',
                                                        '1' => 'Category 2',
                                                        '2' => 'Category 3',
                                                        '3' => 'Category 4',
                                                    ], false, ['class' => 'form-control', 'data-live-search' => 'true', 'style' => 'width: 100%', 'placeholder' => __('lang.please_select'), 'id' => 'parent_id']) !!}
                                                </div>
                                                @forelse($cats as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ old('parent_id', request()->parent_id ) ==$cat->id?'selected':null }} >
                                                        {{ $cat->name }}
                                                    </option>
                                                @empty
                                                @endforelse --}}
                                                </select>
                                            </div>
                                        </div>
                                        @error('parent_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label class="modal-label-width" for="status">@lang('categories.status')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <select name="status"
                                                    class="select p-0 initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                                                    style="width:100%;border-radius:16px;border:2px solid #cececf" required>
                                                    <option value="1" {{ old('status') == 1 ? 'selected' : null }}>
                                                        {{ __('Active') }}</option>
                                                    <option value="0" {{ old('status') == 0 ? 'selected' : null }}>
                                                        {{ __('Inactive') }}</option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">

                                    <div class="form-group">
                                        <label
                                            class="d-block @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('categories.cover')</label>
                                        <input class="form-control img" name="cover" type="file" accept="image/*">
                                        <div class="dropzone d-flex justify-content-center align-items-center"
                                            style="padding: 0;" id="my-dropzone" required>
                                            <div class="dz-message" style="margin: 0;" data-dz-message>
                                                <span>@lang('categories.drop_file_here_to_upload')</span>
                                            </div>
                                        </div>
                                        @error('cover')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="form-actions">
                                {{-- <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> {{ __('Add') }}
                                </button> --}}
                                <div
                                    class="d-flex @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                                    <button type="submit" class="btn btn-primary" id="submit-btn">
                                        <i class="la la-check-square-o"></i> {{ __('Add') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End col -->
            @include('categories.modalCrop')
        </div>
    </div>
@endsection
@push('js')
    {{-- <script src="{{ asset('js/category.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CategoryRequest', '#product-form') !!}
@endpush
