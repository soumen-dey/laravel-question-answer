@extends('layouts.app')

@section('title', 'Browse Questions')

@section('content')

<div class="container">
	<div class="row justify-content-center" v-if="showQuestionRow">
        <div class="col-md-8">
        	<form action="" method="GET">
        		@csrf
	        	<div class="input-group input-group-lg mb-3">
	                <input type="text" value="{{ request()->has('q') ? request()->q : '' }}" class="form-control input-with-border" placeholder="Search for..." name="q">
	                <div class="input-group-append">
	                    <span class="input-group-text input-group-append-with-border" id="basic-addon2"><i class="fa fa-search"></i></span>
	                </div>
	            </div>
        	</form>

            @if(request()->has('q') && $questions->count() > 0)
            	<h4 class="text-gray">Search results for <b>{{ request()->q }}</b></h4>
            	<hr />
            @endif

            @if(request()->has('q') && $questions->count() == 0)
            	<h4 class="text-gray">No results for <b>{{ request()->q }}</b></h4>
            @endif

            @foreach($questions as $question)
                <div class="card margin-bottom-big">
                    <div class="card-body">
                        <h4 class="text-gray">{{ $question->title }}</h4>

                        <small class="text-muted"><i class="fa fa-clock"></i> {{ $question->created_at->diffForHumans() }}</small>&nbsp;&nbsp;&nbsp;
                        <small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($question->views->count()) }}</small>&nbsp;&nbsp;&nbsp;
                        <small class="text-muted"><i class="fa fa-pencil-alt"></i> {{ _number_format($question->answers->count()) }}</small>

                        <a href="{{ route('questions.show', $question->slug) }}" class="btn btn-outline-primary btn-sm float-right margin-right-short">View Question</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@section('script')

@endsection