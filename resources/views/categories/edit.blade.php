@extends('layouts.app')
@section('title', __('categories.edit_categorie'))
@push('css')
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('categories.edit_categorie')
                </h4>
                <div class="breadcrumb-list">
                    <ul cstyle=" list-style: none;"
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                @lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                style="text-decoration: none;color: #596fd7"
                                href="{{ route('sub-categories', 'category') }}">/ @lang('categories.categories')</a>
                        </li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                            aria-current="page">@lang('categories.edit_categorie')</li>
                    </ul>
                </div>
            </div>
            <a href="{{ route('sub-categories', 'category') }}" class="btn btn-primary" style="width: fit-content">
                <i class="fa fa-arrow-left"></i>
                @lang('Back')
            </a>
        </div>
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
                        <form class="form" action="{{ route('categories.update', $category->id) }}" method="post"
                            enctype="multipart/form-data" id="product-edit-form">
                            @csrf
                            @method('PUT')
                            <div class="form-body">
                                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <div class="col-md-4">
                                        <div
                                            class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label class="modal-label-width" for="name">@lang('categories.categorie_name')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <input type="text"
                                                    class="form-control initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                                                    style="width: 100%" placeholder="@lang('categories.categorie_name')" name="name"
                                                    value="{{ old('name', $category->name) }}">
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
                                                'data' => $category,
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
                                                    style="width:100%;border-radius:16px;border:2px solid #cececf">
                                                    <option value="" selected disabled readonly>
                                                        ---{{ __('select') }}---
                                                    </option>
                                                    <option value="" disabled readonly>---{{ __('select') }}---
                                                    </option>
                                                    <option value="1"
                                                        @if ($category->parent_id == 0) selected @endif>Category 1
                                                    </option>
                                                    <option value="2"
                                                        @if ($category->parent_id == 1) selected @endif>Category 2
                                                    </option>
                                                    <option value="3"
                                                        @if ($category->parent_id == 2) selected @endif>Category 3
                                                    </option>
                                                    <option value="4"
                                                        @if ($category->parent_id == 3) selected @endif>Category 4
                                                    </option>
                                                    {{-- @forelse($cats as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : null }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @empty
                                                @endforelse --}}
                                                </select>
                                                @error('parent_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label class="modal-label-width" for="status">@lang('categories.status')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <select name="status"
                                                    class="select p-0 initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                                                    style="width:100%;border-radius:16px;border:2px solid #cececf">
                                                    <option value="1"
                                                        {{ old('status', $category->status) == 1 ? 'selected' : null }}>
                                                        {{ __('Active') }}</option>
                                                    <option value="0"
                                                        {{ old('status', $category->status) == 0 ? 'selected' : null }}>
                                                        {{ __('Inactive') }}</option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">

                                        <div class="form-group">
                                            <label
                                                class="d-block @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('categories.cover')</label>
                                            <div class="dropzone d-flex justify-content-center align-items-center"
                                                style="padding: 0;" id="my-dropzone">
                                                <div style="margin: 0;" class="dz-message" data-dz-message>
                                                    <img src="{{ $category->imagepath }}" style="width: 150px;">
                                                </div>
                                                {{-- <input name="file" type="file" class="dz-message" /> --}}
                                            </div>
                                            @error('cover')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn btn-primary" id="submit-btn">
                                        <i class="la la-check-square-o"></i> {{ __('Edit') }}
                                    </button>
                                </div>
                                {{-- <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> {{ __('Edit') }}
                                </button>
                            </div> --}}
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
    <script src="{{ asset('js/category_edit.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CategoryupdateRequest', '#product-edit-form') !!}
@endpush
