
<nav id="main">
	<ul>
		<li class="area">Profile</li>

		@include('aidkit::partials.profile')

		{{ HTML::aidkitNavigation(Config::get('aidkit::navigation.navigation')) }}
		
	</ul>
</nav>