<div class="modal fade" id="modalUploadCsv" tabindex="-3" role="dialog" aria-labelledby="modalUploadCsv">

    {{Form::open( array( 'url' => route('saveCsv'), 'files' => true ) )}}
        
        <div class="modal-dialog modal-lg">
            
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"> <h3><i class="fa fa-upload fa-fw"></i> Cargar P.D</h3>
                </div><!-- ./modal-header -->

                <div class="modal-body">
            
                    <div class="form-group">
                        {{Form::label('csvfile', 'Seleccione archivo csv:')}} 
                        {{Form::file('csvfile', $attributes = array('id' => 'idcsvfile'));}}
                    </div>

                </div><!-- ./modal-body --> 
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id ="botonSaveCsv">
                      <i class="fa fa-save fa-fw"></i> Importar
                    </button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    {{Form::close()}}
</div><!-- /.modal -->