<?php
require_once("../librerias/lib/connection.php");

		global $conn;
		
		$area=$_POST['idCombo1'];
		$codigo=$_POST['codigo'];
		
		$server=$_POST['server'];
					
		$sql="SELECT distinct c.cod_car, C.NOM_CAR  FROM CARGOS C, CENTROCOSTO2 AREA, EMPLEADOS_BASIC EPL, EMPLEADOS_GRAL GRAL
			  WHERE EPL.COD_EPL = GRAL.COD_EPL
			  AND EPL.COD_CC2='".$area."'
			  AND EPL.COD_CAR=C.COD_CAR
			  AND gral.COD_JEFE  = '".$codigo."'
			  AND C.estado='A'
			  AND EPL.estado='A'"; // llamar los cargos con empleados activos en ese cargo recibe como parametro el centro de costo y el codigo de jefe
					
		
		$rs=$conn->Execute($sql);
		 
			 while($row10 = $rs->fetchrow()){
				$lista0[]=array("codigo" => $row10["cod_car"],
								 "cargo"  => utf8_encode($row10["NOM_CAR"]));
			}	
	
	if ($area!="-1") {
	
	if($server==1){
		$select = "<select class='cargo_autorizacion span12' name='cod_car'>";
	}else{
		$select = "<select class='cargo_autorizacion' >";
	}
	$select .="<option value='-1'>Seleccione el cargo</option>";
		for($i=0; $i<count($lista0);$i++){
					
						 $select .="<option value='".@$lista0[$i]['codigo']."' id='".@$lista0[$i]['codigo']."'>".@$lista0[$i]['cargo']."</option>";		
				       
		}
	$select .= '</select>';
 
    echo $select;
}	
?>