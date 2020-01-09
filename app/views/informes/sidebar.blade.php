<div class="col-lg-12 sidebar" id="opciones-filtrado">
{{Form::open(array('method' => 'POST',/*'route' => '',*/'role' => 'form','id'=>'fBuscaDisponible'))}}
    
    <h2>Opciones de Filtrado</h2>
    
    <!--
    <div class = "align-right">
          <a type="button" data-view="$viewActive" data-day="{{-- $day --}}" data-month="{{-- $numMonth --}}" data-year="{{-- $year --}}"  id="botonFiltrarEventos"  class="btn btn-info {{-- disabled --}}">
            <i class="fa fa-print fa-fw" ></i> Filtar
          </a>
    </div>
    -->
    {{-- Filtrar por estudios//Asiganturas//Profesor --}}
    <div class="titulo-acordeon">

        <h3><a href="">Plan docente <i class="fa fa-angle-double-down" aria-hidden="true"></i></a></h3>
    </div> 
    <div class="fila-acordeon" style="display:none">
        {{-- Select titulaciones --}}  
        <div class="form-group ">
                        
            <label class="control-label">Seleccione una o varias titulaciones:</label>
            <select class="form-control"  name="titulacion" id="titulacion" multiple size="{{count($titulaciones)}}">
                @foreach ($titulaciones as $titulacion)
                <option value="{{ $titulacion['codigo'] }}">{{ $titulacion['titulacion'] }}</option>
                @endforeach
            </select>       
        </div>
                  
        {{-- Select asignaturas --}}
        <div class="form-group" id="select-asignaturas">
            
            <label class="control-label">Seleccione una o varias asignaturas:</label>
            <select class="form-control"  name="asignatura" id="asignatura" multiple>
                {{-- Options desde ajax function en filtraEventos.js --}}
                <option value="all" selected>Todas</option>
            </select>       
        </div>

        {{-- Select profesores --}}
        <div class="form-group" id="select-profesores" >
        
            <label class="control-label">Seleccione uno o varios profesores/profesoras:</label>
            <select class="form-control"  name="profesor" id="profesor" multiple>
                {{-- Options desde ajax function en filtraEventos.js --}}
                <option value="all" selected>Todos/as</option>
            </select>       
        </div>                       
    </div>

    {{-- Filtrar por fechas/día y horario de los eventos--}}
    <div class="titulo-acordeon"  >

        <h3><a href="">Evento <i class="fa fa-angle-double-down" aria-hidden="true"></i></a></h3>
    </div>    
    
    <div class="fila-acordeon" {{-- style="display:none" --}}>
        
        <div class="form-group col-lg-10">
            <p>{{Form::label('f_inicio', 'Fecha inicio')}}: <input name="f_inicio" class="form-control" type="text" id="datepickerIni" value="{{ Config::get('calendarioLectivo.f_inicio_curso') }}"></p>
            <p>{{Form::label('f_fin', 'Fecha fin')}}: <input name="f_fin" class="form-control" type="text" id="datepickerFin" value="{{ Config::get('calendarioLectivo.f_fin_curso') }}"></p>
        </div>
     
        <div class="form-group col-lg-10" id="dias">
      
            {{Form::label('d', 'Días')}}
            <br />
        
            <div class="checkbox-inline" style="display:none">
                <label><input type="checkbox" value = "0" name="dias"> D</label>
            </div>
      
            <div class="checkbox-inline">
                <label><input type="checkbox" value = "1" name="dias" checked="checked"> L</label>
            </div>
      
            <div class="checkbox-inline">
                <label><input type="checkbox" value = "2" name="dias" checked="checked"> M</label>
            </div>  
      
            <div class="checkbox-inline">
                <label><input type="checkbox" value = "3" name="dias" checked="checked"> X</label>  
            </div>
      
            <div class="checkbox-inline">
                <label><input type="checkbox" value = "4" name="dias" checked="checked"> J</label>  
            </div>
      
            <div class="checkbox-inline">
                <label><input type="checkbox" value = "5" name="dias" checked="checked"> V</label>  
            </div>
      
            <div class="checkbox-inline" style="display:none">
                <label><input type="checkbox" value = "6" name="dias"> S</label>
            </div>
        </div>    
      
        <div class="form-group col-lg-10" id="hFin">
        
            {{Form::label('h', 'Horario')}}
        
            <div class="">
                <select class="form-control"  name="h_inicio" id="newReservaHinicio">
                    @foreach (Config::get('options.rangoHorarios') as $hora)
                        <option value="{{ $hora }}">{{ $hora }}</option>
                    @endforeach
                </select>
            </div>
        
            <h4 class="">Hasta:</h4>
            <div class="" style="margin-bottom: 50px">
                <select class="form-control"  name="h_fin" id="newReservaHfin">
                    @foreach (Config::get('options.rangoHorarios') as $hora)
                        <option value="{{ $hora }}">{{ $hora }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div><!--/.fila-acordeon -->
    
    {{-- Filtrar por equipamiento --}}
    <div class="titulo-acordeon" >
        
        <h3><a href="#" >Equipamiento <i class="fa fa-angle-double-down" aria-hidden="true"></i></a></h3>
    </div>

    <div class="fila-acordeon" style="display:none">
        
        <div class="form-group col-lg-10 form-equipamiento" id="fgaforomax">

            {{Form::label('aforomax', 'Aforo Máximo')}}
            <span id="aforomax_error" style="display:none" class="text-danger spanerror"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <span id='text_error'></span></span>
            {{Form::text('aforomax',Input::old('aforomax'),array('class' => 'form-control'))}}
        </div>

        <div class="form-group col-lg-10" id="fgaforoexam">

            {{Form::label('aforoexam', 'Aforo Examen')}}
            <span id="aforoexam_error" style="display:none" class="text-danger spanerror">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            <span id='text_error'></span>
            </span>
            {{Form::text('aforoexam',Input::old('aforoexam'),array('class' => 'form-control'))}}
        </div> 

        <div class="form-group col-lg-10">
        {{Form::label('medios', 'Medios')}}  
            @foreach($aMediosDisponibles as $medio) 
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name = "mediosdisponibles[]" value="{{$medio['codigo']}}" > {{$medio['nombre']}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

     
{{Form::close()}}
</div>

