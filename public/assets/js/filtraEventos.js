$(function(e){

    var $data = { 

            titulaciones: [],

            init: function(){
                this.titulaciones = [];
            },

            setTitulacion: function($aTitulaciones){
                
                this.titulaciones = $aTitulaciones;
                return true;
            },

            getTitulaciones(){
                
                return  this.titulaciones;
            } 

        };

    //Muestra ventana modal nueva titulación
    $("div#modalFormFiltarEventos select#titulacion-de-momento-no").on('click',function(e){
        
        e.preventDefault();
        
        //Set titulacion/es seleccionada/s
        $data.setTitulacion( $('div#modalFormFiltarEventos select#titulacion').val() );

        //Obtener asignaturas
        //showGifEspera();
        console.log($data.getTitulaciones());   
        $.ajax({
            type: "GET",
            url: "getAsignaturas", /* terminar en controllador */
            data: {aCodigos:$data.getTitulaciones()},
            success: function($respuesta){
                
                console.log($respuesta);
                $('div#modalFormFiltarEventos select#asignatura ').empty();
                $respuesta.forEach(function(item,index){
                
                    console.log(item);
                    item.asignatura.forEach(function(item,index){
                        console.log(item);
                        $('div#modalFormFiltarEventos select#asignatura ').append('<option value = "'+item.codigo+'"> ' + item.asignatura + '</option>'); 
                    });
                });
            },
            error: function(xhr, ajaxOptions, thrownError){
                //    hideGifEspera();
                    alert(xhr.responseText + ' (codeError: ' + xhr.status) +')';
            }
        });// --end Ajax function
    }); // --end onclik function 
        
    
    function showGifEspera(){
        $('#espera').css('display','inline').css('z-index','100');
    }

    function hideGifEspera(){
        $('#espera').css('display','none').css('z-index','-100');
    }
});