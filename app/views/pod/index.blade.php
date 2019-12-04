@extends('layout')
 
@section('title')
    Admin:: carga P.O.D 
@stop
 
@section('content')
<div id ="espera" style="display:none"></div>

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
                                               
          {{Form::open( array( 'url' => route('compruebaCsv'), 'files' => true ) )}}
            
            <div class="form-group">
              {{Form::label('csvfile', 'Archivo csv:')}} 
              {{Form::file('csvfile', $attributes = array());}}
            </div>
            
            <button type="submit" class="btn btn-primary"> <i class="fa fa-check fa-fw"></i> Comprobar csv</button>
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


 {{ $resultadoComprobacionCsv or ''}}

</div><!-- ./container -->
@stop

@section('js')

    {{ HTML::script('assets/js/pod.js') }}

@stop