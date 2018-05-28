@extends('layouts.admin')

@section('title', 'Report Question')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
			<div class="card margin-bottom-big">
				<div class="card-body">
					<h4 class="card-title text-gray"><b>{{ $question->title }}</b></h4>
					<p class="card-text text-gray">{{ $question->body }}</p>
				</div>
				<div class="card-footer custom-card-footer">
					<small class="text-muted"><i class="fa fa-user"></i> {{ $question->user->name }}</small>&nbsp;&nbsp;
					<small class="text-muted"><i class="fa fa-clock"></i> {{ $question->created_at->diffForHumans() }}</small>&nbsp;&nbsp;
					<small class="text-muted"><i class="fa fa-eye"></i> {{ _number_format($question->views->count()) }}</small>&nbsp;&nbsp;
					<small class="text-muted"><i class="fa fa-pencil-alt"></i> {{ _number_format($question->answers->count()) }}</small>

					@if($question->isModerated())
						<button class="btn btn-outline-danger btn-sm float-right" disabled>Moderated</button>
					@else
						<button class="btn btn-danger btn-sm float-right"
								@click.prevent="moderateQuestion"
								data-id="{{ $question->id }}">
							<i class="fa fa-trash-alt"></i> Moderate Question
						</button>
					@endif
				</div>
			</div>
			<h4 class="text-gray">{{ _number_format($question->reports->count()) }} {{ str_plural('Report', $question->reports->count()) }}</h4>
			<hr />
			<div class="card">
				<div class="card-body">
					<table class="table">
						<thead style="background-color: #bdc3c7">
							<tr>
								<td>Reported By</td>
								<td>Reported On</td>
							</tr>
						</thead>
						<tbody>
							@foreach($question->reports as $report)
								<tr>
									<td><i class="fa fa-user"></i> {{ $report->user->name }}</td>
									<td><i class="fa fa-clock"></i> {{ $report->created_at->diffForHumans() }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
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