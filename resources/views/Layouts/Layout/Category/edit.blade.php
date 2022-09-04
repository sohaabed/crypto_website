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
                    <h4 class="card-title">Edit Category Form</h4>
                    @if (count($errors) > 0)
                        <ul>
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger col-sm-6" role="alert">
                                    {{$error}}
                                </div>
                            @endforeach
                        </ul>

                    @endif
                    <form class="m-t-40" method="Post" novalidate
                          action="{{route('categories.update' , $category)}}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <h5>Name Field <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="title" class="form-control" required
                                       value="{{$category->title}}"
                                       data-validation-required-message="This field is required"></div>
                        </div>
                        <div class="form-group">
                            <h5>Description Field <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="description" class="form-control" required
                                       value="{{$category->description}}"
                                       data-validation-required-message="This field is required"></div>
                        </div>
                        <div class="form-group">
                            <h5>Active Field <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="number" name="active" class="form-control col-sm-1" required min="0"
                                       max="1" value="{{$category->active}}"
                                       data-validation-required-message="This field is required"></div>
                        </div>

                        <div class="text-xs-right">
                            <button type="submit" class="btn btn-info">Update</button>
                            <button type="reset" class="btn btn-inverse">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
