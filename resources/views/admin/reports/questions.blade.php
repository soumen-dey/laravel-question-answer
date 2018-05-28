@extends('layouts.admin')

@section('title', 'Reported Questions')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
			@foreach($questions as $question)
				<div class="card margin-bottom-big">
					<div class="card-body">
						<a href="{{ route('admin.reports.question', $question->slug) }}" class="text-gray h4">{{ $question->title }}</a>
						<hr />
						<small class="text-muted"><i class="fa fa-clock"></i> {{ $question->created_at->diffForHumans() }}</small>&nbsp;&nbsp;&nbsp;
						<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($question->views->count()) }}</small>

						<button class="btn btn-danger btn-sm float-right margin-right-short"
								@click.prevent="moderateQuestion"
								data-id="{{ $question->id }}">
							<i class="fa fa-trash-alt"></i> Moderate Question
						</button>
					</div>
				</div>
			@endforeach
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
			moderateQuestion: function(event) {
				let element = event.currentTarget;
				let id = element.getAttribute('data-id');

				axios.post("{{ route('admin.moderate.question') }}", {id: id})
						.then(function(response) {
							element.setAttribute('disabled', true);
							element.innerHTML = 'Moderated';
							element.classList.add('btn-outline-danger');
							element.classList.remove('btn-danger');
						});
			}
		}
	});
</script>
@endsection