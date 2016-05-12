<?php
session_start();
$raiz=""; // seguridad no borrar
require_once('class_ciclos.php');

$obj=new ciclos();

if($_POST){

$datos=$obj->crear_ciclo($_POST['codigo_turno'],$_POST['obser'],$_POST['td1'],$_POST['td2'],$_POST['td3'],$_POST['td4'],$_POST['td5'],$_POST['td6'],$_POST['td7'],$_POST['horas'],$_POST['cod_cc2'],$_SESSION['cod_epl']);

	if($datos===1){
		echo '<span class="mensajes_success">Se ingresaron los datos correctamente</span>';
	}else if($datos===2){
		echo '<span class="mensajes_error">No se ha podido ingresar en la base de datos intente mas tarde</span>';
	}else if($datos===4){
		echo '<span class="mensajes_info">La combinaci&oacute;n de turnos ya existe en otro ciclo</span>';
	}else if($datos===6){
		echo '<span class="mensajes_info">El C&oacute;digo ya existe en otro ciclo</span>';
	}
}

?>