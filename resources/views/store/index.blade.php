@extends('layouts.app')
@section('title', __('lang.stores'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.stores')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="#">@lang('lang.settings')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.stores')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-store" href="{{route('store.create')}}">@lang('lang.add_store')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <div class="card mt-3">
                @if(session('status'))
                    @if(session('status')['success'])
                        <div class="alert alert-success" id="alert">
                            {{ session('status')['msg'] }}
                        </div>
                    @else
                        <div class="alert alert-danger" id="alert">
                            {{ session('status')['msg'] }}
                        </div>
                    @endif
                @endif
                <div class="card-header d-flex align-items-center">
                    <h4 class="print-title">@lang('lang.stores')</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="store_table" class="table dataTable">
                            <thead>
                            <tr>
                                <th>@lang('lang.name')</th>
                                <th>@lang('lang.phone_number')</th>
                                <th>@lang('lang.email')</th>
                                <th>@lang('lang.manager_name')</th>
                                <th>@lang('lang.manager_mobile_number')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stores as $store)
                                <tr>
                                    <td>{{$store->name}}</td>
                                    <td>{{$store->phone_number}}</td>
                                    <td>{{$store->email}}</td>
                                    <td>{{$store->manager_name}}</td>
                                    <td>{{$store->manager_mobile_number}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">@lang('lang.action')
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                user="menu">
                                                @can('settings.store.create_and_edit')
                                                    <li>

                                                        <a data-href="{{action('StoreController@edit', $store->id)}}"
                                                           data-container=".view_modal" class="btn btn-modal"><i
                                                                class="dripicons-document-edit"></i> @lang('lang.edit')</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                @endcan
                                                @can('settings.store.delete')
                                                    <li>
                                                        <a data-href="{{action('StoreController@destroy', $store->id)}}"
                                                           data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                                           class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                            @lang('lang.delete')</a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

            {{--     create store modal      --}}

    <div class="modal fade add-store" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['url' => route('store.store'), 'method' => 'post', 'id' => 'add_store' ]) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleLargeModalLabel">@lang('lang.add_store')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('name', __('lang.name')) .'*' !!}
                            {!! Form::text('name',null, ['class' => 'form-control' , 'placeholder' => __('lang.name') , 'required']);  !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('phone_number', __('lang.phone_number'))  !!}
                            {!! Form::text('phone_number',null, ['class' => 'form-control' , 'placeholder' => __('lang.phone_number') ]);  !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', __('lang.name'))  !!}
                            {!! Form::text('email',null, ['class' => 'form-control' , 'placeholder' => __('lang.email') ]);  !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('manager_name', __('lang.manager_name'))  !!}
                            {!! Form::text('manager_name',null, ['class' => 'form-control' , 'placeholder' => __('lang.manager_name') ]);  !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('manager_mobile_number', __('lang.manager_mobile_number'))  !!}
                            {!! Form::text('manager_mobile_number',null, ['class' => 'form-control' , 'placeholder' => __('lang.manager_mobile_number') ]);  !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('details', __('lang.details'))  !!}
                            {!! Form::textarea('email',null, ['class' => 'form-control' , 'placeholder' => __('lang.details') , 'rows' => '2']);  !!}
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                        {!! Form::submit(__('lang.save'),['class' => 'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        setTimeout(function() {
            $('#alert').fadeOut('fast');
        }, 3000);
    </script>
@endsection
