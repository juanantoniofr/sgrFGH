$(function(e){

    var $data = { 

            titulaciones: [],

            init: function(){
        
                this.titulaciones = $('div#opciones-filtrado select#titulacion').val();
            },

            setTitulacion: function($aTitulaciones){
                
                this.titulaciones = $aTitulaciones;
                return true;
            },

            getTitulaciones(){
                
                return  this.titulaciones;
            } 

    };

    
    $( document ).ready(function() {
        //console.log( "ready!" );
        //console.log($('div#opciones-filtrado select#titulacion').val());
        $data.init();
    });

    //Obtiene asignaturas de titulación seleccionada
    $("div#opciones-filtrado select#titulacion").on('click',function(e){
        
        e.preventDefault();
        e.stopPropagation();
        
        //Set titulacion/es seleccionada/s
        $data.setTitulacion( $('div#opciones-filtrado select#titulacion').val() );

        //Obtener asignaturas
        showGifEspera();
        console.log('Código titulaciones ' + $data.getTitulaciones().toString());   
        $.ajax({
            type: "GET",
            url: "getAsignaturas", /* terminar en controllador */
            data: {aCodigos:$data.getTitulaciones()},
            success: function($respuesta){
                
                //console.log($respuesta);
                //hideGifEspera();
                $('div#opciones-filtrado select#asignatura ').empty();
                $('div#opciones-filtrado select#asignatura ').append('<option value="all" selected>Todas</option>');
                $respuesta.forEach(function(titulo,index){
                
                    //console.log(titulo);
                    titulo.asignatura.forEach(function(item,index){
                        console.log(item);
                        $('div#opciones-filtrado select#asignatura ').append('<option value = "'+ item.codigo+'"> ' + titulo.titulacion.codigo + '-' +item.asignatura + '</option>'); 
                    });
                });
                $('#select-asignaturas').fadeOut(400,'linear').fadeIn(400,'linear',function(){hideGifEspera();});

            },
            error: function(xhr, ajaxOptions, thrownError){
                    hideGifEspera();
                    alert(xhr.responseText + ' (codeError: ' + xhr.status) +')';
            }
        });// --end Ajax function
    }); // --end onclik function 
        
    // click filtrar eventos
    $('#botonFiltrarEventos').on('click',function(e){
        e.preventDefault();
        e.stopPropagation();
        showGifEspera();
        console.log('Código titulaciones ' + $data.getTitulaciones().toString());
        $.ajax({
            type: "GET",
            url: "getEventosByFiltros", /* terminar en controllador */
            data: {aCodigosTitulaciones:$data.getTitulaciones()},
            success: function($respuesta){
                
                console.log($respuesta);
                $('#resultados-filtros').fadeOut(400,'linear').html($respuesta).fadeIn(400,'linear',function(){hideGifEspera();});
            },
            error: function(xhr, ajaxOptions, thrownError){
                    hideGifEspera();
                    alert(xhr.responseText + ' (codeError: ' + xhr.status) +')';
            }
        });

    }); 

    function showGifEspera(){
        $('#espera').css('display','inline').css('z-index','100');
    }

    function hideGifEspera(){
        $('#espera').css('display','none').css('z-index','-100');
    }
});