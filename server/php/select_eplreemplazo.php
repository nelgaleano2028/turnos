<?php require_once('class_supernumerario.php');
	
	
	$obj= new supernumerario();
    $lista=$obj->get_reemplazo2($_POST['supernu']);
	
	
	$html="";
	$html.= "<option value='".$_POST["data1"]."'>".$_POST["data2"]."</option>";
	$html.= "<option value='0'>Seleccione un empleado....</option>";
	for($i=0;$i<count($lista);$i++){	
	
		$html.= "<option value=".$lista[$i]['cedula'].">".$lista[$i]['nombre_completo']."</option>";

	}
	
	echo $html;

?>