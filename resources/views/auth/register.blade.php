<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ __('Register') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/logo-icon.png')}}">
    @include('Layouts.Dashboard.css-links')

</head>

<body>
<div class="main-wrapper">
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
         style="background:url({{asset('assets/images/auth-bg.jpg')}}) no-repeat center center;">
        <div class="auth-box">
            <div>
                <div class="logo">
                    <span class="db"><img src="{{asset('assets/images/logo-icon.png')}}" alt="logo"/></span>
                    <h5 class="font-medium m-b-20">Sign Up</h5>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form method="POST" class="form-horizontal m-t-20" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group row ">
                                <div class="col-12 ">
                                    <input id="name" name="name" required autocomplete="name" autofocus
                                           value="{{ old('name') }}"
                                           class="form-control form-control-lg @error('name') is-invalid @enderror"
                                           type="text" required=" " placeholder="Name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-12 ">
                                    <input id="email" type="email" class="form-control form-control-lg @error('email')
                                        is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-12 ">
                                    <input id="password" type="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           name="password" placeholder="Password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12 ">
                                    <input id="password-confirm" type="password" class="form-control form-control-lg"
                                           name="password_confirmation" required
                                           autocomplete="new-password" placeholder="Confirm Password">
                                </div>
                            </div>


                            <div class="form-group text-center ">
                                <div class="col-xs-12 p-b-20 ">
                                    <button class="btn btn-block btn-lg btn-info "
                                            type="submit">{{ __('Register') }}</button>
                                </div>
                            </div>


                            <div class="form-group m-b-0 m-t-10 ">
                                <div class="col-sm-12 text-center ">
                                    Already have an account? <a href="{{route('login')}}"
                                                                class="text-info m-l-5 "><b>Sign In</b></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('Layouts.Dashboard.script-links')

<script>
    $('[data-toggle="tooltip "]').tooltip();
    $(".preloader ").fadeOut();
</script>
</body>

</html>
