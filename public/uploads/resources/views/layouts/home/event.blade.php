<div id="fh5co-events" data-section="events" style="background-image: url({{Config::get('constants.path.img')}}/wood_1.png);" data-stellar-background-ratio="0.5">
	<div class="fh5co-overlay"></div>
	<div class="container">
		<div class="row text-center fh5co-heading row-padded">
			<div class="col-md-8 col-md-offset-2 to-animate">
				<h2 class="heading">Upcoming Events</h2>
				<p class="sub-heading">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
			</div>
		</div>
		<div class="row">
			@foreach($events as $event)
			<div class="col-md-4">
				<div class="fh5co-event to-animate-2">
					<h3>{{$event->name}}</h3>
					<span class="fh5co-event-meta">{{$event->start_time}}</span>
					<p>{{$event->description}}</p>
					<p><a href="{{ URL::route('event.detail', $event->id) }}" class="btn btn-primary btn-outline">Read More</a></p>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>