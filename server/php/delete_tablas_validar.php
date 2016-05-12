<?php 
require_once("../librerias/lib/connection.php");

global $conn;


$centro_costo=$_POST['centro_costo'];
$cargo=$_POST['cargo'];		
$codigo=$_POST['codigo'];//Codigo Jefe		
			
$fecha=$_POST['fecha'];	
$anio=substr($fecha, 0, 4);
$mes=substr($fecha, 5, 2);

//and fecha='".$anio."-".$dia."-".$mes."'

//Si hay color azul
$sql="select color from colores where color='#6D87DA' and mes='".$mes."' and anio='".$anio."' and cod_cc2='".$centro_costo."' and cargo='".$cargo."'";

//var_dump($sql);die();

$rs=$conn->Execute($sql);	

$row = $rs->fetchrow();
	
$hay_color=$row["color"];



if($hay_color == null){

		$sql1="DELETE FROM colores where mes='".$mes."' and anio='".$anio."'";

		$sql2="DELETE FROM prog_reloj_he where MONTH(fecha)='".$mes."' and  YEAR(fecha)='".$anio."'";
		
		
		//var_dump($sql1);
		//var_dump($sql2);die("bn1");
		
		//$sql3="DELETE FROM NOVEDADES_RMTO";

		$conn->Execute($sql1);	

		$conn->Execute($sql2);	

		//$conn->Execute($sql3);	

		echo 1;
		
}else{

	echo 2;
	
}
?>