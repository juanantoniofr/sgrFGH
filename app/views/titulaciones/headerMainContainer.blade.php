<div class="col-lg-12">
        <h3 class=""><i class="fa fa-institution fa-fw"></i> Gestión de titulaciones</h3>
        
        <form class="navbar-form navbar-left">
            <div class="form-group ">
                <a href="" class="active btn btn-danger" id="botonMuestraModalNuevaTitulacion" title="Añadir nueva titulacion"><i class="fa fa-plus fa-fw"></i> Añadir titulación</a>
            </div>
            <div class="form-group ">
                <a href="{{route('recursos')}}" class="btn btn-primary" title="Listar Espacios o Medios"><i class="fa fa-list fa-fw"></i> Listar todos</a>
            </div>                            
                
        </form>
        
        <form class="navbar-form navbar-right" role="search">
            
            <div class="form-group ">
                <input type="text" class="form-control" id="search" placeholder="Busqueda por nombre...." name="search" >
                <button type="submit" class="btn btn-primary form-control"><i class="fa fa-search fa-fw"></i> Buscar</button> 
            </div>                            
                
        </form>
</div>