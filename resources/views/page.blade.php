@extends('layouts.app')

@section('title', $page)

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-header custom-card-header"><h2 class="text-gray"><b>{{ $page }}</b></h2></div>
				<div class="card-body">
					@for($i = 0; $i < rand(1, 5); $i++)
						<p class="text-gray">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</p>
					@endfor
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')

@endsection