@extends('layouts.app')
@section('title', __('categories.add_categorie_name'))
@push('css')

@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('categories.add_categorie_name')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('sub-categories', 'category')}}">@lang('categories.categories')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('categories.add_categorie_name')</li>
                    </ol>
                </div>
            </div>
            <a href="{{route('sub-categories', 'category')}}" class="btn btn-info">
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
                        <form class="form ajaxform" action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data" id='product-form'>
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group ">
                                            <label for="name">@lang('categories.categorie_name')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text" required
                                                       class="form-control"
                                                       placeholder="@lang('categories.categorie_name')"
                                                       name="name"
                                                       value="{{ old('name') }}" >
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <button  class="btn btn-primary btn-sm ml-2" type="button"
                                                    data-toggle="collapse" data-target="#translation_table_category"
                                                    aria-expanded="false" aria-controls="collapseExample">
                                                        {{ __('categories.addtranslations') }}
                                                </button>
                                            </div>
                                            @include('layouts.translation_inputs', [
                                                'attribute' => 'name',
                                                'translations' => [],
                                                'type' => 'category',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_id">@lang('categories.parent')</label>
                                            <select name="parent_id" class="form-control select2"  id="my-select">
                                                <option value="" selected disabled readonly>---{{ __('select') }}---</option>
                                                @forelse($cats as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ old('parent_id', request()->parent_id ) ==$cat->id?'selected':null }} >
                                                        {{ $cat->name }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        @error('parent_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status">@lang('categories.status')</label>
                                        <select name="status" class="form-control" required>
                                            <option value="1" {{ old('status') == 1 ? 'selected' : null }}>{{ __('Active') }}</option>
                                            <option value="0" {{ old('status') == 0 ? 'selected' : null }}>{{ __('Inactive') }}</option>
                                        </select>
                                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('categories.cover')</label>
                                            {{-- <input class="form-control img" name="cover"  type="file" accept="image/*" > --}}
                                            <div class="dropzone" id="my-dropzone" required>
                                                <div class="dz-message" data-dz-message><span>@lang('categories.drop_file_here_to_upload')</span></div>
                                            </div>
                                            @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                {{-- <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> {{ __('Add') }}
                                </button> --}}
                                <button type="button" class="btn btn-primary" id="submit-btn">
                                    <i class="la la-check-square-o"></i> {{ __('Add') }}
                                </button>
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

<script src="{{ asset('js/category.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

@endpush
