<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ $title }}::Login</title>

	{{ HTML::style('packages/codebryo/aidkit/css/vendor/pure.min.css')}}
	{{ HTML::style('packages/codebryo/aidkit/css/vendor/font-awesome.min.css')}}
	{{ HTML::style('packages/codebryo/aidkit/css/vendor/animate.min.css')}}
	{{ HTML::style('packages/codebryo/aidkit/css/style.css')}}

</head>

<body>
	<div id="logincontainer" class="pure-g-r">
		<div id="login" class="pure-u {{ (isset($status) ? 'animated shake' : null ) }}">
			
			{{ Form::open(array('url'=>'admin/login','class'=>'pure-form pure-form-stacked')) }}

				<legend>{{ $title }}</legend>
				
				<fieldset>

					{{ Form::label('username') }}
					{{ Form::text('username') }}

					{{ Form::label('password') }}
					{{ Form::password('password') }}

					<label for="remember">
		            	<input id="remember" name="remember" type="checkbox"> Remember me
		        	</label>

		        	 <button type="submit" class="pure-button green">Sign in</button>
					
				</fieldset>

			{{ Form::close() }}
		</div>
	</div>
</body>
</html>