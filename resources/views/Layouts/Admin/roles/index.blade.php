@extends('Layouts.Dashboard.master')
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp
@section('css')
@endsection

@section('js')

@endsection

@section('title')
    {{__('dashboard.roles')}}

@endsection

@section('title-side')
    {{__('dashboard.roles')}}

@endsection


@section('Headtitle')
    {{__('dashboard.roles')}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 pb-2">
                <a href="{{route('roles.create')}}"><button type="button" class="btn btn-info">Add Role</button></a>
            </div>
            <div class="col-12">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <th scope="row">{{++$i}}</th>
                            <td>{{$role->name}}</td>
                            <td>
                                <a href="{{route('roles.edit' , $role)}}">
                                    <button type="button" class="btn btn-success">
                                        <i class="fas fa-edit"></i></button>
                                </a>
                                <form style="display: inline-block" method="Post" action="{{route('roles.destroy' , $role->id)}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onsubmit="return confirm('Are you sure ?')"
                                        class="btn btn-danger">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
