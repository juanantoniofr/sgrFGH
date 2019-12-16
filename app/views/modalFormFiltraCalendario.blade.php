<!-- Modal filtar eventos calendario -->
<div class="modal fade" id="modalFormFiltarEventos" tabindex="-4" role="dialog" aria-labelledby="filtar" aria-hidden="true">

    <div class="modal-dialog modal-lg">
      
        <div class="modal-content">        
        
            <div class="modal-header">
          
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="filtrar-titulo">Filtar eventos</h3>

                <div class="alert alert-info text-center" role="alert">
                
                    <p>Por favor, seleccione la información a incluir en el calendario.</p>
                </div> 
            </div><!-- ./header -->
        
            <div class="modal-body">
               
                <form> 
                {{-- Select titulaciones --}}  
                    <div class="form-group ">
                        
                        <label class="control-label">Por titulación:</label>
                        <select class="form-control"  name="titulacion" id="titulacion" multiple>
                            @foreach ($titulaciones as $titulacion)
                                <option value="{{ $titulacion['codigo'] }}">{{ $titulacion['titulacion'] }}</option>
                            @endforeach
                        </select>       
                    </div>
                  
                    {{-- Select asignaturas --}}
                    <div class="form-group">
                        
                        <label class="control-label">Por asignatura:</label>
                        <select class="form-control"  name="asignatura" id="asignatura" multiple>
                            {{-- Options desde ajax function en filtraEventos.js --}}
                            @foreach ($asignaturas as $asignatura)
                                <option value="{{ $asignatura['codigo'] }}">{{ $asignatura['asignatura'] }}</option>
                            @endforeach
                        </select>       
                    </div>

                    {{-- Select profesores --}}
                    <div class="form-group">
                    
                    <label class="control-label">Por profesor:</label>
                    <select class="form-control"  name="profesor" id="profesor" multiple>
                        @foreach ($profesores as $profesor)
                            <option value="{{ $profesor['dni'] }}">{{ $profesor['profesor'] }}</option>
                        @endforeach
                    </select>       
                </div>               

                </form> 
            </div> <!-- ./body -->
        
            <div class="modal-footer">
              
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <a href="" target="_blank"class="btn btn-primary" id="modalImprimir" ><i class="fa fa-print fa-fw" ></i> Imprimir</a>
            </div><!-- ./footer -->
      
        </div><!-- ./content -->
    </div><!-- ./modal-dialog -->
</div>