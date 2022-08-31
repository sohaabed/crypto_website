@extends('Layouts.Dashboard.master')
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp

@section('css')
    <link href="{{asset('assets/extra-libs/dataTables.bootstrap4.css')}}" rel="stylesheet">

@endsection

@section('Headtitle')
    {{__('dashboard.Restaurants')}}

@endsection

{{--@section('js')--}}
{{--    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>--}}
{{--    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>--}}
{{--    <script type="text/javascript">--}}

{{--            $(function () {--}}
{{--            var table = $('.restaurants_datatable').DataTable({--}}
{{--                dom: 'Bfrtip',--}}
{{--                processing: true,--}}
{{--                serverSide: true,--}}
{{--                ajax: "{{ route('restaurants.index') }}",--}}
{{--                columns: [--}}
{{--                    {data: 'id', name: 'id'},--}}
{{--                    {data: 'name', name: 'name'},--}}
{{--                    {data: 'logo', name: 'logo'},--}}
{{--                    //  {data: 'description', name: 'description'},--}}
{{--                    {data: 'phoneNumber', name: 'phoneNumber'},--}}
{{--                    // {data: 'address', name: 'address'},--}}
{{--                    {data: 'rating', name: 'rating'},--}}
{{--                    // {data: 'NumRating', name: 'NumRating'},--}}
{{--                    {data: 'start_at', name: 'start_at'},--}}
{{--                    {data: 'end_at', name: 'end_at'},--}}
{{--                    {--}}
{{--                        data: 'action', name: 'action',--}}
{{--                        orderable: false,--}}
{{--                        searchable: false--}}
{{--                    },--}}
{{--                ],--}}

{{--            });--}}

{{--        } );--}}

{{--    </script>--}}
{{--@endsection--}}

@section('title')
    {{__('dashboard.Restaurants')}}
@endsection

@section('title-side')
    {{__('dashboard.Restaurants')}}
@endsection

@section('content')

{{--    <div class="row">--}}
{{--        <div class="col-6 pb-2">--}}
{{--            <a href="{{url('restaurants/create')}}">--}}
{{--                <button type="button" class="btn btn-info">  {{__('dashboard.AddRestaurant')}}</button>--}}
{{--            </a>--}}
{{--        </div>--}}
{{--        <div class="col-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <div class="table-responsive">--}}
{{--                        <table id="alt_pagination"--}}
{{--                               class="table  table-striped table-bordered display display restaurants_datatable"--}}
{{--                               style="width:100%">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#</th>--}}
{{--                                <th>Name</th>--}}
{{--                                <th>Logo</th>--}}
{{--                                --}}{{--                        <th scope="col">Description</th>--}}
{{--                                <th>Phone Number </th>--}}
{{--                                <th>Address</th>--}}
{{--                                <th>Rating</th>--}}
{{--                                --}}{{--                        <th scope="col">NumRating</th>--}}
{{--                                <th>Start_at</th>--}}
{{--                                <th>End_at</th>--}}
{{--                                <th>Actions</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}

{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}


{{$product}}

@endsection




