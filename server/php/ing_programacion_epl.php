<?php

require_once("class_programacion.php");

$programacion = new programacion();

	$mes=$_POST["mes"]; //7
	
	$codigo=$_POST["cod_epl"];
	
	$ano=$_POST["anio"];
	
	$cod_cc2=$_POST["cod_cc2"];
	$cod_car=$_POST["cod_car"];
	$cod_epl_jefe=$_POST["cod_epl_jefe"];

	$arreglo=array();
		
	$arreglo[]=$_POST["arreglo"];
	
	$contar=array();
	for($i=0;$i<count($_POST["arreglo"]);$i++){
		
		
		if($arreglo[0][$i] != 'X' &&  $arreglo[0][$i] != $arreglo[0][0] &&  $arreglo[0][$i] != $arreglo[0][8] &&  $arreglo[0][$i] != $arreglo[0][9]
		&&  $arreglo[0][$i] != $arreglo[0][17] &&  $arreglo[0][$i] != $arreglo[0][18] &&  $arreglo[0][$i] != $arreglo[0][26] &&  $arreglo[0][$i] != $arreglo[0][27]
		&&  $arreglo[0][$i] != $arreglo[0][35] &&  $arreglo[0][$i] != $arreglo[0][36] &&  $arreglo[0][$i] != $arreglo[0][44] &&  $arreglo[0][$i] != $arreglo[0][45]
		&&  $arreglo[0][$i] != $arreglo[0][53]){
		   
			$contar[]=$arreglo[0][$i];
		}else if($arreglo[0][$i]== 'R'){
		
			$contar[]=$arreglo[0][$i];
			
		}else if($arreglo[0][$i]== 'N'){
			$contar[]=$arreglo[0][$i];
		}	
	}
	
	
	$T1=$contar[0];
	$T2=$contar[1];
	$T3=$contar[2];
	$T4=$contar[3];
	$T5=$contar[4];
	$T6=$contar[5];
	$T7=$contar[6];
	$T8=$contar[7];
	$T9=$contar[8];
	$T10=$contar[9];
	$T11=$contar[10];
	$T12=$contar[11];
	$T13=$contar[12];
	$T14=$contar[13];
	$T15=$contar[14];
	$T16=$contar[15];
	$T17=$contar[16];
	$T18=$contar[17];
	$T19=$contar[18];
	$T20=$contar[19];
	$T21=$contar[20];
	$T22=$contar[21];
	$T23=$contar[22];
	$T24=$contar[23];
	$T25=$contar[24];
	$T26=$contar[25];
	$T27=$contar[26];
	
	if(@$contar[27]==NULL){
		$T28='X';
	}else{
		$T28=@$contar[27];
	}
	
	if(@$contar[28]==NULL){
		$T29='X';
	}else{
		$T29=@$contar[28];
	}
	
	if(@$contar[29]==NULL){
		$T30='X';
	}else{
		$T30=@$contar[29];
	}
	
	if(@$contar[30]==NULL){
		$T31='X';
	}else{
		$T31=@$contar[30];
	}
	
	
	$cod_ciclo=$arreglo[0][0];
	$cod_ciclo2=$arreglo[0][9];
	$cod_ciclo3=$arreglo[0][18];
	$cod_ciclo4=$arreglo[0][27];
	$cod_ciclo5=$arreglo[0][36];
	$cod_ciclo6=$arreglo[0][45];
	
	
	$sem1=(int)$arreglo[0][8];
	$sem2=(int)$arreglo[0][17];
	$sem3=(int)$arreglo[0][26];
	$sem4=(int)$arreglo[0][35];
	$sem5=(int)$arreglo[0][44];
	$sem6=(int)$arreglo[0][53];
	
	
	
    $respuesta=$programacion->insertar_programacion($codigo, $mes, $T1, $T2, $T3, $T4, $T5, $T6, $T7, $T8, $T9, $T10, $T11, $T12, $T13, $T14, $T15, $T16, $T17, $T18, $T19, $T20, $T21, $T22, $T23, $T24, $T25, $T26, $T27, $T28, $T29, $T30, $T31, $ano, $cod_ciclo, $cod_ciclo2, $cod_ciclo3, $cod_ciclo4, $cod_ciclo5, $cod_ciclo6, $sem1, $sem2, $sem3, $sem4, $sem5, $sem6,$cod_cc2,$cod_car,$cod_epl_jefe);
												
	echo $respuesta;
	
?>