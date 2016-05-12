<?php
require_once("class_empleado.php");

$obj= new empleado($_POST['cod_epl']);

$datos=$obj->add_tmp_aus($_POST['cod_con'],$_POST['cod_epl'],$_POST['fec_ini'],$_POST['fec_fin'],$_POST['cod_cc2'],$_POST['cod_car'],$_POST['cod_jefe']);
if($datos==1){
    
    echo 1;
}else{
    
    echo 2;
}
?>