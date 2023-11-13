@extends('layouts.app')
@section('title', __('categories.categories'))
@section('breadcrumbbar')
    <style>
        th {
            position: sticky;
            top: 0;
        }
    </style>
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('categories.categories')
                </h4>
                <div class="breadcrumb-list">
                    <ul style=" list-style: none;"
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                @lang('lang.dashboard')</a>
                        </li>
                        {{-- <li class="breadcrumb-item"><a href="#">categories</a></li> --}}
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                            aria-current="page">@lang('categories.categories')</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div
                    class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <a href="{{ route('categories.create') }}" class="btn btn-primary mx-1">
                        <i class="fa fa-plus"></i>
                        @lang('categories.add_categorie_name')
                    </a>
                    <a href="{{ route('sub-categories', 'category') }}" class="btn btn-primary mx-1">
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
                        @if (@isset($categories) && !@empty($categories) && count($categories) > 0)
                            @include('categories.filter')
                            <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif"
                                style="max-height: 400px">
                                <table id="" class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="position-relative">
                                            <th>#</th>
                                            <th>@lang('categories.cover')</th>
                                            <th>@lang('categories.categorie_name')</th>
                                            <th>@lang('categories.parent')</th>
                                            <th>@lang('categories.sub_categories')</th>
                                            <th>@lang('categories.status')</th>
                                            <th>@lang('added_by')</th>
                                            <th>@lang('updated_by')</th>
                                            <th>@lang('categories.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $index => $categorie)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><img src="{{ $categorie->imagepath }}"
                                                        style="width: 50px; height: 50px;" alt="{{ $categorie->name }}">
                                                </td>
                                                <td>{{ $categorie->name }}</td>
                                                <td>{{ $categorie->parentName() }}</td>
                                                <td>
                                                    <a href="{{ route('sub-categories', $categorie->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        {{ $categorie->subCategories->count() }}</a>
                                                </td>
                                                <td>{{ __($categorie->status()) }}</td>
                                                <td>
                                                    @if ($categorie->user_id > 0 and $categorie->user_id != null)
                                                        {{ $categorie->created_at->diffForHumans() }} <br>
                                                        {{ $categorie->created_at->format('Y-m-d') }}
                                                        ({{ $categorie->created_at->format('h:i') }})
                                                        {{ $categorie->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                        <br>
                                                        {{ $categorie->createBy?->name }}
                                                    @else
                                                        {{ __('no_update') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($categorie->last_update > 0 and $categorie->last_update != null)
                                                        {{ $categorie->updated_at->diffForHumans() }} <br>
                                                        {{ $categorie->updated_at->format('Y-m-d') }}
                                                        ({{ $categorie->updated_at->format('h:i') }})
                                                        {{ $categorie->updated_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                        <br>
                                                        {{ $categorie->updateBy?->name }}
                                                    @else
                                                        {{ __('no_update') }}
                                                    @endif
                                                </td>
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
