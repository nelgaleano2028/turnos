<?php
require_once('class_supernumerario.php');

if($_POST['supernume']=='supernumerarios'){

	$obj= new supernumerario();
	
    $lista=$obj->get_supernumerarios("select");
	
	
	$html="";
	$html.= "<option value='0'>Seleccione un supernumerario....</option>";
	for($i=0;$i<count($lista);$i++){	
	
		$html.= "<option value=".$lista[$i]['cedula'].">".$lista[$i]['nombre_completo']."</option>";

	}
	
	echo $html;
}
?>