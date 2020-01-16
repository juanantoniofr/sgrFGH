$(function(e){

    var $data = { 

            titulaciones: [],
            asignaturas: [],
            profesores: [],
            f_inicio: '',
            f_fin: '',
            dias: [],
            h_inicio: '8:30',
            h_fin: '9:30,',
            aforomax: '',
            aforoexam:'',
            medios: [],

            init: function(){

                $("div#opciones-filtrado #newReservaHfin option:last").prop("selected", "selected");
                $("div#opciones-filtrado select#newReservaHinicio option:first").prop("selected", "selected");
        
                if ($('div#opciones-filtrado select#titulacion').val() != null) this.titulaciones = $('div#opciones-filtrado select#titulacion').val();
                if ($('div#opciones-filtrado select#asignatura').val() != null) this.asignaturas = $('div#opciones-filtrado select#asignatura').val();
                if ($('div#opciones-filtrado select#profesor').val() != null) this.profesores = $('div#opciones-filtrado select#profesor').val();
                if ($('div#opciones-filtrado input#datepickerIni').val() != null) this.f_inicio = $('div#opciones-filtrado input#datepickerIni').val();
                if ($('div#opciones-filtrado input#datepickerFin').val() != null) this.f_fin = $('div#opciones-filtrado input#datepickerFin').val();
                $("div#opciones-filtrado input[name='dias']:checked").each(function() { 
                    $data.dias.push( parseInt ($(this).val()) ); 
                }); 
                if ( $("div#opciones-filtrado select[name='h_inicio']").val() != null) this.h_inicio = $("div#opciones-filtrado select[name='h_inicio']").val();
                if ( $("div#opciones-filtrado select[name='h_fin']").val() != null) this.h_fin = $("div#opciones-filtrado select[name='h_fin']").val();
                if ( $("div#opciones-filtrado input[name='aforomax']").val() != null) this.aforomax = $("div#opciones-filtrado input[name='aforomax']").val();
                if ( $("div#opciones-filtrado input[name='aforoexam']").val() != null) this.aforoexam = $("div#opciones-filtrado input[name='aforoexam']").val();
                $("div#opciones-filtrado input[name='mediosdisponibles']:checked").each(function() { 
                    $data.medios.push( $(this).val() ); 
                });


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

            setF_inicio: function($f_inicio){

                this.f_inicio = $f_inicio;
                return true;
            },

            setF_fin: function($f_fin){

                this.f_fin = $f_fin;
                return true;
            },

            setDias: function($aDias){

                this.dias = $aDias;
                return true;
            },

            setH_inicio: function($h_inicio){

                this.h_inicio = $h_inicio;
                return true;
            },

            setH_fin: function($h_fin){

                this.h_fin = $h_fin;
                return true;
            },

            setAforomax: function($aforomax){

                this.aforomax = $aforomax;
                return true;
            },

            setAforoexam: function($aforoexam){

                this.aforoexam = $aforoexam;
                return true;
            },

            setMedios: function($aMedios){

                this.medios = $aMedios;
                return true;
            },

            getTitulaciones: function(){
                
                return  this.titulaciones;
            },

            getAsignaturas: function(){

                return this.asignaturas;
            },

            getProfesores: function(){

                return this.profesores;
            },

            getF_inicio: function(){

                return this.f_inicio;
            },

            getF_fin: function(){

                return this.f_fin;
            },

            getDias: function(){

                return this.dias;
            },

            getH_inicio: function(){

                return this.h_inicio;
            },

            getH_fin: function(){

                return this.h_fin;
            },

            getAforomax: function(){

                return this.aforomax;
            },

            getAforoexam: function(){

                return this.aforoexam;
            },

            getMedios: function(){

                return this.medios;
            },
    };

    
    $( document ).ready(function() {
        $data.init();
        //console.log($data.getF_inicio() + ' -- ' + $data.getF_fin());
        //hideGifEspera();
    });

   
    //Actualizar $data && Obtener asignaturas//profesores y eventos de las titulaciones seleccionadas
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
        $data.setProfesor( $('div#opciones-filtrado select#profesor' ).val() );


        //Obtener asignaturas
        showGifEspera();
        getAsignaturas();
        getProfesores();
        getEventos();
    }); // --end onclik function 
        
    //Actualizar $data && Obtener profesores y eventos de las asignautras seleccionadas
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

    //Actualizar $data && Obtener eventos de los profesores seleccionados
    $("div#opciones-filtrado select#profesor").on('click',function(e){

        e.preventDefault();
        e.stopPropagation();

        //Set asignaturas seleccionadas
        $data.setProfesor( $('div#opciones-filtrado select#profesor' ).val() );
    
       //obtener eventos
        showGifEspera();    
        getEventos();
    });

    $("div#opciones-filtrado input#datepickerIni").on('change',function(e){
        
        e.preventDefault();
        e.stopPropagation();

        $data.setF_inicio($(this).val());
        console.log($data.getF_inicio());

        //obtener eventos
        showGifEspera();    
        getEventos();
    });

    $("div#opciones-filtrado input#datepickerFin").on('change',function(e){
        
        e.preventDefault();
        e.stopPropagation();

        $data.setF_fin($(this).val());
        
        //obtener eventos
        showGifEspera();    
        getEventos();
    });

    $("div#opciones-filtrado input[name='dias']").on('change',function(e){
        
        //e.preventDefault();
        e.stopPropagation();

        var $aDias = []; 
        $("div#opciones-filtrado input[name='dias']:checked").each(function() { 
                $aDias.push( parseInt($(this).val()) ); 
            }); 
        $data.setDias($aDias);
        
        //obtener eventos
        showGifEspera();    
        getEventos();
    });


    $("div#opciones-filtrado select[name='h_inicio']").on('change',function(e){
        
        e.preventDefault();
        e.stopPropagation();

        $data.setH_inicio($(this).val());
        
        //obtener eventos
        showGifEspera();    
        getEventos();
    });

    $("div#opciones-filtrado select[name='h_fin']").on('change',function(e){
        
        e.preventDefault();
        e.stopPropagation();

        $data.setH_fin($(this).val());
        
        //obtener eventos
        showGifEspera();    
        getEventos();
    });

    $("div#opciones-filtrado input[name='aforomax']").on('change',function(e){
        
        e.preventDefault();
        e.stopPropagation();

        //alert($(this).val());
        $data.setAforomax($(this).val());
        
        //obtener eventos
        showGifEspera();    
        getEventos();
    });

    $("div#opciones-filtrado input[name='aforoexam']").on('change',function(e){
        
        e.preventDefault();
        e.stopPropagation();

        //alert($(this).val());
        $data.setAforoexam($(this).val());
        
        //obtener eventos
        showGifEspera();    
        getEventos();
    });

    $("div#opciones-filtrado input[name='mediosdisponibles']").on('change',function(e){
        
        //e.preventDefault();
        e.stopPropagation();

        var $aMedios = []; 
        $("div#opciones-filtrado input[name='mediosdisponibles']:checked").each(function() { 
                $aMedios.push( $(this).val() ); 
            }); 
        $data.setMedios($aMedios);
        
        //obtener eventos
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
        console.log($data.getDias());
        $.ajax({
            type: "GET",
            url: "getEventosByFiltros", /* terminar en controllador */
            data: {aCodigosTitulaciones:$data.getTitulaciones(),aCodigosAsignaturas:$data.getAsignaturas(),aIdProfesores:$data.getProfesores(),f_inicio:$data.getF_inicio(),f_fin:$data.getF_fin(),aDias:$data.getDias(),h_inicio:$data.getH_inicio(),h_fin:$data.getH_fin(),aforomax:$data.getAforomax(),aforoexam:$data.getAforoexam(),medios:$data.getMedios()},
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

    /*
    function showGifEspera(){
        $('#espera').css('display','inline').css('z-index','100');
    }

    function hideGifEspera(){
        $('#espera').css('display','none').css('z-index','-100');
    }
    */
});