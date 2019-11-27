<div>
	Suponemos que queremos reservar un espacio los lunes y martes, de 12:30 A 14:30, todo el mes de enero, con aforo para 40 personas, PC, micrófono y videoconferencia IP</p>
	<p>Tendrías dos bloques. (Me invento las respuesta). </p>
</div>
<div class="table-responsive">
   
   <table class="table table-striped">
   
   	<caption>Disponible</caption>
      <thead><th style="width:40%">Espacio</th><th style="width:30%">Medios</th><th style="width:30%">Esta columna no estaría</th></thead>
   
      <tbody class="text-success">
   	   <tr >
            <td> Aula Docencia 2.3 <br />
              <button class="btn btn-danger" id="btnNuevaReserva" data-fristday=""
              data-toggle="tooltip" data-html="true" 
                          title="
                            <hr />
                            <div>Desde aquí reervamos directamente</div>
                              <hr />
                              " >
                <small><i class="fa fa-external-link" aria-hidden="true"></i> Reservar</small>
            </td>
            <td>
            	<ul style="list-style:none; list-style-position: inside ;padding-left: 0px">
            		<li><i class="fa fa-check fa-fw"></i>Aforo 150</li>
            		<li><i class="fa fa-check fa-fw"></i>PC</li>
            		<li><i class="fa fa-check fa-fw"></i>Micrófono</li>
            		<li><i class="fa fa-check fa-fw"></i>Videoconferencia IP</li>
            	</ul>
            </td>
            <td> Este valdría: El espacio está libre y coincide con los Medios necesitados</td>
         </tr>   
         <tr>
            <td> Aula Docencia 3.4 <br />
              <button class="btn btn-danger" id="btnNuevaReserva" data-fristday="{{}}"
              data-toggle="tooltip" data-html="true" 
                          title="
                            <hr />
                            <div>Desde aquí reervamos directamente</div>
                              <hr />
                              " >
                <small><i class="fa fa-external-link" aria-hidden="true"></i> Reservar</small>
          
          </button>
            </td>
            <td>
            	<ul style="list-style:none; list-style-position: inside ;padding-left: 0px">
            		<li><i class="fa fa-check fa-fw"></i>Aforo 100</li>
            		<li><i class="fa fa-check fa-fw"></i>PC</li>
            		<li><i class="fa fa-check fa-fw"></i>Micrófono</li>
            		<li><i class="fa fa-check fa-fw"></i>Videoconferencia IP</li>
            	</ul>
            </td>
            <td> Este también valdria (puede haber más de uno)</td>
         </tr>
      </tbody>
   </table>
</div>

<hr />

<div class="table-responsive">
   
   <table class="table table-striped">
   
   	<caption>Alternativas</caption>
      <thead><th style="width:40%">Espacio</th><th style="width:30%">Medios</th><th style="width:30%">Esta columna no estaría</th></thead>
   
   
      <tbody class="text-warning">
   	      <tr>
            <td> <i class="fa fa-exclamation-triangle"></i> Aula Docencia 2.8 
            	<ol style=" list-style-position: inside ; padding: 10px auto; margin-top: 5px">
            		<li class="text-warning"> Coindicen con <a href="#" data-toggle="tooltip" data-html="true" 
                       		title="
                       			<hr />
                       			<div>Haciendo click aquí podemos modificar|eliminar esta reserva</div>
                            	<hr />
                            	" > <i>"Título actividad X"</i></a> el lunes 20 de enero, de 12:30 a 13:30</li>
            		<li class="text-warning"> Coincide con <a href="#" data-toggle="tooltip" data-html="true" 
                       		title="
                       			<hr />
                       			<div>Haciendo click aquí podemos modificar|eliminar esta reserva</div>
                            	<hr />
                            	" > <i>"Título actividad Y"</i></a> todos los martes desde el 15 al 30 de Enero, de 12:30 a 14:30.</li>
            	</ol>
            </td>
            <td>
            	<ul style="list-style:none; list-style-position: inside ;padding-left: 0px">
            		<li class="text-success"><i class="fa fa-check fa-fw"></i>Aforo 350</li>
            		<li class="text-success"><i class="fa fa-check fa-fw"></i>PC</li>
            		<li class="text-success"><i class="fa fa-check fa-fw"></i>Micrófono</li>
            		<li class="text-success"><i class="fa fa-check fa-fw"></i>Videoconferencia IP</li>
            	</ul>	
            </td>
            <td> Esta NO valdría: solapa parcialmente con otra/s actividades, aunque cuenta con el equipamiento</td>
         </tr>   
         <tr>
            <td class="text-success"> <i class="fa fa-check fa-fw"></i>   Aula Docencia 3.1 <br />
              <button class="btn btn-danger" id="btnNuevaReserva" data-fristday=""
              data-toggle="tooltip" data-html="true" 
                          title="
                            <hr />
                            <div>Desde aquí reervamos directamente</div>
                              <hr />
                              " >
                <small><i class="fa fa-external-link" aria-hidden="true"></i> Reservar</small>
            </td>
            <td>
            	<ul style="list-style:none; list-style-position: inside ;padding-left: 0px">
            		<li class="text-success"><i class="fa fa-check fa-fw"></i>Aforo 150</li>
            		<li class="text-warning"><i class="fa fa-exclamation-triangle"></i>PC</li>
            		<li class="text-success"><i class="fa fa-check fa-fw"></i>Micrófono</li>
                <li class="text-warning"><i class="fa fa-exclamation-triangle"></i>Videoconferencia IP</li>
            	</ul>
            </td>
            <td> Este NO valdría: El espacio está libre, pero le faltan Medios (Podemos llevar un portatil y valdría)</td>
         </tr>
      </tbody>
   </table>
</div>