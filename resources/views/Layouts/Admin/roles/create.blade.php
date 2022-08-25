@extends('Layouts.Dashboard.master')
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp
@section('css')
    <style>

        .container {
            padding: 2rem 0rem;
        }

        h4 {
            margin: 2rem 0rem 1rem;
        }

        .table-image {

        td, th {
            vertical-align: middle;
        }

        }
    </style>

@endsection

@section('js')

@endsection

@section('title')
    <a href="{{route('roles.index')}}" style="color: #3e5569"> {{__('dashboard.roles')}}</a>

@endsection

@section('title-side')
   <a href="{{route('roles.index')}}" style="color: #3e5569"> {{__('dashboard.roles')}}</a>

@endsection


@section('Headtitle')
    {{__('dashboard.roles')}}
@endsection

@section('content')
    <form method="Post" action="{{route('roles.store')}}">
        @csrf
        <div class="form-group">
            <label for="name">Role Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">

            @error('name')
            <span class="error">{{$message}}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
@endsection
