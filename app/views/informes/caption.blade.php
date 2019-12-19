<div class = "col-lg-10 col-lg-offset-1 bg-info">
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
		<pre>
			{{-- var_dump($inputs) --}}
		</pre>
</div>