  {{-- Resultado de la importación csv: Eventos candidatos a salvar a BD --}}
  @if (!empty($aEventosValidos))
  
    {{-- Eventos a salvar con éxito--}}
    <div class="panel panel-success">
      
      <div class="panel-heading">
        
        <div class="row">
        
          <div class = "col-lg-6">
            <p><b><i class="fa fa-check fa-fw"></i> Eventos sin errores</b></p>
          </div>
        
          <div class = "col-lg-6 text-right">
            <p> 
              <a href="" class="btn btn-primary" id="botonSalvaEventos" title="Salvar eventos a BD" data-eventos=' {{ json_encode($aEventosValidos,JSON_FORCE_OBJECT)  }}'><i class="fa fa-save fa-fw"></i> Salva eventos a DB</a>
            </p>
          </div>
        </div>
        
        
      </div><!-- /.panel-heading -->
      
      <div class="panel-body">

        <div class="row text-center"> </div>

        <table class="table table-striped">
          
           <tr>
            <th>Fila</th>
            <th>Asignatura</th>
            <th>Profesor</th>
            <th>F. Desde</th>
            <th>F. Hasta</th>
            <th>Día</th>
            <th>H. Inicio</th>
            <th>H. Fin</th>
            <th>Aula</th>
          </tr>
        
          @foreach($aEventosValidos as $evento)
            <tr>
              <td>
                <p id = "exitoSalvaEvento-{{ $evento['numfila'] }}" class="text-success" style="display: none;"> <i class="fa fa-check fa-fw"></i> Evento salvado con éxito </p>
                {{ $evento['numfila'] }}
              </td>  
              <td> {{ $evento['asignatura'] }} </td>
              <td> {{ $evento['profesor'] }} </td>
              <td> {{ $evento['f_desde'] }} </td>
              <td> {{ $evento['f_hasta'] }} </td>
              <td> {{ $evento['diaSemana'] }} </td>
              <td> {{ $evento['h_inicio'] }} </td>
              <td> {{ $evento['h_fin'] }} </td>
              <td> {{ $evento['aula'] }} </td>
            </tr>
          @endforeach
          
        </table>
      </div><!-- .//panel-body -->
    </div><!-- .//panel-success -->   
  @else
    <div class="panel panel-danger">
      
      <div class="panel-heading">

        <i class="fa fa-ban fa-fw"></i> Aviso 
      </div>
      
      <div class="panel-body">
        <p class="text-center"><b>No hay eventos que se puedan guardar en el archivo csv</b></p>
      </div>
    </div>
  @endif

  {{-- Error: no existe espacio --}}
  @if (!empty($aSinAula))
  
    <div class="panel panel-danger">
        
      <div class="panel-heading">
      
        <p><i class="fa fa-ban fa-fw"></i> <b>Error: No existe Espacio o Aula.</b></p>
      </div>
          
      <div class="panel-body">  
      
        <table class="table table-striped">
      
          <tr>
            <th>Fila</th>
            <th>Asignatura</th>
            <th>Profesor</th>
            <th>F. Desde</th>
            <th>F. Hasta</th>
            <th>Día</th>
            <th>H. Inicio</th>
            <th>H. Fin</th>
            <th>Aula</th>
          </tr>

          @foreach($aSinAula as $evento)
            <tr>
              <td>{{ $evento['numfila'] }}</td>  
              <td> {{ $evento['asignatura'] }} </td>
              <td> {{ $evento['profesor'] }} </td>
              <td> {{ $evento['f_desde'] }} </td>
              <td> {{ $evento['f_hasta'] }} </td>
              <td> {{ $evento['diaSemana'] }} </td>
              <td> {{ $evento['h_inicio'] }} </td>
              <td> {{ $evento['h_fin'] }} </td>
              <td> {{ $evento['aula'] }} </td>
            </tr>
          @endforeach
         
        </table>
      </div><!-- .//panel-body -->
    </div><!-- .//panel-danger -->
  @else
    <div class="panel panel-success">
      
      <div class="panel-heading">

        <p><i class="fa fa-check fa-fw"></i> Aviso </p>
      </div>
      
      <div class="panel-body">
        <p class="text-center">Resultado de la comprobación de espacios definidos en CSV: <b class="text-success"><i class="fa fa-check fa-fw"></i> Correcta</b>.</p>
      </div>
    </div>
  @endif    
  
{{-- Tiene fechas válidas en el archivo csv --}}  
  @if (!empty($aSinFechaValida))
    
    <div class="panel panel-danger" >
        
      <div class="panel-heading">
    
        <p><i class="fa fa-ban fa-fw"></i> <b>Error: Definición de fechas no válidas. Se esperaba formato de fecha = dd/mm/YYYY</b></p>  
      </div>
        
      <div class="panel-body">  
    
        <table class="table table-striped">
          
          <tr>
            <th>Fila</th>
            <th>Asignatura</th>
            <th>Profesor</th>
            <th>F. Desde</th>
            <th>F. Hasta</th>
            <th>Día</th>
            <th>H. Inicio</th>
            <th>H. Fin</th>
            <th>Aula</th>
          </tr>

          @foreach($aSinFechaValida as $evento)
            <tr>
              <td>{{ $evento['numfila'] }}</td>  
              <td> {{ $evento['asignatura'] }} </td>
              <td> {{ $evento['profesor'] }} </td>
              <td> {{ $evento['f_desde'] }} </td>
              <td> {{ $evento['f_hasta'] }} </td>
              <td> {{ $evento['diaSemana'] }} </td>
              <td> {{ $evento['h_inicio'] }} </td>
              <td> {{ $evento['h_fin'] }} </td>
              <td> {{ $evento['aula'] }} </td>
            </tr>
          @endforeach
       
        </table>
      </div><!-- .//panel-body -->
    </div><!-- .//panel-danger -->
  @else
    <div class="panel panel-success">
      
      <div class="panel-heading">

        <p><i class="fa fa-check fa-fw"></i> Aviso </p> 
      </div>
      
      <div class="panel-body">
        <p class="text-center">Resultado de la comprobación de fechas y horas de los eventos definidos en el archivo csv: <b class="text-success"><i class="fa fa-check fa-fw"></i> Correcta</b></p>
      </div>
    </div>
  @endif

  {{-- Solapamientos en el archivo csv --}}  
  @if (!empty($aSolapesCsv))
    
    <div class="panel panel-danger" >
        
      <div class="panel-heading">
    
        <p><i class="fa fa-ban fa-fw"></i> <b>Error: Solapamientos en archivo csv.</b></p>  
      </div>
        
      <div class="panel-body">  
    
        <table class="table table-striped">
          
          <tr>
            <th>Fila</th>
            <th>Asignatura</th>
            <th>Profesor</th>
            <th>F. Desde</th>
            <th>F. Hasta</th>
            <th>Día</th>
            <th>H. Inicio</th>
            <th>H. Fin</th>
            <th>Aula</th>
          </tr>

          @foreach($aSolapesCsv as $evento)
            <tr>
              <td>{{ $evento['numfila'] }}</td>  
              <td> {{ $evento['asignatura'] }} </td>
              <td> {{ $evento['profesor'] }} </td>
              <td> {{ $evento['f_desde'] }} </td>
              <td> {{ $evento['f_hasta'] }} </td>
              <td> {{ $evento['diaSemana'] }} </td>
              <td> {{ $evento['h_inicio'] }} </td>
              <td> {{ $evento['h_fin'] }} </td>
              <td> {{ $evento['aula'] }} </td>
            </tr>
          @endforeach
       
        </table>
      </div><!-- .//panel-body -->
    </div><!-- .//panel-danger -->
  @else
    <div class="panel panel-success">
      
      <div class="panel-heading">

        <p><i class="fa fa-check fa-fw"></i> Aviso </p> 
      </div>
      
      <div class="panel-body">
        <p class="text-center">Resultado de la comprobación de solapamientos de los eventos definidos en el archivo csv: <b class="text-success"><i class="fa fa-check fa-fw"></i> Correcto</b></p>
      </div>
    </div>
  @endif

  {{-- Solapamientos DB --}}  
  @if (!empty($aSolapesBD))
    
    <div class="panel panel-danger" >
        
      <div class="panel-heading">
    
        <p><i class="fa fa-ban fa-fw"></i> <b>Error: Solapamientos en Base de Datos. Los eventos siguientes solapan con otras reservas/eventos existentes.</b></p>  
      </div>
        
      <div class="panel-body">  
    
        <table class="table table-striped">
          
          <tr>
            <th>Fila</th>
            <th>Asignatura</th>
            <th>Profesor</th>
            <th>F. Desde</th>
            <th>F. Hasta</th>
            <th>Día</th>
            <th>H. Inicio</th>
            <th>H. Fin</th>
            <th>Aula</th>
          </tr>

          @foreach($aSolapesBD as $evento)
            <tr>
              <td>{{ $evento['numfila'] }}</td>  
              <td> {{ $evento['asignatura'] }} </td>
              <td> {{ $evento['profesor'] }} </td>
              <td> {{ $evento['f_desde'] }} </td>
              <td> {{ $evento['f_hasta'] }} </td>
              <td> {{ $evento['diaSemana'] }} </td>
              <td> {{ $evento['h_inicio'] }} </td>
              <td> {{ $evento['h_fin'] }} </td>
              <td> {{ $evento['aula'] }} </td>
            </tr>
          @endforeach
       
        </table>
      </div><!-- .//panel-body -->
    </div><!-- .//panel-danger -->
  @else
    <div class="panel panel-success">
      
      <div class="panel-heading">

        <p><i class="fa fa-check fa-fw"></i> Aviso </p>
      </div>
      
      <div class="panel-body">
        <p class="text-center">Resultado de la comprobación de solapamientos entre eventos definidos en el CSV y eventos en Base de Datos: <b class="text-success"><i class="fa fa-check fa-fw"></i> Correcto.</b></p>
      </div>
    </div>
  @endif