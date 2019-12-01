$(function(e){

    //Muestra ventana modal nueva titulación
    $("#botonMuestraModalNuevaTitulacion").on('click',function(e){
        e.preventDefault();
        $('#modalNuevaTitulacion').modal('show');
    });

    //Muestra ventana modal edita titulación
    $(".editaTitulacion").on('click',function(e){
        e.preventDefault();
        //console.log ( $(this).data('idTitulo') );
        console.log ( $(this).data('idtitulo') );
        //Cargar valores del recurso a editar en #modalEditRecurso
       
        $.ajax({
            type: "GET",
            url:  "getTitulacion",
            data: {id:$(this).data('idtitulo')},
            success: function($respuesta){
                
                console.log('Resouesta: ' + $respuesta.titulacion.id);
                $('#modalEditaTitulacion input#id').val($respuesta.titulacion.id);
                $('#modalEditaTitulacion input#codigo').val($respuesta.titulacion.codigo);
                $('#modalEditaTitulacion input#titulacion').val($respuesta.titulacion.titulacion);
                //$('#modalEditaTitulacion .text-danger').slideDown();
                $('#modalEditaTitulacion').modal('show');
               
             
            },
            error: function(xhr, ajaxOptions, thrownError){
                    //hideGifEspera();
                    alert(xhr.responseText + ' (codeError: ' + xhr.status +')');
                    }
            });
        
        });
        
    //Ajax function para salvar nuevo recurso
    $('#botonSalvaTitulacion').on('click',function(e){
        e.preventDefault();
        $data = $('form#nuevaTitulacion').serialize();
        $.ajax({
            type: "POST",
            url: "salvaNuevaTitulacion", /* terminar en controllador */
            data: $data,
            success: function($respuesta){
                if ($respuesta['error'] == false){
                    $('#modalNuevaTitulacion').modal('hide');
                    location.reload();
                }
                //Hay errores de validación del formulario
                else {
                   console.log($respuesta);
                   //resetea errores anteriores
                   $('#modalNuevaTitulacion div#aviso span').html($respuesta.msg).fadeIn();
                   //console.log($respuesta.msg);
                   $('#modalNuevaTitulacion .has-error').removeClass('has-error');//borrar errores anteriores
                   $('#modalNuevaTitulacion .spanerror').each(function(){$(this).slideUp();});
                   //new errors
                   $.each($respuesta['errors'],function(key,value){
                        //$('#modalNuevaTitulacion #'+key+'_error').fadeOut("slow");
                        $('#modalNuevaTitulacion #'+key).addClass('has-error');
                        $('#modalNuevaTitulacion #'+key+'_error > span#text_error').html(value);
                        $('#modalNuevaTitulacion #'+key+'_error').fadeIn("slow");
                        $('#aviso').slideDown("slow");
                    });     
                }
            },
            error: function(xhr, ajaxOptions, thrownError){
                    //hideGifEspera();
                    alert(xhr.responseText + ' (codeError: ' + xhr.status) +')';
                }
            });
    }); // --end Ajax function

    //Ajax function para salvar nuevo recurso
    $('#botonEditaTitulacion').on('click',function(e){
        e.preventDefault();
        alert('aún en desarrollo....');
    });
});