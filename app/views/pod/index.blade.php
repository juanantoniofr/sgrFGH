@extends('layout')
 
@section('title')
    Admin:: carga P.O.D 
@stop
 
@section('content')
<div class="container">

  {{-- Cabecera página --}}
  <div class="row">
    
    <div class="col-lg-12">
        <h3 class="page-header"><i class="fa fa-cogs fa-fw"></i> Gestión P.O.D</h3>
    </div>
  </div> <!-- /.row -->

  {{-- Formulario upload archivo csv --}}
  <div class="row">
    
    <div class="panel panel-info">
        
      <div class="panel-heading">
        <h4><i class="fa fa-upload fa-fw"></i> Cargar P.O.D</h4>
      </div>
        
      <div class="panel-body">
        
        <div class="col-lg-12">
          
          {{Form::open( array( 'url' => route('uploadPOD'), 'files' => true ) )}}
            
            <div class="form-group">
              {{Form::label('csvfile', 'Archivo csv:')}} 
              {{Form::file('csvfile', $attributes = array());}}
            </div>
            
            <button type="submit" class="btn btn-primary">Importar POD</button>
          {{Form::close()}}
        </div><!-- /.col-lg-12 -->
      </div><!-- /.panel-body -->
    </div><!-- /.panel-info -->
  </div><!-- /.row -->
  
  {{-- Msg para usuario --}}
  @if (Session::has('msg-exito'))
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ Session::get('msg-exito') }}
    </div>
  @endif
  @if (Session::has('msg-error'))
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ Session::get('msg-error') }}
    </div>
  @endif


 
  {{-- Resultado de la importación csv: Eventos salvados con éxito --}}
  <br /> 
  @if (!empty($events))
  
    {{-- Eventos salvados con éxito--}}
    <div class="panel panel-success">
      
      <div class="panel-heading">

        <i class="fa fa-check fa-fw"></i> Eventos importados con éxito
      </div>
      
      <div class="panel-body" style="height:350px;overflow:scroll">
        <table class="table table-striped">
          <tr>
            <th>Fila</th>
            <th>Id. Lugar</th>
            <th>F. Inicio</th>
            <th>F. Fin</th>
            <th>Día</th>
            <th>H. Inicio</th>
            <th>H. Fin</th>
            <th>Lugar</th>
            <th>Asignatura</th>
            <th>Profesor</th>
            <th>Cod. día Semana</th>
          </tr>
          @foreach($events as $numFila => $contentFila)
            <tr>
              <td>{{ $numFila }}</td>
        
              @foreach($contentFila as $valueColumn)  
                <td>{{ $valueColumn }}</td>
              @endforeach
            
            </tr>
          @endforeach
          
        </table>
      </div><!-- .//panel-body -->
    </div><!-- .//panel-success -->   
  @endif

  {{-- Error: no existe espacio --}}
  @if (!empty($aSinAula))
  
    <div class="panel panel-danger">
        
      <div class="panel-heading">
      
        <i class="fa fa-ban fa-fw"></i> <strong>Error al guardar:</strong>: No existe Espacio o Aula, <b>los sigientes eventos no se guardaron.</b>
      </div>
          
      <div class="panel-body" style="height:350px;overflow:scroll">  
      
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

          @foreach($aSinAula as $indice => $evento)
            <tr>
              <td>{{ $indice }}</td>  
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
  @endif 

   {{-- test clase sgrCsv --}}
  <pre>
    {{ var_dump($test) }}
  </pre>   
  
  {{-- Solapimientos en el archivo csv --}}  
  @if (!empty($solapescsv))
    
    <div class="panel panel-danger" >
        
      <div class="panel-heading">
    
        <i class="fa fa-ban fa-fw"></i> <strong>Error al guardar:</strong> Solapamientos en archivo csv <small>(los eventos no se guardaron)</small>.  
      </div>
        
      <div class="panel-body" style="height:350px;overflow:scroll">  
    
        <table class="table table-striped">
          
          <tr>
            <th>Fila</th>
            <th>Id. Lugar</th>
            <th>F. Inicio</th>
            <th>F. Fin</th>
            <th>Día</th>
            <th>H. Inicio</th>
            <th>H. Fin</th>
            <th>Lugar</th>
            <th>Asignatura</th>
            <th>Profesor</th>
            <th>Cod. día Semana</th>
          </tr>

          @foreach($solapescsv as $numerofila => $aFila)
            <tr>
              <td>{{ $numerofila }}</td>
              @foreach($aFila as $valor)  
                <td>{{ $valor }}</td>
              @endforeach
            </tr>
          @endforeach
       
        </table>
      </div><!-- .//panel-body -->
    </div><!-- .//panel-danger -->
  @endif

  {{-- Solapmientos con eventos ya salvados en la BD --}}
  @if (!empty($solapesdb))
    
    <div class="panel panel-danger" style="height:350px;overflow:scroll">
        
        <div class="panel-heading">
    
          <i class="fa fa-ban fa-fw"></i> <strong>Error al guardar:</strong> Solapamientos con eventos existentes <small>(los eventos no se guardaron)</small>.  
        </div>
        
        <div class="panel-body">  
          
          <table class="table table-striped">
            <tr>
              <th>Fila</th>
              <th>Id. Lugar</th>
              <th>F. Inicio</th>
              <th>F. Fin</th>
              <th>Día</th>
              <th>H. Inicio</th>
              <th>H. Fin</th>
              <th>Lugar</th>
              <th>Asignatura</th>
              <th>Profesor</th>
              <th>Cod. día Semana</th>
            </tr>

            @foreach($solapesdb as $numerofila => $aFila)
              <tr>
                <td>{{ $numerofila }}</td>
                @foreach($aFila as $valor)  
                  <td>{{ $valor }}</td>
                @endforeach
              </tr>
            @endforeach
       
          </table>
        </div><!-- .//panel-body -->
    </div><!-- .//panel-danger -->
  @endif

</div><!-- ./container -->
@stop