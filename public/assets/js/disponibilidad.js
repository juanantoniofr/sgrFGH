$(function(e) {
    
    $('[data-toggle="tooltip"]').tooltip();
    $( "#datepickerIni" ).datepicker( $.datepicker.regional[ "es" ] );
	$( "#datepickerFin" ).datepicker( $.datepicker.regional[ "es" ] );
	$( '.titulo-acordeon').click(function(e){;
		e.preventDefault();
		e.stopPropagation();
		$( this ).next().toggle('slow');
		//$( 'div.fila-acordeon', this).toggle('slow');
	});
});