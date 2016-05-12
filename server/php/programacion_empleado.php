<?php session_start();
	
$cod_epl_sesion=$_SESSION['cod']; //sesion de empleado
	
require_once("class_programacion.php");
				
$obj=new programacion();	

$lista1=$obj->anio_programaciones_anteriores();	
$lista2=$obj->anio_max_programacion();
   // $lista3=$obj->centro_costo_empleado($cod_epl_sesion);
   
   
//$lista3=$obj->lista_centroCosto($cod_epl_sesion);
//$serv$lista3=$obj->lista_centroCosto($cod_epl_sesion);er=$_SERVER['PHP_SELF'];
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
  <script src="../../js/empleado.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/jquery.popover-1.1.2.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/chosen.jquery.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/tiny_mce/tiny_mce.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>  
  <script type="text/javascript" language="javascript" src="../../js/DataTables/media/js/jquery.dataTables.js"></script>
  
  <script src="../../js/jquery.contextMenu.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  
<div id="body">
	<div id="wrapper">
		<div id="header" style="width: 98%; !important">
			<form class="form-inline">
			
			  <input id="cod_epl_sesion" type="hidden" value="<?php echo $cod_epl_sesion ?>">
			  <input id="server" type="hidden" value="2">
			  
			  
			 
			 
			   <div id="meses" style="display:inline">
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
			  
			   <div id="anios" style="display:inline">
			  <select class="select anio">
				<?php for($i=0; $i<count($lista1);$i++){
							
					echo "<option value='".@$lista1[$i]['anio']."' id='".@$lista1[$i]['anio']."'>".@$lista1[$i]['anio']."</option>";		
				
				} ?>
				  
				  <option value="<?php echo @$lista2[0]['ano']; ?>" id="<?php echo @$lista2[0]['ano']; ?>"><?php echo @$lista2[0]['ano']; ?></option>
			  </select>
			   </div>
			  
			  <input type="button"  name="singlebutton" id="registrar_ausencia" class="btn btn-primary" value="Solicitar Ausencia">
			  <input type="button"  name="singlebutton" id="intercambiar_turno" class="btn btn-primary" value="Intercambiar Turno">
                          <input type="button"  name="singlebutton" id="solicitar_turno" class="btn btn-primary" value="Solicitar Turno">	
			  <input type="button"  name="singlebutton" id="enviar_turno" class="btn btn-primary" value="Enviar">
			  <input type="button"  name="singlebutton" id="imprimir_turno" class="btn btn-primary" value="Imprimir">
	          
			  
			  
			</form>
			
		</div><br><br><br>
		<div id="contenedor_tablas">
		<div id="contenido">
		
		</div>
		
		<div id="contenido2">
                    
		
		</div>
		</div>
	</div>
</div>