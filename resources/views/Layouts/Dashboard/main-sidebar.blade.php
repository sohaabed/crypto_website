<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User Profile-->
                    <div class="user-profile dropdown m-t-20">
                        <div class="user-pic">
                            <img src="{{asset('assets/images/1.jpg')}}" alt="users"
                                 class="rounded-circle img-fluid"/>
                        </div>
                        <div class="user-content hide-menu m-t-10">
                            <h5 class="m-b-10 user-name font-medium">{{Auth::user()->name}}</h5>
                            <a href="javascript:void(0)" class="btn btn-circle btn-sm m-r-5" id="Userdd"
                               role="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="ti-settings"></i>
                            </a>

                            <a class="btn btn-circle btn-sm" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="ti-power-off"></i>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <div class="dropdown-menu animated flipInY" aria-labelledby="Userdd">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-user m-r-5 m-l-5"></i>{{__('dashboard.myProfile')}}</a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-wallet m-r-5 m-l-5"></i> {{__('dashboard.myBalance')}}</a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-email m-r-5 m-l-5"></i> {{__('dashboard.inbox')}}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-settings m-r-5 m-l-5"></i> {{__('dashboard.accountSetting')}}</a>
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i>
                                    {{__('dashboard.logout')}}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End User Profile-->
                </li>

                {{--                <li class="sidebar-item">--}}
                {{--                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"--}}
                {{--                       aria-expanded="false">--}}
                {{--                        <i class="icon-Car-Wheel"></i>--}}
                {{--                        <span class="hide-menu">{{__('dashboard.Category')}}</span>--}}
                {{--                    </a>--}}
                {{--                    <ul aria-expanded="false" class="collapse  first-level">--}}
                {{--                        <li class="sidebar-item">--}}
                {{--                            <a href="{{url('categories')}}" class="sidebar-link">--}}
                {{--                                <i class="icon-Record"></i>--}}
                {{--                                <span class="hide-menu"> {{__('dashboard.ShowCategory')}} </span>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                @if(\Illuminate\Support\Facades\Session::has('impersonate'))
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false"
                           href="{{ route('impersonate_back') }}">
                            <i class="mdi mdi-directions"></i>
                            <span class="hide-menu">Add User Task </span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false"
                           href="{{ route('impersonate_back') }}">
                            <i class="mdi mdi-directions"></i>
                            <span class="hide-menu">Back to Admin</span>
                        </a>
                    </li>
                @endif()



            @if(\Illuminate\Support\Facades\Auth::user()->hasRole('admin'))

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="icon-Car-Wheel"></i>
                            <span class="hide-menu">{{__('dashboard.roles')}}</span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="{{url('roles')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.roles')}} </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{url('roles/create')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.addRoles')}} </span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="icon-Car-Wheel"></i>
                            <span class="hide-menu">{{__('dashboard.permissions')}}</span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="{{url('permissions')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.permissions')}} </span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="icon-Car-Wheel"></i>
                            <span class="hide-menu">{{__('dashboard.user')}}</span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="{{url('users')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.user')}} </span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="{{url('users/create')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.AddUser')}} </span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif

                @if(\Illuminate\Support\Facades\Auth::user()->hasRole(['admin','owner']))
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="icon-Car-Wheel"></i>
                            <span class="hide-menu">{{__('dashboard.Categories')}}</span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="{{url('categories')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.Categories')}} </span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="{{route('categories.create')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.AddCategory')}} </span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="icon-Car-Wheel"></i>
                            <span class="hide-menu">{{__('dashboard.SubCategories')}}</span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="{{url('subcategories')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.SubCategories')}} </span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="{{route('subcategories.create')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.AddSubCategory')}} </span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="icon-Car-Wheel"></i>
                            <span class="hide-menu">{{__('dashboard.Restaurants')}}</span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="{{url('restaurants')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.Restaurants')}} </span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="{{route('restaurants.create')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.AddRestaurant')}} </span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="icon-Car-Wheel"></i>
                            <span class="hide-menu">{{__('dashboard.Products')}}</span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item">
                                <a href="{{url('products')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.Products')}} </span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="{{route('products.create')}}" class="sidebar-link">
                                    <i class="icon-Record"></i>
                                    <span class="hide-menu"> {{__('dashboard.AddProduct')}} </span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif


                <li class="sidebar-item">

                    <a class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false"
                       href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-directions"></i>
                        <span class="hide-menu">{{__('dashboard.logout')}}</span>

                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
