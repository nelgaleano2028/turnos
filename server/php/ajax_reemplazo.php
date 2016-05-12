<?php
require_once("../librerias/lib/connection.php");

global $conn;
//print_r($_POST);die();

$sql4="select * from  prog_mes_tur where cod_epl=".$_POST['supernume_tmp'];

$reg=$conn->Execute($sql4);

if($reg->RecordCount() > 0){
	
	$sql="update prog_mes_tur set cod_epl='".$_POST['reemplazo']."' where cod_epl='".$_POST['supernume_tmp']."'";

	$conn->Execute($sql);

	$sql3="update prog_mes_tur_ini set cod_epl='".$_POST['reemplazo']."' where cod_epl='".$_POST['supernume_tmp']."'";

	$conn->Execute($sql3);

	$sql2="delete supernumerario_tmp where Id='".$_POST['supernume_tmp']."'";

	$res2=$conn->Execute($sql2);
	
	if($res2){
		 echo 1;
	}else{
		 echo 2;
	}
	
}else{

	echo 3;
}
?>