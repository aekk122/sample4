<form action="{{ route('statuses.store') }}" method="POST">
	@include('shared._errors')
	{{ csrf_field() }}
	<textarea name="content" id="content" rows="3" class="form-control" placeholder="HERE |"></textarea>
	<button class="btn btn-primary pull-right" type="submit">发布</button>

</form>