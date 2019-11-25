@extends('layout')

@section('title')
    SGR: {{ Config::get('options.nombreSitio') }}. Busquedas.
@stop


@section('content')
    <div id="page-wrapper" style="margin-right: 10px">
        <div class="row col-sm-6 col-md-9">
            <div id = "espera" style="display:none"></div>

            <div style="margin:20px auto">
            
                <div class="row">
                    {{ $header or '' }}
                </div>

            
            
                <div class="panel panel-info">
                    
                    <div class="panel-heading">
                        <h2><i class="fa fa-list fa-fw"></i> Busquedas. {{ Config::get('options.nombreSitio') }}</h2>
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
                                    <tr>
                                        <td> Resultado de la busqueda, listado de espacios</td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- /.panel-body  -->           
                </div> <!-- /.panel-info -->   
            </div><!-- / -->
        </div><!-- /.row -->
    </div><!-- /#page-wrapper -->    
@stop


@section('modal')

    {{ $modalNuevaTitulacion or '' }}
    {{ $modalEditaTitulacion or '' }}
@stop

@section('js')

    {{HTML::script('assets/js/busqueda.js')}}
    {{HTML::script('assets/js/datepicker-es.js')}}

@stop