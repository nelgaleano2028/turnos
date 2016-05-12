<?php session_start();
require_once("../librerias/lib/connection.php");

$anio=$_POST['anio']; 
$mes=$_POST['mes'];
$cargo=$_POST['cargo'];
$centro_costo=$_POST['cc'];


$perfil=$_SESSION['usuario']; 


//$perfil=$_SESSION['nom']; //pERFIL JEFE

include("tabla_programacion.php");

echo $html;
?>