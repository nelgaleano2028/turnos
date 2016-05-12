<?php
require_once("class_programacion.php");

$programacion = new programacion();
 
$contar=array();
$contar=json_decode(json_decode($_POST["arreglo"],true),true);



$codigo=$contar[0]["cod_epl"];
$mes=($contar[0]["Mes"]+1);
$ano=$contar[0]["Ano"];
	
$T1=$contar[0][1];
$T2=$contar[0][2];
$T3=$contar[0][3];
$T4=$contar[0][4];
$T5=$contar[0][5];
$T6=$contar[0][6];
$T7=$contar[0][7];
$T8=$contar[0][8];
$T9=$contar[0][9];
$T10=$contar[0][10];
$T11=$contar[0][11];
$T12=$contar[0][12];
$T13=$contar[0][13];
$T14=$contar[0][14];
$T15=$contar[0][15];
$T16=$contar[0][16];
$T17=$contar[0][17];
$T18=$contar[0][18];
$T19=$contar[0][19];
$T20=$contar[0][20];
$T21=$contar[0][21];
$T22=$contar[0][22];
$T23=$contar[0][23];
$T24=$contar[0][24];
$T25=$contar[0][25];
$T26=$contar[0][26];
$T27=$contar[0][27];
$T28=$contar[0][28];
$T29=$contar[0][29];
$T30=$contar[0][30];
$T31=$contar[0][31];

/*
$T32=$contar[0][32];
$T33=$contar[0][33];
$T34=$contar[0][34];
$T35=$contar[0][35];
$T36=$contar[0][36];
$T37=$contar[0][37];
$T38=$contar[0][38];
$T39=$contar[0][39];
*/

$cod_ciclo=$contar[0]["cod_ciclo"];
$cod_ciclo2=$contar[0]["cod_ciclo2"];
$cod_ciclo3=$contar[0]["cod_ciclo3"];
$cod_ciclo4=$contar[0]["cod_ciclo4"];
$cod_ciclo5=$contar[0]["cod_ciclo5"];
$cod_ciclo6=$contar[0]["cod_ciclo6"];	

			
$respuesta=$programacion->insertar_programacion($codigo, $mes, $T1, $T2, $T3, $T4, $T5, $T6, $T7, $T8, $T9, $T10, $T11, $T12, $T13, $T14, $T15, $T16, $T17, $T18, $T19, $T20, $T21, $T22, $T23, $T24, $T25, $T26, $T27, $T28, $T29, $T30, $T31, $ano, $cod_ciclo, $cod_ciclo2, $cod_ciclo3, $cod_ciclo4, $cod_ciclo5, $cod_ciclo6, $contar[0]["sem1"], $contar[0]["sem2"], $contar[0]["sem3"], $contar[0]["sem4"],$contar[0]["sem5"],$contar[0]["sem6"], $contar[0]["cod_cc2"], $contar[0]["cod_car"], $contar[0]["cod_epl_jefe"]);

echo $respuesta;
			
?>