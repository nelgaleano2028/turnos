<?php require_once("../librerias/lib/connection.php");

require_once("class_programacion.php");
					
global $conn;

$obj=new programacion();


$centro_costo=$_POST['cod_cc2'];
$cargo=$_POST['cod_car'];	
$mes=$_POST['mes'];
$jefe=$_POST['cod_epl_jefe'];
$anio=$_POST['ano'];
$mes_ante=(int)$_POST['mes'] -1 ;
$lista=array();

/*validar el mes de enero*/
if($mes_ante==0){
	$mes_ante=12;
	$anio=(int)$_POST['ano'] - 1;
}

$sql2="select * from prog_mes_tur where mes='".$mes."' and ano='".$anio."' and cod_cc2='".$centro_costo."' and cod_car='".$cargo."' and cod_epl_jefe='".$jefe."'";

$rs2=$conn->Execute($sql2);

if($rs2->RecordCount() > 0){
	echo 3;
	die();
}


$sql="select * from prog_mes_tur_ini where mes='".$mes_ante."' and ano='".$anio."' and cod_cc2='".$centro_costo."' and cod_car='".$cargo."' and cod_epl_jefe='".$jefe."'";

$rs=$conn->Execute($sql);

if($rs->RecordCount() > 0){
	
	while($row10 = $rs->fetchrow()){
		
		$datos=$obj->insertar_programacion($row10["cod_epl"], $mes, $row10["Td1"], $row10["Td2"], $row10["Td3"], $row10["Td4"], $row10["Td5"], $row10["Td6"], $row10["Td7"], $row10["Td8"], $row10["Td9"],  $row10["Td10"],  $row10["Td11"],  $row10["Td12"],  $row10["Td13"],  $row10["Td14"],  $row10["Td15"],  $row10["Td16"],  $row10["Td17"],  $row10["Td18"],  $row10["Td19"],  $row10["Td20"],  $row10["Td21"],  $row10["Td22"],  $row10["Td23"],  $row10["Td24"],  $row10["Td25"],  $row10["Td26"],  $row10["Td27"],  $row10["Td28"],  $row10["Td29"],  $row10["Td30"],  $row10["Td31"], $anio, $row10["cod_ciclo"], $row10["cod_ciclo2"], $row10["cod_ciclo3"], $row10["cod_ciclo4"], $row10["cod_ciclo5"], $row10["cod_ciclo6"], $row10["sem1"], $row10["sem2"], $row10["sem3"], $row10["sem4"] ,$row10["sem5"], $row10["sem6"],$row10["cod_cc2"],$row10["cod_car"],$row10["cod_epl_jefe"]);
	}

	echo 1;
}else{
	echo 2;
}

/*$rs=$conn->Execute($sql);
while($row10 = $rs->fetchrow()){
	  
	 $lista0[]=array(
					"cod_epl"=>$row10["cod_epl"],
					"id"=>$row10["id"],
					1=>$row10["td1"],
					2=>$row10["td2"],
					3=>$row10["td3"],
					4=>$row10["td4"],
					5=>$row10["td5"],
					6=>$row10["td6"],
					7=>$row10["td7"],
					8=>$row10["td8"],
					9=>$row10["td9"],
					10=>$row10["td10"],
					11=>$row10["td11"],
					12=>$row10["td12"],
					13=>$row10["td13"],
					14=>$row10["td14"],
					15=>$row10["td15"],
					16=>$row10["td16"],
					17=>$row10["td17"],
					18=>$row10["td18"],
					19=>$row10["td19"],
					20=>$row10["td20"],
					21=>$row10["td21"],
					22=>$row10["td22"],
					23=>$row10["td23"],
					24=>$row10["td24"],
					25=>$row10["td25"],
					26=>$row10["td26"],
					27=>$row10["td27"],
					28=>$row10["td28"],
					29=>$row10["td29"],
					30=>$row10["td30"],
					31=>$row10["td31"],
					'sem1'=>$row10["sem1"],
					'sem2'=>$row10["sem2"],
					'sem3'=>$row10["sem3"],
					'sem4'=>$row10["sem4"],
					'sem5'=>$row10["sem5"],
					'sem6'=>$row10["sem6"],
					'horas'=>$row10["horas"],
					);
 }*/
 


?>