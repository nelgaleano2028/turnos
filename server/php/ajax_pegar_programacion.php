<?php 
	session_start();
	require_once("class_programacion.php");
		
		$pegar= new programacion();
		
		$programacion= json_decode($_POST["data"],true);
		
		
		if($_POST["data"] == null){
			echo 1;
		}else{
			echo $pegar->pegar_programacion($programacion,$_POST["cod_epl"],$_POST["anio"],$_POST["mes"],$_POST["area"],$_POST["cargo"],$_POST["jefe"],$_POST["id"]);
			unset($_SESSION["programacion"]);
			$_SESSION["programacion"]='';
		}
		
?>