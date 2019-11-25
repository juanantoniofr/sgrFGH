  <div class="col-sm-6 col-md-3 sidebar">
    {{Form::open(array('method' => 'POST',/*'route' => '',*/'role' => 'form','id'=>'fBuscaDisponible'))}}
    
      
      <h2>Filtros</h2>
      <h3>Equipamiento</h3>  
      <div class="form-group" id="fgaforomax">

        {{Form::label('aforomax', 'Aforo Máximo')}}
        <span id="aforomax_error" style="display:none" class="text-danger spanerror"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <span id='text_error'></span></span>
        {{Form::text('aforomax',Input::old('aforomax'),array('class' => 'form-control'))}}
      </div>

      <div class="form-group" id="fgaforoexam">

        {{Form::label('aforoexam', 'Aforo Examen')}}
          <span id="aforoexam_error" style="display:none" class="text-danger spanerror">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            <span id='text_error'></span>
          </span>
          {{Form::text('aforoexam',Input::old('aforoexam'),array('class' => 'form-control'))}}
      </div> 

      <div class="form-group">
        <h4>Medios disponibles:</h4>  
        @foreach($aMediosDisponibles as $medio) 
          <div class="checkbox">
            <label>
              <input type="checkbox" name = "mediosdisponibles[]" value="{{$medio['codigo']}}" > {{$medio['nombre']}}
            </label>
          </div>
        @endforeach
      </div>
    

      <h2>Evento</h2>
      <p>Fecha inicio: <input type="text" id="datepickerIni"></p>
      <p>Fecha fin: <input type="text" id="datepickerFin"></p>
      <!-- días -->
      <div class="form-group" id="dias">
      
          <h4  class="">días:</h4>
      
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
      </div><!-- /#dias -->    
      
      <div class="form-group" id="hFin">
        
        <h4 class="">Horario:</h4>
        
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
    {{Form::close()}}
  </div>
