<?php 
require_once('class_supernumerario.php');

if($_POST['id']){

	$obj= new supernumerario();
	$datos=$obj->eliminar_movimiento($_POST['id'], $_POST['fecha']);
	
	echo $datos;
}	
?>