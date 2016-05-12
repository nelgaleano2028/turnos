<?php
require_once('class_supernumerario.php');

if($_POST['id']){

	$obj= new supernumerario();
	$datos=$obj->supernumerario_id($_POST['id']);
	
	//var_dump($datos); die();
	
	echo json_encode($datos);
}
?>