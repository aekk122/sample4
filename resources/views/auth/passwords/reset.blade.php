@extends('layouts.default')
@section('title', '密码重置')

@section('content')
<div class="container">
	<div class="col-md-offset-2 col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>更新密码</h5>
			</div>

			<div class="panel-body">
				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				<form action="{{ route('password.update') }}" method="POST">
					{{ csrf_field() }}

					<input type="hidden" name="token" value="{{ $token }}">

					<div class="form-group{{ $errors->has('email') ? 'has-error' : '' }}">
						<label for="email">邮箱地址</label>
						<input type="text" class="form-control" name="email" value="{{ $email or old('email') }}" required>
						@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>

					<div class="form-group{{ $errors->has('password') ? 'has-error' : '' }}">
						<label for="password">密码</label>
						<input type="password" class="form-control" name="password"  required>
						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>

					<div class="form-group{{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
						<label for="password_confirmation">密码</label>
						<input type="password" class="form-control" name="password_confirmation"  required>
						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password_confirmation') }}</strong>
							</span>
						@endif
					</div>

					<div class="form-group">
						<button class="btn btn-primay" type="submit">修改密码</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop