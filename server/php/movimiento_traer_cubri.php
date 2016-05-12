<?php
require_once('class_supernumerario.php');


if($_POST['id']){

	$obj= new supernumerario();
	$datos=$obj->supernumerario_id2($_POST['id']);
	
	echo json_encode($datos);
   

}
?>