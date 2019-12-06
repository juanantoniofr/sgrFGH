<!-- modal elimina titulacion -->
<div class="modal fade" id="modalEliminaTitulacion" tabindex="-1" role="dialog" aria-labelledby="eliminaTitulacion" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
      
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h3 class="modal-title"><i class="fa fa-graduation-cap fa-fw"></i> Eliminar Titulación</h3>
            </div>

            <div class="modal-body">
        
                <div class="alert alert-danger" role = "alert">¿Estás seguro que deseas <b>eliminar</b> la Titulación: "<b><span id="nombretitulo"></span>"</b> ?</div>
                <div class="alert alert-warning"> Al eliminar la Titulación, se eliminará de forma permanente la Titulación y todas sus asignaturas.</div>
       
            </div><!-- ./.modal-body -->

            <div class="modal-footer">
                <a class="btn btn-primary" href="" role="button" id="btnEliminaTitulacion"><i class="fa fa-trash-o fa-fw"></i> Eliminar</a>

                <!--<button type="button" class="btn btn-primary" value= "" id="btnEliminar" data-idrecurso="" >Eliminar</button>-->
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- ./.modal-content -->
    </div><!-- ./.modal-dialog -->
</div><!-- ./#modalborrarRecurso -->