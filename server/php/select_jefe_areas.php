<?php
require_once('class_supernumerario.php');

if($_POST['id']){

	$obj= new supernumerario();
    $lista=$obj->areas_jefe($_POST['id']);
	
	
	$html="";
	$html.= "<option value='0'>Seleccione un Centro de Costo....</option>";
	for($i=0;$i<count($lista);$i++){	
	
		$html.= "<option value=".$lista[$i]['codigo'].">".$lista[$i]['area']."</option>";

	}
	
	echo $html;
}
?>