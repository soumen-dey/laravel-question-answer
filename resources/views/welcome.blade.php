<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Welcome | {{ config('app.name') }}</title>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet" type="text/css">

	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
	<!-- Custom stylesheet -->
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">

	<!-- Script -->
	<script src="{{ asset('js/jquery.slim.js') }}"></script>
	<script src="{{ asset('js/popper.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-transparent navbar-custom">
		<div class="container">
			<a class="navbar-brand" href="#">{{ config('app.name') }}</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					@if(auth()->guest())
						<li><a href="{{ route('register') }}" class="nav-link margin-right-medium">Register</a></li>
						<form class="form-inline my-2 my-lg-0">
							<a href="{{ route('login') }}" class="btn btn-info my-2 my-sm-0 margin-left-short">Login</a>
						</form>
					@else
						<li><a href="{{ route('home') }}" class="nav-link margin-right-medium">Home</a></li>
						<li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('users.show', auth()->user()->id) }}" style="color: #000000 !important" class="dropdown-item">Profile</a>
                                    <a href="{{ route('topics.add') }}" style="color: #000000 !important" class="dropdown-item">Add Topic</a>
                                    <a class="dropdown-item" style="color: #000000 !important" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	<div class="jumbotron jumbotron-background">
		<div class="container">
			<div class="row" style="height: 100%;">
				<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 align-self-center	">
					<h1 style="font-weight: lighter;line-height: 1.5;">Got a Question in Mind?</h1>
					<h3 style="font-weight: lighter;line-height: 1.5;">Ask thousands of experts, get your questions answered!</h3>
					<div class="margin-bottom-big"></div>
					<form action="{{ route('questions') }}" method="GET">
						<div class="input-group input-group-lg mb-3">
							<input type="text" name="q" class="form-control input-custom" placeholder="Search for Knowledge" aria-label="Recipient's username" aria-describedby="basic-addon2">
							<div class="input-group-append">
								<span class="input-group-text input-group-append-custom" id="basic-addon2"><i class="fa fa-search"></i></span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="section">
			<div class="text-center">
				<h2 class="text-gray">Ask What You Want</h2>
				<br />
			</div>
			<div class="row">
				<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
					<div class="text-center padding-big info-section">
						<img src="{{ asset('icons/telescope.png') }}">
						<h3>Curious</h3>
						<p>Want to know about something? No worries just ask it!</p>
					</div>
				</div>
				<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
					<div class="text-center padding-big info-section">
						<img src="{{ asset('icons/bookshelf.png') }}">
						<h3>Get Answered</h3>
						<p>Find exactly what you are looking for, no need to spend hours on searh engines!</p>
					</div>
				</div>
				<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
					<div class="text-center padding-big info-section">
						<img src="{{ asset('icons/notebook.png') }}">
						<h3>Just for Knowledge</h3>
						<p>Not in mood for asking? Just follow others and see what they are upto!</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sub-section">
		<div class="container">
			<div class="row" style="height: 100%;">
				<div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
					<img src="{{ asset('images/sub-section.jpg') }}">
				</div>
				<div class="col-md-5 col-lg-5 col-sm-12 col-xs-12 align-self-center">
					<h2>Ask an Expert or Be the Expert!</h2>
					<p style="font-size: 1rem;">Have knowledge that you have the urge to share? Want to find people who will read and understand your knowledge? Answer questions posted by others and make the difference!</p>
					<a href="{{ route('home') }}" class="btn btn-outline-light btn-lg">Answer Questions</a>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="section">
			<h2 class="text-gray text-center margin-bottom-huge">Some Trending Questions</h2>
			<div class="row">
				@foreach($questions as $question)
					<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
						<div class="card margin-bottom-big">
							<div class="card-body">
								<h5 class="text-gray">{{ str_limit($question->title, 80) }}</h5>
							</div>
							<div class="card-footer custom-card-footer">
								<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format(mt_rand(50, 50000)) }}</small>&nbsp;&nbsp;&nbsp;
								<small class="text-muted"><i class="fa fa-pencil-alt"></i> {{ _number_format(mt_rand(50, 50000)) }}</small>&nbsp;&nbsp;&nbsp;
								<small class="text-muted"><i class="fa fa-user"></i> {{ _number_format(mt_rand(50, 50000)) }}</small>&nbsp;&nbsp;&nbsp;
								<a href="{{ route('questions.show', $question->slug) }}" class="btn btn-outline-primary float-right">View Question</a>
							</div>
						</div>
					</div>
				@endforeach
			</div>
			<br />
			<div class="text-center">
				<a href="{{ route('home') }}" class="btn btn-outline-secondary">View More Question</a>
			</div>
		</div>
	</div>
	<div class="jumbotron no-margin-bottom no-border-radius" style="background-color: rgb(62, 69, 81);color: #ffffff">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
					<h4>{{ config('app.name') }}</h4>
					<p class="text-cloud">{{ config('app.name') }} is a place to gain and share knowledge. It's a platform to ask questions and connect with people who contribute unique insights and quality answers.</p>
				</div>
				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 footer-about-us">
					<h4>About Us</h4>
					<ul>
						<li><a href="{{ route('page', 'contact-us') }}">Contact Us</a></li>
						<li><a href="{{ route('page', 'about-us') }}">About Us</a></li>
						<li><a href="{{ route('page', 'reviews') }}">Reviews</a></li>
					</ul>
				</div>
				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 footer-about-us">
					<h4>Get Started</h4>
					<ul>
						<li><a href="{{ route('home') }}">Home</a></li>
						<li><a href="{{ route('register') }}">Sign up</a></li>
						<li><a href="{{ route('login') }}">Login</a></li>
					</ul>
				</div>
				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 footer-about-us">
					<h4>Support</h4>
					<ul>
						<li><a href="{{ route('page', 'terms') }}">Terms</a></li>
						<li><a href="{{ route('page', 'privacy') }}">Privacy</a></li>
						<li><a href="{{ route('page', 'faq') }}">FAQ</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="jumbotron no-margin-bottom no-border-radius footer-signup">
		<div class="text-center">
			<h4 class="margin-bottom-huge">Not already registered?</h4>
			<a href="{{ route('register') }}" class="btn btn-danger btn-lg">Register for Free</a>
		</div>
	</div>
	<div class="jumbotron no-margin-bottom no-border-radius footer-copyright">
		<div class="text-center">
			&copy; {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.
		</div>
	</div>
</body>
</html>