<div id="info-filtros">
	<h1>
		{{ Config::get('options.nombreSitio') }}
	</h1>
	{{-- //Titulaciones --}}
	@if ( !empty($aTitulaciones) )
		<h2>
		@foreach ($aTitulaciones as $titulacion)

			{{ $titulacion->titulacion }}<br />
		@endforeach
		</h2>
	@endif

	{{-- //Asignaturas --}}
	@if( !empty($aAsignaturas) )
		<h3>
		@foreach ( $aAsignaturas as $asignatura )
			<span>  {{ $asignatura->asignatura }} </span>
		@endforeach
		</h3>
	@endif
</div>