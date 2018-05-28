@extends('layouts.app')

@section('title', 'Add Topic')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-header custom-card-header"><h4 class="text-gray"><b>Add Topic</b></h4></div>
				<div class="card-body">
					<form action="{{ route('topics.store') }}" method="POST">
						@csrf
						<div class="form-group">
							<label for="title">Topic Title</label>
							<input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Topic Title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}">
							@if ($errors->has('title'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-primary float-right" value="Add Topic">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')

@endsection