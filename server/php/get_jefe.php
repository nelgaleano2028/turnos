<?php
require_once('class_supernumerario.php');


if($_POST['id']){

	$obj= new supernumerario();
    $lista=$obj->get_jefe($_POST['id']);
	echo json_encode($lista);	
}
?>