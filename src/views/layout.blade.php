<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ $title }}</title>

	<!-- <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet"> -->

	{{ HTML::style('packages/codebryo/aidkit/css/vendor/pure.min.css')}}
	{{ HTML::style('packages/codebryo/aidkit/css/vendor/font-awesome.min.css')}}
	{{ HTML::style('packages/codebryo/aidkit/css/vendor/animate.min.css')}}
	{{ HTML::style('packages/codebryo/aidkit/css/style.css')}}

</head>
<body>
	<div id="layout" class="pure-g-r">
		<div id="mainnavigation" class="pure-u">
			{{ $navigation }}
		</div>
		<div id="content" class="pure-u">
			{{ $content }}
		</div>
	</div>
</body>
</html>