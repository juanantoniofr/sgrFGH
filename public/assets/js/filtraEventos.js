$(function(e){

    var $data = { 

            titulaciones: [],
            asignaturas: [],
            profesores: [],

            init: function(){
        
                if ($('div#opciones-filtrado select#titulacion').val() != null) this.titulaciones = $('div#opciones-filtrado select#titulacion').val();
                if ($('div#opciones-filtrado select#asignatura').val() != null) this.asignaturas = $('div#opciones-filtrado select#asignatura').val();
                if ($('div#opciones-filtrado select#profesor').val() != null) this.profesores = $('div#opciones-filtrado select#profesor').val();

            },

            setTitulacion: function($aTitulaciones){
                
                this.titulaciones = $aTitulaciones;
                return true;
            },

            setAsignatura: function($aAsignaturas){

                this.asignaturas = $aAsignaturas;
                return true;
            },

            setProfesor: function($aProfesores){

                this.profesores = $aProfesores;
                return true;
            },

            getTitulaciones(){
                
                return  this.titulaciones;
            },

            getAsignaturas(){

                return this.asignaturas;
            },

            getProfesores(){

                return this.profesores;
            },

    };

    
    $( document ).ready(function() {
        $data.init();
        //hideGifEspera();
    });

   
    //Update $data && Obtiene asignaturas//profesores de las titulaciones seleccionadas
    $("div#opciones-filtrado select#titulacion").on('click',function(e){
        
        e.preventDefault();
        e.stopPropagation();
        
        //Set titulacion/es seleccionada/s
        $data.setTitulacion( $('div#opciones-filtrado select#titulacion' ).val() );

        //Set select asignaturas a 'all'
        $('div#opciones-filtrado select#asignatura ').empty();
        $('div#opciones-filtrado select#asignatura ').append('<option value="all" selected>Todas</option>');
        // And update $data
        $data.setAsignatura( $('div#opciones-filtrado select#asignatura' ).val() );

        //Obtener asignaturas
        showGifEspera();
        getAsignaturas();
        getProfesores();
        getEventos();
    }); // --end onclik function 
        
    //Update $data && Obtiene profesores y eventos de las asignautras seleccionadas
    $("div#opciones-filtrado select#asignatura").on('click',function(e){

        e.preventDefault();
        e.stopPropagation();

        //Set asignaturas seleccionadas
        $data.setAsignatura( $('div#opciones-filtrado select#asignatura' ).val() );
    
       //obtener profesores
        showGifEspera();    
        getProfesores();
        getEventos();
    });

    //Update $data && Obtiene eventos de los profesores seleccionados
    $("div#opciones-filtrado select#profesor").on('click',function(e){

        e.preventDefault();
        e.stopPropagation();

        //Set asignaturas seleccionadas
        $data.setProfesor( $('div#opciones-filtrado select#profesor' ).val() );
    
       //obtener profesores
        showGifEspera();    
        getEventos();
    });

    function getAsignaturas(){
        $.ajax({
            type: "GET",
            url: "getAsignaturas", 
            data: {aCodigos:$data.getTitulaciones()},
            success: function($respuesta){
                
                $respuesta.forEach(function(titulo,index){
                
                    titulo.asignatura.forEach(function(item,index){
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
    }
    
    function getProfesores(){
        $.ajax({
            type: "GET",
            url: "getProfesores",
            data: {aCodigosTitulaciones:$data.getTitulaciones(),aCodigosAsignaturas:$data.getAsignaturas()},
            success: function($respuesta){
                //console.log($respuesta);
                $('div#opciones-filtrado select#profesor').empty();
                $('div#opciones-filtrado select#profesor').append('<option value="all" selected>Todos/as</option>');
                $respuesta.forEach(function(item,index){
                    //console.log(item);
                    //console.log(index);
                    item.profesores.forEach(function(item,index){
                        //console.log(item);
                        //console.log(index);

                            item.forEach(function(profesor,index){
                                //console.log(profesor);
                                //console.log(index);
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
    }

    function getEventos(){
        console.log($data.getProfesores());
        $.ajax({
            type: "GET",
            url: "getEventosByFiltros", /* terminar en controllador */
            data: {aCodigosTitulaciones:$data.getTitulaciones(),aCodigosAsignaturas:$data.getAsignaturas(),aIdProfesores:$data.getProfesores()},
            success: function($respuesta){
                
                //console.log($respuesta);
                $('#resultados-filtros').fadeOut(400,'linear').html($respuesta).fadeIn(400,'linear',function(){hideGifEspera();});
            },
            error: function(xhr, ajaxOptions, thrownError){
                    hideGifEspera();
                    alert(xhr.responseText + ' (codeError: ' + xhr.status) +')';
            }
        });
    }

    // click filtrar eventos
    $('#botonFiltrarEventos').on('click',function(e){
        e.preventDefault();
        e.stopPropagation();
        showGifEspera();
        console.log('Código Asignaturas ' + $data.getAsignaturas().toString());
        $.ajax({
            type: "GET",
            url: "getEventosByFiltros", /* terminar en controllador */
            data: {aCodigosTitulaciones:$data.getTitulaciones(),aCodigosAsignaturas:$data.getAsignaturas()},
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