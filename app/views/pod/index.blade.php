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
            
            <button type="submit" class="btn btn-primary">Comprobar csv</button>
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
        {{ Session::forget('msg-exito') }}
    </div>
  @endif
  @if (Session::has('msg-error'))
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ Session::get('msg-error') }}
        {{ Session::forget('msg-error') }}
    </div>
  @endif


 
  {{-- Resultado de la importación csv: Eventos salvados con éxito --}}
  <br /> 
  @if (!empty($aEventosValidos))
  
    {{-- Eventos a salvar con éxito--}}
    <div class="panel panel-success">
      
      <div class="panel-heading">

        <i class="fa fa-check fa-fw"></i> Eventos válidos
        <a href="" class="active btn btn-info" id="botonSalvaEventosCsv" title="Salvar eventos"><i class="fa fa-save fa-fw"></i> Salvar Eventos</a>
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
        <p class="text-center"><b>No hay eventos válidos en el archivo csv</b></p>
      </div>
    </div>
  @endif

  {{-- Error: no existe espacio --}}
  @if (!empty($aSinAula))
  
    <div class="panel panel-danger">
        
      <div class="panel-heading">
      
        <i class="fa fa-ban fa-fw"></i> <b>Error: No existe Espacio o Aula.</b>
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

</div><!-- ./container -->
@stop