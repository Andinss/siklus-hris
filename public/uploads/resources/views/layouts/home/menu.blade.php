<div id="fh5co-menus" data-section="menu">
	<div class="container">
		<div class="row text-center fh5co-heading row-padded">
			<div class="col-md-8 col-md-offset-2">
				<h2 class="heading to-animate">Food Menu</h2>
				<p class="sub-heading to-animate">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
			</div>
		</div>
		<div class="row row-padded">
			<div class="col-md-6">
				<div class="fh5co-food-menu to-animate-2">
					<h2 class="fh5co-drinks">Drinks</h2>
					<ul>
						@foreach($drinks as $drink)
						<li>
							<div class="fh5co-food-desc">
								<figure>
									<img src="{{Config::get('constants.path.uploads')}}/drink/{{$drink->name}}/{{$drink->filename}}" class="img-responsive" alt="Free HTML5 Templates by FREEHTML5.co">
								</figure>
								<div>
									<h3>{{$drink->name}}</h3>
									<p>{{$drink->description}}</p>
								</div>
							</div>
							<div class="fh5co-food-pricing">
								{{$drink->price}}
							</div>
						</li>
						@endforeach
					</ul>
				</div>
			</div>
			<div class="col-md-6">
				<div class="fh5co-food-menu to-animate-2">
					<h2 class="fh5co-dishes">Food</h2>
					<ul>
						@foreach($foods as $food)
						<li>
							<div class="fh5co-food-desc">
								<figure>
									<img src="{{Config::get('constants.path.uploads')}}/food/{{$food->name}}/{{$food->filename}}" class="img-responsive" alt="Free HTML5 Templates by FREEHTML5.co">
								</figure>
								<div>
									<h3>{{$food->name}}</h3>
									<p>{{$food->description}}</p>
								</div>
							</div>
							<div class="fh5co-food-pricing">
								{{$food->price}}
							</div>
						</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-md-offset-4 text-center to-animate-2">
				<p><a href="{{ URL::route('menu') }}" class="btn btn-primary btn-outline">More Food Menu</a></p>
			</div>
		</div>
	</div>
</div>