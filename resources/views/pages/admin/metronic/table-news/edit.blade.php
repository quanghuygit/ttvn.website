@extends('pages.admin.metronic.layout.application',['menu' => 'table-news'] )

@section('metadata')
@stop

@section('styles')
    <style>
        .row {
            margin-bottom: 15px;
        }
    </style>
@stop

@section('scripts')
    <script src="{!! \URLHelper::asset('libs/metronic/demo/default/custom/crud/forms/validation/form-controls.js', 'admin') !!}"></script>
    <script>
        $(document).ready(function () {
            $('#cover-image').change(function (event) {
                $('#cover-image-preview').attr('src', URL.createObjectURL(event.target.files[0]));
            });

            $('.datetime-picker').datetimepicker({
                todayHighlight: true,
                autoclose: true,
                pickerPosition: 'bottom-left',
                format: 'yyyy/mm/dd hh:ii'
            });
        });
    </script>
@stop

@section('title')
    TableNew | Admin | {{ config('site.name') }}
@stop

@section('header')
    TableNew
@stop

@section('breadcrumb')
    <li class="m-nav__separator"> / </li>
    <li class="m-nav__item">
        <a href="{!! action('Admin\TableNewController@index') !!}" class="m-nav__link">
            TableNew
        </a>
    </li>

    @if( $isNew )
        <li class="m-nav__separator"> / </li>
        <li class="m-nav__item">
            New Record
        </li>
    @else
        <li class="m-nav__separator"> / </li>
        <li class="m-nav__item">
            {{ $tableNew->id }}
        </li>
    @endif
@stop

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Create New Record
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{!! action('Admin\TableNewController@index') !!}" class="btn m-btn--pill m-btn--air btn-secondary btn-sm" style="width: 120px;">
                            @lang('admin.pages.common.buttons.back')
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="m-portlet__body">
            @if(isset($errors) && count($errors))
                {{ $errs = $errors->all() }}
                <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                    <strong>
                        Error !!!
                    </strong>
                    <ul>
                        @foreach($errs as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="m-form m-form--fit" action="@if($isNew){!! action('Admin\TableNewController@store') !!}@else{!! action('Admin\TableNewController@update', [$tableNew->id]) !!}@endif" method="POST">
                @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
                {!! csrf_field() !!}

                <div class="m-portlet__body" style="padding-top: 0;">
                                                                        <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group m-form__group row @if ($errors->has('name')) has-danger @endif">
                                        <label for="name">@lang('admin.pages.table-news.columns.name')</label>
                                        <input type="text" class="form-control m-input" name="name" id="name" required placeholder="@lang('admin.pages.table-news.columns.name')" value="{{ old('name') ? old('name') : $tableNew->name }}">
                                    </div>
                                </div>
                            </div>
                                                                                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group m-form__group row @if ($errors->has('slug')) has-danger @endif">
                                        <label for="slug">@lang('admin.pages.table-news.columns.slug')</label>
                                        <input type="text" class="form-control m-input" name="slug" id="slug" required placeholder="@lang('admin.pages.table-news.columns.slug')" value="{{ old('slug') ? old('slug') : $tableNew->slug }}">
                                    </div>
                                </div>
                            </div>
                                                                                                                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group m-form__group row" style="max-width: 500px;">
                                        @if( !empty($tableNew->present()->coverImage()) )
                                        <img id="cover-image-preview" style="max-width: 100%;" src="{!! $tableNew->present()->coverImage()->present()->url !!}" alt="" class="margin"/>
                                        @else
                                        <img id="cover-image-preview" style="max-width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" class="margin"/>
                                        @endif
                                        <input type="file" style="display: none;" id="cover-image" name="cover-image">
                                        <p class="help-block" style="font-weight: bolder; display: block; width: 100%; text-align: center;">
                                            @lang('admin.pages.table-news.columns.cover_image_id')
                                            <label for="cover-image" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                                                                                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group m-form__group row @if ($errors->has('new_category_id')) has-danger @endif">
                                        <label for="new_category_id">@lang('admin.pages.table-news.columns.new_category_id')</label>
                                        <input type="number" min="0" class="form-control m-input" name="new_category_id" id="new_category_id" required placeholder="@lang('admin.pages.table-news.columns.new_category_id')" value="{{ old('new_category_id') ? old('new_category_id') : $tableNew->new_category_id }}">
                                    </div>
                                </div>
                            </div>
                                                                                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-form__group row @if ($errors->has('display')) has-danger @endif">
                                        <label for="display" class="label-switch">@lang('admin.pages.table-news.columns.display')</label>
                                        <span class="m-switch m-switch--outline m-switch--icon m-switch--primary">
                                            <label>
                                                <input type="checkbox" id="display" name="display" value="1" @if( $tableNew->display) checked @endif>
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                                                                                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group m-form__group row @if ($errors->has('order')) has-danger @endif">
                                        <label for="order">@lang('admin.pages.table-news.columns.order')</label>
                                        <input type="number" min="0" class="form-control m-input" name="order" id="order" required placeholder="@lang('admin.pages.table-news.columns.order')" value="{{ old('order') ? old('order') : $tableNew->order }}">
                                    </div>
                                </div>
                            </div>
                                                                                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group m-form__group row @if ($errors->has('meta_title')) has-danger @endif">
                                        <label for="meta_title">@lang('admin.pages.table-news.columns.meta_title')</label>
                                        <input type="text" class="form-control m-input" name="meta_title" id="meta_title" required placeholder="@lang('admin.pages.table-news.columns.meta_title')" value="{{ old('meta_title') ? old('meta_title') : $tableNew->meta_title }}">
                                    </div>
                                </div>
                            </div>
                                                                                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group m-form__group row @if ($errors->has('meta_description')) has-danger @endif">
                                        <label for="meta_description">@lang('admin.pages.table-news.columns.meta_description')</label>
                                        <input type="text" class="form-control m-input" name="meta_description" id="meta_description" required placeholder="@lang('admin.pages.table-news.columns.meta_description')" value="{{ old('meta_description') ? old('meta_description') : $tableNew->meta_description }}">
                                    </div>
                                </div>
                            </div>
                                                                                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group m-form__group row @if ($errors->has('sapo')) has-danger @endif">
                                        <label for="sapo">@lang('admin.pages.table-news.columns.sapo')</label>
                                        <textarea name="sapo" id="sapo" class="form-control m-input" rows="3" placeholder="@lang('admin.pages.table-news.columns.sapo')">{{ old('sapo') ? old('sapo') : $tableNew->sapo }}</textarea>
                                    </div>
                                </div>
                            </div>
                                                                                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group m-form__group row @if ($errors->has('content')) has-danger @endif">
                                        <label for="content">@lang('admin.pages.table-news.columns.content')</label>
                                        <textarea name="content" id="content" class="form-control m-input" rows="3" placeholder="@lang('admin.pages.table-news.columns.content')">{{ old('content') ? old('content') : $tableNew->content }}</textarea>
                                    </div>
                                </div>
                            </div>
                                                                                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group m-form__group row @if ($errors->has('auth')) has-danger @endif">
                                        <label for="auth">@lang('admin.pages.table-news.columns.auth')</label>
                                        <input type="text" class="form-control m-input" name="auth" id="auth" required placeholder="@lang('admin.pages.table-news.columns.auth')" value="{{ old('auth') ? old('auth') : $tableNew->auth }}">
                                    </div>
                                </div>
                            </div>
                                                                                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-form__group row @if ($errors->has('is_enabled')) has-danger @endif">
                                        <label for="is_enabled" class="label-switch">@lang('admin.pages.table-news.columns.is_enabled')</label>
                                        <span class="m-switch m-switch--outline m-switch--icon m-switch--primary">
                                            <label>
                                                <input type="checkbox" id="is_enabled" name="is_enabled" value="1" @if( $tableNew->is_enabled) checked @endif>
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                                                            </div>

                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <a href="{!! action('Admin\TableNewController@index') !!}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-accent" style="width: 120px;">
                                    @lang('admin.pages.common.buttons.cancel')
                                </a>
                                <button type="submit" class="btn m-btn--pill m-btn--air btn-primary m-btn m-btn--custom" style="width: 120px;">
                                    @lang('admin.pages.common.buttons.save')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
