@extends('layouts.app')

@section('title', 'Edit Answer')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">

			<div class="card">
				<div class="card-header custom-card-header">
					<h4 class="text-gray"><b>Edit Answer</b></h4>
				</div>
				<div class="card-body">
					<form action="{{ route('answers.update') }}" method="POST">
						@csrf
						<input type="hidden" name="answer" value="{{ $answer->id }}">

						<div class="form-group">
							<label for="body">Question Body (optional)</label>
							<textarea name="body" id="body" placeholder="Question Body" class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" style="resize:none;" rows="6">{{ old('body', $answer->body) }}</textarea>
							<small class="text-muted">Explain your answer in simple words, do not use abusive language.</small>

							@if ($errors->has('body'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                            @endif
						</div>
						<div class="form-group">
							<label for="reference">References (optional)</label>
							<input type="text" name="reference" id="reference" placeholder="References" class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" value="{{ old('reference', $answer->reference) }}">

							@if ($errors->has('reference'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('reference') }}</strong>
                                </span>
                            @endif
						</div>
						<div class="form-group">
							<label>
								<input type="checkbox" name="anonymous" {{ ($answer->is_anonymous == 1) ? 'checked' : '' }}"> Ask Anonymously
							</label>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Save Changes">
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