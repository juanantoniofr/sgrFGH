<div id="info-filtros">

	{{-- //Titulaciones --}}
	@if ( !empty($aTitulaciones) )
		<h2>
		@foreach ($aTitulaciones as $titulacion)

			{{ $titulacion->titulacion }}<br />
		@endforeach
		</h2>
	@endif

	{{-- //fechas --}}
	@if( !empty($f_inicio_filtro) && !empty($f_fin_filtro))
		<p>
			( {{ $f_inicio_filtro }} // {{ $f_fin_filtro }} )
		</p>
	@endif
</div>