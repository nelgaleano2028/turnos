<?php
	session_start();
	$cod_epl_sesion=$_SESSION['cod_epl']; 
	
  	require_once("class_administracion.php");
	require_once("class_programacion.php");
					
	$obj=new Administra();	
	
	$lista1=$obj->lista_jefes();
	
	$obj2=new programacion();	
	$lista2=$obj2->anio_programaciones_anteriores();	
	$lista3=$obj2->anio_max_programacion();

  ?>
  
<link rel="stylesheet" href="../../css/programacion.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/tablascroll_programacion.css?css=<?php echo rand(1, 100);?>" /> 
<link rel="stylesheet" href="../../css/scroll.css?css=<?php echo rand(1, 100);?>" /> 
<link rel="stylesheet" href="../../css/chosen.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/popover.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/jquery.contextMenu.css?css=<?php echo rand(1, 100);?>" />
<style type="text/css" title="currentStyle">
		@import "../../js/DataTables/extras/TableTools/media/css/TableTools.css";
		@import "../../js/DataTables/extras/TableTools/media/css/TableTools_JUI.css";
		@import "../../js/DataTables/media/css/demo_page.css";
		@import "../../js/DataTables/media/css/demo_table_jui.css";
		@import "../../js/DataTables/media/css/jquery-ui-1.8.4.custom.css";
</style>

  <script src="../../js/alert.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/administrador.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/jquery.popover-1.1.2.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/chosen.jquery.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/tiny_mce/tiny_mce.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  
  <script type="text/javascript" language="javascript" src="../../js/DataTables/media/js/jquery.dataTables.js"></script>
  <script type="text/javascript" charset="utf-8" src="../../js/DataTables/extras/TableTools/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" charset="utf-8" src="../../js/DataTables/extras/TableTools/media/js/TableTools.js"></script>
<script type="text/javascript" charset="utf-8" src="../../js/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
  
  <script src="../../js/jquery.contextMenu.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  
<div id="body">
	<div id="wrapper">
		<div id="header">
			<form class="form-inline">
			
			  <select class="empleado_jefe">
					 <option value="-1">Seleccione Usuario Jefe</option>
			  
				  <?php 
					for($i=0; $i<count($lista1);$i++){
					
						echo "<option value='".@$lista1[$i]['codigo']."' id='".@$lista1[$i]['codigo']."'>".@$lista1[$i]['usuario']."</option>";	
				
					} 
				   ?>
			  </select>
			  
			  <div id="combo2" style="display:inline">
					<!-- aqui se cargará el select centro de costo
					-->
			  </div>
			  
			  <div id="combo3" style="display:inline">
					<!-- aqui se cargará el select de cargos-->
			  </div>
			  
			 
			   <div id="meses" style="display:none">
			  <select class="select mes">
				  
				  <option value="1"  id="enero">Enero</option>
				  <option value="2"  id="febrero">Febrero</option>
				  <option value="3"  id="marzo">Marzo</option>
				  <option value="4"  id="abril">Abril</option>
				  <option value="5"  id="mayo">Mayo</option>
				  <option value="6"  id="junio">Junio</option>
				  <option value="7"  id="julio">Julio</option>
				  <option value="8"  id="agosto">Agosto</option>
				  <option value="9"  id="septiembre">Septiembre</option>
				  <option value="10" id="octubre">Octubre</option>
				  <option value="11" id="noviembre">Noviembre</option>
				  <option value="12" id="diciembre">Diciembre</option>				  
			  </select>
			   </div>
			  
			   <div id="anios" style="display:none">
			  <select class="select anio">
				 <?php for($i=0; $i<count($lista2);$i++){
							
							echo "<option value='".@$lista2[$i]['anio']."' id='".@$lista2[$i]['anio']."'>".@$lista2[$i]['anio']."</option>";		
				
				} ?>
				  
				  <option value="<?php echo @$lista3[0]['ano']; ?>" id="<?php echo @$lista3[0]['ano']; ?>"><?php echo @$lista3[0]['ano']; ?></option>
			  </select>
			   </div>
			  
			</form>
			
		</div><br>
		<center>
			<div id="contenedor_tablas">
					<div id="contenido" style="width:90%; text-align:center;">
					 <!--Aca esta la tabla de programacion de turnos-->
					</div>
				
			</div>
		</center>
	</div>
</div>

<div id="oculto" style="display:none;"></div>