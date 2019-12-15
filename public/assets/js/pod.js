$(function(e){


    $(' #botonSalvaEventos ').on('click',function(e){

        e.preventDefault();
        e.stopPropagation();
        
        showGifEspera();
        $.ajax({
            type: "POST",
            url:  "salvaEventosCsv",
            data: {eventos:$(this).data('eventos')},
            success: function($respuesta){
                console.log($respuesta);
                console.log($respuesta.resultAsignatura.error);
                if ( $respuesta.errorMsgInputValidate != '' ) alert($respuesta.errorMsgInputValidate);
                
                console.log($respuesta.resultEventoExito);
                //Exito, fadeIn fila tabla
                //$htmlRespuesta += ' ( ' + $respuesta.resultEvento + ' )<br>';
                $respuesta.resultEventoExito.forEach( function(item, index) {
                        $(' #exitoSalvaEvento-' + item).fadeIn(1000);
                    }
                );

                if ($respuesta.resultAsignatura.error != false ){
                   //errores alert
                    /*
                    var $htmlRespuesta = '';
                    $respuesta.resultAsignatura.exito.forEach( function(item, index){
                            $htmlRespuesta += item + "<br>";
                            //console.log(item);
                        }
                    );
                    if ($htmlRespuesta != '') alert($htmlRespuesta);
                    */
                     
                }
                     
                

            },
            error: function(xhr, ajaxOptions, thrownError){
                hideGifEspera();
                alert(xhr.responseText + ' (codeError: ' + xhr.status +')');
            }
        });
        hideGifEspera();

    });
    
    function showGifEspera(){
        $('#espera').css('display','inline').css('z-index','100');
    }

    function hideGifEspera(){
        $('#espera').css('display','none').css('z-index','-100');
    }
});