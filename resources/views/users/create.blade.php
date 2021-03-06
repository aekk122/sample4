@extends('layouts.default')
@section('title', '注册')

@section('content')
<div class="col-md-offset-2 col-md-8">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h5>注册</h5>
		</div>
		<div class="panel-body">
			@include('shared._errors')

			<form action="{{ route('users.store') }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="name">名称：</label>
					<input type="text" name="name" class="form-control">
				</div>

				<div class="form-group">
					<label for="email">邮箱：</label>
					<input type="text" class="form-control" name="email">
				</div>

				<div class="form-group">
					<label for="password">密码：</label>
					<input type="password" name="password" class="form-control">
				</div>

				<div class="form-group">
					<label for="password_confirmation">密码确认：</label>
					<input type="password" name="password_confirmation" class="form-control">
				</div>

				<button class="btn btn-primary" type="submit">注册</button>
			</form>	
		</div>
	</div>
</div>
@stop