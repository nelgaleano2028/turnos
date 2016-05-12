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
<link rel="stylesheet" href="../../css/tiempo_extra.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/tablascroll_programacion.css?css=<?php echo rand(1, 100);?>" /> 
<link rel="stylesheet" href="../../css/scroll.css?css=<?php echo rand(1, 100);?>" /> 
<link rel="stylesheet" href="../../css/chosen.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/popover.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/jquery.contextMenu.css?css=<?php echo rand(1, 100);?>" />

<style type="text/css" title="currentStyle">
	@import "../../js/DataTables/media/css/jquery.dataTables_themeroller.css";			
</style>

  <script src="../../js/alert.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>  
  <script src="../../js/jquery.popover-1.1.2.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/chosen.jquery.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  
  
  <script type="text/javascript" language="javascript" src="../../js/DataTables/media/js/jquery.dataTables.js"></script>

  <!-- <script type="text/javascript" src="../../js/dataTables.fnGetHiddenNodes.js"></script> -->

  
  <script src="../../js/jquery.contextMenu.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>

<ul class="nav nav-tabs">
  <li class="active"><a href="#home" data-toggle="tab">Validaci&oacute;n Tiempo Extra </a></li>
  <li><a href="#profile" data-toggle="tab">Total Horas Extras</a></li> 
</ul>

<div class="tab-content">
  <div class="tab-pane active" id="home">
   <div id="body">
	 <div id="wrapper">
		<div id="header" style="width:80% !important;">
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
				  
				  <option value="1"  class="enero">Enero</option>
				  <option value="2"  class="febrero">Febrero</option>
				  <option value="3"  class="marzo">Marzo</option>
				  <option value="4"  class="abril">Abril</option>
				  <option value="5"  class="mayo">Mayo</option>
				  <option value="6"  class="junio">Junio</option>
				  <option value="7"  class="julio">Julio</option>
				  <option value="8"  class="agosto">Agosto</option>
				  <option value="9"  class="septiembre">Septiembre</option>
				  <option value="10" class="octubre">Octubre</option>
				  <option value="11" class="noviembre">Noviembre</option>
				  <option value="12" class="diciembre">Diciembre</option>				  
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
			  
			  		  
			  <input type="button"  id="validar_programacion" name="singlebutton" class="btn btn-primary" value="Validaci&oacute;n">
			  
			  
			</form>
			
		</div>
		
		<br>
		
		<div id="contenedor_tablas">
		<div id="contenido">
		
		
		
		
		</div>

		<!--codigo Steven -->
		<div id="contenido2" style="float:left; width: 30%;">
				
				
				
				
		</div>
		
		<div id="contenido3" style="float:right; margin-right: 480px; margin-top: 50px; display:none">
				
				<table border="0px">
					<tr>
						<td width="10%"><div style='background-color:#CBD0CB'>&nbsp;</div><td>
						<td>Marcacion igual a lo programado<td>
					</tr>
					<tr>
						<td ><div style='background-color:#F5A65D'>&nbsp;</div><td>
						<td>Numero de horas extras marcadas<td>
					</tr>
					<tr>
						<td><div style='background-color:#F997C5'>&nbsp;</div><td>
						<td>Menor tiempo laborado al programado<td>
					</tr>
					<tr>
						<td><div style='background-color:#BBF6C0'>&nbsp;</div><td>
						<td>No hay registros de marcacion para este turno<td>
					</tr>
					<tr>
						<td><div style='background-color:#F5F4B1'>&nbsp;</div><td>
						<td>No hay turnos para esta marcacion<td>
					</tr>
					<tr>
						<td><div style='background-color:#6D87DA'>&nbsp;</div><td>
						<td>Marcacion revisada<td>
					</tr>
					<tr>
						<td><div style='background-color:#E78587'>&nbsp;</div><td>
						<td>Horario no coincide con turno programado<td>
					</tr>
					<tr>
						<td><div style='background-color:#93E5DF'>&nbsp;</div><td>
					<td>Falta una Marcacion<td>
					</tr>					
				</table>
				
		</div>



		
		<!--fin codigo Steven -->
		
		</div>
	</div><!-- cierre wrapper -->
</div> 
  
  </div><!-- cierre pestaña1 -->
  
  <div class="tab-pane" id="profile" ><!--Pestaña 2 -->

   <div id="wrapper">
		<div id="header" style="width:80% !important;">
			<form class="form-inline">
			
			  <input id="cod_epl_sesion" type="hidden" value="<?php echo $cod_epl_sesion ?>">
			  <input id="server" type="hidden" value="2">
			  <select class="centro_costo_pro">
					 <option value="-1">Seleccione Centro de Costo</option>
			  
				  <?php 
					for($i=0; $i<count($lista3);$i++){
					
						echo "<option value='".@$lista3[$i]['codigo']."' id='".@$lista3[$i]['codigo']."'>".@$lista3[$i]['area']."</option>";		
				
					} 
				   ?>
			  </select>
			  
			  <div id="combo9" style="display:inline">
					<!-- aqui se cargará el select -->
			  </div>
			  
			 
			   <div id="meses_pes" style="display:none">
			  <select class="select mes_pes">
				  
				  <option value="1"  class="enero">Enero</option>
				  <option value="2"  class="febrero">Febrero</option>
				  <option value="3"  class="marzo">Marzo</option>
				  <option value="4"  class="abril">Abril</option>
				  <option value="5"  class="mayo">Mayo</option>
				  <option value="6"  class="junio">Junio</option>
				  <option value="7"  class="julio">Julio</option>
				  <option value="8"  class="agosto">Agosto</option>
				  <option value="9"  class="septiembre">Septiembre</option>
				  <option value="10" class="octubre">Octubre</option>
				  <option value="11" class="noviembre">Noviembre</option>
				  <option value="12" class="diciembre">Diciembre</option>				  
			  </select>
			   </div>
			  
			  			  
			  <div id="anios_pes" style="display:none">
			  <select class="select anio_pes">
			  
				<option value='2013' id='2013'>2013</option>
				
				<option value='2014' id='2014' selected>2014</option>
				
				<option value='2015' id='2015'>2015</option>
			  
				<!-- for($j=0; $j<count($lista1);$j++){
							
							echo "<option value='".@$lista1[$j]['anio']."' id='".@$lista1[$j]['anio']."'>".@$lista1[$j]['anio']."</option>";		
				
				} -->
				  
				  <!--<option value=" echo @$lista2[0]['ano']; ?>" id="echo @$lista2[0]['ano']; ?>">echo @$lista2[0]['ano']; ?></option>-->
				  
				  
			  </select>
			   </div>
			  
			  		  
			  <input type="button"  id="autorizar" name="singlebutton" class="btn btn-primary" value="Autorizar">
			  
			</form>
			
		</div>
		
		<br>
		
		
		<div id="contenido_general">
				
		
		</div>		
		
	</div><!-- cierre wrapper -->  
  </div><!-- cierre pestaña 2 -->
  
  
</div><!-- cierre Tab-content -->

<script src="../../js/tiempo_extra.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>