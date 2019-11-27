@extends('layout')

@section('title')
    SGR: {{ Config::get('options.nombreSitio') }}. Busquedas.
@stop


@section('content')
    <div id="page-wrapper" style="margin-right: 10px">
        <div class="row col-sm-12 col-md-12 col-lg-12">
            <div id = "espera" style="display:none"></div>

            <div style="margin:20px auto">
            
                <div class="row">
                    {{ $header or '' }}
                </div>

            
            
                <div class="panel panel-info">
                    
                    <div class="panel-heading">
                        <h2><i class="fa fa-list fa-fw"></i> Disponibilidad. {{ Config::get('options.nombreSitio') }}</h2>
                    </div>

                    <div class="panel-body">
                                
                        @if (Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ Session::get('message') }}
                            </div>
                        @endif

                        {{ $disponibilidad or '' }}
                        
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

    {{HTML::script('assets/js/disponibilidad.js')}}
    {{HTML::script('assets/js/datepicker-es.js')}}

@stop