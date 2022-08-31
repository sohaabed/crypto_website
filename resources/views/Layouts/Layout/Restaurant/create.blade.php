@extends('Layouts.Dashboard.master')
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp
@section('css')
    <link href="{{asset('assets/libs/jquery.steps.css')}}" rel="stylesheet">
    <link href="{{asset('assets/libs/steps.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-material-datetimepicker.css')}}">

@endsection

@section('js')
    <script src="{{asset('assets/extra-libs/validation.js')}}"></script>
    <script src="{{asset('assets/libs/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/libs/moment.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap-material-datetimepicker-custom.js')}}"></script>
    <script>
        // MAterial Date picker
        $('#timepicker1').bootstrapMaterialDatePicker({format: 'HH:mm', time: true, date: false});
        $('#timepicker2').bootstrapMaterialDatePicker({format: 'HH:mm', time: true, date: false});
    </script>
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
    {{__('dashboard.AddRestaurant')}}
@endsection

@section('title-side')
    {{__('dashboard.AddRestaurant')}}
@endsection

@section('Headtitle')
    {{__('dashboard.AddRestaurant')}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Restaurant Form</h4>
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
                          action="{{route('restaurants.store')}}">
                        @csrf
                        <div class="form-group">
                            <h5>Name Field <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="name" class="form-control" required
                                       data-validation-required-message="This field is required"></div>
                        </div>
                        <div class="form-group">
                            <h5>Description Field <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" name="description" class="form-control" required
                                       data-validation-required-message="This field is required"></div>
                        </div>
                        <div class="form-group">
                            <h5>Phone Field <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" class="form-control phone-inputmask" id="phoneNumber"
                                       name="phoneNumber" required
                                       data-validation-required-message="This field is required"
                                       placeholder="Enter Phone Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Open Time Picker<span class="text-danger">*</span></h5>
                            <div class="controls col-12">
                                <input class="form-control" id="timepicker1" name="start_at"
                                       data-validation-required-message="This field is required"
                                       placeholder="Open time">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Close Time Picker<span class="text-danger">*</span></h5>
                            <div class=" controls col-12">
                                <input class="form-control" id="timepicker2" name="end_at"
                                       data-validation-required-message="This field is required"
                                       placeholder="Close time">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Owner<span class="text-danger">*</span> <small>Open this select menu</small></h5>
                            <div class=" controls col-12">
                                <select required class="form-control form-select-lg mb-3" aria-label=".form-select-lg example" id="owner_id" name="owner_id">
                                    @foreach($allUsers as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Category<span class="text-danger">*</span></h5>
                            <div class=" controls col-12">
                                @foreach($allCategory as $category)
                                    <div class="custom-control custom-checkbox">
                                        <label class="checkbox">
                                            <input type="checkbox" name="category_id[]"
                                                   id="{{ $category->id }}"
                                                   value="{{ $category->id }}">
                                            {{$category->title}}
                                        </label>

                                    </div>
                                @endforeach
                            </div>
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

                        <div class="mapform">
                            <div class="row">
                                <div class="col-5">
                                    <input type="text" class="form-control" required placeholder="latitude"
                                           name="latitude" id="latitude">
                                </div>
                                <div class="col-5">
                                    <input type="text" class="form-control" required placeholder="longitude"
                                           name="longitude" id="longitude">
                                </div>
                            </div>

                            <div id="map" style="height:400px; width: 800px;" class="my-3"></div>

                            <script>
                                let map;

                                function initMap() {
                                    map = new google.maps.Map(document.getElementById("map"), {
                                        center: {lat: -34.397, lng: 150.644},
                                        zoom: 8,
                                        scrollwheel: true,
                                    });
                                    const uluru = {lat: -34.397, lng: 150.644};
                                    let marker = new google.maps.Marker({
                                        position: uluru,
                                        map: map,
                                        draggable: true
                                    });
                                    google.maps.event.addListener(marker, 'position_changed',
                                        function () {
                                            let lat = marker.position.lat()
                                            let lng = marker.position.lng()
                                            $('#latitude').val(lat)
                                            $('#longitude').val(lng)
                                        })
                                    google.maps.event.addListener(map, 'click',
                                        function (event) {
                                            pos = event.latLng
                                            marker.setPosition(pos)
                                        })
                                }
                            </script>
                            <script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"
                                    type="text/javascript"></script>
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



