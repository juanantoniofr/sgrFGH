<div class = "col-lg-10 col-lg-offset-1 bg-info">

	<h3>Resultados de busqueda</h3>
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
</div>
@if (!empty($recursos))
    @foreach($recursos as $recurso)
		<table style = "table-layout: fixed;width: 100%;" id="tableCalendar" >
    		<caption id="tableCaption" > {{ $recurso->nombre }} </caption>
    		<thead id="tableHead"> {{ $thead or ''}} </thead>
    		<tbody id="tableBody">
    			@if (!empty($filas))
    				@foreach($filas as $fila)
    					{{ $fila }}
    				@endforeach
    			@endif
    		</tbody>
		</table>
	@endforeach
@endif