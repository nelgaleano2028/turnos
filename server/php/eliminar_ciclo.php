<?php
session_start();
require_once('class_ciclos.php');

$obj= new ciclos();
$datos=$obj->eliminar_ciclo($_POST['cod_old'],$_POST['cod_cc2'],$_SESSION['cod_epl']);

    if($datos===1){
		echo '<span class="mensajes_success">Se ha Eliminado el ciclo correctamente</span>';
	}else if($datos===2){
		echo '<span class="mensajes_error">No se ha podido Eliminar el ciclo intente mas tarde</span>';
	}
?>