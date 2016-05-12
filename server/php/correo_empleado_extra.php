<?php
require_once("../librerias/lib/connection.php");

$codigo_epl=$_POST['codigo_epl'];



function correo_empleados($codigo_epl){
	
		global $conn;
		
		$sql=" select  gral.email,b.nom_epl+' '+b.ape_epl as nom_epl from empleados_gral as gral, empleados_basic as b
				where gral.cod_epl=b.cod_epl and b.estado='A' and gral.email <> '' and gral.cod_epl='".$codigo_epl."'
				union
				select correo_jefe_gh AS email, nom_epl='GESTION HUMANA'  from turnos_parametros tur";
		
		$res=$conn->Execute($sql);
		 
		 	if($res){
			 
				while($row = $res->FetchRow()){
				
					$lista[] =  array("nom_epl"=>utf8_encode($row["nom_epl"]),
											"email_epl"=>$row["email"]);	
				}	
			}
			
			return $lista;
	}



if($_POST['correo']=='empleados'){
	
    $lista=correo_empleados($codigo_epl);
	
	
	$html="";
	
	
	
	for($i=0;$i<count($lista);$i++){	
	
		$html.= "<option value=".$lista[$i]['email_epl'].">".$lista[$i]['nom_epl']."</option>";

	}
	
	echo $html;
}
?>