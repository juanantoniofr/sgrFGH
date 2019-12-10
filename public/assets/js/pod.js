$(function(e){

    showGifEspera();

    $( '.container' ).load(function() {
        hideGifEspera();
        
    });
    
    function showGifEspera(){
        $('#espera').css('display','inline').css('z-index','100');
    }

    function hideGifEspera(){
        $('#espera').css('display','none').css('z-index','-100');
    }
});