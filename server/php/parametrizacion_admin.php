                                                                                 <?php
@session_start();


if (!isset($_SESSION['privi']) && $_SESSION['privi']!='TURNOS'){  //SEGURIDAD
  
  echo "<script>location.href='../../index.php'</script>";
}
	require_once("class_administracion.php");
					
	$obj=new Administra();	
	
	$lista=$obj->parametrizacion();
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/>
    
	<!-- Bootstrap -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css?css=<?php echo rand(1, 100);?>" />
    <link rel="stylesheet" href="../../css/style.css?css=<?php echo rand(1, 100);?>"  />
    <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.css?css=<?php echo rand(1, 100);?>" />
	<script src="../../js/alert.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
	<script src="../../js/administrador.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>  
</head>
<body>
	<div id="error"></div>
	<div class="container-fluid">
		<div class="row-fluid">
          <div class="dialog span10">
              
			<div class="cambia" >
				<div class="modal-header">
				
				<h3 id="myModalLabel" style="text-align:center !important;">Parametros Administrador</h3>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
					 <form  method="post" id="parametros_admin">
						<table border='0'>
							<tr>
								<td><label class="help-inline t_hor_max_turnos" style="color: rgb(41, 76, 139) !important;font-weight:bold !important;">Horas Máximas del turno:</label><td>
								<td><input type="text"  class="input-large" name="t_hor_max_turnos" id="t_hor_max_turnos" value="<?php echo $lista[0]['t_hor_max_turnos'];?>" /><td>
								<td><label class="help-inline t_hor_min_ciclos" style="color: rgb(41, 76, 139) !important;font-weight:bold !important; margin-left:5px;">Horas Mínimas del ciclo semanal:</label></td>
								<td><input type="text"  class="input-large" name="t_hor_min_ciclos" id="t_hor_min_ciclos" value="<?php echo $lista[0]['t_hor_min_ciclos'];?>"/></td>
							</tr>
							<tr>
								<td><label class="help-inline t_hor_min_prog" style="color: rgb(41, 76, 139) !important;font-weight:bold !important;">Horas Mínimas Mensuales:</label><td>
								<td><input type="text"   class="input-large" name="t_hor_min_prog" id="t_hor_min_prog" value="<?php echo $lista[0]['t_hor_min_prog'];?>"/><td>
								<td><label class="help-inline dias_vac" style="color: rgb(41, 76, 139) !important;font-weight:bold !important;">Numero días Vacaciones:</label></td>
								<td><input type="text" class="input-large" name="dias_vac" id="dias_vac" value="<?php echo $lista[0]['dias_vac'];?>" /></td>
							</tr>
							<tr>
								<td><label class="help-inline correo_jefe_gh" style="color: rgb(41, 76, 139) !important;font-weight:bold !important;">Correo Electrónico Jefe GH:</label><td>
								<td><input type="text" class="input-large" name="correo_jefe_gh" id="correo_jefe_gh" value="<?php echo $lista[0]['correo_jefe_gh'];?>" /><td>
								<td><label class="help-inline correo_tiempo_extra" style="color: rgb(41, 76, 139) !important;font-weight:bold !important;">Correo Electrónico Tiempo Extra:</label></td>
								<td><input type="text" class="input-large" name="correo_tiempo_extra" id="correo_tiempo_extra" value="<?php echo $lista[0]['correo_tiempo_extra'];?>" /></td>
							</tr>
							<tr>
								<td><label class="help-inline tiempo_desc_turnos" style="color: rgb(41, 76, 139) !important;font-weight:bold !important;">Tiempo Descanso entre Turnos:</label><td>
								<td><input type="text" class="input-large" name="tiempo_desc_turnos" id="tiempo_desc_turnos" value="<?php echo $lista[0]['tiempo_desc_turnos'];?>"/><td>
								<td><label class="help-inline tiempo_hol_marca" style="color: rgb(41, 76, 139) !important;font-weight:bold !important;">Tiempo Holgura de Marcación:</label></td>
								<td><input type="text" class="input-large" name="tiempo_hol_marca" id="tiempo_hol_marca" value="<?php echo $lista[0]['tiempo_hol_marca'];?>" /></td>
							</tr>
							<tr>
								<td><label class="help-inline min_hora_extra" style="color: rgb(41, 76, 139) !important;font-weight:bold !important;">Minutos contabilizar hora extra:</label><td>
								<td><input type="text" class="input-large" name="min_hora_extra" id="min_hora_extra" value="<?php echo $lista[0]['min_hora_extra'];?>"/><td>
								<td><label class="help-inline tiempo_hol_marca" style="color: rgb(41, 76, 139) !important;font-weight:bold !important;">Minutos contabilizar hora recargo:</label></td>
								<td><input type="text" class="input-large" name="min_recargo" id="min_recargo" value="<?php echo $lista[0]['min_recargo'];?>" /></td>
								
							</tr>
							<tr>
								<td><label class="help-inline min_extra_horario" style="color: rgb(41, 76, 139) !important;font-weight:bold !important;">Minutos Holgura antes de Entrada del Turno:</label><td>
								<td><input type="text" class="input-large" name="min_extra_horario" id="min_extra_horario" value="<?php echo $lista[0]['min_extra_horario'];?>"/><td>
								<td><label class="help-inline tiempo_hora_completa" style="color: rgb(41, 76, 139) !important;font-weight:bold !important;">Minutos Holgura Cumplio Hora:</label></td>
								<td><input type="text" class="input-large" name="min_hora_completa" id="min_hora_completa" value="<?php echo $lista[0]['min_hora_completa'];?>" /></td>
								
							</tr>
						</table>
						<div style="text-align:center !important;">
							<input id="guardar_administra" type="button" class="btn btn-primary" value="Guardar" style='margin-top:10px !important;'/>
						</div>	
							
					  </form>
					</div>
				</div>
          </div>
		</div>
    </div>
	<script src="../../js/jquery-1.10.1.min.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>
	<script src="../../js/bootstrap.min.js?js=<?php echo rand(1, 100);?>" type="text/javascript"></script>	

</body>
</html>