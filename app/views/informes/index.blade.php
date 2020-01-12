@extends('layout')
 
@section('title')
    SGR: Informes de ocupación
@stop


@section('content')

<div id="page-wrapper" class="container-fluid"> 


    <div id = "espera" style="display:none"></div>

    <div id="calendario" class="col-lg-12">
        
        <div class = "row">
            <div class = "col-lg-12">
                <h3><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Horarios e Informes: <span  id ="recurseName"></span></h3>
                 
                <hr />

                <div class="form-inline pull-right btn-group" role="form">
                    
                    <div class = "btn-group"  >

                        <a type="button" data-view="{{$viewActive}}" data-day="{{$day}}" data-month="{{$numMonth}}" data-year="{{$year}}"  id="btnprint"  class="btn btn-primary disabled">
                            <i class="fa fa-print fa-fw" ></i> Imprimir
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class= "row">
            @if(isset($msg) && !empty($msg))
            
            <div class="alert alert-danger col-md-12 text-center" role="alert" id="alert_msg">
              <strong>{{$msg}}</strong>
            </div>  
            @endif
          
            <div style = "display:none" class="alert alert-info col-md-12 text-center" role="alert" id="msg"></div> 
            <div style = "display:none" class="alert alert-success col-md-12 text-center" role="alert" id="message"></div>
            <div style = "display:none" class="alert alert-warning col-md-12 text-center" role="alert" id="warning"></div>
        </div>

        <div class="row" style="margin-top:20px">
            
            <div id="container-calendar" class="col-lg-12">  
                
                <div id="resultados-filtros">

                  {{ $msgInicio or '' }}

                </div>
                
                
            </div>
        </div><!-- /.row -->
    </div><!-- /#calendario -->   

</div><!-- /#page-wrapper -->

<!-- Modal print -->
<div class="modal fade printModal-md " id="printModal" tabindex="-3" role="dialog" aria-labelledby="print" aria-hidden="true">

    <div class="modal-dialog modal-md">
      
      <div class="modal-content">        
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title" id="printTitle">Opciones de impresión</h3>
        </div><!-- ./header -->
        
        <div class="modal-body">
          <div class="alert alert-info text-center" role="alert">Por favor, seleccione la información a incluir en la impresión</div>
            
            <div class="row">
              <div class="col-md-6 col-md-offset-4"> 
                  <div class="checkbox"> 
                    <label><input type="checkbox" id ="checktitulo" value = "titulo" name="info[]" checked /> Título</label>
                  </div>
              </div>
              <div class="col-md-6 col-md-offset-4">     
                  <div class="checkbox">
                    <label><input type="checkbox"  id = "checknombre" value = "nombre" name="info[]" /> Nombre y apellidos</label>
                  </div>
              </div>      
              <div class="col-md-6 col-md-offset-4"> 
                  <div class="checkbox">
                    <label><input type="checkbox" id = "checkcolectivo" value = "colectivo" name="info[]" /> Colectivo</label>
                  </div>  
              </div>     
              
              <div class="col-md-6 col-md-offset-4"> 
                  <div class="checkbox">
                    <label><input type="checkbox" id = "checktotal" value = "total" name="info[]" /> Total (puestos/equipos)</label>
                  </div>  
              </div>
              
              <div class="col-md-6 col-md-offset-4">
                <label class="control-label">Tipo de Actividad:</label>
                <select class="form-control"  name="actividad" id="printTipoActividad" multiple="multiple">
                  @foreach (Config::get('options.tipoActividad') as $actividad)
                    <option selected="selected" value=" {{ $actividad['codigo'] }} ">{{ $actividad['actividad'] }}
                    </option>
                  @endforeach
                </select>       
              </div>    
            
            </div>
              
        </div> <!-- ./body -->
    
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <a href="" target="_blank"class="btn btn-primary" id="modalImprimir" ><i class="fa fa-print fa-fw" ></i> Imprimir</a>
          
        </div><!-- ./footer -->
      
      </div><!-- ./content -->
    </div><!-- ./modal-dialog -->
</div>

{{ $modaldescripcion or '' }}
{{ $modalMsg         or '' }}
{{ $modalFormFiltraCalendario or '' }}

@stop

@section('js')
  {{ HTML::script('assets/js/sgr.js')}}
  {{ HTML::script('assets/js/filtraEventos.js') }}
  {{-- HTML::script('assets/js/imprimir.js') --}}
  {{ HTML::script('assets/js/datepicker-es.js')}}
@stop