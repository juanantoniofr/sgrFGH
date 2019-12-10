  {{-- Resultado de la importación csv: Eventos salvados con éxito --}}
  @if (!empty($aEventosValidos))
  
    {{-- Eventos a salvar con éxito--}}
    <div class="panel panel-success">
      
      <div class="panel-heading">
        <div class="row">
          <div class = "col-lg-6">
            <i class="fa fa-check fa-fw"></i> Eventos válidos
          </div>
          <div class = "col-lg-6 text-right">
            <a href="" class="btn btn-info" id="botonSalvaEventosCsv" title="Salvar eventos"><i class="fa fa-save fa-fw"></i> Salvar Eventos</a>
          </div>
        </div>
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

          @foreach($aEventosValidos as $evento)
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
      
        <i class="fa fa-ban fa-fw"></i> <b>Error: No existe Espacio o Aula. Los siguientes eventos definen reservas/eventos en espacios/aulas no definidas.</b>
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

        <i class="fa fa-check fa-fw"></i> Aviso 
      </div>
      
      <div class="panel-body">
        <p class="text-center">Comprobación correcta de espacios y/o aulas definidas en el csv</p>
      </div>
    </div>
  @endif    
  
  {{-- Solapamientos en el archivo csv --}}  
  @if (!empty($aSolapesCsv))
    
    <div class="panel panel-danger" >
        
      <div class="panel-heading">
    
        <i class="fa fa-ban fa-fw"></i> <b>Error: Solapamientos en archivo css. Los eventos siguientes solapan entre si.</b>.  
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

        <i class="fa fa-check fa-fw"></i> Aviso 
      </div>
      
      <div class="panel-body">
        <p class="text-center">El arvhivo csv no define ningún solapamiento</p>
      </div>
    </div>
  @endif

  {{-- Solapamientos DB --}}  
  @if (!empty($aSolapesBD))
    
    <div class="panel panel-danger" >
        
      <div class="panel-heading">
    
        <i class="fa fa-ban fa-fw"></i> <b>Error: Solapamientos en Base de Datos. Los eventos siguientes solapan con otras reservas/eventos existentes.</b>.  
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

        <i class="fa fa-check fa-fw"></i> Aviso 
      </div>
      
      <div class="panel-body">
        <p class="text-center">El arvhivo csv no define solapamiento con eventos/reservas existentes</p>
      </div>
    </div>
  @endif