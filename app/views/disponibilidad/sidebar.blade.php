<div class="col-sm-6 col-md-3 sidebar ">
  {{Form::open(array('method' => 'POST',/*'route' => '',*/'role' => 'form','id'=>'fBuscaDisponible'))}}
    
    <h3>Opciones de busqueda</h3>
    <div class="titulo-acordeon" >

        <h4><a href="">Evento <i class="fa fa-angle-double-down" aria-hidden="true"></i></a></h4>
    </div>    
    <div class="fila-acordeon" >
        
        <div class="form-group col-lg-10">
            <p>{{Form::label('fi', 'Fecha inicio')}}: <input class="form-control" type="text" id="datepickerIni"></p>
            <p>{{Form::label('ff', 'Fecha fin')}}: <input class="form-control" type="text" id="datepickerFin"></p>
        </div>
     
        <div class="form-group col-lg-10" id="dias">
      
            {{Form::label('d', 'Días')}}
            <br />
        
            <div class="checkbox-inline" style="display:none">
                <label><input type="checkbox" value = "0" name="dias[]"> D</label>
            </div>
      
            <div class="checkbox-inline">
                <label><input type="checkbox" value = "1" name="dias[]"> L</label>
            </div>
      
            <div class="checkbox-inline">
                <label><input type="checkbox" value = "2" name="dias[]"> M</label>
            </div>  
      
            <div class="checkbox-inline">
                <label><input type="checkbox" value = "3" name="dias[]"> X</label>  
            </div>
      
            <div class="checkbox-inline">
                <label><input type="checkbox" value = "4" name="dias[]"> J</label>  
            </div>
      
            <div class="checkbox-inline">
                <label><input type="checkbox" value = "5" name="dias[]"> V</label>  
            </div>
      
            <div class="checkbox-inline" style="display:none">
                <label><input type="checkbox" value = "6" name="dias[]"> S</label>
            </div>
        </div>    
      
        <div class="form-group col-lg-10" id="hFin">
        
            {{Form::label('h', 'Horario')}}
        
            <div class="">
                <select class="form-control"  name="hInicio" id="newReservaHinicio">
                    <option value="8:30">8:30</option>
                    <option value="9:30">9:30</option>
                    <option value="10:30">10:30</option>
                    <option value="11:30">11:30</option>
                    <option value="12:30">12:30</option>
                    <option value="13:30">13:30</option>
                    <option value="14:30">14:30</option>
                    <option value="15:30">15:30</option>
                    <option value="16:30">16:30</option>
                    <option value="17:30">17:30</option>
                    <option value="18:30">18:30</option>
                    <option value="19:30">19:30</option>
                    <option value="20:30">20:30</option>
                </select>
            </div>
        
            <h4 class="">Hasta:</h4>
            <div class="" style="margin-bottom: 50px">
                <select class="form-control"  name="hFin" id="newReservaHfin">
                    <option value="9:30">9:30</option>
                    <option value="10:30">10:30</option>
                    <option value="11:30">11:30</option>
                    <option value="12:30">12:30</option>
                    <option value="13:30">13:30</option>
                    <option value="14:30">14:30</option>
                    <option value="15:30">15:30</option>
                    <option value="16:30">16:30</option>
                    <option value="17:30">17:30</option>
                    <option value="18:30">18:30</option>
                    <option value="19:30">19:30</option>
                    <option value="20:30">20:30</option>
                    <option value="21:30">21:30</option>
                </select>
            </div>
        </div>
    </div><!--/.fila-acordeon -->
    

    <div class="titulo-acordeon" >
        
        <h4><a href="#" >Equipamiento <i class="fa fa-angle-double-down" aria-hidden="true"></i></a></h4>
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

