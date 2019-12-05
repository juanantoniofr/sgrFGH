@extends('layout')

@section('title')
    SGR: {{ Config::get('options.nombreSitio') }}. Gestión de titulaciones.
@stop


@section('content')
<div id = "espera" style="display:none"></div>

<div class="container">
    
        <div class="row">
            {{ $header or '' }}
        </div>

        <div class="panel panel-info">
            
            <div class="panel-heading">
                <h2><i class="fa fa-list fa-fw"></i> Titulaciones. {{ Config::get('options.nombreSitio') }}</h2>
            </div>

            <div class="panel-body">
                        
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
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead><th>Código</th><th>Nombre</th><th>Update At</th></thead>
                        <tbody>
                        @foreach($titulaciones as $titulacion )
                            <tr>
                                <td>{{ $titulacion->codigo}}</td>
                                <td>
                                    <div class="titulo-acordeon" >
                                    <a href="">{{ $titulacion->titulacion }} <i class="fa fa-angle-double-down" aria-hidden="true"></i></a>
                                    <!-- editar -->
                                    <a href="" title="Editar Titulación" class="editaTitulacion" data-idtitulo="{{ $titulacion->id }}" ><i class="fa fa-pencil fa-fw"></i></a>
                                
                                    <!-- eliminar -->
                                    <a href="" class="eliminaTitulacion" data-idtitulo="{{$titulacion->id}}" data-nombretitulo="{{ $titulacion->titulacion }}" title = "Eliminar Titulación"><i class="fa fa-trash-o fa-fw"></i></a>
                                    </div>
                                    <div class="col-lg-10 fila-acordeon" style="display: none;">
                                        <ul>
                                            @foreach( $titulacion->asignaturas as $asignatura )
                                                <li> 
                                                    {{ $asignatura->asignatura }} <br />
                                                    <small>(
                                                        @foreach($asignatura->gruposAsignatura as $grupo)
                                                            {{  $grupo->grupo }} : @foreach ($grupo->profesores as $profesor) {{  $profesor->profesor }} , @endforeach <br />
                                                        @endforeach
                                                    )</small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                                
                                <td> Update: {{ $titulacion->updated_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div> <!-- /.panel-body  -->           
        </div> <!-- /.panel-info -->   

</div><!-- /.container -->


@stop


@section('modal')

    {{ $modalNuevaTitulacion or '' }}
    {{ $modalEditaTitulacion or '' }}
    {{ $modalEliminaTitulacion or '' }}

@stop

@section('js')

    {{HTML::script('assets/js/titulaciones.js')}}

@stop