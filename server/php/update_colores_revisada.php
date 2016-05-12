<?php 
require_once("../librerias/lib/connection.php");

global $conn;

$posicion=$_POST['posicion'];
$anio=$_POST['anio'];
$mes=$_POST['mes'];	
$color_mas=$_POST['color_mas'];
$cod_epl=$_POST['cod_epl'];		


/*
$sql0="SELECT (RTRIM(emp.nom_epl)+' '+RTRIM(emp.ape_epl)) as empleado, convert(varchar,hor_entr,108) as hor_entrada, convert(varchar,hor_sal,108) as hor_salida FROM prog_reloj_tur tur, empleados_basic emp where emp.cod_epl=tur.cod_epl and tur.cod_epl='".$cod_epl."' and tur.fecha='".$anio."-".$dia."-".$mes."'";

$rs0=$conn->Execute($sql0);	

$row0 = $rs0->fetchrow();

$empleado=$row0["empleado"];
$hor_entrada=$row0["hor_entrada"];
$hor_salida=$row0["hor_salida"];
*/


if($color_mas != null){
	
	$sql="update colores set color='".$color_mas."' where posicion='".$posicion."' and mes='".$mes."' and anio='".$anio."' and cod_epl='".$cod_epl."'";

	$conn->Execute($sql);

}else{

	$sql="update colores set color='#6D87DA' where posicion='".$posicion."' and mes='".$mes."' and anio='".$anio."' and cod_epl='".$cod_epl."'";

	$conn->Execute($sql);

}

echo 1;

?>