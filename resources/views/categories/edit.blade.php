@extends('layouts.app')
@section('title', __('categories.edit_categorie'))
@push('css')
<style>


</style>
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('categories.edit_categorie')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sub-categories', 'category') }}">@lang('categories.categories')</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('categories.edit_categorie')</li>
                    </ol>
                </div>
            </div>
            <a href="{{ route('sub-categories', 'category') }}" class="btn btn-info">
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
                        <h5 class="card-title">@lang('categories.categories')</h5>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ route('categories.update', $category->id) }}" method="post"
                            enctype="multipart/form-data" id="product-edit-form">
                            @csrf
                            @method('PUT')
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">@lang('categories.categorie_name')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center">
                                                <input type="text" class="form-control" placeholder="@lang('categories.categorie_name')"
                                                    name="name" value="{{ old('name', $category->name) }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <button class="btn btn-primary btn-sm ml-2" type="button"
                                                    data-toggle="collapse" data-target="#translation_table_category"
                                                    aria-expanded="false" aria-controls="collapseExample">
                                                    {{ __('categories.addtranslations') }}
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_id">@lang('categories.parent')</label>
                                            <select name="parent_id" class=" form-control select2">
                                                <option value="" disabled readonly>---{{ __('select') }}---</option>
                                                <option value="1" @if ($category->parent_id == 0) selected @endif >Category 1</option>
                                                <option value="2" @if ($category->parent_id == 1) selected @endif>Category 2</option>
                                                <option value="3" @if ($category->parent_id == 2) selected @endif>Category 3</option>
                                                <option value="4" @if ($category->parent_id == 3) selected @endif>Category 4</option>
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
                                    <div class="col-md-6">
                                        <label for="status">@lang('categories.status')</label>
                                        <select name="status" class="form-control">
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
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('categories.cover')</label>
                                            <div class="dropzone" id="my-dropzone">
                                                <div class="dz-message" data-dz-message>
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
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CategoryupdateRequest','#product-edit-form'); !!}
@endpush
