$(function(e){

    var $data = { 

            titulaciones: [],
            asignaturas: [],

            init: function(){
        
                this.titulaciones = $('div#opciones-filtrado select#titulacion').val();
                this.asignaturas = $('div#opciones-filtrado select#asignatura').val();
            },

            setTitulacion: function($aTitulaciones){
                
                this.titulaciones = $aTitulaciones;
                return true;
            },

            setAsignatura: function($aAsignaturas){

                this.asignaturas = $aAsignaturas;
                return true;
            },

            getTitulaciones(){
                
                return  this.titulaciones;
            },

            getAsignaturas(){

                return this.asignaturas;
            },

    };

    
    $( document ).ready(function() {
        $data.init();
    });

   
    //Update $data && Obtiene asignaturas de titulaciones seleccionadas
    $("div#opciones-filtrado select#titulacion").on('click',function(e){
        
        e.preventDefault();
        e.stopPropagation();
        
        //Set titulacion/es seleccionada/s
        $data.setTitulacion( $('div#opciones-filtrado select#titulacion' ).val() );

        //Obtener asignaturas
        showGifEspera();
        //console.log('Código titulaciones ' + $data.getTitulaciones().toString());   
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
                        //console.log(item);
                        $('div#opciones-filtrado select#asignatura ').append('<option value = "'+ item.codigo+'"> ' + titulo.titulacion.codigo + '-' +item.asignatura + '</option>'); 
                    });
                });
                $('div#select-asignaturas').fadeOut(400,'linear').fadeIn(400,'linear',function(){hideGifEspera();});

            },
            error: function(xhr, ajaxOptions, thrownError){
                    hideGifEspera();
                    alert(xhr.responseText + ' (codeError: ' + xhr.status) +')';
            }
        });// --end Ajax function
    }); // --end onclik function 
        
    //Update $data && Obtiene profesores de las asignautras seleccionadas
    $("div#opciones-filtrado select#asignatura").on('click',function(e){

        e.preventDefault();
        e.stopPropagation();

        //Set asignaturas seleccionadas
        $data.setAsignatura( $('div#opciones-filtrado select#asignatura' ).val() );

        //obtener profesores
        showGifEspera();
        $.ajax({
            type: "GET",
            url: "getProfesores",
            data: {aCodigos: $data.getAsignaturas()},
            success: function($respuesta){
                console.log($respuesta);
                $('div#opciones-filtrado select#profesor').empty();
                $('div#opciones-filtrado select#profesor').append('<option value="all" selected>Todos/as</option>');
                $respuesta.forEach(function(item,index){
                    console.log(item);
                    console.log(index);
                    item.profesores.forEach(function(item,index){
                        console.log(item);
                        console.log(index);

                            item.forEach(function(profesor,index){
                                console.log(profesor);
                                console.log(index);
                                $('div#opciones-filtrado select#profesor').append('<option value = "'+ profesor.id+'"> ' + profesor.profesor + '</option>');        
                            });
                         
                    });
                });
                $('div#select-profesores').fadeOut(400,'linear').fadeIn(400,'linear',function(){hideGifEspera();});

            },
            error: function(xhr, ajaxOptions, thrownError){
                    hideGifEspera();
                    alert(xhr.responseText + ' (codeError: ' + xhr.status) +')';
            }
        });
    });


    // click filtrar eventos
    $('#botonFiltrarEventos').on('click',function(e){
        e.preventDefault();
        e.stopPropagation();
        showGifEspera();
        //console.log('Código titulaciones ' + $data.getTitulaciones().toString());
        $.ajax({
            type: "GET",
            url: "getEventosByFiltros", /* terminar en controllador */
            data: {aCodigosTitulaciones:$data.getTitulaciones()},
            success: function($respuesta){
                
                //console.log($respuesta);
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