<?php require_once("../librerias/lib/connection.php");

global $conn;


$sql3="update turnos_parametros set t_hor_max_turnos='".$_POST['t_hor_max_turnos']."', t_hor_min_ciclos='".$_POST['t_hor_min_ciclos']."',
 t_hor_min_prog='".$_POST['t_hor_min_prog']."', correo_jefe_gh='".$_POST['correo_jefe_gh']."',
 correo_tiempo_extra='".$_POST['correo_tiempo_extra']."', tiempo_desc_turnos='".$_POST['tiempo_desc_turnos']."', tiempo_hol_marca='".$_POST['tiempo_hol_marca']."',
 min_hora_extra='".$_POST['min_hora_extra']."', min_recargo='".$_POST['min_recargo']."', dias_vac='".$_POST['dias_vac']."', min_extra_horario='".$_POST['min_extra_horario']."', min_hora_completa='".$_POST['min_hora_completa']."'";
 
$rs3 = $conn->Execute($sql3);

if($rs3){
	echo 1;
}else{ echo 2;}
