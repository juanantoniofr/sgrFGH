<li class="dropdown ">
  <a href="{{Auth::user()->getHome()}}" title="Menú" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-list fa-fw"></i> Menú  <span class="caret "></span></a>
  
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    
    <li ><a  href="{{route('adminHome.html')}}" title="Escritorio"><i class="fa fa-dashboard fa-fw"></i> Escritorio</a></li>

    <li><a href="{{route('calendarios.html')}}"><i class="fa fa-calendar fa-fw"></i> Calendarios</a></li>
    
    <li><a href="{{route('pod.html')}}"><i class="fa fa-upload fa-fw"></i>P.O.D</a></li>
    
    <li><a  href="{{route('recursos')}}"><i class="fa fa-institution fa-fw"></i> Espacios y equipos<span class="fa arrow"></span></a></li>

    <li><a href="{{route('informes-de-ocupacion.html')}}"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Imprimir Horarios e Informes</a></li>  
    
    <li><a href="{{route('disponibilidad.html')}}"><i class="fa fa-search fa-fw"></i> Disponibilidad</a></li>  

    <li><a href="{{route('titulaciones.html')}}"><i class="fa fa-graduation-cap fa-fw"></i> Titulaciones</a></li>  

  </ul>
            
</li>