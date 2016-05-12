<?php 
	include_once("class_empleado.php");
	
	$empleado = new empleado($_POST["codigo"]);
	
	echo json_encode($empleado->run());
?>