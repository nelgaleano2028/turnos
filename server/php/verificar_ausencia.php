<?php 

	require_once("class_programacion.php");
	
	$buscar= new programacion();
	
	if($_POST['info']==1){
		
		$arreglo=array();
		$datos=$buscar->find_ausencias_vigentes(@$_POST["anio"],@$_POST["mes"],@$_POST["cod_cc2"],@$_POST["cod_epl"]);
		
		if($datos==1){
			
			$arreglo[]=array("ausencia"=>1);
		
		}else if($datos==2){
			
			$arreglo[]=array("ausencia"=>2);
			
		}else if($datos==3){
		
			$arreglo[]=array("ausencia"=>3);
		}
		
		echo  json_encode(array('info'=>$arreglo));
	
	}else{
	
		echo $buscar->find_ausencias_vac(@$_POST["anio"],@$_POST["mes"],@$_POST["cod_cc2"],@$_POST["cod_epl"]);
	}
	
	
?>