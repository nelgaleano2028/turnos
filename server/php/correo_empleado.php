<?php
require_once('class_turnos.php');

if($_POST['correo']=='empleados'){

	$obj= new turnos();
    $lista=$obj->correo_empleados();
	
	
	$html="";
	for($i=0;$i<count($lista);$i++){	
	
		$html.= "<option value=".$lista[$i]['email_epl'].">".$lista[$i]['nom_epl']."</option>";

	}
	
	echo $html;
}
?>