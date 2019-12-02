@extends('pages.admin.metronic.layout.application',['menu' => 'histories'] )

@section('metadata')
@stop

@section('styles')
    <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.5/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.5/css/froala_style.min.css' rel='stylesheet' type='text/css' />
    <style>
        .row {
            margin-bottom: 15px;
        }

        .bootstrap-tagsinput, .fr-box {
            width: 100%;
            min-height: 100px;
        }
        .bootstrap-tagsinput input[type="text"] {
            width: 100%;
        }
    </style>
@stop

@section('scripts')
    <script src="{!! \URLHelper::asset('libs/metronic/demo/default/custom/crud/forms/validation/form-controls.js', 'admin') !!}"></script>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.5/js/froala_editor.pkgd.min.js'></script>

    <script>
        $(document).ready(function () {
            $('#cover-image').change(function (event) {
                $('#cover-image-preview').attr('src', URL.createObjectURL(event.target.files[0]));
            });

            $('.datetime-picker').datepicker({format: "yyyy",
            viewMode: "years", 
            minViewMode: "years"});
        });

        Boilerplate.imageUploadUrl = "{!! URL::action('Admin\ArticleController@postImage') !!}";
        Boilerplate.imageUploadParams = {
            "article_id" : "{!! empty($history->id) ? 0 : $history->id !!}",
            "_token": "{!! csrf_token() !!}"
        };
        Boilerplate.imagesLoadURL = "{!! URL::action('Admin\ArticleController@getImages') !!}";
        Boilerplate.imagesLoadParams = {
            "article_id" : "{!! empty($history->id) ? 0 : $history->id !!}"
        };
        Boilerplate.imageDeleteURL = "{!! URL::action('Admin\ArticleController@deleteImage') !!}";
        Boilerplate.imageDeleteParams = {
            "_token": "{!! csrf_token() !!}",
            "article_id" : "{!! empty($history->id) ? 0 : $history->id !!}"
        };
    </script>
    <script src="{{ \URLHelper::asset('js/pages/articles/edit.js', 'admin/metronic') }}"></script>
@stop

@section('title')
    History | Admin | {{ config('site.name') }}
@stop

@section('header')
    History
@stop

@section('breadcrumb')
    <li class="m-nav__separator"> / </li>
    <li class="m-nav__item">
        <a href="{!! action('Admin\HistoryController@index') !!}" class="m-nav__link">
            History
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
            {{ $history->id }}
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
                        <a href="{!! action('Admin\HistoryController@index') !!}" class="btn m-btn--pill m-btn--air btn-secondary btn-sm" style="width: 120px;">
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

            <form class="m-form m-form--fit" action="@if($isNew){!! action('Admin\HistoryController@store') !!}@else{!! action('Admin\HistoryController@update', [$history->id]) !!}@endif" method="POST" enctype="multipart/form-data">
                @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
                {!! csrf_field() !!}

                <div class="m-portlet__body" style="padding-top: 0;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-form__group row @if ($errors->has('date_start')) has-danger @endif">
                                <label for="date_start">@lang('admin.pages.histories.columns.date_start')</label>
                                <input type="text" class="form-control m-input datetime-picker" name="date_start" id="date_start" required placeholder="@lang('admin.pages.histories.columns.date_start')" value="{{ old('date_start') ? old('date_start') : $history->date_start }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-form__group row" style="max-width: 500px;">
                                @if( !empty($history->present()->coverImage()) )
                                <img id="cover-image-preview" style="max-width: 100%;" src="{!! $history->present()->coverImage()->present()->url !!}" alt="" class="margin"/>
                                @else
                                <img id="cover-image-preview" style="max-width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" class="margin"/>
                                @endif
                                <input type="file" style="display: none;" id="cover-image" name="cover-image">
                                <p class="help-block" style="font-weight: bolder; display: block; width: 100%; text-align: center;">
                                    @lang('admin.pages.histories.columns.cover_image_id')
                                    <label for="cover-image" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-form__group row @if ($errors->has('content')) has-danger @endif">
                                <label for="content">@lang('admin.pages.histories.columns.content')</label>
                                <textarea name="content" id="froala-editor" class="form-control m-input" rows="3">{{ old('content') ? old('content') : $history->content }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <a href="{!! action('Admin\HistoryController@index') !!}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-accent" style="width: 120px;">
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
