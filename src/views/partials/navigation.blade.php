<aside>
	<ul>
		{{-- Create a clean and easy to call Html macro --}}
		@foreach(Config::get('aidkit::navigation.navigationPoints') as $name=>$attributes)
			<li>
				<a href="{{ (isset($attributes['url']) ? URL::to($attributes['url']) : URL::route($attributes['route'])) }}">{{ $name }}</a>
			</li>
		@endforeach
	</ul>
</aside>