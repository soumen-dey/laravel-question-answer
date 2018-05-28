@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="container" id="app">
	<div class="row justify-content-center">
		<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
			<div class="card margin-bottom-big">
				<div class="card-body">
					<div class="row">
						<div class="col-md-3">
							@if(auth()->user()->id == $user->id)
								<a href="{{ route('users.avatar') }}">
									@if($user->avatar)
										<img src="{{ route('users.avatar.get', $user->avatar->file_name) }}" width="150px" height="150px;" style="border-radius: 50%;">
									@else
										<img src="{{ asset('images/avatars/'.rand(1, 9).'.png') }}" width="150px" height="150px;" style="border-radius: 50%;">
									@endif
								</a>
							@else
								@if($user->avatar)
									<img src="{{ route('users.avatar.get', $user->avatar->file_name) }}" width="150px" height="150px;" style="border-radius: 50%;">
								@else
									<img src="{{ asset('images/avatars/'.rand(1, 9).'.png') }}" width="150px" height="150px;" style="border-radius: 50%;">
								@endif
							@endif
						</div>
						<div class="col-md-9">
							<h2 class="text-gray"><b>{{ $user->name }}</b></h2>

							@if($user->detail)
								@if($user->detail->bio)
									<p class="text-gray">{{ $user->detail->bio }}</p>
								@endif

								@if($user->detail->works_at && !$user->detail->designation)
									<p class="text-gray">Working at {{ $user->detail->works_at }}</p>
								@endif

								@if($user->detail->works_at && $user->detail->designation)
									<p class="text-gray">{{ $user->detail->designation }} at {{ $user->detail->works_at }}</p>
								@endif

								@if($user->detail->college)
									<p class="text-gray">Studied at {{ $user->detail->college }}</p>
								@endif

								@if($user->detail->city)
									<p class="text-gray">Lives in {{ $user->detail->city->name }}</p>
								@endif
							@endif
						</div>
					</div>
				</div>
				<div class="card-footer custom-card-footer">
					<a href="?v=questions" class="btn btn-link"><i class="fa fa-comment-alt"></i> Questions</a>
					<a href="?v=answers" class="btn btn-link"><i class="fa fa-pencil-alt"></i> Answers</a>
					<a href="?v=followings" class="btn btn-link"><i class="fa fa-user"></i> Followings</a>
					<a href="?v=followers" class="btn btn-link"><i class="fa fa-user"></i> Followers</a>

					@if(auth()->user()->id == $user->id)
						<a href="{{ route('users.edit') }}" class="btn btn-info float-right"><i class="fa fa-pencil-alt"></i> Edit Profile</a>
					@else
						@if($user->isFollowing())
							<button class="btn btn-success float-right"
									@click.prevent="followUser"
									data-id="{{ $user->id }}">
								<i class="fa fa-check"></i> Following | {{ _number_format($user->follows->count()) }}
							</button>
						@else
							<button class="btn btn-outline-secondary float-right"
									@click.prevent="followUser"
									data-id="{{ $user->id }}">
								<i class="fa fa-plus"></i> Follow | {{ _number_format($user->follows->count()) }}
							</button>
						@endif
					@endif
				</div>
			</div>

			@if(!isset($_GET['v']))
				@if($user->questions->count())
					<h5>{{ $user->questions->count() }} {{ str_plural('Question', $user->questions->count()) }}</h5>
					<hr />
					@foreach($user->questions as $question)
						<div class="card margin-bottom-big">
							<div class="card-body">
								<a href="{{ route('questions.show', $question->slug) }}" class="text-gray h4">{{ $question->title }}</a>
								<hr />
								<small class="text-muted"><i class="fa fa-clock"></i> {{ $question->created_at->diffForHumans() }}</small>&nbsp;&nbsp;&nbsp;
								<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($question->views->count()) }}</small>
							</div>
						</div>
					@endforeach
				@else
					<div class="text-center">
						<p>No Questions Yet</p>
					</div>
				@endif
			@endif

			@if(isset($_GET['v']) && $_GET['v'] == 'questions')
				@if($user->questions->count())
					<h5>{{ $user->questions->count() }} {{ str_plural('Question', $user->questions->count()) }}</h5>
					<hr />
					@foreach($user->questions as $question)
						<div class="card margin-bottom-big">
							<div class="card-body">
								<a href="{{ route('questions.show', $question->slug) }}" class="text-gray h4">{{ $question->title }}</a>
								<hr />
								<small class="text-muted"><i class="fa fa-clock"></i> {{ $question->created_at->diffForHumans() }}</small>&nbsp;&nbsp;&nbsp;
								<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($question->views->count()) }}</small>
							</div>
						</div>
					@endforeach
				@else
					<div class="text-center">
						<h5>No Questions Yet</h5>
					</div>
				@endif
			@endif

			@if(isset($_GET['v']) && $_GET['v'] == 'answers')
				@if($user->answers->count())
					<h5>{{ $user->answers->count() }} {{ str_plural('Answer', $user->answers->count()) }}</h5>
					<hr />
					@foreach($user->answers as $answer)
						<div class="card margin-bottom-big">
							<div class="card-body">
								<a href="{{ route('questions.show', $answer->question->slug, $answer->id) }}" class="text-gray h4">{{ $answer->question->title }}</a>
								<p class="text-gray">{{ str_limit($answer->body, 150) }}</p>
								<hr />
								<small class="text-muted"><i class="fa fa-clock"></i> {{ $answer->created_at->diffForHumans() }}</small>&nbsp;&nbsp;&nbsp;
								<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format(mt_rand(100, 10000)) }}</small>
							</div>
						</div>
					@endforeach
				@else
					<div class="text-center">
						<p>No Answers Yet</p>
					</div>
				@endif
			@endif

			@if(isset($_GET['v']) && $_GET['v'] == 'followings')
				<div class="card">
					<div class="card-body">
						<ul class="nav nav-pills margin-bottom-big nav-fill" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-questions-tab" data-toggle="pill" href="#pills-questions" role="tab" aria-controls="pills-questions" aria-selected="true">Questions</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-topics-tab" data-toggle="pill" href="#pills-topics" role="tab" aria-controls="pills-topics" aria-selected="false">Topics</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-users-tab" data-toggle="pill" href="#pills-users" role="tab" aria-controls="pills-users" aria-selected="false">Users</a>
							</li>
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-questions" role="tabpanel" aria-labelledby="pills-questions-tab">
								<hr />
								@if($user->getQuestionFollowings()->count())
									@foreach($user->getQuestionFollowings() as $questionFollowings)
										<a class="text-gray link-card h4" 
											href="{{ route('questions.show', $questionFollowings->slug) }}"
											>
											{{ $questionFollowings->title }}
										</a>
										<small class="text-muted"><i class="fa fa-clock"></i> {{ $questionFollowings->created_at->diffForHumans() }}</small>&nbsp;&nbsp;&nbsp;
										<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($questionFollowings->views->count()) }}</small>
										
										@if(!$loop->last)
											<hr />
										@endif
									@endforeach
								@else
									<div class="text-center">
										<h3>Currently there are no questions followings</h3>
									</div>
								@endif
							</div>
							<div class="tab-pane fade" id="pills-topics" role="tabpanel" aria-labelledby="pills-topics-tab">
								<hr />
								@if($user->getTopicFollowings()->count())
									@foreach($user->getTopicFollowings() as $topicFollowings)
										<a class="text-gray link-card h4" 
											href="{{ route('topics.show', $topicFollowings->slug) }}"
											>
											{{ $topicFollowings->name }}
										</a>
										<small class="text-muted">{{ _number_format($topicFollowings->questions->count()) }} {{ str_plural('Question', $topicFollowings->questions->count()) }}</small>
										
										@if(!$loop->last)
											<hr />
										@endif
									@endforeach
								@else
									<div class="text-center">
										<h3>Currently there are no topics followings</h3>
									</div>
								@endif
							</div>
							<div class="tab-pane fade" id="pills-users" role="tabpanel" aria-labelledby="pills-users-tab">
								<hr />
								@if($user->getUserFollowings()->count())
									<div class="row">
										@foreach($user->getUserFollowings() as $following)
											<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
												<div class="card margin-bottom-big">
													<div class="card-body">
														<div class="row">
															<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
																<img src="http://placehold.it/350x350" width="100%" style="border-radius: 50%;">
															</div>
															<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
																<a href="{{ route('users.show', $following->id) }}" class="text-gray h4" style="margin-top: 10px;">
																	{{ $following->name }}
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										@endforeach
									</div>
								@else
									<div class="text-center">
										<h3>Currently there are no User followings</h3>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			@endif

			@if(isset($_GET['v']) && $_GET['v'] == 'followers')
				@if($user->getFollowers()->count())
					<h5>{{ $user->getFollowers()->count() }} {{ str_plural('Follower', $user->getFollowers()->count()) }}</h5>
					<hr />
					<div class="row">
						@foreach($user->getFollowers() as $follower)
							<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
								<div class="card margin-bottom-big">
									<div class="card-body">
										<div class="row">
											<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
												<img src="http://placehold.it/350x350" width="100%" style="border-radius: 50%;">
											</div>
											<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
												<a href="{{ route('users.show', $follower->id) }}" class="text-gray h4" style="margin-top: 10px;">
													{{ $follower->name }}
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				@else
					<div class="text-center">
						<h3>Currently there are no followers.</h3>
					</div>
				@endif
			@endif
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
			followUser: function(event) {
				let element = event.currentTarget
				let id = element.getAttribute('data-id');

				axios.post("{{ route('follow.user') }}", {id: id})
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
			}
		}
	});
</script>
@endsection