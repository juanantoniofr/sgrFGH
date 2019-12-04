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
                
                $(' #respuestaSalvaEventos ').html( $respuesta );

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