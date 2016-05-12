<?php
session_start();
$raiz="";
require_once('class_turnos.php');

$obj=new turnos();

if($_POST){

$obj->set_empleado(@$_SESSION['cod_epl']);
$datos=$obj->crear_turno($_POST['codigo'],$_POST['fecha_ini'],$_POST['fecha_fin'],$_POST['horas'],$_POST['almuerzo'],$_SESSION['cod_epl']);

	if($datos===1){
		echo '<span class="mensajes_success">Se ingresaron los datos correctamente</span>';
	}else if($datos===2){
		echo '<p class="mensajes_error">No se ha podido ingresar en la base de datos intente mas tarde</span>';
	}else if($datos===3){
		echo '<span class="mensajes_info">El rango de fechas ya existe en turnos creados</span>';
	}else if($datos===4){
		echo '<span class="mensajes_info">El rango de fechas ya existe en catalogos</span>';
	}else if($datos===5){
		echo '<span class="mensajes_info">El C&oacute;digo ya existe en turnos creados</span>';
	}else if($datos===6){
		echo '<span class="mensajes_info">El C&oacute;digo ya existe en catalogos</span>';
	}
}

?>