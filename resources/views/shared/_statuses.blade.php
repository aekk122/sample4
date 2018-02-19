@if (count($statuses) > 0)
	<ol class="statuses">
		@foreach($statuses as $status)
			@include('statuses._status', ['user' => $status->belongsToUser])
		@endforeach
	</ol>
	{!! $statuses->render() !!}
@endif