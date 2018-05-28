@extends('layouts.admin')

@section('title', 'Reported Answers')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
			@foreach($answers as $answer)
				<div class="card margin-bottom-big">
					<div class="card-body">
						<a href="{{ route('admin.reports.answer', $answer->id) }}" class="text-gray h4">{{ $answer->body }}</a>
						<hr />
						<small class="text-muted"><i class="fa fa-clock"></i> {{ $answer->created_at->diffForHumans() }}</small>&nbsp;&nbsp;&nbsp;
						<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($answer->views->count()) }}</small>

						<button class="btn btn-danger btn-sm float-right margin-right-short"
								@click.prevent="moderateAnswer"
								data-id="{{ $answer->id }}">
							<i class="fa fa-trash-alt"></i> Moderate answer
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
			moderateAnswer: function(event) {
				let element = event.currentTarget;
				let id = element.getAttribute('data-id');

				axios.post("{{ route('admin.moderate.answer') }}", {id: id})
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