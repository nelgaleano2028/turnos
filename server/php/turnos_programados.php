<?php
	session_start();
	
	
  	require_once("class_turnoshe.php");
					
	$obj=new Turnoshe();	
	
	$lista=$obj->usuarios_jefes();
	//$lista1=$obj->anio_programaciones_anteriores();	
	
	//$server=$_SERVER['PHP_SELF'];
  ?>
  
<link rel="stylesheet" href="../../css/programacion.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/tablascroll_programacion.css?css=<?php echo rand(1, 100);?>" /> 
<link rel="stylesheet" href="../../css/scroll.css?css=<?php echo rand(1, 100);?>" /> 
<link rel="stylesheet" href="../../css/chosen.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/popover.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/jquery.contextMenu.css?css=<?php echo rand(1, 100);?>" />
<style type="text/css" title="currentStyle">
	@import "../../js/DataTables/media/css/jquery.dataTables_themeroller.css";			
</style>

  <script src="../../js/alert.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/turnoshe.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/jquery.popover-1.1.2.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/chosen.jquery.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/tiny_mce/tiny_mce.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  
  <script type="text/javascript" language="javascript" src="../../js/DataTables/media/js/jquery.dataTables.js"></script>
  
  <script src="../../js/jquery.contextMenu.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  
<div id="body">
	<div id="wrapper">
		<div id="header">
			<form class="form-inline">
			
			  <select class="usario_jefe">
					 <option value="-1">Seleccione Usuario Jefe...</option>
			  
				  <?php 
					for($i=0; $i<count($lista);$i++){
					
						echo "<option value='".@$lista[$i]['cod_epl']."' id='".@$lista[$i]['cod_epl']."'>".@$lista[$i]['usuario']."</option>";		
				
					} 
				   ?>
			  </select>
			  
			  <div id="combo2" style="display:inline">
					<!-- aqui se cargará el select -->
			  </div>
			  
			  <div id="combo3" style="display:inline">
					<!-- aqui se cargará el select -->
			  </div>
			 
			   <div id="meses" style="display:inline">
			  
			   </div>
			  
			   <div id="anios" style="display:inline">
				 
			   </div>
			 
			  <input type="button"  id="correo_programados" name="singlebutton" class="btn btn-primary" value="Correo">
			  <div class="btn-group">
				  <a class="btn btn-primary" href="#"> Imprimir</a>
				  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="javascript:void(0);" id="imprimir_excel">EXCEL</a></li>
					<li><a href="javascript:void(0);" id="imprimir_pdf">PDF</li>
				  </ul>
				
			  </div>				  
			  
			</form>
			
		</div><br>
		<div id="contenedor_tablas">
		<div id="contenido">
		 <!--Aca esta la tabla de programacion de turnos-->
		</div>
		
		<div id="contenido2">
		
		</div>
		</div>
	</div>
</div>

<div id="oculto" style="display:none;"></div>