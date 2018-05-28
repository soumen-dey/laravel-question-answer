@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-header custom-card-header"><h4>Edit Profile</h4></div>
				<div class="card-body">
					<form method="POST" action="{{ route('users.update') }}" id="user_update">
						@csrf

                        <div class="form-group">
                            <label><b>Name</b></label>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $user->name) }}" placeholder="Your Name">

                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label><b>Bio</b></label>
                            <textarea rows="5" style="resize: none;" class="form-control{{ $errors->has('bio') ? ' is-invalid' : '' }}" name="bio" placeholder="A short bio">
                            	{{ old('bio', $user->detail->bio) ?? '' }}
                            </textarea>

                            @if ($errors->has('bio'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('bio') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label><b>Qualification</b></label>
                            <input type="text" class="form-control{{ $errors->has('qualification') ? ' is-invalid' : '' }}" name="qualification" value="{{ old('qualification', $user->detail->qualification) ?? '' }}" placeholder="Your Qualification">

                            @if ($errors->has('qualification'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('qualification') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label><b>Working At</b></label>
                            <input type="text" class="form-control{{ $errors->has('working') ? ' is-invalid' : '' }}" name="working" value="{{ old('working', $user->detail->works_at) }}" placeholder="Working At">

                            @if ($errors->has('working'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('working') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label><b>College</b></label>
                            <input type="text" class="form-control{{ $errors->has('college') ? ' is-invalid' : '' }}" name="college" value="{{ old('college', $user->detail->college) ?? '' }}" placeholder="Your College">

                            @if ($errors->has('college'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('college') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label><b>Designation</b></label>
                            <input type="text" class="form-control{{ $errors->has('designation') ? ' is-invalid' : '' }}" name="designation" value="{{ old('designation', $user->detail->designation) ?? '' }}" placeholder="Your Designation">

                            @if ($errors->has('designation'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('designation') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                        	<div class="row">
                        		<div class="col-md-6 col-lg-6 col-sm- col-xs-">
		                            <label><b>Date of Birth</b></label>
		                            <input type="date" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" name="dob" value="{{ old('dob', $user->detail->dob) }}" placeholder="Your Date of Birth">

		                            @if ($errors->has('dob'))
		                                <span class="invalid-feedback">
		                                    <strong>{{ $errors->first('dob') }}</strong>
		                                </span>
		                            @endif
                        		</div>
                        		<div class="col-md-6 col-lg-6 col-sm- col-xs-">
                        			<label><b>City</b></label>
		                            <select class="form-control" name="city">
		                            	@if($user->detail->city)
		                            		<option value="{{ $user->detail->city->id }}">{{ $user->detail->city->name }}</option>
		                            	@endif

		                            	@foreach($cities as $city)
		                            		<option value="{{ $city->id }}">{{ $city->name }}</option>
		                            	@endforeach
		                            </select>

		                            @if ($errors->has('city'))
		                                <span class="invalid-feedback">
		                                    <strong>{{ $errors->first('city') }}</strong>
		                                </span>
		                            @endif
                        		</div>
                        	</div>
                        </div>
					</form>
				</div>
				<div class="card-footer custom-card-footer">
					<button form="user_update" class="btn btn-info float-right">Save Changes</button>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')

@endsection