<div class = "col-lg-10 col-lg-offset-1 bg-info">

	<h3>Resultados de busqueda</h3>
</div>
@if (!empty($recursos))
    @foreach($recursos as $recurso)

    	
		<table style = "table-layout: fixed;width: 100%;" id="tableCalendar" class="informes" >
    		<caption id="tableCaption" class="text-align: center;padding: 40px;font-size: 36px;" > <span class="text-center">{{ $recurso->nombre }} </span> </caption>
    		<thead id="tableHead"> {{ $thead or ''}} </thead>
    		<tbody id="tableBody">
    			@foreach (Config::get('options.rangoHorarios') as $hora) 
					<tr>
						<td style = "width:6%">{{ $hora or '' }}</td>
						<td>
							<?php $eventos = $recurso->filtraEventos(1,$hora); ?>
							@if (!empty($eventos))
								@foreach ($eventos as $e)
									{{ $e->asignatura }}
									<small>({{ Date::datetoES($e->fechaInicio,'-') }} // {{ Date::datetoES($e->fechaFin,'-') }})</small>
								@endforeach
							@endif
						</td>
						<td>
							<?php $eventos = $recurso->filtraEventos(2,$hora); ?>
							@if (!empty($eventos))
								@foreach ($eventos as $e)
									{{ $e->asignatura }}
									<small>({{ Date::datetoES($e->fechaInicio,'-') }} // {{ Date::datetoES($e->fechaFin,'-') }})</small>
								@endforeach
							@endif
						</td>
						<td>
							<?php $eventos = $recurso->filtraEventos(3,$hora); ?>
							@if (!empty($eventos))
								@foreach ($eventos as $e)
									{{ $e->asignatura }}
									<small>({{ Date::datetoES($e->fechaInicio,'-') }} // {{ Date::datetoES($e->fechaFin,'-') }})</small>
								@endforeach
							@endif
						</td>
						<td>
							<?php $eventos = $recurso->filtraEventos(4,$hora); ?>
							@if (!empty($eventos))
								@foreach ($eventos as $e)
									{{ $e->asignatura }}
									<small>({{ Date::datetoES($e->fechaInicio,'-') }} // {{ Date::datetoES($e->fechaFin,'-') }})</small>
								@endforeach
							@endif
						</td>
						<td>
							<?php $eventos = $recurso->filtraEventos(5,$hora); ?>
							@if (!empty($eventos))
								@foreach ($eventos as $e)
									{{ $e->asignatura }}
									<small>({{ Date::datetoES($e->fechaInicio,'-') }} // {{ Date::datetoES($e->fechaFin,'-') }})</small>
								@endforeach
							@endif
						</td>
					</tr>
				@endforeach
		    </tbody>
		</table>
	@endforeach
@endif

<div class = "col-lg-10 col-lg-offset-1 bg-warning" style="margin-top: 40px">

	<p>No se encontraron eventos</p>

</div>