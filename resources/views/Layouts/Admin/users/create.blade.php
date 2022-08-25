@extends('Layouts.Dashboard.master')
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp
@section('css')

@endsection

@section('js')
    <script src="{{asset('assets/extra-libs/validation.js')}}"></script>
    <script src="{{asset('assets/libs/dropzone.min.js')}}"></script>

    <script>
        !function (window, document, $) {
            "use strict";
            $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
        }(window, document, jQuery);

        var loadFile = function (event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endsection

@section('title')
    {{__('dashboard.AddUser')}}
@endsection

@section('title-side')
    {{__('dashboard.AddUser')}}
@endsection

@section('Headtitle')
    {{__('dashboard.AddUser')}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add User Form</h4>
                    @if (count($errors) > 0)
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger" role="alert">
                                        {{$error}}
                                    </div>
                                @endforeach
                            </ul>

                    @endif
                    <form class="m-t-40" method="Post" enctype='multipart/form-data' novalidate
                          action="{{route('users.store')}}">
                        @csrf
                        <div class="form-group">
                            <h5>Name Field <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="name" class="form-control" required
                                       data-validation-required-message="This field is required"></div>
                        </div>
                        <div class="form-group">
                            <h5>Email Field <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="email" name="email" class="form-control" required
                                       data-validation-required-message="This field is required"></div>
                        </div>
                        <div class="form-group">
                            <h5>Phone Field <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" class="form-control phone-inputmask" id="phone_number"
                                       name="phone_number" required
                                       data-validation-required-message="This field is required"
                                       placeholder="Enter Phone Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Password Input Field <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="password" name="password" class="form-control" required
                                       data-validation-required-message="This field is required"></div>
                        </div>
                        <div class="form-group">
                            <h5>Repeat Password Input Field <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="password" name="confirm-password" data-validation-match-match="password"
                                       class="form-control" required></div>
                        </div>
                        <div class="form-group">
                            <h5>Image Field <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="file" name="file" accept="image/*"
                                       id="file" onchange="loadFile(event)"
                                       class="form-control">
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="file">Uploaded Image</label>
                            <img id="output" width="200"/>
                        </div>
                        <div class="text-xs-right">
                            <button type="submit" class="btn btn-info">Submit</button>
                            <button type="reset" class="btn btn-inverse">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection



