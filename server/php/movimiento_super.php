<?php
require_once('class_supernumerario.php');

if($_POST['id']){

	$obj= new supernumerario();
	$datos=$obj->cubri_reemplazo($_POST['id']);
	
	echo $datos[0]['editar'];
}
?>