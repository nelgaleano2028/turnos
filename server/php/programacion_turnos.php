<?php session_start();

$cod_epl_sesion=$_SESSION['cod_epl']; //sesion de RHERRERA
require_once("class_programacion.php");
				
$obj=new programacion();	

$lista1=$obj->anio_programaciones_anteriores();	
$lista2=$obj->anio_max_programacion();	
$lista3=$obj->lista_centroCosto($cod_epl_sesion);
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
  <script src="../../js/programacion.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/jquery.popover-1.1.2.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/chosen.jquery.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/tiny_mce/tiny_mce.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  
  <script type="text/javascript" language="javascript" src="../../js/DataTables/media/js/jquery.dataTables.js"></script>
  
  <script src="../../js/jquery.contextMenu.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  
<div id="body">
	<div id="wrapper">
		<div id="header">
			<form class="form-inline">
			
			  <input id="cod_epl_sesion" type="hidden" value="<?php echo $cod_epl_sesion ?>">
			  <input id="server" type="hidden" value="2">
			  <select class="centro_costo">
					 <option value="-1">Seleccione Centro de Costo</option>
			  
				  <?php 
					for($i=0; $i<count($lista3);$i++){
					
						echo "<option value='".@$lista3[$i]['codigo']."' id='".@$lista3[$i]['codigo']."'>".@$lista3[$i]['area']."</option>";		
				
					} 
				   ?>
			  </select>
			  
			  <div id="combo2" style="display:inline">
					<!-- aqui se cargará el select -->
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
				<?php for($i=0; $i<count($lista1);$i++){
							
							echo "<option value='".@$lista1[$i]['anio']."' id='".@$lista1[$i]['anio']."'>".@$lista1[$i]['anio']."</option>";		
				
				} ?>
				  
				  <option value="<?php echo @$lista2[0]['ano']; ?>" id="<?php echo @$lista2[0]['ano']; ?>"><?php echo @$lista2[0]['ano']; ?></option>
			  </select>
			   </div>
			  
			 <!-- <input type="button"  id="copiar_programacion" name="singlebutton" class="btn btn-primary" value="Copiar Programación ">-->
			  <input type="button"  id="correo_programacion" name="singlebutton" class="btn btn-primary" value="Enviar">
			   <div class="btn-group">
				  <a class="btn btn-primary" href="#"> Imprimir</a>
				  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="javascript:void(0);" id="imprimir_excel">EXCEL</a></li>
					<li><a href="javascript:void(0);" id="imprimir_pdf">PDF</li>
				  </ul>
				</div>			  
			  <input type="button"  id="validar_programacion" name="singlebutton" class="btn btn-primary" value="Validar Programacion">
			  <input type="hidden"  id="jefe_programacion"   value="<?php echo $cod_epl_sesion; ?>">
			  
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