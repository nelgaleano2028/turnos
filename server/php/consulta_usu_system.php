<?php
	session_start();
	$cod_epl_sesion=$_SESSION['cod_epl']; 
	
  	require_once("class_administracion.php");
					
	$obj=new Administra();	
	
	$lista1=$obj->lista_privilegios();

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
			
			  <select class="privilegios">
					 <option value="-1">Seleccione el Perfil...</option>
			  
				  <?php 
					for($i=0; $i<count($lista1);$i++){
					
						echo "<option value='".@$lista1[$i]['privilegio']."' id='".@$lista1[$i]['privilegio']."'>".@$lista1[$i]['privilegio']."</option>";	
				
					} 
				   ?>
			  </select>
			  
			  
		</div>
			  
			</form>
			
		</div><br>
		<center>
		<div id="contenedor_tablas">
				<div id="contenido" style="width:80%; text-align:center;">
					
					
				
				 <!--Aca esta la tabla de programacion de turnos-->
				</div>
			
		</div>
			</center>
	</div>
</div>

<div id="oculto" style="display:none;"></div>