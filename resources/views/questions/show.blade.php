@extends('layouts.app')

@section('title', $question->title)

@section('content')

<div class="container" id="app">

	<div class="modal fade" id="answerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-gray" id="exampleModalLabel"><b>{{ $question->title }}</b></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p v-text="answerContent"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
			@if(session()->has('message'))
				<div class="alert alert-success">
					{{ session('message') }}
				</div>
			@endif

			<div class="card margin-bottom-big">
				<div class="card-body">
					<small style="margin-bottom: 1rem;" class="inline-block">
						<a href="{{ route('home') }}" class="black-link underlined">Home</a>
						@if($question->hasTopic())
							 > <a href="{{ route('topics.show', $question->topic->slug) }}" class="black-link underlined">{{ $question->topic->name }}</a>
						@endif
					</small>
					
					<h4 class="text-gray"><b>{{ $question->title }}</b></h4>

					@if($question->reference)
						<small class="blockquote-footer">Reference: {{ $question->reference }}</small>
					@endif
					
					@if($question->body)
						<hr />
						<p class="text-gray">{{ $question->body }}</p>
						@if($question->hasBestAnswer())
							<hr />
							<h5 class="text-gray"><b>Best Answer:</b></h5>
							<p class="text-gray">{{ $question->best_answer->body }}</p>
							@if($question->best_answer->reference)
								<small class="blockquote-footer">{{ $question->best_answer->reference }}</small>
							@endif
						@endif
					@endif
					
				</div>
				<div class="card-footer">
					@if($question->isAnonymous())
						<small class="text-muted"><i class="fa fa-user"></i> Anonymous</small> &nbsp;&nbsp;
					@else
						<small><a href="{{ route('users.show', $question->user->id) }}"><i class="fa fa-user"></i> {{ $question->user->name }}</a></small> &nbsp;&nbsp;
					@endif
					<small class="text-muted"><i class="fa fa-clock"></i> {{ $question->created_at->diffForHumans() }}</small> &nbsp;&nbsp;

					<button class="btn btn-outline-secondary btn-sm float-right" 
								data-id="{{ $question->id }}" 
								v-if="!isFollowingQuestion" @click.prevent="followQuestion">
						<i class="fa fa-plus"></i> Follow | <span v-html="questionFollowers"></span>
					</button>

					<button class="btn btn-success btn-sm float-right" 
								data-id="{{ $question->id }}" 
								v-if="isFollowingQuestion" @click.prevent="followQuestion">
						<i class="fa fa-check"></i> Following | <span v-html="questionFollowers"></span>
					</button>

					@if(!$question->hasAlreadyAnswered())
						<button v-if="showAnswerQuestionBox" @click.prevent="toggleAnswerQuestionBox" class="btn btn-primary btn-sm float-right margin-right-short"><i class="fa fa-pencil-alt"></i> Answer</button>
					@endif

					@if($question->isOwner())
						<a href="{{ route('questions.edit', $question->slug) }}" class="btn btn-outline-info btn-sm margin-right-short float-right">Edit Question</a>
					@endif
				</div>
			</div>

			<div class="card" v-if="!showAnswerQuestionBox">
				<div class="card-body">
					<form @submit.prevent="submitAnswerForm">
						@csrf
						<input type="hidden" name="question" value="{{ $question->id }}">
						<div class="form-group">
							<label>Write your answer here.</label>
							<textarea class="form-control"
									 	v-bind:class="{'is-invalid': errors.body.isError}"
									 	name="answer" 
									 	style="resize: none;" 
									 	rows="8" 
									 	placeholder="Write your answer here." 
									 	v-model="answer.body"></textarea>
							
							<span class="invalid-feedback" v-show="errors.body.isError">
                                <strong v-text="errors.body.message"></strong>
                            </span>
						</div>
						<div class="form-group">
							<label>References (optional)</label>
							<input type="text" 
									name="reference" 
									class="form-control" 
									v-bind:class="{'is-invalid': errors.reference.isError}" 
									placeholder="References" 
									v-model="answer.reference">
							
							<span class="invalid-feedback" v-show="errors.reference.isError">
                                <strong v-text="errors.reference.message"></strong>
                            </span>
						</div>
						<div class="form-group">
							<input type="submit" value="Post Answer" class="btn btn-primary float-right">
							<a href="#" @click.prevent="toggleAnswerQuestionBox" class="btn btn-link float-right margin-right-short">Cancel</a>
						</div>
					</form>
				</div>
			</div>

			@if($question->answers->count())
				<br />
				<h5 class="text-gray">
					<b>
						{{ $question->answers->count() }} {{ str_plural('Answer', 'Answers', $question->answers->count()) }}
					</b>
				</h5>
				<hr />
				@foreach($question->answers as $answer)
					<div id="answer_{{ $answer->id }}"
						class="card margin-bottom-big {{ $answer->isBestAnswer() ? ' border-success' : '' }}">
						<div class="card-body">
							<p class="text-gray link-card"
								@click.prevent="showAnswerModal"
								data-answer="{{ $answer->body }}"
								data-id="{{ $answer->id }}">
								{{ $answer->body }}
							</p>
							
							@if($answer->reference)
								<small class="blockquote-footer">{{ $answer->reference }}</small>
							@endif

							<hr />
							<small><a href="{{ route('users.show', $answer->user->id) }}"><i class="fa fa-user"></i> {{ $answer->user->name }}</a></small> &nbsp;&nbsp;
							<small class="text-muted"><i class="fa fa-clock"></i> {{ $answer->created_at->diffForHumans() }}</small> &nbsp;&nbsp;
							<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($answer->views->count()) }}</small>

							@if($question->isOwner() && !$question->hasBestAnswer())
								<button class="btn btn-outline-dark btn-sm float-right"
										data-id="{{ $answer->id }}"
										data-question="{{ $question->id }}"
										@click.prevent="pickBestAnswer">
									<i class="fa fa-check"></i> Pick as Best
								</button>
							@endif

							@if($answer->hasAlreadyUpvoted())
								<button class="btn btn-info btn-sm float-right margin-right-short"
										@click.prevnet="upvoteAnswer"
										data-id="{{ $answer->id }}"
										data-question="{{ $question->id }}">
									<i class="fa fa-arrow-up"></i> Upvoted | {{ _number_format($answer->upvotes->count()) }}
								</button>
							@else
								<button class="btn btn-outline-info btn-sm float-right margin-right-short"
										@click.prevent="upvoteAnswer"
										data-id="{{ $answer->id }}"
										data-question="{{ $question->id }}">
									<i class="fa fa-arrow-up"></i> Upvote | {{ _number_format($answer->upvotes->count()) }}
								</button>
							@endif

							@if($answer->hasAlreadyDownvoted())
								<button class="btn btn-link btn-sm float-right margin-right-short" disabled>Downvoted</button>
							@else
								<button class="btn btn-link btn-sm float-right margin-right-short"
										@click.prevent="downvoteAnswer"
										data-id="{{ $answer->id }}"
										data-question="{{ $question->id }}">
									Downvote
								</button>
							@endif

							@if($answer->hasAlreadyReported())
								<button class="btn btn-link btn-sm float-right" disabled>
									<i class="fa fa-flag"></i> Reported
								</button>
							@else
								<button class="btn btn-link btn-sm float-right"
										@click.prevent="reportAnswer"
										data-id="{{ $answer->id }}">
									<i class="fa fa-flag"></i> Report
								</button>
							@endif

							@if($answer->isOwner())
								<a href="{{ route('answers.edit', $answer->id) }}" class="btn btn-link btn-sm float-right margin-right-short">
									Edit Answer
								</a>
							@endif

						</div>
					</div>
				@endforeach
			@else
				<div class="card" v-if="showAnswerQuestionBox">
					<div class="card-body">
						<div class="text-center">
							<p class="text-gray">No Answers Yet</p>
							<button @click="toggleAnswerQuestionBox" class="btn btn-primary">
								<i class="fa fa-pencil-alt"></i> Write Answer
							</button>
						</div>
					</div>
				</div>

			@endif
		</div>

		<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
			<div class="card margin-bottom-big">
				<div class="card-body">
					<h6 class="text-gray"><b>Viewed: {{ _number_format($views) }} {{ str_plural('time', $views) }}</b></h6>
					<h6 class="text-gray"><b>Popularity: {{ round($question->getPopularity(), 2) }}%</b></h6>
					<hr />
					@if($question->hasAlreadyReported())
						<button class="btn btn-secondary btn-sm float-right" disabled><i class="fa fa-flag"></i> Reported</button>
					@else
						<button class="btn btn-sm btn-secondary float-right" 
								data-id="{{ $question->id }}" 
								@click.prevent="reportQuestion">
							<i class="fa fa-flag"></i> Report
						</button>
					@endif
				</div>
			</div>
			<h5>Topics you might like</h5>
			<hr />
			@foreach($topics as $topic)
				<div class="card margin-bottom-big">
					<div class="card-body">
						<a class="text-gray block margin-bottom-short"><b>{{ $topic->name }}</b></a>
						<small class="text-gray">{{ _number_format($topic->questions->count()) }} {{ str_plural('Question', $topic->questions->count()) }}</small>
						@if($topic->isFollowing())
							<button class="btn btn-sm btn-success float-right" 
									data-id="{{ $topic->id }}" 
									@click.prevent="followTopic">
								<i class="fa fa-check"></i> Following | {{ _number_format($topic->follows()->count()) }}
							</button>
						@else
							<button class="btn btn-sm btn-info float-right" 
									data-id="{{ $topic->id }}" 
									@click.prevent="followTopic">
								<i class="fa fa-plus"></i> Follow | {{ _number_format($topic->follows()->count()) }}
							</button>
						@endif
					</div>
				</div>
			@endforeach
			<br />
			<h5>Some similar questions</h5>
			<hr />
			<div class="card margin-bottom-big">
				@foreach($questions as $similar)
					<div class="card-body" style="padding: 10px; border-bottom: 1px solid rgba(0,0,0,.125);">
						<a href="{{ route('questions.show', $similar->slug) }}" class="text-gray block margin-bottom-short"><b>{{ $similar->title }}</b></a>
						<small class="text-gray">{{ _number_format($similar->answers->count()) }} {{ str_plural('Answer', $similar->answers->count()) }}</small> &nbsp;&#9679;&nbsp;
						<small class="text-gray">{{ _number_format($similar->follows->count()) }} {{ str_plural('Answer', $similar->follows->count()) }}</small> &nbsp;&#9679;&nbsp;
						<small class="text-gray"><i class="fa fa-clock"></i> {{ $similar->created_at->diffForHumans() }}</small>
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
		
		data: {
			html: '',
			showAnswerQuestionBox: true,
			answer: {
				body: '',
				reference: '',
				question: {{ $question->id }}
			},
			errors: {
				body: {
					isError: false,
					message: ''
				},
				reference: {
					isError: false,
					message: ''
				}
			},
			isFollowingQuestion: {{ ($question->isFollowing()) ? 'true' : 'false' }},
			questionFollowers: {{ $question->follows()->count() }},
			answerContent: '',
		},

		methods: {
			toggleAnswerQuestionBox: function() {
				this.showAnswerQuestionBox = !this.showAnswerQuestionBox;
			},

			submitAnswerForm: function() {
				let self = this;
				axios.post("{{ route('answers.store') }}", this.answer)
					.then(function(response) {
						window.location.href = window.location.href;
					}).catch(function(error) {
						let errors = error.response.data.errors;
						for(error in errors) {
							let e = errors[error];
							self.errors[error].isError = true;
							self.errors[error].message = e[0];
						}
					});
			},

			followQuestion: function(event) {
				let self = this;
				let id = event.currentTarget.getAttribute('data-id');

				axios.post("{{ route('follow.question') }}", {id: id})
					.then(function(response) {
						self.isFollowingQuestion = !self.isFollowingQuestion;
						if (response.data.message == 'unfollowed') {
							self.questionFollowers = self.questionFollowers - 1;
						} else {
							self.questionFollowers = self.questionFollowers + 1;
						}

					}).catch(function(error) {

					});
			},

			followTopic: function(event) {
				let element = event.currentTarget
				let id = element.getAttribute('data-id');

				axios.post("{{ route('follow.topic') }}", {id: id})
					.then(function(response) {
						if (response.data.message == 'unfollowed') {
							element
								.innerHTML = "<i class='fa fa-plus'></i> Follow | " + response.data.count;
							
							element.classList.add('btn-info');
							element.classList.remove('btn-success');
						} else if(response.data.message == 'followed') {
							element
								.innerHTML = "<i class='fa fa-check'></i> Following | " + response.data.count;
							
							element.classList.add('btn-success');
							element.classList.remove('btn-info');

						}
					}).catch(function(error) {

					});
			},

			reportQuestion: function(event) {
				let element = event.currentTarget;
				let id = element.getAttribute('data-id');

				axios.post("{{ route('reports.question') }}", {id: id})
					.then(function(response) {
							element
								.innerHTML = "<i class='fa fa-flag'></i> Reported";
							element.setAttribute('disabled', 'true');
					});
			},

			pickBestAnswer: function(event) {
				let element = event.currentTarget;
				let id = element.getAttribute('data-id');
				let question = element.getAttribute('data-question');
				let formData = {
					id: id,
					question: question
				}

				axios.post("{{ route('answers.best') }}", formData)
					.then(function(response) {
						window.location.href = window.location.href;
					});
			},

			upvoteAnswer: function(event) {
				let element = event.currentTarget;
				let id = element.getAttribute('data-id');
				let question = element.getAttribute('data-question');
				let formData = {
					id: id,
					question: question
				}

				axios.post("{{ route('answers.upvote') }}", formData)
					.then(function(response) {
						let count = parseInt(response.data.upvotes);

						if (response.data.message === 'upvoted') {
							let upvote = count+1;
							element
								.innerHTML = "<i class='fa fa-arrow-up'></i> Upvoted | " + upvote.toString();
							
							element.classList.add('btn-info');
							element.classList.remove('btn-outline-info');
						} else if(response.data.message === 'un_upvoted') {
							let unupvote = count-1;
							element
								.innerHTML = "<i class='fa fa-arrow-up'></i> Upvote | " + unupvote.toString();
							
							element.classList.add('btn-outline-info');
							element.classList.remove('btn-info');

						}
					});
			},

			downvoteAnswer: function(event) {
				let element = event.currentTarget;
				let id = element.getAttribute('data-id');
				let question = element.getAttribute('data-question');
				let formData = {
					id: id,
					question: question
				}

				axios.post("{{ route('answers.downvote') }}", formData)
					.then(function(response) {
							element
								.innerHTML = "Downvoted";
							element.setAttribute('disabled', true);
					});
			},

			reportAnswer: function(event) {
				let element = event.currentTarget;
				let id = element.getAttribute('data-id');

				axios.post("{{ route('reports.answer') }}", {id: id})
					.then(function(response) {
							element
								.innerHTML = "<i class='fa fa-flag'></i> Reported";
							element.setAttribute('disabled', 'true');
					});
			},

			showAnswerModal: function(event) {
				$('#answerModal').modal('show');
				let element = event.currentTarget;
				let id = element.getAttribute('data-id');
				this.answerContent = element.getAttribute('data-answer');

				axios.post("{{ route('answers.view') }}", {id: id});
			}
		}
	});
</script>
@endsection