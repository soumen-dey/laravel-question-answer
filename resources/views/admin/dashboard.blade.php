@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-body">
					<a href="{{ route('admin.reports.questions') }}" class="card-title text-gray h4 mb-4"><b>Reported Questions</b></a>
					<p class="card-text mb-0">Total Reported</p>
					<h4 class="text-gray mt-0">{{ _number_format($questions->count()) }}</h4>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-body">
					<a href="{{ route('admin.reports.answers') }}" class="card-title text-gray h4 mb-4"><b>Reported Answers</b></a>
					<p class="card-text mb-0">Total Reported</p>
					<h4 class="text-gray mt-0">{{ _number_format($answers->count()) }}</h4>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title text-gray"><b>Users</b></h4>
					<p class="card-text mb-0">Total Users</p>
					<h4 class="text-gray mt-0">{{ _number_format($users->count()) }}</h4>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')

@endsection