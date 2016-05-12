<?php
  	require_once("class_supernumerario.php");
	$obj=new supernumerario();				
	$lista=$obj->empleados_cmi();
	$obj2=new supernumerario();
	$lista2=$obj2->empleados_externos();
	
 ?>
  
<link rel="stylesheet" href="../../css/scroll.css?css=<?php echo rand(1, 100);?>" />  
<link rel="stylesheet" href="../../css/tablascroll_supernumerarios_nuevo.css?css=<?php echo rand(1, 100);?>" /> 
<link rel="stylesheet" href="../../css/supernumerarios.css?css=<?php echo rand(1, 100);?>" />
  
  <div id="body">
	<div id="contenido">
  
	  <div id="wrapper">
	  
		<div id="TablaCMI">
			
			<div id="header">
				<span style="font-weight:bold; font-size:14px; color: rgb(41, 76, 139);">EMPLEADOS INTERNOS</span>
			</div>
  
  
  <div class="tabla">
	
				
<table class="tableone table-bordered" border="0" id="empleados">
      
		<thead>
			<tr>			
				<th  align="center" scope="col" class="th1" >C&eacute;dula</th>
				<th  align="center" scope="col" class="th2">Nombre Completo</th>
				<th  align="center" scope="col" class="th3">Centro de Costo</th>
				<th  align="center" scope="col" class="th4">Cargo</th>
				<th  align="center" scope="col" class="th5">Marca</th>						
			</tr>
			
			<tr>
				<th class="th1"  align="center"><input  type="text" class="input"  name="cedula" style="width:80px" onkeyup='this.value=this.value.toUpperCase();'></th>
				<th class="th2"  align="center"><input  type="text" class="input"  name="nombre" style="width:260px" onkeyup='this.value=this.value.toUpperCase();'></th>
				<th class="th3"  align="center"><input  type="text" class="input"  name="costo" style="width:220px" onkeyup='this.value=this.value.toUpperCase();'></th>
				<th class="th4"  align="center"><input  type="text" class="input"  name="cargo" style="width:220px" onkeyup='this.value=this.value.toUpperCase();'></th>
				<th class="th4"  align="center"></td>				
			<tr>
			
		</thead>
	  
     
		<tbody>
			<tr>
				<td colspan="5">
					<div class="innerb">
						<table class="tabletwo"  border="0">
							<tbody>
					<form  action="" method="post" id="super">		
								<?php
				
					
					for($i=0;$i<count($lista);$i++){					
						if($i % 2){
                           	echo "<tr class='si seleccionar_$i contar' id='$i'>";
                        }else{
							echo "<tr class='si odd seleccionar_$i contar' id='$i'>";
                        }	
					?>
						
							
							<td class="cedula_<?php echo $i ?> cedula td1"><?php echo @$lista[$i]['cedula']; ?></td>  
							<td class="nombre_<?php echo $i ?> nombre td2"><?php echo @$lista[$i]['nombre_completo']; ?></td>
							<td class="costo_<?php echo $i ?> costo td3"><?php echo @$lista[$i]['centro_costo']; ?></td>
							<td class="cargo_<?php echo $i ?> cargo td4"><?php echo @$lista[$i]['cargo']; ?></td>
						 	<td align="center" class="td5 <?php echo $i ?>"><input type="checkbox" name="seleccionar1[]"  class="seleccionar" value="<?php echo  @$lista[$i]['cedula']; ?>"></td>		
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
				
				
	</div><!-- FIN TABLA -->	
</div><!-- FIN TABLACMI -->
			
			<div id="TablaEXTERNOS">
				
				<div id="header">
				<span style="font-weight:bold; font-size:14px; color: rgb(41, 76, 139);">EMPLEADOS EXTERNOS</span>
			</div>
  
  
  <div class="tabla">
					
<table class="tableone table-bordered" border="0" id="externos">
      
		<thead>
				<tr>			
				<th  align="center" scope="col" class="th1" >C&eacute;dula</th>
				<th  align="center" scope="col" class="th2">Nombre Completo</th>
				<th  align="center" scope="col" class="th3">Centro de Costo</th>
				<th  align="center" scope="col" class="th4">Cargo v</th>
				<th  align="center" scope="col" class="th5">Marca</th>						
			</tr>
			
			<tr>
				<th class="th1"  align="center"><input  type="text" class="input"  name="cedula" style="width:80px" onkeyup='this.value=this.value.toUpperCase();'></th>
				<th class="th2"  align="center"><input  type="text" class="input"  name="nombre" style="width:260px" onkeyup='this.value=this.value.toUpperCase();'></th>
				<th class="th3"  align="center"><input  type="text" class="input"  name="costo" style="width:220px" onkeyup='this.value=this.value.toUpperCase();'></th>
				<th class="th4"  align="center"><input  type="text" class="input"  name="cargo" style="width:220px" onkeyup='this.value=this.value.toUpperCase();'></th>
				<th class="th4"  align="center"></td>				
			<tr>
			
		</thead>
	  
     
		<tbody>
			<tr>
				<td colspan="5">
					<div class="innerb">
						<table class="tabletwo"  border="0">
							<tbody>
							
								<?php
				
					
								for($j=0;$j<count($lista2);$j++){					
									if($j % 2){
										echo "<tr class='si seleccionar_$j contar' id='$j'>";
									}else{
										echo "<tr class='si odd seleccionar_$j contar' id='$j'>";
									}	
								?>
						
							<td class="cedula_<?php echo $j ?> cedula td1"><?php echo @$lista2[$j]['cedulac']; ?></td>  
							<td class="nombre_<?php echo $j ?> nombre td2"><?php echo @$lista2[$j]['nombre_completoc']; ?></td>
							<td class="costo_<?php echo $j ?> costo td3"><?php echo @$lista2[$j]['centro_costoc'];  ?></td>
							<td class="cargo_<?php echo $j ?> cargo td4"><?php echo @$lista2[$j]['cargoc']; ?></td>
						 	<td align="center" class="td5 <?php echo $j ?>"><input type="checkbox" name="seleccionar2[]" class="seleccionar" value="<?php echo  @$lista2[$j]['cedulac']; ?>"></td>	
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
				
				
			</div>	<!--Fin Tabla -->
			</div>  <!--Fin TABLAEXTERNOS -->
			
			<div id="footerboton" align="center">
				<span> <input type="submit"  name="singlebutton" id="enviar" class="btn btn-primary" value="Añadir"> </span>
			</div>
	</form>
			
	</div> <!--Fin Wrapper -->
	
  </div> <!--Fin Contenido -->
  </div><!--Fin Body -->
  <script src="../../js/supernumerario.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>