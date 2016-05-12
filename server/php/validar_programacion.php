<?php 
session_start();
require_once("../librerias/lib/connection.php");

global $conn;


$centro_costo=$_POST['cod_cc2'];
$cargo=$_POST['cod_car'];	
$mes=$_POST['mes'];
$jefe=$_POST['cod_epl_jefe'];
$anio=$_POST['ano'];
$lista0=array();
$lista1=array();

//$perfil="RHERRERA";

$perfil=$_SESSION['nom'];


/*Parametros administrador*/
$sql2="select top 1 t_hor_min_prog from turnos_parametros";
$rs=$conn->Execute($sql2);
$fila=$rs->FetchRow();

 $sql = "exec ('SuperQueryTurnos @ano=".$anio.", @mes=".$mes." , @usuario=".$perfil.", @cargo=".$cargo.", @centrocosto=".$centro_costo.",  @param=0')";

$rs=$conn->Execute($sql);


		
	while($row10 = $rs->fetchrow()){
					  
				   
		if($row10["td1"] == ""){
			$lista0[]=array('empleado' => array("codigo"=>$row10["cod_epl"]));
			
		}
		
		if((int)$row10["horas"] < (int)$fila['t_hor_min_prog']){//parametro
			$lista1[]=array('empleado' => array("horas"=>$row10["horas"]));
			
		}
		

	}
	if($lista0){
		echo json_encode($lista0);
	}else if($lista1){
		echo json_encode($lista1);
	}else{
		echo 1;
	}

?>