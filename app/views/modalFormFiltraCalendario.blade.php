<!-- Modal filtar eventos calendario -->
<div class="modal fade" id="modalFormFiltarEventos" tabindex="-4" role="dialog" aria-labelledby="filtar" aria-hidden="true">

    <div class="modal-dialog modal-lg">
      
      <div class="modal-content">        
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title" id="printTitle">Filtar eventos</h3>
        </div><!-- ./header -->
        
        <div class="modal-body">
          <div class="row">
            <div class="alert alert-info text-center" role="alert">Por favor, seleccione la información a incluir en el calendario.</div>
          </div>  
          
          <div class="row">
              
            <div class="col-lg-8 col-lg-offset-2">
              <label class="control-label">Titulación:</label>
                <select class="form-control"  name="titulacion" id="titulacion" multiple>
                  @foreach ($titulaciones as $titulacion)
                    <option value=" {{ $titulacion['codigo'] }} ">{{ $titulacion['titulacion'] }}
                    </option>
                  @endforeach
                </select>       
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
                    <option value=" {{ $actividad['codigo'] }} ">{{ $actividad['actividad'] }}
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