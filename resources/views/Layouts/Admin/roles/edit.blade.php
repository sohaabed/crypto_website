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
        <form method="Post" action="{{route('roles.update', $role)}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Role Name</label>
                <input type="text" value="{{$role->name}}" class="form-control" id="name" name="name">

                @error('name')
                <span class="error">{{$message}}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <div class="container p-3">
        <label for="name">Role Permissions</label>
        <div>
            @if ($role->permissions)
                @foreach ($role->permissions as $role_permission)
                    <form method="POST"
                          action="{{ route('roles.permissions.revoke',[$role->id, $role_permission->id]) }}"
                          onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ $role_permission->name }}</button>
                    </form>
                @endforeach
            @endif
        </div>
    </div>
    <div class="container p-3">
        <form method="POST" action="{{ route('roles.permissions', $role->id) }}">
            @csrf
            <div class="sm:col-span-6">
                <label for="role" class="block text-sm font-medium text-gray-700">Permissions</label>
                <select id="role" name="role" autocomplete="role-name"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white
                        rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('name')
            <span class="text-red-400 text-sm">{{ $message }}</span>
            @enderror

            <div class="sm:col-span-6 pt-3">
                <button type="submit"
                        class="btn btn-primary">Assign
                </button>
            </div>
        </form>
    </div>
@endsection
