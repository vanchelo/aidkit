<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ $title }}::Login</title>
</head>
<body>
	{{ Form::open(array('url'=>'admin/login')) }}

		{{ Form::label('username') }}
		{{ Form::text('username') }}

		{{ Form::label('password') }}
		{{ Form::password('password') }}

		{{ Form::submit('login') }}
	{{ Form::close() }}
</body>
</html>