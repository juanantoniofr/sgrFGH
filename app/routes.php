<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('newUser',array('as'=>'newUser',function(){
  

    // salvamos los datos.....
        $user = new User;

        $user->nombre = 'Publicador'; 
        $user->apellidos = 'Unidad TIC, FGH';
        $user->colectivo = 'PAS';
       


        $user->username = 'publicador'; 
        $user->capacidad = 3;
        // La fecha se debe guardar en formato USA Y-m-d  
        $user->caducidad = '2020-01-01';
        
        $user->estado = 1; //Activamos al crear
        $user->email = 'juanafr@us.es';
        $user->password  = Hash::make('secreta');
        $user->save();
        echo 'message: Usuario creado con éxito';
        //return Redirect::to($url);
}));

Route::get('hola',array('as'=>'hola',function(){
	
	
	
	//$tipoActividad = ACL::getTipoActividadPorRol();
	
	

	echo "<pre>";
	var_dump(Titulacion::find('2')->toArray());
	echo "</pre>";
	
}));

//*********
// Titulaciones
//*********

Route::get('/admin/titulaciones.html',array('as' => 'titulaciones','uses' => 'TitulacionController@listar'));

Route::post('admin/salvaNuevaTitulacion',array('as' => 'salvaNuevaTitulacion','uses' => 'TitulacionController@nuevaTitulacion','before' => array(/*'auth',*/'ajax_check'/*,'capacidad:4-6,msg'*/)) );//Nueva Titulacion 

Route::get('admin/getTitulacion',array('as' => 'getTitulacion','uses' => 'TitulacionController@getTitulacion','before' => array(/*'auth',*/'ajax_check'/*,'capacidad:4-6,msg'*/)) );//Nueva Titulacion 




//*********
// Login
//*********

Route::get('/',array('as' => 'loginsso','uses' => 'AuthController@doLogin'));
Route::post('login', 'AuthController@postLogin'); // Verificar datos
Route::get('logout',array('as' => 'logout','uses' => 'AuthController@doLogout'));


//*********
// Admin (capacidad = 4)
//*********
Route::get('admin/home.html',array('as' => 'adminHome.html','uses' => 'UsersController@home','before' => array('auth','capacidad:4,msg')));

//*********
// Calendarios (Todas las capacidades)
//*********
Route::get('calendarios.html',array('as' => 'calendarios.html','uses' => 'CalendarController@showCalendarViewMonth','before' => array('auth','inicioCurso','capacidad:1-2-3-4-5-6,msg')));

Route::get('calendariosFGH.html',array('as' => 'calendariosFGH.html','uses' => 'CalendarControllerFGH@showCalendarViewMonth','before' => array('auth','inicioCurso','capacidad:1-2-3-4-5-6,msg')));

//*********
// Recursos (capacidad = 4)
//*********
Route::get('admin/listarecursos.html',array('as' => 'recursos','uses' => 'recursosController@listar','before' => array('auth','capacidad:4-6,msg')));

Route::get('admin/editarecurso.html',array('as' => 'editarecurso.html','uses' => 'recursosController@formEdit','before' => array('auth','capacidad:4-6,msg')));
Route::post('admin/updateRecurso.html',array('uses' => 'recursosController@editRecurso','before' => array('auth','ajax_check','capacidad:4-6,msg')));//Update propiedades recurso
Route::post('admin/salvarDesecripcion.html',array('as' => 'updateDescripcionGrupo','uses' => 'recursosController@updateDescripcionGrupo','before' => array('auth','ajax_check','capacidad:4-6,msg')));//Update propiedades grupo (nombre y descripción)
Route::get('admin/eliminarecurso.html',array('uses'=>'recursosController@eliminar','before' => array('auth','capacidad:4-6,msg')));
Route::get('admin/deshabilitarRecurso.html',array('uses'=>'recursosController@deshabilitar','before' => array('auth','capacidad:4-6,msg')));
Route::get('admin/habilitarRecurso.html',array('uses'=>'recursosController@habilitar','before' => array('auth','capacidad:4-6,msg')));

Route::get('admin/getrecurso',array('uses'=>'recursosController@getrecurso','before' => array('auth','capacidad:4-6,msg')));





//++++++
//++++++

Route::get('loginerror',array('as' => 'msg',function(){
	$msg = Session::get('msg');//Privilegios insuficientes';
	$title = Session::get('title');//Error de acceso';
	return View::make('loginerror')->with(compact('msg','title'));
}));

Route::get('msg',array('as' => 'msg',function(){
	$msg = Session::get('msg');//Privilegios insuficientes';
	$title = Session::get('title');//Error de acceso';
	return View::make('msg')->with(compact('msg','title'));
}));

Route::get('wellcome',array('as'=>'wellcome','uses' => 'HomeController@showWellcome'));

Route::get('ayuda.html',array('as'=>'ayuda','uses'=>'HomeController@ayuda'));

Route::get('contactar.html',array('as'=>'contactar','uses'=>'HomeController@contacto','before'=>'auth'));
Route::post('contactar.html',array('as'=>'enviaformulariocontacto','uses'=>'HomeController@sendmailcontact','before'=>'auth'));

Route::get('justificante', array('as' => 'justificante', function(){
	
	if (Evento::where('evento_id','=',Input::get('idEventos'))->count() == 0) return View::make('pdf.msg'); 

	$events = Evento::where('evento_id','=',Input::get('idEventos'))->first();
		

	//$recursos = DB::table('eventos')->select('recurso_id')->where('evento_id','=',Input::get('idEventos'))->get();
	$recurso_id = Evento::where('evento_id','=',Input::get('idEventos'))->first()->recurso_id;
	$recurso = Recurso::where('id','=',$recurso_id)->get();//find($recurso_id);
	
	
	$arrayRecurso = $recurso->toArray();
	
	
	if ($arrayRecurso[0]['tipo'] != 'espacio')
	{
		$recursos = Evento::where('evento_id','=',Input::get('idEventos'))->get();
	} 
	else {
		$recursos = $recurso;
	}


	setlocale(LC_TIME,'es_ES@euro','es_ES.UTF-8','esp');
	
   	$strDayWeek = Date::getStrDayWeek($events->fechaEvento);
	$strDayWeekInicio = Date::getStrDayWeek($events->fechaInicio);
	$strDayWeekFin = Date::getStrDayWeek($events->fechaFin);
	$created_at = ucfirst(strftime('%A %d de %B  a las %H:%M:%S',strtotime($events->created_at)));
   
    $html = View::make('pdf.justificante')->with(compact('events','strDayWeek','strDayWeekInicio','strDayWeekFin','recursos','created_at'));
   	$result = myPDF::getPDF($html,'comprobante');

   	return Response::make($result)->header('Content-Type', 'application/pdf');
	})
);


Route::get('test',array('as'=>'test'),function(){

	Recurso::all()->unique('grupo');

});

//Validador (roles 4 (admin) y 5 (validador))
//Route::get('validador/home.html',array('as' => 'validadorHome.html','uses' => 'ValidacionController@index','before' => array('auth','capacidad:4-5,msg')));

//Route::get('validador/valida.html',array('as' => 'valida.html','uses' => 'ValidacionController@valida','before' => array('auth','capacidad:4-5,msg')));


//routes administración delegada
Route::get('admin/administradores.html',array('as' => 'admins','uses' => 'recursosController@admins','before' => array('auth','capacidad:4,msg')));	
Route::get('admin/addAdmin.html',array('as' => 'addRecursoAdmin','uses' => 'recursosController@Addadmin','before' => array('auth','capacidad:4,msg')));	
Route::post('admin/addAdmin.html',array('as' => 'postaddRecursoAdmin','uses' => 'recursosController@addRecursoAdmin','before' => array('auth','capacidad:4,msg')));


//routes gestión de usuarios
Route::get('admin/users.html',array('as' => 'users','uses' => 'UsersController@listUsers','before' => array('auth','capacidad:4,msg')));

Route::get('admin/adduser.html',array('as' => 'adduser','uses' => 'UsersController@newUser','before' => array('auth','capacidad:4,msg')));
//Route::post('admin/user/new',array('as' => 'addUser','uses' => 'UsersController@create','before' => array('auth','capacidad:4,msg')));
Route::post('admin/salvarNuevoUsuario',array('as' => 'post_addUser','uses' => 'UsersController@create','before' => array('auth','ajax_check','capacidad:4,msg')));


//Route::get('admin/useredit.html',array('as' => 'useredit.html','uses' => 'UsersController@formEditUser','before' => array('auth','capacidad:4,msg')));
//Route::post('admin/useredit.html',array('as' => 'updateUser.html','uses' => 'UsersController@updateUser','before' => array('auth','capacidad:4,msg')));

Route::get('admin/eliminaUser.html',array('as' => 'eliminaUser.html','uses' => 'UsersController@delete','before' => array('auth','capacidad:4,msg')));
Route::get('admin/ajaxBorraUser',array('as' => 'ajaxBorraUser','uses' => 'UsersController@ajaxDelete','before' => array('auth','capacidad:4,msg','ajax_check')));

//routes POD
Route::get('admin/pod.html',array('as' => 'pod.html','uses' => 'PodController@index','before' => array('auth','capacidad:4,msg')));
Route::post('admin/pod.html',array('as' => 'uploadPOD','uses' => 'PodController@savePOD','before' => array('auth','capacidad:4,msg')));

//routes logs & config
/*
Route::get('admin/config.html',array('as' => 'config.html',function(){
			return View::make('admin.config')->nest('dropdown',Auth::user()->dropdownMenu());
			},
			'before' => array('auth','capacidad:4,msg')
		));
*/
/*
Route::get('admin/logs.html',array('as' => 'logs.html',function(){
			return View::make('admin.logs')->nest('dropdown',Auth::user()->dropdownMenu());
			},
			'before' => array('auth','capacidad:4,msg')
		));
*/
//EE de equipo (capacidad = 6) y administradores de la aplicación (capacidad = 4)
Route::get('admin/addrecurso.html',array('as' => 'addRecurso','uses' => 'recursosController@formAdd','before' => array('auth','capacidad:4-6,msg')));
Route::get('admin/salvarNuevoRecurso',array('as' => 'postAddRecurso','uses' => 'recursosController@addRecurso','before' => array('auth','ajax_check','capacidad:4-6,msg')));





//Técnico MAV atención de reservas (capacidad = 3)
//Route::get('tecnico/home.html',array('as' => 'tecnicoHome.html','uses' => 'UsersController@hometecnico','before' => array('auth','capacidad:3-4,msg')));
//Route::get('tecnico/espacios.html',array('as' => 'recursosAtendidos','uses' => 'recursosController@recursosAtendidos','before' => array('auth','capacidad:3-4,msg')));
//Route::get('tecnico/informes.html',array('as' => 'informes','uses' => 'InformesController@index','before' => array('auth','capacidad:3-4,msg')));

//Route::get('tecnico/search',array(	'uses' => 'CalendarController@search','before' => array('auth','capacidad:3-4,msg')));
//Route::get('tecnico/getDataEvent',array(	'uses' => 'CalendarController@getDataEvent','before' => array('auth','capacidad:3-4,msg')));
//Route::post('tecnico/saveAtencion',array(	'uses' => 'CalendarController@saveAtencion','before' => array('auth','capacidad:3-4,msg')));


//Ajax function
//Evento: cambio grupo de recursos
Route::get('ajaxGetRecursoByGroup',array('as' => 'getRecursoByAjax','uses' => 'CalendarController@getRecursosByAjax','before' => array('auth','ajax_check')));
//Evento: cambio recurso seleccionado
Route::get('ajaxCalendar',array('uses' => 'CalendarController@getTablebyajax','before' => array('auth','ajax_check')));
Route::get('enableInputRepeticion',array('uses' => 'CalendarController@enableInputRepeticion','before' => array('auth','ajax_check')));

//Route::get('validador/ajaxDataEvent',array('uses' => 'CalendarController@ajaxDataEvent','before' =>array('auth','ajax_check') ));
Route::post('saveajaxevent',array('uses' => 'CalendarController@eventsavebyajax','before' => array('auth','ajax_check')));		
Route::get('getajaxevent',array('uses' => 'CalendarController@getajaxeventbyId','before' => array('auth','ajax_check')));
Route::post('delajaxevent',array('uses' => 'CalendarController@delEventbyajax','before' => array('auth','ajax_check')));
Route::post('getajaxeventbyId',array('uses' => 'CalendarController@getajaxeventbyId','before' => array('auth','ajax_check')));
Route::post('editajaxevent',array('uses' => 'CalendarController@editEventbyajax','before' => array('auth','ajax_check')));
Route::post('admin/ajaxActiveUser',array('uses' => 'UsersController@activeUserbyajax','before' => array('auth','ajax_check')));
Route::post('admin/ajaxDesactiveUser',array('uses' => 'UsersController@desactiveUserbyajax','before' => array('auth','ajax_check')));
Route::post('admin/ajaxBorraUser',array('as' => 'ajaxBorraUser','uses' => 'UsersController@ajaxDelete','before' => array('auth','capacidad:4,msg','ajax_check')));

Route::get('getDescripcion',array('as' => 'getDescripcion','uses' => 'CalendarController@getDescripcion','before' => array('auth','ajax_check')));



Route::get('print',array('uses' => 'CalendarController@imprime'));




App::missing(function($exception)
{
    return View::make('404');
});


App::error(function(ModelNotFoundException $e)
  {
    $msg = 'Error base de datos: Objeto no encontrado.... ';
    $title = 'Error';
	return View::make('msg')->with(compact('msg','title'));
  
  });



Route::get('data',array('as'=>'ToValidate',function(){
	
	
	$limit = Input::get('limit','10');
	$offset = Input::get('offset','0');
	$sort = Input::get('sort','asc');	
	$order = Input::get('order','asc');
	$search = Input::get('search','');
	
	if($search == "") {
		$events = Evento::Where('estado','=','pendiente')->get()->toArray();
	} else {
		$events = Evento::Where('estado','=','pendiente')->Where('titulo','like','%'.$search.'%')->get()->toArray();
	}
	
	$count = count($events);

	if($order != "asc") {
		$events = array_reverse($events);
	}
		
	$events = array_slice($events, $offset, $limit);
	
	$jsonString =  "{";
	$jsonString .= '"total": ' . $count . ',';
	$jsonString .= '"rows": ';
	$jsonString .=	json_encode($events);
	$jsonString .= "}"; 
	
	return $jsonString;

}));