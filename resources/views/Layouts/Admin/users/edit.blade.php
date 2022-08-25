@extends('Layouts.Dashboard.master')
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp
@section('css')
@endsection

@section('js')
@endsection

@section('title')
    {{__('dashboard.user')}}
@endsection

@section('title-side')
    {{__('dashboard.user')}}
@endsection

@section('Headtitle')
    {{__('dashboard.user')}}
@endsection

@section('content')
    <form method="Post" action="{{route('users.update', $user)}}">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
