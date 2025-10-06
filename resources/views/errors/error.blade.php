@if (count($errors) > 0)
	<!-- Form Error List -->
	@foreach ($errors->all() as $error)
		<div class="alert custom-error-alert">{{ $error }}</div>
	@endforeach
@endif
