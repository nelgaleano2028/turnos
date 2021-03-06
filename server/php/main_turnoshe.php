<?php 
session_start();
$raiz="";
require_once('sesiones.php');
require_once('sesion_automatica.php'); // para cerrar la session si esta inactiva
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Turnos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css?css=<?php echo rand(1, 100);?>" />
    <link rel="stylesheet" href="../../css/style.css?css=<?php echo rand(1, 100);?>"  />
    <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.css?css=<?php echo rand(1, 100);?>" />
  </head>
  <body id="main">
      
      <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <ul class="nav pull-right">
                    
                    <li class="dropdown">
                        <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i> <?php echo $_SESSION['nom'] ?>
                            <i class="icon-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
							 <li><a tabindex="-1" href="#marcaciones_marcadas" class="text">Marcaciones Cargadas</a></li>
							 <li><a tabindex="-1" href="#turnos_programados" class="text">Turnos Programados</a></li>
							 
							 <li class="dropdown-submenu">
								<a tabindex="-1" href="#" class="text">Tiempo Extra Aprobado</a>
								<ul class="dropdown-menu">
									<li><a tabindex="-1" href="#consultar_aprobacion" class="text">Aprobacion</a></li>
									<li><a tabindex="-1" href="#consultar_novedades" class="text">Novedades</a></li>											
								</ul>
							 
							 </li>
							 
							 
							 <li><a tabindex="-1" href="#consultar_turnos" class="text">Consultar Turnos</a></li>   
							 <li><a tabindex="-1" href="#consultar_ciclos" class="text">Consultar Ciclos</a></li>   							                         
                             <li class="divider"></li>
                             <li><a tabindex="-1" href="#nuevopass" class="text">Cambiar Contrase&ntilde;a</a></li>
                             <li><a tabindex="-1"  href="cerrar.php">Cerrar Sesi&oacute;n</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <a class="brand" href="#"><span id="titulo" class="first">Marcaciones Cargadas</span></a>
            </div>
        </div>
    </div>
    <div id="content"></div>
    
    <script src="../../js/jquery-1.10.1.min.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
    <script src="../../js/bootstrap.min.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
	  <script src="../../js/funciones.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
      
    
  </body>
</html>