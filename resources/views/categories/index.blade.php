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
                <br/>
                {{-- +++++++++++++++ Style : checkboxes and labels inside selectbox +++++++++++++++ --}}
                <style>
                    .selectBox {
                    position: relative;
                    }

                    /* selectbox style */
                    .selectBox select
                    {
                        width: 100%;
                        padding: 0 !important;
                        padding-left: 4px;
                        padding-right: 4px;
                        color: #fff;
                        border: 1px solid #596fd7;
                        background-color: #596fd7;
                        height: 39px !important;
                    }

                    .overSelect {
                    position: absolute;
                    left: 0;
                    right: 0;
                    top: 0;
                    bottom: 0;
                    }

                    #checkboxes {
                    display: none;
                    border: 1px #dadada solid;
                    height: 125px;
                    overflow: auto;
                    padding-top: 10px;
                    /* text-align: end;  */
                    }

                    #checkboxes label {
                    display: block;
                    padding: 5px;

                    }

                    #checkboxes label:hover {
                    background-color: #ddd;
                    }
                    #checkboxes label span
                    {
                        font-weight: normal;
                    }
                </style>
                {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                <div class="col-md-4 col-lg-4">
                    <div class="multiselect col-md-6">
                        <div class="selectBox" onclick="showCheckboxes()">
                            <select class="form-select form-control form-control-lg">
                                <option>@lang('lang.show_hide_columns')</option>
                            </select>
                            <div class="overSelect"></div>
                        </div>
                        <div id="checkboxes">
                            {{-- +++++++++++++++++ checkbox1 : # +++++++++++++++++ --}}
                            <label for="col1_id">
                                <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                <span>#</span> &nbsp;
                            </label>
                            {{-- +++++++++++++++++ checkbox2 : cover +++++++++++++++++ --}}
                            <label for="col2_id">
                                <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                <span>@lang('categories.cover')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox3 : categorie_name +++++++++++++++++ --}}
                            <label for="col3_id">
                                <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                <span>@lang('categories.categorie_name')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox4 : categories.parent +++++++++++++++++ --}}
                            <label for="col4_id">
                                <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                <span>@lang('categories.parent')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox5 : categories.status +++++++++++++++++ --}}
                            <label for="col5_id">
                                <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                <span>@lang('categories.status')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox6 : added_by +++++++++++++++++ --}}
                            <label for="col6_id">
                                <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                <span>@lang('lang.added_by')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox7 : updated_by +++++++++++++++++ --}}
                            <label for="col7_id">
                                <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                <span>@lang('lang.updated_by')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox8 : categories.action +++++++++++++++++ --}}
                            <label for="col8_id">
                                <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                <span>@lang('categories.action')</span>
                            </label>

                        </div>
                    </div>
                </div> <br/>
                <div class="card m-b-30">
                    <div class="card-body">
                        @if (@isset($categories) && !@empty($categories) && count($categories) > 0 )
                           @include('categories.filter')
                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="col1">#</th>
                                            <th class="col2">@lang('categories.cover')</th>
                                            <th class="col3">@lang('categories.categorie_name')</th>
                                            <th class="col4">@lang('categories.parent')</th>
                                            <th class="col5">@lang('categories.status')</th>
                                            <th class="col6">@lang('added_by')</th>
                                            <th class="col7">@lang('updated_by')</th>
                                            <th class="col8">@lang('categories.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $index=>$categorie)
                                            <tr>
                                                <td class="col1">{{ $index+1 }}</td>
                                                <td class="col2"><img src="{{$categorie->imagepath}}" style="width: 50px; height: 50px;" alt="{{ $categorie->name }}" ></td>
                                                <td class="col3">{{ $categorie->name }}</td>
                                                <td class="col4">
                                                    @if($categorie->parent_id == 1)
                                                        Category 1
                                                    @elseif ($categorie->parent_id == 2)
                                                        Category 2
                                                    @elseif ($categorie->parent_id == 3)
                                                        Category 3
                                                    @else
                                                        Category 4
                                                    @endif
                                                </td>
                                                                                                {{-- <td>
                                                    <a href="{{ route('sub-categories', $categorie->id) }}" class="btn btn-sm btn-primary">
                                                        {{ $categorie->subCategories->count() }}</a>
                                                </td> --}}
                                                <td class="col5">{{ __($categorie->status())}}</td>
                                                <td class="col6">
                                                    @if ($categorie->user_id  > 0 and $categorie->user_id != null)
                                                        {{ $categorie->created_at->diffForHumans() }} <br>
                                                        {{ $categorie->created_at->format('Y-m-d') }}
                                                        ({{ $categorie->created_at->format('h:i') }})
                                                        {{ ($categorie->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                        {{ $categorie->createBy?->name }}
                                                    @else
                                                    {{ __('no_update') }}
                                                    @endif
                                                </td>
                                                <td class="col7">
                                                    @if ($categorie->last_update  > 0 and $categorie->last_update != null)
                                                        {{ $categorie->updated_at->diffForHumans() }} <br>
                                                        {{ $categorie->updated_at->format('Y-m-d') }}
                                                        ({{ $categorie->updated_at->format('h:i') }})
                                                        {{ ($categorie->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                        {{ $categorie->updateBy?->name }}
                                                    @else
                                                       {{ __('no_update') }}
                                                    @endif
                                                </td>
                                                <td class="col8">
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
@section('javascript')
    {{-- +++++++++++++++ Show/Hide checkboxes +++++++++++++++ --}}
    <script>
        // +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++
        $("input:checkbox:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });

        $("input:checkbox").click(function(){
            var column = "table ." + $(this).attr("name");
            $(column).toggle();
        });
        // +++++++++++++++++ Checkboxs and label inside selectbox : showCheckboxes() method ++++++++++++++
        var expanded = false;
        function showCheckboxes()
        {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }
    </script>
@endsection
