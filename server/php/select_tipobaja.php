<?php
require_once('class_supernumerario.php');

if($_POST['supernume']=='supernumerarios'){

	$obj= new supernumerario();
    $lista=$obj->get_tipobaja();
	
	if(isset($_POST["data1"])){
	
		$html="";
		$html.= "<option value='".$_POST['data1']."'>".$_POST['data2']."</option>";
		$html.= "<option value='0'>Seleccione el tipo de baja....</option>";
		for($i=0;$i<count($lista);$i++){	
		
			$html.= "<option value=".$lista[$i]['tipo_baja'].">".$lista[$i]['nombre']."</option>";

		}
		
		echo $html;
	
	
	}else{
	
		$html="";
		$html.= "<option value='0'>Seleccione el tipo de baja....</option>";
		for($i=0;$i<count($lista);$i++){	
		
			$html.= "<option value=".$lista[$i]['tipo_baja'].">".$lista[$i]['nombre']."</option>";

		}
		
		echo $html;
	
	
	}
	
}
?>