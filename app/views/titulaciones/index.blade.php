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
                        
                @if (Session::has('message'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('message') }}
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
                                    <!-- editar -->
                                    <a href="" title="Editar Titulación" class="editaTitulacion" data-idtitulo="{{ $titulacion->id }}" ><i class="fa fa-pencil fa-fw"></i></a>
                                
                                    <!-- eliminar -->
                                    <a class = "eliminaTitulacion" data-idtitulo="{{$titulacion->id}}" title = "Eliminar Titulación"><i class="fa fa-trash-o fa-fw"></i></a>
                                    {{ $titulacion->nombre }}
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
@stop

@section('js')

    {{HTML::script('assets/js/titulaciones.js')}}

@stop