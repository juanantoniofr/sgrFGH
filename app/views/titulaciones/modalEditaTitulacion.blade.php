<div class="modal fade" id="modalEditaTitulacion" tabindex="-2" role="dialog" aria-labelledby="modalEditaTitulacion">

  {{Form::open(array('method' => 'POST','role' => 'form','id'=>'editaTitulacion'))}}
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title"><i class="fa fa-institution fa-fw"></i> Editar Titulación</h3>
      </div><!-- ./modal-header -->

      <div class="modal-body">
        
        <div class="alert alert-danger" role="alert" style="display:none" id="aviso">
          Revise el formulario para corregir errores.... 
          <span></span>
        </div>
        
        <div class="form-group" id="codigo">  
          {{Form::label('codigo', 'Código Titulación')}}

          <span id="codigo_error" style="display:none" class="text-danger spanerror"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            <span id='text_error'></span>
          </span>
          
          {{Form::text('codigo','',array('class' => 'form-control'))}}
        </div>
              
        <div class="form-group" id="nombre">
          {{Form::label('nombre', 'Titulación')}}
          <span id="nombre_error" style="display:none" class="text-danger spanerror"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            <span id='text_error'></span>
          </span>
          {{Form::text('nombre','',array('class' => 'form-control'))}}
        </div>

        <div class="form-group hidden">
          {{Form::text('id','',array('class' => 'form-control','id' => 'id'))}}
          </div>

      </div><!-- ./modal-body --> 
    
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id ="botonEditaNuevaTitulacion">
          <i class="fa fa-save fa-fw"></i> Salvar
        </button>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
      {{Form::close()}}
</div><!-- /.modal -->