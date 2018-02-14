@extends('layouts.default')
@section('重置密码')

@section('content')

<div class="col-md-offset-2 col-md-8">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h5>重置密码</h5>
		</div>
		<div class="panel-body">
			@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
			@endif

			<form action="{{ route('password.email') }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group{{ $errors->has('email') ? 'has-error' : ''}}">
					<label for="email">邮箱地址</label>
					<input type="text" name="email" class="form-control" required>

					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-group">
					<button class="btn btn-primary" type="submit">发送重置密码邮件</button>
				</div>
			</form>
		</div>
	</div>
</div>

@stop