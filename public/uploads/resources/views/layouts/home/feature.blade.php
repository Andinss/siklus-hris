<div id="fh5co-featured" data-section="features">
	<div class="container">
		<div class="row text-center fh5co-heading row-padded">
			<div class="col-md-8 col-md-offset-2">
				<h2 class="heading to-animate">Featured Dishes</h2>
				<p class="sub-heading to-animate">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
			</div>
		</div>
		<div class="row">
			<div class="fh5co-grid">
				@foreach($features as $feature)
				<div class="fh5co-v-half to-animate">
					<div class="fh5co-v-col-2 fh5co-bg-img" style="background-image: url({{Config::get('constants.path.img')}}/{{$feature->filename}})"></div>
					<div class="fh5co-v-col-2 fh5co-text fh5co-special-1 arrow-left">
						<h2>{{$feature->name}}</h2>
						<span class="pricing"><sup>Rp</sup>{{ number_format($feature->price,0) }}k</span>
						<p>{{$feature->description}}</p>
					</div>
				</div>
				@endforeach
			</div>
		</div>

	</div>
</div>