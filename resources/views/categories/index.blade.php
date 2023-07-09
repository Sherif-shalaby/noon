@extends('layouts.app')
@section('title', __('categories.categories'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('categories.categories')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        {{-- <li class="breadcrumb-item"><a href="#">categories</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">@lang('categories.categories')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        @lang('categories.add_categorie_name')
                    </a>
                    <a href="{{route('sub-categories', 'category')}}" class="btn btn-info">
                        <i class="fa fa-arrow-left"></i>
                        @lang('categories.allcategories')
                    </a>
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
                    <div class="card-body">
                        @if (@isset($categories) && !@empty($categories) && count($categories) > 0 )
                           @include('categories.filter')
                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('categories.categorie_name')</th>
                                            <th>@lang('categories.parent')</th>
                                            <th>@lang('categories.sub_categories')</th>
                                            <th>@lang('categories.status')</th>
                                            <th>@lang('categories.created_at')</th>
                                            <th>@lang('categories.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $index=>$categorie)
                                            <tr>
                                                <td>{{ $index+1 }}</td>
                                                <td>{{ $categorie->name }}</td>
                                                <td>{{ $categorie->parentName()}}</td>
                                                <td>
                                                    <a href="{{ route('sub-categories', $categorie->id) }}" class="btn btn-sm btn-primary">
                                                        {{ $categorie->subCategories->count() }}</a>
                                                </td>
                                                <td>{{ __($categorie->status())}}</td>
                                                <td>{{ $categorie->created_at() }}</td>
                                                <td>
                                                    @include('categories.action')
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <tfoot>
                                    <tr>
                                        <th colspan="12">
                                            <div class="float-right">
                                                {!! $categories->appends(request()->all())->links() !!}
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </div>
                        @else
                        <div class="alert alert-danger">
                            {{ __('categories.data_no_found') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
    </div>
@endsection
