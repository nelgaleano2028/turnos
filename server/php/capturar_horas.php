<?php
require_once('class_ciclos.php');

$obj=new ciclos();
$datos=$obj->capatura_horas_tur($_POST['td1'],$_POST['td2'],$_POST['td3'],$_POST['td4'],$_POST['td5'],$_POST['td6'],$_POST['td7']);

echo json_encode(array("turnos"=>$datos));

?>