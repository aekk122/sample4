<div class="stats">
	<a href="{{ route('users.followings', $user->id) }}">
		<strong id="following" class="stat">
			{{ count($user->hasManyFollows) }}
		</strong>
		关注
	</a>

	<a href="{{ route('users.followers', $user->id) }}">
		<strong id="followers" class="stat">
			{{ count($user->hasManyFollowers) }}
		</strong>
		粉丝
	</a>

	<a href="{{ route('users.show', $user->id) }}">
		<strong id="statuses" class="stat">
			{{ count($user->hasManyStatuses) }}
		</strong>
		微博
	</a>
</div>