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
                if ($respuesta.resultAsignatura.error == false){
                    var $htmlRespuesta = '';
                    $respuesta.resultAsignatura.exito.forEach( function(item, index){
                            $htmlRespuesta += item + "<br>";
                            console.log(item);
                        }
                    );
                    console.log($respuesta.resultEvento);
                    $htmlRespuesta.innerHTML += "<hr>";
                    //$htmlRespuesta += ' ( ' + $respuesta.resultEvento + ' )<br>';
                    $respuesta.resultEvento.exito.forEach( function(item, index) {
                            $htmlRespuesta += item + "<br>";
                        }
                    ); 
                }
                     
                $(' #respuestaSalvaEventos ').html($htmlRespuesta).fadeIn(1000);

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