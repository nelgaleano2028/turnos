<?php
session_start();

require_once("../librerias/lib/connection.php");

$sql2="select usuario from acc_usuariosTurnosWeb where cod_epl= (select cod_jefe from empleados_gral where cod_epl='".$_SESSION['cod']."')";

$rs2=$conn->Execute($sql2);
$fila=$rs2->fetchrow();
$perfil=@$fila['usuario']; 



if($perfil==NULL){

echo 1;
}else{

echo 2;
}


?>