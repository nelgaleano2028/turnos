<?php
  	require_once("class_supernumerario.php");
	$obj=new supernumerario();				
	$lista=$obj->get_super_nov();
	
 ?>
<link rel="stylesheet" href="../../css/scroll.css?css=<?php echo rand(1, 100);?>" />  
<link rel="stylesheet" href="../../css/tablascroll_admin_supernumerario.css?css=<?php echo rand(1, 100);?>" /> 
<link rel="stylesheet" href="../../css/chosen.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/supernumerarios.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/datepicker.css?css=<?php echo rand(1, 100);?>" />
  <div id="body">
  <div id="contenido">
  
  <div id="wrapper">
  <div id="TablaCMI">
  <div id="header">
			<form class="form-inline">
				<input type="button"  name="singlebutton"  class="btn btn-primary"  id="nuevo_adm" value="Nuevo">
				<input type="button"  name="singlebutton"  class="btn btn-primary"  id="editar_adm"  disabled="disabled" value="Editar">
				<input type="button"  name="singlebutton"  class="btn btn-primary"  id="eliminar_adm" disabled="disabled" value="Eliminar">
				<input type="button"  name="singlebutton"  class="btn btn-primary"  id="correo_adm" value="Enviar Correo">
				<input type="button"  name="singlebutton"  class="btn btn-primary"  id="imprimir_adm" value="Imprimir">
			</form>
  </div>
  
  
  <div class="tabla">
	
				
<table class="tableone table-bordered" border="0" id="admin">
      
		<thead>
			<tr>
			
				<th  align="center" scope="col" class="th1">Nombre</th>
				<th  align="center" scope="col" class="th2">Area</th>
				<th align="center" scope="col" class="th3">Fecha ing</th>
				<th align="center" scope="col" class="th4">Supernumerario</th>
				<th  align="center" scope="col" class="th5">Tipo de Baja</th>
				<th  align="center" scope="col" class="th6">Inicio</th>
				<th  align="center" scope="col" class="th7">Fin</th>
				<th  align="center" scope="col" class="th8">Jefe</th>
				<th  align="center" scope="col" class="th9">Observaciones</th>
						
			</tr>
			
			<tr>
				<th class="th1"  align="center"><input  type="text" class="input"  name="nombre" style="width:55px" onkeyup='this.value=this.value.toUpperCase();'></td>
				<th class="th2"  align="center"><input  type="text" class="input"  name="area" style="width:55px" onkeyup='this.value=this.value.toUpperCase();'></td>
				<th class="th3"  align="center"></th>
				<th class="th4"  align="center"><input  type="text" class="input"  name="super" style="width:55px" onkeyup='this.value=this.value.toUpperCase();'></td>
				<th class="th5"  align="center"><input  type="text" class="input"  name="baja" style="width:55px" ></td>
				<th class="th6"  align="center"><input  type="text" class="input"  name="inicio" style="width:55px"></td>
				<th class="th7"  align="center"><input  type="text" class="input"  name="fin" style="width:55px"></td>
				<th class="th8"  align="center"><input  type="text" class="input"  name="jefe" style="width:55px" onkeyup='this.value=this.value.toUpperCase();'></td>
				<th class="th9"  align="center"></td>	
			<tr>
			
		</thead>
	  
     
		<tbody>
			<tr>
				<td colspan="9">
					<div class="innerb">
						<table class="tabletwo" border="0">
							<tbody>
								<?php
				
					
					for($i=0;$i<count($lista);$i++){
						if($i % 2){
                           	echo "<tr class='si seleccionarad_$i contar_admin' id='$i'>";
                        }else{
							echo "<tr class='si odd seleccionarad_$i contar_admin' id='$i'>";
                        }	
					
					?>
							<td  class="reemplazo_<?php echo $i ?> nombre  td1"><?php echo @$lista[$i]['reemplazo']; ?></td>
							<td  class="area_<?php echo $i ?> area td2"><?php echo @$lista[$i]['area']; ?></td>
							<td  align="center" class="ingreso_<?php echo $i ?>  td3"><?php echo @$lista[$i]['ingreso']; ?></td>
							<td  class="super_<?php echo $i ?> super td4"><?php echo @$lista[$i]['supernumerario']; ?></td>
							<td  align="center" class="baja_<?php echo $i ?> baja  td5"><?php echo @$lista[$i]['baja']; ?></td>
							<td  align="center" class="fecini_<?php echo $i ?> inicio  td6"><?php echo @$lista[$i]['fec_ini']; ?></td>
							<td  align="center" class="fecfin_<?php echo $i ?> fin td7"><?php echo @$lista[$i]['fec_fin']; ?></td>
							<td  class="jefe_<?php echo $i ?> jefe td8"><?php echo @$lista[$i]['jefe']; ?></td>
							<td  class="obser_<?php echo $i ?>  td9"><?php echo @$lista[$i]['observaciones']; ?></td>
							<td  class="idsuper_<?php echo $i ?>" style="display:none" id="<?php echo @$lista[$i]['id']?>" ></td>
						</tr>
									
					<?php
					
					}
					
					?>							
								  
							</tbody>
						</table>
					</div>
				</td>
			</tr>
		</tbody>
</table>
				
				
			</div>	
			</div>
			
			<!--No hay oculto porque se hizo en archivo diferente imprimir_supernumerario-->
			
			<div id="oculto" style="display:none">
			
			
			<table  border="1">
      
			<thead>
				<tr>
				
				<td  align="center">Nombre</td>
				<td  align="center">Area</td>
				<td  align="center">Fecha ing</td>
				<td  align="center">Supernumerario</td>
				<td  align="center">Tipo de Baja</td>
				<td  align="center">Inicio</td>
				<td  align="center">Fin</td>
				<td  align="center">Jefe</td>
				<td  align="center">Observaciones</td>
							
				</tr>
				
			</thead>
	  
     
			<tbody>
						<?php
						for($j=0;$j<count($lista);$j++){
						
						?>
							<tr>
								<td><?php echo @$lista[$j]['reemplazo']; ?></td>
								<td><?php echo @$lista[$j]['area']; ?></td>
								<td><?php echo @$lista[$j]['ingreso']; ?></td>
								<td><?php echo @$lista[$j]['supernumerario']; ?></td>
								<td><?php echo @$lista[$j]['baja']; ?></td>
								<td><?php echo @$lista[$j]['fec_ini']; ?></td>
								<td><?php echo @$lista[$j]['fec_fin']; ?></td>
								<td><?php echo @$lista[$j]['jefe']; ?></td>
								<td><?php echo @$lista[$j]['observaciones']; ?></td>
							</tr>
										
						<?php
						
						}
						
						?>							
			</tbody>
		</table>
			
			</div>
	
	</div> <!--Fin Wrapper -->
	
  </div> 
  </div>
  <script src="../../js/supernumerario.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/chosen.jquery.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/tiny_mce/tiny_mce.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/bootstrap-datepicker.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  