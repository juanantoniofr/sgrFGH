$(function(e) {
    
    $('[data-toggle="tooltip"]').tooltip();
    $( "#datepickerIni" ).datepicker( $.datepicker.regional[ "es" ] );
	$( "#datepickerFin" ).datepicker( $.datepicker.regional[ "es" ] );
	$( '.titulo-acordeon').click(function(){
		$( 'div.fila-acordeon', this).toggle('slow');
	});
});