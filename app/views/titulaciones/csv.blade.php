@extends('layout')

@section('title')
    SGR: {{ Config::get('options.nombreSitio') }}. Gestión de titulaciones, Uplaod CSV.
@stop


@section('content')
<div id = "espera" style="display:none"></div>

<div class="container">
    
        <div class="row">
            {{ $header or '' }}
        </div>

        
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-cogs fa-fw"></i> Títulaciones/ Plan docente</h3>
            </div>
        </div> <!-- /.row -->

        <!-- formulario upload file csv -->
        <div class="row">
            
            <div class="panel panel-info">
        
                <div class="panel-heading">
                    <h4><i class="fa fa-upload fa-fw"></i> Cargar P.D</h4>
                </div>
                
                <div class="panel-body">
                    
                    <div class="col-lg-12">
                        {{Form::open( array( 'url' => route('titulacionesUpload'), 'files' => true ) )}}
                
                        <div class="form-group">
                            {{Form::label('csvfile', 'Archivo csv:')}} 
                            {{Form::file('csvfile', $attributes = array());}}
                        </div>
                  
                        <button type="submit" class="btn btn-primary">Importar P.D</button>
             
                        {{Form::close()}}
                    </div><!-- /.col-lg-12 -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel-info -->
        </div><!-- /.row -->

        <!-- resultado de la lectura -->
        <div class="row">
            <div class="panel panel-info">
                
                <div class="panel-heading">
                    <h3><i class="fa fa-list fa-fw"></i> Titulaciones: Upload CSV. {{ Config::get('options.nombreSitio') }}</h3>
                </div>

                <div class="panel-body">
                            
                    @if (Session::has('message'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ Session::get('msg') }}
                        </div>
                    @endif

                    <div>
                        <p>{{ $titulacion or '' }}</p>
                        <pre>
                            {{ var_dump($pd)  or ''}}            
                        </pre>
                        <pre>
                            Resultado de la lectura CSV
                            {{ var_dump($datos)  or ''}}
                        </pre>
                    </div>

                </div> <!-- /.panel-body  -->           
            </div> <!-- /.panel-info -->   
        </div>
</div><!-- /.container -->


@stop


@section('modal')

@stop

@section('js')

    {{HTML::script('assets/js/titulaciones.js')}}

@stop