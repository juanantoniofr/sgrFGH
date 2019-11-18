$(function(e){

	$('#btnprint').on('click',function(e){
		e.preventDefault();
		setUrl();
		$('#printModal').modal('show');
	});


	$('#checktitulo').on('change',function(){
		setUrl();
	});
	
	$('#checknombre').on('change',function(){
		setUrl();
	});

	$('#checkcolectivo').on('change',function(){
		setUrl();
	});

	$('#checktotal').on('change',function(){
		setUrl();
	});

	$('#printTipoActividad').on('change',function(){
		setUrl();
	});

	//$('#printTipoActividad').change(function(){
	//	setUrl();
	//}).change();

	



	function setUrl(){
		$view = $('#btnView .active').data('calendarView');
		//$view = $('#btnprint').data('view');
		$day = $('#btnprint').data('day');
		$month = $('#btnprint').data('month');
		$year = $('#btnprint').data('year');
		$idRecurso = $('select#recurse option:selected').val();
		$groupID = $('select#selectGroupRecurse option:selected').val();

		$title = $('#checktitulo').prop('checked');
		$nombre = $('#checknombre').prop('checked');
		$colectivo = $('#checkcolectivo').prop('checked');
		$total = $('#checktotal').prop('checked');
		$activiad = $('select#tipoActividad option:selected').val();

		var $tipoActividad = '';
		$('#printTipoActividad option:selected').each(function(){
			$tipoActividad += $( this ).val()+',';
		});
		console.log($tipoActividad);
		$url = 'print?view='+$view+'&day='+$day+'&month='+$month+'&year='+$year+'&idRecurso='+$idRecurso+'&groupID='+$groupID+'&titulo='+$title+'&nombre='+$nombre+'&colectivo='+$colectivo+'&total='+$total+'&tipoActividad='+$tipoActividad;
		$('a#modalImprimir').attr('href', $url);
	}

});