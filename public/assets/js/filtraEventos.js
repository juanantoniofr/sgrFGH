$(function(e){

    var $data = { 

            titulaciones: [],

            setTitulacion: function($titulacion){
                this.titulaciones.push($titulacion);
                return true;
            },

            getTitulaciones(){
                return  this.titulaciones;
            } 

        };

    //Muestra ventana modal nueva titulación
    $("div#modalFormFiltarEventos select#titulacion").on('click',function(e){
        
        e.preventDefault();
        alert($data.getTitulaciones().toString());
        $data.setTitulacion('vamos');
        alert($data.getTitulaciones().toString());
    });

    
    function showGifEspera(){
        $('#espera').css('display','inline').css('z-index','100');
    }

    function hideGifEspera(){
        $('#espera').css('display','none').css('z-index','-100');
    }
});