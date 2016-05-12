<?php
session_start();
require_once('class_turnos.php');

$obj= new turnos();

//$vars = get_defined_vars(); 
//print_r($vars);
$obj->set_empleado(@$_SESSION['cod_epl']);
$datos=$obj->eliminar_turno($_POST['codigo'],$_POST['codigo_old'],@$_SESSION['cod_epl']);

    if($datos===1){
		echo '<span class="mensajes_success">Se ha eliminado el turno correctamente</span>';
	}else if($datos===2){
		echo '<span class="mensajes_error">No se ha podido eliminar el turno intente mas tarde</span>';
	}else if($datos===3){
		echo '<span class="mensajes_error">No se ha podido eliminar el turno porque esta asociado a un ciclo</span>';
	}else if($datos===4){
		echo '<span class="mensajes_error">No se ha podido eliminar el turno porque tiene una programación asignada </span>';
	}
?>