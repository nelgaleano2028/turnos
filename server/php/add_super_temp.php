<?php
require_once("../librerias/lib/connection.php");

global $conn;

$sql="insert into supernumerario_tmp(nombre,cod_car,cod_cc2,cod_epl_jefe,ano,mes)
	  values('".$_POST['nombre']."','".$_POST['cod_car']."','".$_POST['cod_cc2']."','".$_POST['cod_epl_jefe']."','".$_POST['ano']."','".$_POST['mes']."')";
	  
$rs1=$conn->Execute($sql);

if($rs1){ echo "1";}else{echo "2";}

?>