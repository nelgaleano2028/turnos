<?php
$raiz="";
require_once('class_supernumerario.php');

$obj=new supernumerario();
if($_POST["cedula"]){

	$datos=$obj->activar_supernumerario($_POST["cedula"],$_POST["estado"]);
	
	if($datos==1){
		echo '1';
	}else if($datos==2){
	
		echo '2';
	}else if($datos==3){
	
		echo '3';
	}
}
?>