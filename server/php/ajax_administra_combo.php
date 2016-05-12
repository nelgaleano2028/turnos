<?php
require_once("../librerias/lib/connection.php");
require_once("class_administracion.php");
					
$obj=new Administra();	
	
global $conn;
		
if($_POST['info']==1){
	
	
		$codigo=@$_POST['empleado_jefe'];
				
		$lista1=$obj->lista_centroCosto($codigo);
					
		
	
	
		$select = "<select class='centroCosto' >";

		$select .="<option value='-1'>Seleccione el centro de costo</option>";
			for($i=0; $i<count($lista1);$i++){
						
				$select .="<option value='".@$lista1[$i]['codigo']."' id='".@$lista1[$i]['codigo']."'>".@$lista1[$i]['area']."</option>";		
						   
			}
		$select .= '</select>';
	 
		echo $select;
		
		
}else if($_POST['info']==2){

	$centro_costo=@$_POST['centrocosto'];
	$jefe=@$_POST['jefe'];
			
	$lista1=$obj->lista_cargos($centro_costo,$jefe);
				

	$select = "<select class='cargo' >";

	$select .="<option value='-1'>Seleccione el cargo</option>";
		for($i=0; $i<count($lista1);$i++){
					
			$select .="<option value='".@$lista1[$i]['codigo']."' id='".@$lista1[$i]['codigo']."'>".@$lista1[$i]['cargo']."</option>";		
					   
		}
	$select .= '</select>';
 
	echo $select;



}else if($_POST['info']==3){

		$cargo=@$_POST['cargo'];
		$jefe=@$_POST['jefe'];
			
		$lista=$obj->lista_empleados($cargo,$jefe);
		
		echo json_encode($lista);

}else if($_POST['info']==4){


		$privilegio=@$_POST['privilegios'];
			
		$lista=$obj->lista_usuarios($privilegio);
		
		echo json_encode($lista);

}	
?>