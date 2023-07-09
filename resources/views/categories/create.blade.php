@extends('layouts.app')
@section('title', __('categories.add_categorie_name'))
@push('css')
{{-- <link rel="stylesheet" href="{{asset('js/select2/css/select2.min.js')}}"> --}}
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('categories.add_categorie_name')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        {{-- <li class="breadcrumb-item"><a href="#">categories</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">@lang('categories.add_categorie_name')</li>
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
                        <form class="form" action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">@lang('categories.categorie_name')</label>
                                            <input type="text"
                                                   class="form-control"
                                                   placeholder="@lang('categories.categorie_name')"
                                                   name="name"
                                                   value="{{ old('name') }}" >
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_id">@lang('categories.parent')</label>
                                            <select name="parent_id" class="form-control select2">
                                                <option value="" selected disabled readonly>---{{ __('select') }}---</option>
                                                @forelse($cats as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ old('parent_id', request()->parent_id ) ==$cat->id?'selected':null }} >
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
                                    <i class="la la-check-square-o"></i> {{ __('Add') }}
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
@push('js')
{{-- <script src="{{ asset('js/select2/js/select2.min.js')}}"></script> --}}
<script>
    $('.select2').select2({
        'width': '100%',
    });
</script>
@endpush
