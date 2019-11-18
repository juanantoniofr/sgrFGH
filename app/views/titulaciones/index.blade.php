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
                
                <p>Titulaciones. FadeIn para ver las asignaturas</p>
                

            </div> <!-- /.panel-body  -->           
        </div> <!-- /.panel-info -->   

</div><!-- /.container -->


@stop

{{$addModal or ''}}

@section('js')

{{HTML::script('assets/js/applet.js')}}
<script type="text/javascript">
        function writeToContainer(valor){
            
            
            
                $('#dni').html(valor).change();
            
            
            
            
            }    
</script>

@stop