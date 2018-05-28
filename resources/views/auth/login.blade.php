<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/laravel.css') }}">
    <!-- Custom stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Script -->
    <script src="{{ asset('js/jquery.slim.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</head>
    <body>
        <div class="container">
            <div class="row" style="margin-top: 3rem;margin-bottom: 3rem;">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="text-center">
                        <h1 class="font-gugi text-muted">{{ config('app.name') }}</h1>
                    </div>
                </div>
            </div>
            <div class="row" style="height: 100%;">
                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 d-flex justify-content-center" style="border-right: 1px solid #7f8c8d;padding-top: 2rem;padding-bottom: 2rem;">
                    <div class="card shadow-light" style="width: 80%;border-radius: 0px !important;">
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <label><b>Email</b></label>
                                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="example@example.com">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label><b>Password</b></label>
                                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" placeholder="Password">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <label>
                                    <input type="checkbox" name="remember">
                                    Remeber Me
                                </label>
                                <br />
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-block" value="Login">
                                </div>
                                <div class="text-center">
                                    <a href="">Forgot Password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 align-self-center justify-content-center d-flex">
                    <div class="card" style="background-color: transparent;border: 0px;">
                        <div class="card-body">
                            <h1 class="text-muted" style="font-weight: lighter;">Not Already Registered?</h1>
                            <p class="text-muted" style="font-weight: lighter;">Join the experts and answer some of the most intriguing questions ever asked! Or have a question? Just ask it and get answered!</p>
                            <a href="{{ route('register') }}" class="btn btn-info btn-lg">Register for Free</a>&nbsp;&nbsp;&nbsp;
                            <a href="{{ route('welcome') }}" class="btn btn-link">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <br />
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="text-center">
                        <p class="text-muted">&copy; {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>