@extends('layouts.app')
@section('title', __('categories.edit_categorie'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('categories.edit_categorie')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        {{-- <li class="breadcrumb-item"><a href="#">categories</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">@lang('categories.edit_categorie')</li>
                    </ol>
                </div>
            </div>
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
                        <form class="form" action="{{ route('categories.update',$category->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">@lang('categories.categorie_name')</label>
                                            <input type="text"
                                                   class="form-control"
                                                   placeholder="@lang('categories.categorie_name')"
                                                   name="name"
                                                   value="{{ old('name',$category->name) }}" >
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_id">@lang('categories.parent')</label>
                                            <select name="parent_id" class="form-control">
                                                <option value="" selected disabled readonly>---{{ __('select') }}---</option>
                                                @forelse($cats as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ old('parent_id',$category->parent_id)==$cat->id?'selected':null }} >
                                                        {{ $cat->name }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('parent_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status">@lang('categories.status')</label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ old('status',$category->status) == 1 ? 'selected' : null }}>{{ __('Active') }}</option>
                                            <option value="0" {{ old('status',$category->status) == 0 ? 'selected' : null }}>{{ __('Inactive') }}</option>
                                        </select>
                                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Cover </label>
                                            <input class="form-control img" name="cover"  type="file" accept="image/*" >
                                            @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="{{ asset('images/no-image.jpg') }}" alt="" class="img-thumbnail img-preview" width="200px">
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> {{ __('Edit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
    </div>
@endsection
