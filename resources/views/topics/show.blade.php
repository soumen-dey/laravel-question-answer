@extends('layouts.app')

@section('title', $topic->name)

@section('content')

<div class="container" id="app">
	<div class="row">
		<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
			<div class="card margin-bottom-big">
				<div class="card-body">
					<h4 class="text-gray"><b>{{ $topic->name }}</b></h4>
				</div>
				<div class="card-footer">
					<a href="?v=top" class="btn btn-link">Top Questions</a>
					<a href="?v=unanswered" class="btn btn-link">Unanswered</a>
					<a href="?v=recent" class="btn btn-link">Recent</a>

					@if($topic->isFollowing())
						<button class="btn btn-success float-right"
								@click.prevent="followTopic"
								data-id="{{ $topic->id }}">
							<i class="fa fa-check"></i> Following | {{ _number_format($topic->follows->count()) }}
						</button>
					@else
						<button class="btn btn-outline-secondary float-right"
								@click.prevent="followTopic"
								data-id="{{ $topic->id }}">
							<i class="fa fa-plus"></i> Follow | {{ _number_format($topic->follows->count()) }}
						</button>
					@endif

					<a href="{{ route('topics.question', $topic->slug) }}" class="btn btn-info float-right margin-right-short"><i class="fa fa-comment-alt"></i> Ask Question</a>
				</div>
			</div>
			<br />

			<!-- GET data not set -->
			@if(!isset($_GET['v']))
				<h4 class="text-gray">Top Questions</h4>
				<hr />
				@if($topQuestions->count())
					@foreach($topQuestions as $topQuestion)
						<div class="card margin-bottom-big">
							<div class="card-body">
								<h4 class="text-gray">{{ $topQuestion->title }}</h4>
								<hr />
								<small class="text-muted"><i class="fa fa-clock"></i> {{ $topQuestion->created_at->diffForHumans() }}</small>&nbsp;&nbsp;&nbsp;
								<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($topQuestion->views->count()) }}</small>

								@if($topQuestion->isFollowing())
									<button class="btn btn-success btn-sm float-right"
											@click.prevent="followQuestion"
											data-id="{{ $topQuestion->id }}">
										<i class="fa fa-check"></i> Following | {{ _number_format($topQuestion->follows->count()) }}
									</button>
								@else
									<button class="btn btn-outline-secondary btn-sm float-right"
											@click.prevent="followQuestion"
											data-id="{{ $topQuestion->id }}">
										<i class="fa fa-plus"></i> Follow | {{ _number_format($topQuestion->follows->count()) }}
									</button>
								@endif

								<a href="{{ route('questions.show', $topQuestion->slug) }}" class="btn btn-primary btn-sm float-right margin-right-short"><i class="fa fa-pencil-alt"></i> Answer</a>
							</div>
						</div>
					@endforeach
				@else
					<div class="card margin-bottom-big">
						<div class="card-body">
							<div class="text-center">
								<h4 class="text-gray">No Questions Yet</h4>
								<a href="{{ route('topics.question', $topic->slug) }}" class="btn btn-info"><i class="fa fa-comment-alt"></i> Ask Question</a>
							</div>
						</div>
					</div>
				@endif
			@endif
			<!-- /. GET data not set -->

			<!-- Top questions -->
			@if(isset($_GET['v']) && $_GET['v'] == 'top')
				<h4 class="text-gray">Top Questions</h4>
				<hr />
				@if($topQuestions->count())
					@foreach($topQuestions as $question)
						<div class="card margin-bottom-big">
							<div class="card-body">
								<h4 class="text-gray">{{ $question->title }}</h4>
								<hr />
								<small class="text-muted"><i class="fa fa-clock"></i> {{ $question->created_at->diffForHumans() }}</small>&nbsp;&nbsp;&nbsp;
								<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($question->views->count()) }}</small>
								
								@if($question->isFollowing())
									<button class="btn btn-success btn-sm float-right"
											@click.prevent="followQuestion"
											data-id="{{ $question->id }}">
										<i class="fa fa-check"></i> Following | {{ _number_format($question->follows->count()) }}
									</button>
								@else
									<button class="btn btn-outline-secondary btn-sm float-right"
											@click.prevent="followQuestion"
											data-id="{{ $question->id }}">
										<i class="fa fa-plus"></i> Follow | {{ _number_format($question->follows->count()) }}
									</button>
								@endif

								<a href="{{ route('questions.show', $question->slug) }}" class="btn btn-primary btn-sm float-right margin-right-short"><i class="fa fa-pencil-alt"></i> Answer</a>
							</div>
						</div>
					@endforeach
				@else
					<div class="card margin-bottom-big">
						<div class="card-body">
							<div class="text-center">
								<h4 class="text-gray">No Questions Yet</h4>
								<a href="{{ route('topics.question', $topic->slug) }}" class="btn btn-info"><i class="fa fa-comment-alt"></i> Ask Question</a>
							</div>
						</div>
					</div>
				@endif
			@endif
			<!-- /. Top questions -->

			<!-- Unanswered Questions -->
			@if(isset($_GET['v']) && $_GET['v'] == 'unanswered')
				<h4 class="text-gray">Unanswered Questions</h4>
				<hr />
				@if($unansweredQuestions->count())
					@foreach($unansweredQuestions as $unansweredQuestion)
						<div class="card margin-bottom-big">
							<div class="card-body">
								<h4 class="text-gray">{{ $unansweredQuestion->title }}</h4>
								<hr />
								<small class="text-muted"><i class="fa fa-clock"></i> {{ $unansweredQuestion->created_at->diffForHumans() }}</small>&nbsp;&nbsp;&nbsp;
								<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($unansweredQuestion->views->count()) }}</small>
								
								@if($unansweredQuestion->isFollowing())
									<button class="btn btn-success btn-sm float-right"
											@click.prevent="followQuestion"
											data-id="{{ $unansweredQuestion->id }}">
										<i class="fa fa-check"></i> Following | {{ _number_format($unansweredQuestion->follows->count()) }}
									</button>
								@else
									<button class="btn btn-outline-secondary btn-sm float-right"
											@click.prevent="followQuestion"
											data-id="{{ $unansweredQuestion->id }}">
										<i class="fa fa-plus"></i> Follow | {{ _number_format($unansweredQuestion->follows->count()) }}
									</button>
								@endif

								<a href="{{ route('questions.show', $unansweredQuestion->slug) }}" class="btn btn-primary btn-sm float-right margin-right-short"><i class="fa fa-pencil-alt"></i> Answer</a>
							</div>
						</div>
					@endforeach
				@else
					<div class="card margin-bottom-big">
						<div class="card-body">
							<div class="text-center">
								<h4 class="text-gray">No Questions Yet</h4>
								<a href="{{ route('topics.question', $topic->slug) }}" class="btn btn-info"><i class="fa fa-comment-alt"></i> Ask Question</a>
							</div>
						</div>
					</div>
				@endif
			@endif
			<!-- /. Unanswered Questions -->

			<!-- Recent Questions -->
			@if(isset($_GET['v']) && $_GET['v'] == 'recent')
				<h4 class="text-gray">Recent Questions</h4>
				<hr />
				@if($recentQuestions->count())
					@foreach($recentQuestions as $recentQuestion)
						<div class="card margin-bottom-big">
							<div class="card-body">
								<h4 class="text-gray">{{ $recentQuestion->title }}</h4>
								<hr />
								<small class="text-muted"><i class="fa fa-clock"></i> {{ $recentQuestion->created_at->diffForHumans() }}</small>&nbsp;&nbsp;&nbsp;
								<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($recentQuestion->views->count()) }}</small>
								
								@if($recentQuestion->isFollowing())
									<button class="btn btn-success btn-sm float-right"
											@click.prevent="followQuestion"
											data-id="{{ $recentQuestion->id }}">
										<i class="fa fa-check"></i> Following | {{ _number_format($recentQuestion->follows->count()) }}
									</button>
								@else
									<button class="btn btn-outline-secondary btn-sm float-right"
											@click.prevent="followQuestion"
											data-id="{{ $recentQuestion->id }}">
										<i class="fa fa-plus"></i> Follow | {{ _number_format($recentQuestion->follows->count()) }}
									</button>
								@endif

								<a href="{{ route('questions.show', $recentQuestion->slug) }}" class="btn btn-primary btn-sm float-right margin-right-short"><i class="fa fa-pencil-alt"></i> Answer</a>
							</div>
						</div>
					@endforeach
				@else
					<div class="card margin-bottom-big">
						<div class="card-body">
							<div class="text-center">
								<h4 class="text-gray">No Questions Yet</h4>
								<a href="{{ route('topics.question', $topic->slug) }}" class="btn btn-info"><i class="fa fa-comment-alt"></i> Ask Question</a>
							</div>
						</div>
					</div>
				@endif
			@endif
			<!-- /. Recent Questions -->
		</div>
		<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
			<div class="card-group">
				<div class="card">
					<div class="card-body text-center">
						<h2 class="no-margin-bottom">{{ _number_format($topic->follows->count()) }}</h2>
						<small>{{ str_plural('Follower', $topic->follows->count()) }}</small>
					</div>
				</div>
				<div class="card">
					<div class="card-body text-center">
						<h2 class="no-margin-bottom">{{ _number_format($topic->questions->count()) }}</h2>
						<small>{{ str_plural('Question', $topic->questions->count()) }}</small>
					</div>
				</div>
				<div class="card">
					<div class="card-body text-center">
						<h2 class="no-margin-bottom">{{ _number_format($totalAnswers) }}</h2>
						<small>{{ str_plural('Answer', $totalAnswers) }}</small>
					</div>
				</div>
			</div>
			<br />
			<h5>Some related Topics you might like</h5>
			<hr />
			<div class="card margin-bottom-big">
				@foreach($topics as $related)
					<div class="card-body" style="padding: 10px; border-bottom: 1px solid rgba(0,0,0,.125);">
						<a href="{{ route('topics.show', $related->slug) }}" class="text-gray block margin-bottom-short"><b>{{ $related->name }}</b></a>
						<small class="text-gray">{{ _number_format($related->questions->count()) }} Questions</small> &nbsp;&#9679;&nbsp;
						<small class="text-gray">{{ _number_format($related->follows->count()) }} Followers</small>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
<script type="text/javascript" src="{{ asset('js/vue.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/axios.js') }}"></script>
<script type="text/javascript">
	var app = new Vue({
		el: '#app',
		methods: {
			followTopic: function(event) {
				let element = event.currentTarget
				let id = element.getAttribute('data-id');

				axios.post("{{ route('follow.topic') }}", {id: id})
					.then(function(response) {
						if (response.data.message == 'unfollowed') {
							element
								.innerHTML = "<i class='fa fa-plus'></i> Follow | " + response.data.count;
							
							element.classList.add('btn-outline-secondary');
							element.classList.remove('btn-success');
						} else if(response.data.message == 'followed') {
							element
								.innerHTML = "<i class='fa fa-check'></i> Following | " + response.data.count;
							
							element.classList.add('btn-success');
							element.classList.remove('btn-outline-secondary');

						}
					});
			},

			followQuestion: function(event) {
				let element = event.currentTarget
				let id = element.getAttribute('data-id');

				axios.post("{{ route('follow.question') }}", {id: id})
					.then(function(response) {
						if (response.data.message == 'unfollowed') {
							element
								.innerHTML = "<i class='fa fa-plus'></i> Follow | " + response.data.count;
							
							element.classList.add('btn-outline-secondary');
							element.classList.remove('btn-success');
						} else if(response.data.message == 'followed') {
							element
								.innerHTML = "<i class='fa fa-check'></i> Following | " + response.data.count;
							
							element.classList.add('btn-success');
							element.classList.remove('btn-outline-secondary');

						}
					});
			},
		}
	});
</script>
@endsection