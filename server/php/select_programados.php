<?php

	require_once("class_turnoshe.php");
					
	$obj=new Turnoshe();	

if($_POST['info']==1){

	$lista=$obj->lista_centroCosto($_POST['usuario_jefe']);
	
	$html="<select class='centro_costo'>";
	$html.= "<option value='0'>Seleccione un Centro de Costo....</option>";
	for($i=0;$i<count($lista);$i++){	
	
		$html.= "<option value=".$lista[$i]['codigo'].">".$lista[$i]['area']."</option>";

	}
	$html.="</select>";
	echo $html;



}else if($_POST['info']==2){

	$lista=$obj->anio_programaciones_anteriores();	
	$lista2=$obj->anio_max_programacion();	
	
	$html="<select class='anio_progra'>";
	$html.= "<option value='0'>Seleccione el a&ntilde;o..</option>";
	for($i=0;$i<count($lista);$i++){	
	
		$html.= "<option id=".$lista[$i]['anio']." value=".$lista[$i]['anio'].">".$lista[$i]['anio']."</option>";

	}
		$html.="<option id=".$lista2[0]['ano']."  value=".$lista2[0]['ano'].">".$lista2[0]['ano']."</option>";
		$html.="</select>";
	echo $html;


}	
?>


		
	