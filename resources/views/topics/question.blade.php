@extends('layouts.app')

@section('title', 'Add Question')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-header">Add a Question</div>
				<div class="card-body">
					<form action="{{ route('topics.storeQuestion') }}" method="POST">
						@csrf
						<input type="hidden" name="topic" value="{{ $topic->id }}">
						<div class="form-group">
							<label for="title">Question Title (start with "why", "how", etc.)</label>
							<input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Question Body" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}">
							@if ($errors->has('title'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
						</div>
						<div class="form-group">
							<label for="body">Question Body (optional)</label>
							<textarea name="body" id="body" placeholder="Question Body" class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" style="resize:none;" rows="6">{{ old('body') }}</textarea>
							<small class="text-muted">Explain your question in simple words, do not use abusive language.</small>

							@if ($errors->has('body'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                            @endif
						</div>
						<div class="form-group">
							<label for="reference">References (optional)</label>
							<input type="text" name="reference" id="reference" placeholder="References" class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" value="{{ old('reference') }}">

							@if ($errors->has('reference'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('reference') }}</strong>
                                </span>
                            @endif
						</div>
						<div class="form-group">
							<label>
								<input type="checkbox" name="anonymous"> Ask Anonymously
							</label>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Ask Question">
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