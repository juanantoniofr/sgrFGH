<div class = "col-lg-10 col-lg-offset-1 bg-info">
		@if ( !empty($aTitulaciones) )
			@foreach($aTitulaciones as $titulacion)
				<span> | {{ $titulacion->titulacion }} |</span>
			@endforeach
		@endif
		<pre>
			{{-- var_dump($inputs) --}}
		</pre>
</div>