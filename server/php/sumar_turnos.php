<?php session_start();
require_once("../librerias/lib/connection.php");

 global $conn;

 
$total=0;

$suma=array();

$ver=$_POST["arreglo"];



$total_suma=0;

for($i=0;$i<count($_POST["arreglo"]);$i++){
$sql="select count(cod_tur)as CUANTOS from turnos_prog where cod_tur=".$_POST["arreglo"][$i]."";
$res=$conn->Execute($sql);
$row=$res->FetchRow();
$cuantos=(int)$row['CUANTOS'];

if($cuantos > 0){
	
	$sql2="select horas from turnos_prog where cod_tur=".$_POST["arreglo"][$i]."";
	$res2=$conn->Execute($sql2);
    $row2=$res2->FetchRow();
	$suma=(double)$row2['horas'];
}

$sql3="select count(cod_tur)as CUANTOS from turnos_prog_tmp where cod_tur=".$_POST["arreglo"][$i]." AND cod_cargo ='".$_SESSION['cod_epl']."'";
$res3=$conn->Execute($sql3);
$row3=$res3->FetchRow();
$cuantos2=(int)$row3['CUANTOS'];

if( $cuantos2 > 0){
	$sql4="select horas from turnos_prog_tmp where cod_tur=".$_POST["arreglo"][$i]." AND cod_cargo ='".$_SESSION['cod_epl']."'";
	$res4=$conn->Execute($sql4);
    $row4=$res4->FetchRow();
	$suma=(double)$row4['horas'];
}

if($cuantos== 0 && $cuantos2==0){
	$suma=0;
}

$total_suma+=$suma;

}

 echo $total_suma;