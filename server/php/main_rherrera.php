<?php 
session_start();
header('Content-Type: text/html; charset=UTF-8');
$raiz="";
require_once('sesiones.php');
require_once('sesion_automatica.php'); // para cerrar la session si esta inactiva

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Turnos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8" />
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
							<li><a tabindex="-1" href="#programacion_turnos" class="text">Programaci&oacute;n Turnos</a></li>
							<li><a tabindex="-1" href="#supernume_tmp" class="text">Supernumerario Tmp</a></li>
							<li><a tabindex="-1" href="#supernume_reemp" class="text">Supernumerario</a></li>
                            <li><a tabindex="-1" href="#turnos_catalogo" class="text">Turnos</a></li>
                            <li><a tabindex="-1" href="#ciclos_catalogo" class="text">Ciclos</a></li>
							
                            <li class="dropdown-submenu">
								<a tabindex="-1" href="#" class="text">Novedades</a>								
								<ul class="dropdown-menu">
								  <li class="dropdown-submenu">
									<a tabindex="-1" href="#" class="text">Solicitudes</a>
										<ul class="dropdown-menu">
											<li><a tabindex="-1" href="#sol_intercambio_turnos" class="text">Intercambio Turnos</a></li>
											<li><a tabindex="-1" href="#sol_cambio_turno" class="text">Cambio de Turno</a></li>
											<li><a tabindex="-1" href="#sol_ausencia_turnos" class="text">Ausencias</a></li>	
										</ul>							  
								  </li>
								  <li class="dropdown-submenu">
									<a tabindex="-1" href="#" class="text">Bitacoras</a>
										<ul class="dropdown-menu">
											<li><a tabindex="-1" href="#bit_aprodesa_ausencias" class="text">Aprobar y desaprobar ausencias</a></li>
											<li><a tabindex="-1" href="#bit_aprodesa_turnos" class="text">Aprobar y desaprobar Turnos</a></li>
											<li><a tabindex="-1" href="#bit_mov_turnos" class="text">Movimientos de Turnos</a></li>
											<li><a tabindex="-1" href="#bit_mov_ausencias" class="text">Movimientos de Ausencias</a></li>
											<li><a tabindex="-1" href="#bit_reemplazos" class="text">Reemplazos</a></li>
											<li><a tabindex="-1" href="#bit_mov_vaca_li" class="text">Solicitudes vacaciones y licencia</a></li>
											<li><a tabindex="-1" href="#bit_soli_tur" class="text">Solicitud de turnos</a></li>
											
										</ul>								   
								  </li>
								 							  
								</ul></li>
							
                            <li><a tabindex="-1" href="#tiempo_extra" class="text">Tiempo Extra</a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" href="#nuevopass" class="text">Cambiar Contrase&ntilde;a</a></li>
                            <li><a tabindex="-1"  href="cerrar.php">Cerrar Sesi&oacute;n</a></li>
							
                        </ul>
                    </li>
                    
                </ul>
                <a class="brand" href="#"><span id="titulo" class="first">Programaci&oacute;n Turnos</span></a>
            </div>
        </div>
    </div>
    <div id="content">
	
	</div>
		
    <script src="../../js/jquery-1.10.1.min.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
    <script src="../../js/bootstrap.min.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
    <script src="../../js/funciones.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
	<script src="../../js/DataTables/media/js/jquery.dataTables.min.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>	
	<script src="../../js/dataTables.fnGetFilteredNodes.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>	
    
  </body>
</html>