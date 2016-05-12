<?php
session_start();
$raiz="";
require_once('class_turnos.php');

$obj=new turnos();

$obj->set_empleado(@$_SESSION['cod_epl']);


if($_POST['info']==1){

	$datos=$obj->crear_turno_pre($_POST['codigo'],$_POST['fecha_ini'],$_POST['fecha_fin'],$_POST['horas']);

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
}else if($_POST['info']== 2){

	$datos=$obj->editar_turno_pre($_POST['codigo'],$_POST['codigo_old'],$_POST['fecha_ini'],$_POST['fecha_fin'],$_POST['horas']);
	
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


}else if($_POST['info']== 3){


	$datos=$obj->eliminar_turno_pre($_POST['codigo'],$_POST['codigo_old'],$_POST['fecha_ini'],$_POST['fecha_fin'],$_POST['horas']);
	
	 if($datos===1){
		echo '<span class="mensajes_success">Se ha eliminado el turno correctamente</span>';
	}else if($datos===2){
		echo '<span class="mensajes_error">No se ha podido eliminar el turno intente mas tarde</span>';
	}else if($datos===3){
		echo '<span class="mensajes_error">No se ha podido eliminar el turno porque esta asociado a un ciclo</span>';
	}


}

?>