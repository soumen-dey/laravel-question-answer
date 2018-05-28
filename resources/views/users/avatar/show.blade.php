@extends('layouts.app')

@section('title', 'Change Avatar')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/dropzone.css') }}">
<style type="text/css">
	.dropzone {
		border: 3px dashed #3498db;
	}
</style>
@endsection

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-header custom-card-header">
					<h4 class="text-gray">Change Avatar</h4>
				</div>
				<div class="card-body">
					<div class="text-center mb-4">
						<img src="{{ route('users.avatar.get', auth()->user()->avatar->file_name) }}" width="150px" height="150px" class="mb-3" style="border-radius: 50%;">
						<h4 class="text-gray">{{ auth()->user()->name }}</h4>
					</div>
					<form action="{{ route('users.avatar.store') }}" class="dropzone" id="avatar">
						@csrf
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
<script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>
<script type="text/javascript">
	Dropzone.options.avatar = {
		init: function() {
			this.on('success', function($file) {
				window.location.href = "{{ route('users.show', auth()->user()->id) }}";
			});
		},
		paramName: 'avatar',
		maxFileSize: 2
	}
</script>
@endsection