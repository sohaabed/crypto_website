@extends('Layouts.Dashboard.master')
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp
@section('css')

@endsection

@section('js')
    <script src="{{asset('assets/extra-libs/validation.js')}}"></script>
    <script>
        !function (window, document, $) {
            "use strict";
            $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
        }(window, document, jQuery);
    </script>
@endsection

@section('title')
    {{$category->title}}
@endsection

@section('title-side')
    {{__('dashboard.Categories')}}

@endsection


@section('Headtitle')
    {{__('dashboard.Categories')}}

@endsection



@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Show Category</h4>

                    <div class="form-group">
                        <h5>Name Field <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="title" class="form-control" required disabled value="{{$category->title}}"
                                   data-validation-required-message="This field is required"></div>
                    </div>
                    <div class="form-group">
                        <h5>Description Field <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" name="description" class="form-control" required disabled value="{{$category->description}}"
                                   data-validation-required-message="This field is required"></div>
                    </div>
                    <div class="form-group">
                        <h5>Active Field <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="number" name="active" class="form-control col-sm-1" required min="0"
                                   max="1" disabled  value="{{$category->active}}"
                                   data-validation-required-message="This field is required"></div>
                    </div>

                    <div class="text-xs-right">
                        <a href="{{route('categories.edit' , $category)}}">
                            <button type="submit" class="btn btn-info">Edit</button>

                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
