<?php
$raiz="";
require_once('class_supernumerario.php');

$obj=new supernumerario();


if($_POST){

	
	if(isset($_POST['seleccionar2']) and isset($_POST['seleccionar1']) ){
		
		$datos=$obj->agregar_supernume($_POST['seleccionar1'],$_POST['seleccionar2']);
		
		if($datos==1){
		
			echo "se agrego en la base de datos";
		}else{
			echo "No se agrego en la base de datos";
		}
		
	}else if(isset($_POST['seleccionar1'])){
	
	
		$datos=$obj->agregar_supernume1($_POST['seleccionar1']);
		
		if($datos==1){
		
			echo "se agrego en la base de datos";
		}else{
			echo "No se agrego en la base de datos";
		}
		
		
	}else if(isset($_POST['seleccionar2'])){
	
		$datos=$obj->agregar_supernume2($_POST['seleccionar2']);
		
		if($datos==1){
		
			echo "se agrego en la base de datos";
		}else{
			echo "No se agrego en la base de datos";
		}
		
	}
	
}else{
	echo " No se ha seleccionado en los checkbox";

}
?>