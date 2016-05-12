<?php
  	require_once("class_supernumerario.php");
	$obj=new supernumerario();				
	$lista=$obj->get_supernumerarios("");
	
 ?>
  
<link rel="stylesheet" href="../../css/scroll.css?css=<?php echo rand(1, 100);?>" />  
<link rel="stylesheet" href="../../css/tablascroll_supernumerarios.css?css=<?php echo rand(1, 100);?>" /> 
<link rel="stylesheet" href="../../css/chosen.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/supernumerarios.css?css=<?php echo rand(1, 100);?>" />
  <div id="body">
  <div id="contenido">
  
  <div id="wrapper">
  <div id="TablaCMI">
  <div id="header">
			<form class="form-inline">
			  <input type="button"  name="singlebutton"  id="activar" class="btn btn-primary" disabled="disabled" id="activar" value="Activar / Inactivar">
			  <input type="button"  name="singlebutton"  class="btn btn-primary"  id="correo" value="Enviar Correo">
			  <input type="button"  name="singlebutton"  class="btn btn-primary"  id="imprimir" value="Imprimir">
			</form>
  </div>
  
  
  <div class="tabla">
	
				
<table class="tableone table-bordered" border="0" id="supernumerario">
      
		<thead>
			<tr>
			
				<th  align="center" scope="col" class="th1">C&eacute;dula</th>
				<th  align="center" scope="col" class="th2">Nombre Completo</th>
				<th  align="center" scope="col" class="th3">Centro de Costo</th>
				<th  align="center" scope="col" class="th4">Cargo</th>
				<th  align="center" scope="col" class="th5">Estado</th>
						
			</tr>
			
			<tr>
				<th class="th1"  align="center"><input  type="text" class="input"  name="cedula" style="width:85px" 	onkeyup='this.value=this.value.toUpperCase();'></th>
				<th class="th2"  align="center"><input  type="text" class="input"  name="nombre" style="width:258px" 	onkeyup='this.value=this.value.toUpperCase();'></th>
				<th class="th3"  align="center"><input  type="text" class="input"  name="costo" style="width:269px" 	onkeyup='this.value=this.value.toUpperCase();'></th>
				<th class="th4"  align="center"><input  type="text" class="input"  name="cargo" style="width:290px" 	onkeyup='this.value=this.value.toUpperCase();'></th>
				<th class="th5"  align="center"><input  type="text" class="input"  name="estado" style="width:70px" 	onkeyup='this.value=this.value.toUpperCase();'></th>				
			<tr>
			
		</thead>
	  
     
		<tbody>
			<tr>
				<td colspan="5">
					<div class="innerb">
						<table class="tabletwo" border="0">
							<tbody>
								<?php
				
					
					for($i=0;$i<count($lista);$i++){
						if($i % 2){
                           	echo "<tr class='si seleccionar_$i contar' id='$i'>";
                        }else{
							echo "<tr class='si odd seleccionar_$i contar' id='$i'>";
                        }	
					
					?>
							<td  class="cedula_<?php echo $i ?> cedula td1"><?php echo @$lista[$i]['cedula']; ?></td>
							<td  class="nombre_<?php echo $i ?> nombre td2"><?php echo @$lista[$i]['nombre_completo']; ?></td>
							<td  class="costo_<?php echo $i ?> costo td3"><?php echo @$lista[$i]['centro_costo']; ?></td>
							<td  class="cargo_<?php echo $i ?> cargo td4"><?php echo @$lista[$i]['cargo']; ?></td>
							<td  class="estado_<?php echo $i ?> estado  td5"  align="center"><?php echo @$lista[$i]['estado']; ?></td>
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
				
				<th  align="center" scope="col">Cedula</th>
				<th  align="center" scope="col">Nombre Completo</td>
				<th  align="center" scope="col">Centro de Costo</th>
				<th  align="center" scope="col">Cargo</th>
				<th  align="center" scope="col">Estado</th>
							
				</tr>
				
			</thead>
	  
     
			<tbody>
				
						
							
									<?php
					
						
						for($j=0;$j<count($lista);$j++){
						
						?>
							<tr>
								<td><?php echo @$lista[$j]['cedula']; ?></td>
								<td><?php echo @$lista[$j]['nombre_completo']; ?></td>
								<td><?php echo @$lista[$j]['centro_costo']; ?></td>
								<td><?php echo @$lista[$j]['cargo']; ?></td>
								<td><?php echo @$lista[$j]['estado']; ?></td>
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