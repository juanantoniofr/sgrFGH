@if (!empty($recursos))
    
    <span data-numerorecursos="{{ $recursos->count() }}" id="recursos-info"></span>
    @foreach($recursos as $recurso)
    	{{ $infoFiltros or '' }}
		<table style = "table-layout: fixed;width: 100%;" id="tableCalendar" class="informes" >
    		<caption id="tableCaption" class="text-align: center;padding: 40px;font-size: 36px;height:70px" > <h2 class="text-center">{{ $recurso->nombre }} </h2> </caption>
    		<thead id="tableHead"> {{ $thead or ''}} </thead>
    		<tbody id="tableBody">
    			@foreach (Config::get('options.rangoHorarios') as $hora) 
    				{{-- @if ( strtotime($h_inicio) <= strtotime($hora) && strtotime($hora) < strtotime($h_fin) ) --}}
						<tr>
							<td style = "padding: 15px" class="columnaHora">{{ date('H:i',strtotime($hora)) }} <b>//</b> {{ date('H:i',strtotime($hora)+1800) }}</td>
							<td>
								@if(in_array(1,$aDias))
									<?php $eventos = $recurso->filtraEventos(1,$hora); ?>
									@if (!empty($eventos))
										@foreach ($eventos as $e)
											{{ $e->asignatura }}, {{$e->dia}}
											<small>({{ Date::datetoES($e->fechaInicio,'-') }} // {{ Date::datetoES($e->fechaFin,'-') }})</small>
										@endforeach
									@endif
								@endif
							</td>
							<td>
								@if(in_array(2,$aDias))
									<?php $eventos = $recurso->filtraEventos(2,$hora); ?>
									@if (!empty($eventos))
										@foreach ($eventos as $e)
											{{ $e->asignatura }}
											<small>({{ Date::datetoES($e->fechaInicio,'-') }} // {{ Date::datetoES($e->fechaFin,'-') }})</small>
										@endforeach
									@endif
								@endif
							</td>
							<td>
								@if(in_array(3,$aDias))
									<?php $eventos = $recurso->filtraEventos(3,$hora); ?>
									@if (!empty($eventos))
										@foreach ($eventos as $e)
											{{ $e->asignatura }}
											<small>({{ Date::datetoES($e->fechaInicio,'-') }} // {{ Date::datetoES($e->fechaFin,'-') }})</small>
										@endforeach
									@endif
								@endif
							</td>
							<td>
								@if(in_array(4,$aDias))
									<?php $eventos = $recurso->filtraEventos(4,$hora); ?>
									@if (!empty($eventos))
										@foreach ($eventos as $e)
											{{ $e->asignatura }}
											<small>({{ Date::datetoES($e->fechaInicio,'-') }} // {{ Date::datetoES($e->fechaFin,'-') }})</small>
										@endforeach
									@endif
								@endif
							</td>
							<td>
								@if(in_array(5,$aDias))
									<?php $eventos = $recurso->filtraEventos(5,$hora); ?>
									@if (!empty($eventos))
										@foreach ($eventos as $e)
											{{ $e->asignatura }}
											<small>({{ Date::datetoES($e->fechaInicio,'-') }} // {{ Date::datetoES($e->fechaFin,'-') }})</small>
										@endforeach
									@endif
								@endif
							</td>
						</tr>
					{{-- @endif --}}
				@endforeach
		    </tbody>
		</table>
	@endforeach
@endif
@if (empty($recurso))
	<div class = "col-lg-10 col-lg-offset-1 bg-warning text-center" style="margin-top: 40px;padding: 40px">
		<p><b>No se encontraron eventos</b></p>
	</div>
@endif