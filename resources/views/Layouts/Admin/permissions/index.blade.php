@extends('Layouts.Dashboard.master')
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp
@section('css')
@endsection

@section('js')

@endsection

@section('title')
    {{__('dashboard.permissions')}}

@endsection

@section('title-side')
   <a href="{{route('permissions.index')}}"> {{__('dashboard.permissions')}}</a>

@endsection


@section('Headtitle')
    {{__('dashboard.permissions')}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
{{--            <div class="col-6 pb-2">--}}
{{--                <a href="{{route('permissions.create')}}"><button type="button" class="btn btn-info">Add Permission</button></a>--}}
{{--            </div>--}}
            <div class="col-12">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Guard Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <th scope="row">{{++$i}}</th>
                            <td>{{$permission->name}}</td>
                            <td>{{$permission->guard_name}}</td>
                            <td>
                                <a href="{{route('permissions.show' , $permission)}}">
                                    <button type="button" class="btn btn-info"><i
                                            class="fas fa-eye"></i></button>
                                </a>
{{--                                <a href="{{route('permissions.edit' , $permission)}}">--}}
                                {{--                                    <button type="button" class="btn btn-success"><i--}}
                                {{--                                            class="fas fa-edit"></i></button>--}}
                                {{--                                </a>--}}
                                <form style="display: inline-block" method="Post" action="{{route('permissions.destroy' , $permission->id)}}">
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


