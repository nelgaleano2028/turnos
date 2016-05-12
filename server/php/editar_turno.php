<?php
session_start();
require_once('class_turnos.php');

$obj= new turnos();
$obj->set_empleado(@$_SESSION['cod_epl']);


$datos=$obj->editar_turno($_POST['codigo'],$_POST['codigo_old'],$_POST['fecha_ini'],$_POST['fecha_fin'],$_POST['horas'],$_POST['almuerzo'],@$_SESSION['cod_epl']);

    if($datos===1){
		echo '<span class="mensajes_success">Se Editaron los Datos Correctamente</span>';
	}else if($datos===2){
		echo '<span class="mensajes_error">No se han podido Editar los datos intente mas tarde</span>';
	}else if($datos===3){
		echo '<span class="mensajes_info">El rango de fechas ya existe en turnos creados</span>';
	}else if($datos===4){
		echo '<span class="mensajes_info">El rango de fechas ya existe en catalogos</span>';
	}else if($datos===5){
		echo '<span class="mensajes_info">El c&oacute;digo ya existe en turnos creados</span>';
	}else if($datos===6){
		echo '<span class="mensajes_info">El c&oacute;digo ya existe en catalogos</span>';
	}
?>