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
    {{__('dashboard.permissions')}}

@endsection


@section('Headtitle')
    {{__('dashboard.permissions')}}
@endsection

@section('content')
     <div class="container">
    <form method="Post" action="{{route('permissions.update', $permission)}}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Permission Name</label>
            <input type="text" value="{{$permission->name}}" class="form-control" id="name" name="name">

            @error('name')
            <span class="error">{{$message}}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
     </div>
     <div class="container p-3">
         <label for="name">Roles</label>
        <div>
            @if ($permission->roles)
                @foreach ($permission->roles as $permission_role)
                    <form  method="POST"
                          action="{{ route('permissions.roles.remove', [$permission->id, $permission_role->id]) }}"
                          onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ $permission_role->name }}</button>
                    </form>
                @endforeach
            @endif
        </div>
     </div>
     <div class="container p-3">
            <form method="POST" action="{{ route('permissions.roles', $permission->id) }}">
                @csrf
                <div class="sm:col-span-6">
                    <label for="role" class="block text-sm font-medium text-gray-700">Roles</label>
                    <select id="role" name="role" autocomplete="role-name"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('role')
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
