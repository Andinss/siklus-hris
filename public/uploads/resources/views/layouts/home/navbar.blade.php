<div class="js-sticky">
	<div class="fh5co-main-nav">
		<div class="container-fluid">
			<div class="fh5co-menu-1">
				<a href="#" data-nav-section="home">Home</a>
				<a href="#" data-nav-section="about">About</a>
				<a href="#" data-nav-section="features">Features</a>
			</div>
			<div class="fh5co-logo">
				<a href="{{ URL::route('home') }}">Pondok Laras</a>
			</div>
			<div class="fh5co-menu-2">
				{{-- @if(isset($page) && $page != 'menu')
					<a href="{{ URL::route('menu') }}">Menu</a>
				@else --}}
					<a href="#" data-nav-section="menu">Menu</a>
				{{-- @endif --}}

				{{-- @if(isset($page) && $page != 'event')
					<a href="{{ URL::route('event') }}">Events</a>
				@else --}}
					<a href="#" data-nav-section="events">Events</a>
				{{-- @endif --}}
				<a href="#" data-nav-section="reservation">Reservation</a>
			</div>
		</div>
		
	</div>
</div>