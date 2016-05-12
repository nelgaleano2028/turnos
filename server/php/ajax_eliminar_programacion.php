<?php 

	require_once("class_programacion.php");
	
	$eliminar= new programacion();
	
	if($_POST['modulo']==1){
	
		echo $eliminar->find_bs_ausencias_vac(@$_POST["ano"],@$_POST["mes"],@$_POST["area"],@$_POST["codigo"]);
	
	
	}else{
	
		echo $eliminar->eliminar_programacion(@$_POST["ano"],@$_POST["mes"],@$_POST["area"],@$_POST["cargo"],@$_POST["codigo"],$_POST["nombre"],$_POST["jefe"]);
	
	}
	

 
?>