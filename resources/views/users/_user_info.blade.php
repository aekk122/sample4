<a href="{{ route('users.show', $user->id) }}">
	<img src="{{ $user->gravatar('140') }}" class="gravatar" alt="{{ $user->name }}">
</a>
<h1>{{ $user->name }}</h1>