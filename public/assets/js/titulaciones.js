$(function(e){

    //Muestra ventana modal nueva titulación
    $("#botonMuestraModalNuevaTitulacion").on('click',function(e){
        e.preventDefault();
        $('#modalNuevaTitulacion').modal('show');
    });

    //Muestra ventana modal edita titulación
    $(".editaTitulacion").on('click',function(e){
        e.preventDefault();
        e.stopPropagation();
        
        $.ajax({
            type: "GET",
            url:  "getTitulacion",
            data: {id:$(this).data('idtitulo')},
            success: function($respuesta){
                
                console.log('Resouesta: ' + $respuesta.titulacion.id);
                $('#modalEditaTitulacion input#id').val($respuesta.titulacion.id);
                $('#modalEditaTitulacion input#codigo').val($respuesta.titulacion.codigo);
                $('#modalEditaTitulacion input#titulacion').val($respuesta.titulacion.titulacion);
                $('#modalEditaTitulacion').modal('show'); 
            },
            error: function(xhr, ajaxOptions, thrownError){
                lert(xhr.responseText + ' (codeError: ' + xhr.status +')');
            }
        });
    });

    //Muestra ventana modal eliminar titulación
    $(".eliminaTitulacion").on('click',function(e){
        e.preventDefault();
        e.stopPropagation();
        $('div#modalEliminaTitulacion #nombretitulo').html($(this).data('nombretitulo'));
        
        $('div#modalEliminaTitulacion a#btnEliminaTitulacion').attr('href', 'elimina-titulacion.html' + '?'+'id='+$(this).data('idtitulo'));
        $('div#modalEliminaTitulacion').modal('show');
    });

    //Muestra ventana modal fromulario upload fichero csv
    $("#botonUploadCsv").on('click',function(e){
        e.preventDefault();
        e.stopPropagation();
        $('div#modalUploadCsv').modal('show');
    });




    //Ajax function para salvar nuevo recurso
    $('#botonSalvaTitulacion').on('click',function(e){
        e.preventDefault();
        $data = $('form#nuevaTitulacion').serialize();
        showGifEspera();
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
                    hideGifEspera();
                    alert(xhr.responseText + ' (codeError: ' + xhr.status) +')';
                }
            });
    }); // --end Ajax function

    //Ajax function para salvar nuevo recurso
    $('#botonEditaTitulacion').on('click',function(e){
        e.preventDefault();
        alert('aún en desarrollo....');
    });

    $( '.titulo-acordeon').click(function(e){;
        e.preventDefault();
        e.stopPropagation();
        $( this ).next().toggle('slow');
        //$( 'div.fila-acordeon', this).toggle('slow');
    });

    function showGifEspera(){
        $('#espera').css('display','inline').css('z-index','100');
    }

    function hideGifEspera(){
        $('#espera').css('display','none').css('z-index','-100');
    }
});