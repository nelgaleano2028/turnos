<?php session_start();
require_once("class_ciclos.php");
$obj=new ciclos();				
$lista=$obj->ciclos_query($_SESSION['cod_epl']);
$cod_cc2=$obj->get_cod_cc2($_SESSION['cod_epl']);

 ?>
<link rel="stylesheet" href="../../css/ciclos.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/scroll.css?css=<?php echo rand(1, 100);?>" />  
<link rel="stylesheet" href="../../css/tablascroll_ciclos.css?css=<?php echo rand(1, 100);?>" /> 
<link rel="stylesheet" href="../../css/popover.css?css=<?php echo rand(1, 100);?>" />
<link rel="stylesheet" href="../../css/chosen.css?css=<?php echo rand(1, 100);?>" />
  <div id="body">
  <div id="contenido">
  <div id="wrapper">
	<div id="header">		
		<div id="crear" data-toggle="tooltip" data-placement="bottom" title data-original-title="Crear Ciclo"><img src="../../img/Nuevo.png" style="width: 46px; height: 46px;"/></div>
		<div id="correo" data-toggle="tooltip" data-placement="bottom" title data-original-title="Enviar Ciclos"><img src="../../img/Correo.png" style="width: 46px; height: 46px;"/></div>
		<div id="imprimir" data-toggle="tooltip" data-placement="bottom" title data-original-title="Imprimir Ciclos"><img src="../../img/Imprimir.png" style="width: 46px; height: 46px;"/></div>
		<div id="editar" style=" display:none;" data-toggle="tooltip" data-placement="bottom" title data-original-title="Editar Ciclo"><img src="../../img/Editar.png" style="width: 46px; height: 46px;"/></div>
		<div id="eliminar" style=" display:none;" data-toggle="tooltip" data-placement="bottom" title data-original-title="Eliminar Ciclo"><img src="../../img/Eliminar.png" style="width: 46px; height: 46px;"/></div>
		<input type='hidden' id="centro_costo" value="<?php echo $cod_cc2[0]['cod_cc2'] ?>" />
	</div>
	

		<div class="tabla">
				
				
<table class="tableone table-bordered" border="0" id="ciclos">
      
		<thead>
			<tr>
			
			<th class="th1" scope="col">Cod Ciclo</th>
			<th class="th2" scope="col">Dias</td>
			<th class="th3" scope="col">L</th>
			<th class="th3" scope="col">M</th>
			<th class="th3" scope="col">M</th>
			<th class="th3" scope="col">J</td>
			<th class="th3" scope="col">V</th>
			<th class="th3" scope="col">S</th>
			<th class="th3" scope="col">D</th>						
			<th class="th4" scope="col">Horas Ciclo</th>
			<th class="th5" scope="col">Observacion</th>
						
			</tr>
			
			<tr>
				<th class="th1" ><input onkeyup='this.value=this.value.toUpperCase();' type="text" class="input" placeholder="Filtre por Codigo" name="codigo"></td>
				<th class="th3"></th>
				<th class="th3"><input onkeyup='this.value=this.value.toUpperCase();' type="text" class="input"  name="lunes"></th>
				<th class="th3"><input onkeyup='this.value=this.value.toUpperCase();' type="text" class="input"  name="martes"></th>
				<th class="th3"><input onkeyup='this.value=this.value.toUpperCase();' type="text" class="input"  name="miercoles"></th>
				<th class="th3"><input onkeyup='this.value=this.value.toUpperCase();' type="text" class="input"  name="jueves"></th>
				<th class="th3"><input onkeyup='this.value=this.value.toUpperCase();' type="text" class="input"  name="viernes"></th>
				<th class="th3"><input onkeyup='this.value=this.value.toUpperCase();' type="text" class="input"  name="sabado"></th>
				<th class="th3"><input onkeyup='this.value=this.value.toUpperCase();' type="text" class="input"  name="domingo"></th>				
				<th class="th4" ><input  type="text" class="input" placeholder="Filtre por Hora" name="hora"></th>
				<th class="th5" ></th>
			<tr>
			
			
		</thead>
	  
     
		<tbody>
			<tr>
				<td colspan="11">
					<div class="innerb">
						<table class="tabletwo"  border="0">
							<tbody>
							
								<?php
				
					
					for($i=0;$i<count($lista);$i++){					
						 if($i % 2){
                             
                             echo "<tr class='si seleccionar_$i contar' id='$i'>";
                        }else{
                             echo "<tr class='si seleccionar_$i odd contar' id='$i'>";
                        }
					
					
					?>
						<td class="codigos_<?php echo $i ?> codigos td1"><?php echo @$lista[$i]['codigo_ciclo']; ?></td>
						<td class="dias_<?php echo $i ?>  td2" align="center"><?php echo @$lista[$i]['dias']; ?></td>
						<td class="uno_<?php echo $i ?> uno td3" align="center"><?php echo @$lista[$i]['uno']; ?></td>
						<td class="dos_<?php echo $i ?> dos td3" align="center"><?php echo @$lista[$i]['dos']; ?></td>
						<td class="tres_<?php echo $i ?> tres td3" align="center"><?php echo @$lista[$i]['tres']; ?></td>
						<td class="cuatro_<?php echo $i ?> cuatro td3" align="center"><?php echo @$lista[$i]['cuatro']; ?></td>
						<td class="cinco_<?php echo $i ?> cinco td3" align="center"><?php echo @$lista[$i]['cinco']; ?></td>
						<td class="seis_<?php echo $i ?> seis td3" align="center"><?php echo @$lista[$i]['seis']; ?></td>
						<td class="siete_<?php echo $i ?> siete td3" align="center"><?php echo @$lista[$i]['siete']; ?></td>						
						<td class="horas_<?php echo $i ?> horas td4" align="center"><?php echo number_format(@$lista[$i]['horas'],0,",","."); ?></td>
						<td class="observacion_<?php echo $i ?>  td5"><?php echo @$lista[$i]['observacion']; ?></td>					
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
			
			<!--TABLA -->
				<div style="display:none;" id="oculto">
					
						<table   border="1">
								<thead>
									<tr>
									
									<th class="th1" scope="col">Cod Ciclo</th>
									<th class="th2" scope="col">Dias</td>
									<th class="th3" scope="col">L</th>
									<th class="th3" scope="col">M</th>
									<th class="th3" scope="col">M</th>
									<th class="th3" scope="col">J</td>
									<th class="th3" scope="col">V</th>
									<th class="th3" scope="col">S</th>
									<th class="th3" scope="col">D</th>						
									<th class="th4" scope="col">Horas Ciclo</th>
									<th class="th5" scope="col">Observacion</th>
												
									</tr>
								</thead>
							<tbody>
							
								<?php
				
					
					for($i=0;$i<count($lista);$i++){					
									
					?>
						<tr>
						<td ><?php echo @$lista[$i]['codigo_ciclo']; ?></td>
						<td align="center"><?php echo @$lista[$i]['dias']; ?></td>
						<td  align="center"><?php echo @$lista[$i]['uno']; ?></td>
						<td  align="center"><?php echo @$lista[$i]['dos']; ?></td>
						<td  align="center"><?php echo @$lista[$i]['tres']; ?></td>
						<td  align="center"><?php echo @$lista[$i]['cuatro']; ?></td>
						<td  align="center"><?php echo @$lista[$i]['cinco']; ?></td>
						<td  align="center"><?php echo @$lista[$i]['seis']; ?></td>
						<td  align="center"><?php echo @$lista[$i]['siete']; ?></td>						
						<td  align="center"><?php echo number_format(@$lista[$i]['horas'],0,",","."); ?></td>
						<td ><?php echo @$lista[$i]['observacion']; ?></td>					
					</tr>
									
					<?php
					
					}
					
					?>							
								  
							</tbody>
						</table>
				</div>
			<!--FIN TABLA-->
	</div>  
  </div> 
  </div>
  <script src="../../js/ciclos.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/jquery.popover-1.1.2.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
    <script src="../../js/chosen.jquery.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/tiny_mce/tiny_mce.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  