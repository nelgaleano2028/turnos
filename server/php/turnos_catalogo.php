<?php session_start();
 
require_once("class_turnos.php");
				
$obj=new turnos();
				
$lista=$obj->turnos_predeterminados();

$obj2=new turnos();
$lista2=$obj2->turnos_creados($_SESSION['cod_epl']);
	
?>
	
  <link rel="stylesheet" href="../../css/turnos.css?css=<?php echo rand(1, 100);?>" />
  <link rel="stylesheet" href="../../css/tablascroll_turnos.css?css=<?php echo rand(1, 100);?>" />
  <link rel="stylesheet" href="../../css/chosen.css?css=<?php echo rand(1, 100);?>" />
  <link rel="stylesheet" href="../../css/scroll.css?css=<?php echo rand(1, 100);?>" />

  
  <script src="../../js/turnos.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/chosen.jquery.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  <script src="../../js/tiny_mce/tiny_mce.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
  
  
  
  <div id="body">
  <div id="wrapper">
	<div id="header">
		<div id="crear" data-toggle="tooltip" data-placement="bottom" title data-original-title="Crear Turno"><img src="../../img/TurnoNuevo.png" /></div>
		<div id="correo" data-toggle="tooltip" data-placement="bottom" title data-original-title="Enviar Turnos"><img src="../../img/Correo.png"/></div>
		<div id="imprimir" data-toggle="tooltip" data-placement="bottom" title data-original-title="Imprimir Turnos"><img src="../../img/Imprimir.png" /></div>
		<div id="editar" style=" display:none;" data-toggle="tooltip" data-placement="bottom" title data-original-title="Editar Turno"><img src="../../img/Editar.png" /></div>
		<div id="eliminar" style=" display:none;" data-toggle="tooltip" data-placement="bottom" title data-original-title="Eliminar Turno"><img src="../../img/Eliminar.png" /></div>
	</div>
	<div id="contenido">
		<div id="predeterminado">
			<div class="subtitulo"> Catalogo de Turnos </div>
			<div class="tabla">
				
				
<table class="tableone table-bordered" border="0" id="predeter">
      
		<thead>
			<tr>
			<th class="th1" scope="col">Cod Turno</th> 
			<th class="th2" scope="col">Hora</th> 
			<th class="th3" scope="col">Hora Inicial</th> 
			<th class="th4" scope="col">Hora Final</th> 			
			</tr>
			
			<tr>
				<th class="th1" ><input onkeyup='this.value=this.value.toUpperCase();' type="text" class="input" placeholder="Filtre por Codigo" name="codigo"></td>
				<th class="th2" ><input  type="text" class="input" placeholder="Filtre por Hora" name="hora"></td>
				<th class="th3" ><input  type="text" class="input" placeholder="Filtre por Hora Inicial" name="hora_ini"></td>
				<th class="th4" ><input  type="text" class="input" placeholder="Filtre por Hora Final" name="hora_fin"></td>
			<tr>
		</thead>
	  
     
		<tbody>
			<tr>
				<td colspan="4" style="border: hidden !important;">
					<div class="innerb">
						<table class="tabletwo"  border="0">
							<tbody>
							
								<?php
				
					
					for($i=0; $i<count($lista); $i++){					
						 if($i % 2){
                             
                             echo "<tr>";
                        }else{
                             echo "<tr class='odd'>";
                        }
					
					
					?>
						
						<td class="codigos td1" ><?php echo @$lista[$i]['codigo_turno']; ?></td>
						<td class="horas td2"><?php echo @$lista[$i]['horas']; ?></td>
						<td class="hora_ini td3"><?php echo @$lista[$i]['hora_ini']; ?></td>
						<td class="hora_fin td4"><?php echo @$lista[$i]['hora_fin']; ?></td>
					<tr>
					
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
		
			
		
		<div id="creacion">
			<div class="subtitulo"> Mis Turnos Creados </div>
			
			<div class="tabla">
						
			<table class="tableone table-bordered" border="0" id="personal">
			
				<thead>
					<tr>
						<th class="th1" scope="col">Cod Turno</th> 
						<th class="th2" scope="col">Hora</th> 
						<th class="th3" scope="col">Hora Inicial</th> 
						<th class="th4" scope="col">Hora Final</th> 			
					</tr>		
					<tr>
						<th class="th1" ><input onkeyup='this.value=this.value.toUpperCase();' type="text" class="input" placeholder="Filtre por Codigo" name="codigo"></td>
						<th class="th2" ><input  type="text" class="input" placeholder="Filtre por Hora" name="hora"></td>
						<th class="th3" ><input  type="text" class="input" placeholder="Filtre por Hora Inicial" name="hora_ini"></td>
						<th class="th4" ><input  type="text" class="input" placeholder="Filtre por Hora Final" name="hora_fin"></td>
					<tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="4" style="border: hidden !important;">
							<div class="innerb">
								<table class="tabletwo"  border="0">
									<tbody>
							
								<?php
				
					
					for($j=0;$j<count($lista2);$j++){					
						 if($j % 2){
                           	echo "<tr class='si seleccionar_$j contar' id='$j'>";
                        }else{
							echo "<tr class=' si odd seleccionar_$j contar' id='$j'>";
                        }	
					
					
					?>												
				
							
							<td class="codigos_<?php echo $j ?> codigos td1"><?php echo @$lista2[$j]['codigo_turno']; ?></td>
							<td class="horas_<?php echo $j ?> horas td2"><?php echo @$lista2[$j]['horas']; ?></td>
							<td class="hora_ini_<?php echo $j ?> hora_ini td3"><?php echo @$lista2[$j]['hora_ini']; ?>:00</td>
							<td class="hora_fin_<?php echo $j ?> hora_fin td4"><?php echo @$lista2[$j]['hora_fin']; ?>:00</td>
						<tr>
					
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
		
		
		<div style="display:none;" id="oculto">
			<div style="float:left; width:50%">
			<table border='1' >
				<tr>
					<td>Cod Turno</td>
					<td>Hora</td>
					<td>Hora Inicial</td>
					<td>Hora Final</td>
				</tr>
				<?php
						
					for($v=0;$v<count($lista);$v++){
			
				?>
					<tr>
					<td><?php echo @$lista[$v]['codigo_turno']; ?></td>
					<td><?php echo @$lista[$v]['horas']; ?></td>
					<td><?php echo @$lista[$v]['hora_ini']; ?>:00</td>
					<td><?php echo @$lista[$v]['hora_fin']; ?>:00</td>
					</tr>
				<?php
					}
				?>
			</table>
			</div>
			<div style="float:left; width:50%">
			<table border='1'>
				<tr>
					<td>Cod Turno</td>
					<td>Hora</td>
					<td>Hora Inicial</td>
					<td>Hora Final</td>
				</tr>
				<?php
						
					for($p=0;$p<count($lista2);$p++){
			
				?>
					<tr>
					<td><?php echo @$lista2[$p]['codigo_turno']; ?></td>
					<td><?php echo @$lista2[$p]['horas']; ?></td>
					<td><?php echo @$lista2[$p]['hora_ini']; ?>:00</td>
					<td><?php echo @$lista2[$p]['hora_fin']; ?>:00</td>
					</tr>
				<?php
					}
				?>
			</table>
			</div>
		</div>
		
		
		
	</div>  
  </div> 
  </div>
  