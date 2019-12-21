<div class = "col-lg-10 col-lg-offset-1 bg-info">

	{{ var_dump($id_grupos) }}
	<hr />
	@if ( !empty($recursos) )

		@foreach($recursos as $recurso)

			<p> {{ $recurso->nombre }}</p>
			<p> <?php
				$recurso_id = $recurso->id;
			    $eventos = $recurso->events->filter(function($e){
				 
				 	return ( $e->fechaEvento == '2020-02-10' && $e->dia == 1 );
				});
				?>
				@if (!empty($eventos))
				@foreach ($eventos as $e)
					{{ $e->titulo }} -- 
				@endforeach
				@endif
			</p>
		@endforeach
	@endif
		@if ( !empty($aTitulaciones) )
			<ul>
			@foreach($aTitulaciones as $titulacion)
				<li>{{ $titulacion->titulacion }}</li> 
					<ul>
					@foreach($titulacion->asignaturas as $asignatura)
						<li> {{ $asignatura->asignatura }}</li>
							<ul>
								@foreach( $asignatura->gruposAsignatura as $grupo)
									<li> {{ $grupo->grupo }}</li>
									<ul>
										@foreach( $grupo->eventos as $evento)
											<li> {{ $evento->titulo }}</li>
										@endforeach
									</ul>
								@endforeach
							</ul>
					@endforeach
					</ul>
			@endforeach
			</ul>
		@endif
		
			{{-- var_dump($inputs) --}}
		
</div>