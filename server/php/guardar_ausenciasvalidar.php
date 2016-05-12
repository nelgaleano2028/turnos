<?php session_start();


require_once("../librerias/lib/connection.php");

global $conn;



	// //VALIDAR SI EXISTE AUSENCIAS EN VD Y SI EXISTE SACAR MENSAJE QUE NO SE PUEDE GGUARDAR AUSENCIA
	// //****-----------******************
	
	if($_POST['modulo']=="VALIDARDATOSFEC_INI_R"){
		
		$fecha_ini_r = $_POST['fecha_ini_r'];
		
		$fecha_fin_r = $_POST['fecha_fin_r'];
		
		$mes = $_POST['mes'];
		
		$dia1 = $_POST['diaini'];
		
		$dia1 = substr($dia1, -2);
		
		$dia2 = $_POST['diafin'];
		
		$dia2 = substr($dia2, -2);
		
		if($dia1 == '13'){
			
			$td1 = 'Td13';
			
		}else if($dia1 == '01'){
			
			$td1 = 'Td1';
			
		}else if($dia1 == '02'){
			
			$td1 = 'Td2';
			
		}else if($dia1 == '03'){
			
			$td1 = 'Td3';
			
		}else if($dia1 == '04'){
			
			$td1 = 'Td4';
			
		}else if($dia1 == '05'){
			
			$td1 = 'Td5';
			
		}else if($dia1 == '06'){
			
			$td1 = 'Td6';
			
		}else if($dia1 == '07'){
			
			$td1 = 'Td7';
			
		}else if($dia1 == '08'){
			
			$td1 = 'Td8';
			
		}else if($dia1 == '09'){
			
			$td1 = 'Td9';
			
		}else if($dia1 == '10'){
			
			$td1 = 'Td10';
			
		}else if($dia1 == '11'){
			
			$td1 = 'Td11';
			
		}else if($dia1 == '12'){
			
			$td1 = 'Td12';
			
		}else if($dia1 == '14'){
			
			$td1 = 'Td14';
			
		}else if($dia1 == '15'){
			
			$td1 = 'Td15';
			
		}else if($dia1 == '16'){
			
			$td1 = 'Td16';
			
		}else if($dia1 == '17'){
			
			$td1 = 'Td17';
			
		}else if($dia1 == '18'){
			
			$td1 = 'Td18';
			
		}else if($dia1 == '19'){
			
			$td1 = 'Td19';
			
		}else if($dia1 == '20'){
			
			$td1 = 'Td20';
			
		}else if($dia1 == '21'){
			
			$td1 = 'Td21';
			
		}else if($dia1 == '22'){
			
			$td1 = 'Td22';
			
		}else if($dia1 == '23'){
			
			$td1 = 'Td23';
			
		}else if($dia1 == '24'){
			
			$td1 = 'Td24';
			
		}else if($dia1 == '25'){
			
			$td1 = 'Td25';
			
		}else if($dia1 == '26'){
			
			$td1 = 'Td26';
			
		}else if($dia1 == '27'){
			
			$td1 = 'Td27';
			
		}else if($dia1 == '28'){
			
			$td1 = 'Td28';
			
		}else if($dia1 == '29'){
			
			$td1 = 'Td29';
			
		}else if($dia1 == '30'){
			
			$td1 = 'Td30';
			
		}else if($dia1 == '31'){
			
			$td1 = 'Td31';
			
		}

		
		if($dia2 == '13'){
			
			$td2 = 'Td13';
			
		}else if($dia2 == '01'){
			
			$td2 = 'Td1';
			
		}else if($dia2 == '02'){
			
			$td2 = 'Td2';
			
		}else if($dia2 == '03'){
			
			$td2 = 'Td3';
			
		}else if($dia2 == '04'){
			
			$td2 = 'Td4';
			
		}else if($dia2 == '05'){
			
			$td2 = 'Td5';
			
		}else if($dia2 == '06'){
			
			$td2 = 'Td6';
			
		}else if($dia2 == '07'){
			
			$td2 = 'Td7';
			
		}else if($dia2 == '08'){
			
			$td2 = 'Td8';
			
		}else if($dia2 == '09'){
			
			$td2 = 'Td9';
			
		}else if($dia2 == '10'){
			
			$td2 = 'Td10';
			
		}else if($dia2 == '11'){
			
			$td2 = 'Td11';
			
		}else if($dia2 == '12'){
			
			$td2 = 'Td12';
			
		}else if($dia2 == '14'){
			
			$td2 = 'Td14';
			
		}else if($dia2 == '15'){
			
			$td2 = 'Td15';
			
		}else if($dia2 == '16'){
			
			$td2 = 'Td16';
			
		}else if($dia2 == '17'){
			
			$td2 = 'Td17';
			
		}else if($dia2 == '18'){
			
			$td2 = 'Td18';
			
		}else if($dia2 == '19'){
			
			$td2 = 'Td19';
			
		}else if($dia2 == '20'){
			
			$td2 = 'Td20';
			
		}else if($dia2 == '21'){
			
			$td2 = 'Td21';
			
		}else if($dia2 == '22'){
			
			$td2 = 'Td22';
			
		}else if($dia2 == '23'){
			
			$td2 = 'Td23';
			
		}else if($dia2 == '24'){
			
			$td2 = 'Td24';
			
		}else if($dia2 == '25'){
			
			$td2 = 'Td25';
			
		}else if($dia2 == '26'){
			
			$td2 = 'Td26';
			
		}else if($dia2 == '27'){
			
			$td2 = 'Td27';
			
		}else if($dia2 == '28'){
			
			$td2 = 'Td28';
			
		}else if($dia2 == '29'){
			
			$td2 = 'Td29';
			
		}else if($dia2 == '30'){
			
			$td2 = 'Td30';
			
		}else if($dia2 == '31'){
			
			$td12 = 'Td31';
			
		}else{
			
			$selectT= "*";
			
		}
		
		$selectT = $td1.",".$td2;

		
		$mes1 = str_replace("0", "", $mes);

		$sqlvalidate="select ".$selectT."
		from prog_mes_tur
		where cod_epl = '".$_POST['cod_epl']."' and mes = '".$mes1."'  ";

	 //var_dump($sqlvalidate);
	
	$rs = $conn->Execute($sqlvalidate);

	$fila=$rs->FetchRow();
	
	echo $mes=strip_tags(@$fila['Mes']).",";
	echo $Td1=strip_tags(@$fila['Td1']).",";
	echo $Td2=strip_tags(@$fila['Td2']).",";
	echo $Td3=strip_tags(@$fila['Td3']).",";
	echo $Td4=strip_tags(@$fila['Td4']).",";
	echo $Td5=strip_tags(@$fila['Td5']).",";
	echo $Td6=strip_tags(@$fila['Td6']).",";
	echo $Td7=strip_tags(@$fila['Td7']).",";
	echo $Td8=strip_tags(@$fila['Td8']).",";
	echo $Td9=strip_tags(@$fila['Td9']).",";
	echo $Td10=strip_tags(@$fila['Td10']).",";
	echo $Td11=strip_tags(@$fila['Td11']).",";
	echo $Td12=strip_tags(@$fila['Td12']).",";
	echo $Td13=strip_tags(@$fila['Td13']).",";
	echo $Td14=strip_tags(@$fila['Td14']).",";
	echo $Td15=strip_tags(@$fila['Td15']).",";
	echo $Td16=strip_tags(@$fila['Td16']).",";
	echo $td17=strip_tags(@$fila['Td17']).",";
	echo $Td18=strip_tags(@$fila['Td18']).",";
	echo $Td19=strip_tags(@$fila['Td19']).",";
	echo $Td20=strip_tags(@$fila['Td20']).",";
	echo $Td21=strip_tags(@$fila['Td21']).",";
	echo $Td22=strip_tags(@$fila['Td22']).",";
	echo $Td23=strip_tags(@$fila['Td23']).",";
	echo $Td24=strip_tags(@$fila['Td24']).",";
	echo $Td25=strip_tags(@$fila['Td25']).",";
	echo $Td26=strip_tags(@$fila['Td26']).",";
	echo $Td27=strip_tags(@$fila['Td27']).",";
	echo $Td28=strip_tags(@$fila['Td28']).",";
	echo $Td29=strip_tags(@$fila['Td29']).",";
	echo $Td30=strip_tags(@$fila['Td30']).",";
	echo $Td31=strip_tags(@$fila['Td31']);

 // die();
	

}
	
	
	//***********************************
	//END QUERY VALIDAR AUSENCIAS
	

	
	
	if($_POST['modulo']=="ACTUALIZARFECHAREALAUS"){
		
		$fecha_ini_real = $_POST['aniocompleto'];
		
		$cod_epl = $_POST['cod_epl'];
		
		$tabla = $_POST['tabla'];
		
		
		$sqlupdatefecha="UPDATE $tabla set fec_ini_r =  convert(datetime, '".$fecha_ini_real."',121)
		where cod_epl = '".$cod_epl."'  ";

		
		
		
		
		
		// var_dump($sqlupdatefecha); 
		
		$rs = $conn->Execute($sqlupdatefecha);

		$fila=$rs->FetchRow();
		
		//echo $mes=strip_tags(@$fila['cod_con']).",";

		

		
		
 // die();
	

}
	
		
	
	if($_POST['modulo']=="TRAERFECHAINIFINDIAS"){
		
		$cod_epl = $_POST['cod_epl'];
		
		$tabla = $_POST['tabla'];
		
		$sqltraerfechadias="select fec_ini_r, fec_fin_r from $tabla
		where cod_epl = '".$cod_epl."' and cod_con in ('11','9000')  ";

		//var_dump($sqltraerfechadias);

		// var_dump($sqltraerfechadias); 
		
		$rs = $conn->Execute($sqltraerfechadias);

		$fila=$rs->FetchRow();
		
		//echo "holaa";
		
       echo $aniocompletoini = strip_tags(@$fila['fec_ini_r']).",";
	   
	   echo $aniocompletofin = strip_tags(@$fila['fec_fin_r']).",";

 // die();
	

}
		
	
	if($_POST['modulo']=="UPDATEFECHASUMADOSDIAS"){
		
		$cod_epl = $_POST['cod_epl'];
		
		$fechacompletasumasdias = $_POST['fechacompletasumasdias'];
		
		$tabla = $_POST['tabla'];
		
		
		$sqlupdatediasresult="UPDATE $tabla set fec_fin_r = convert(datetime, '".$fechacompletasumasdias."',121)
		where cod_epl = '".$cod_epl."' and  cod_con in ('11','9000')  ";

		//var_dump($sqlupdatediasresult);
		
		$rs = $conn->Execute($sqlupdatediasresult);

		$fila=$rs->FetchRow();
		
 // die();
	
}


	if($_POST['modulo']=="UPDATEFECHASUMADOSDIASULTIMOS"){
		
		$cod_epl = $_POST['cod_epl'];
		
		$fechaCompletaValidarMes = $_POST['fechaCompletaValidarMes'];
		
		$tabla = $_POST['tabla'];
		
		
		$sqlupdatediasresult="UPDATE $tabla set fec_fin_r = convert(datetime, '".$fechaCompletaValidarMes."',121)
		where cod_epl = '".$cod_epl."' and  cod_con in ('11','9000')  ";

		//var_dump($sqlupdatediasresult);
		
		$rs = $conn->Execute($sqlupdatediasresult);

		$fila=$rs->FetchRow();
		
 // die();
	
}

	if($_POST['modulo']=="ACTUALIZARFECHACUANDOSEPASADEMES"){
		
		$cod_epl = $_POST['cod_epl'];
		
		$fechaCompletaUnMesMas = $_POST['fechaCompletaUnMesMas'];
		
		$tabla = $_POST['tabla'];
		
		
		$sqlupdatediasresult2="UPDATE $tabla set fec_fin_r = convert(datetime, '".$fechaCompletaUnMesMas."',121)
		where cod_epl = '".$cod_epl."' and  cod_con in ('11','9000')  ";

		//var_dump($sqlupdatediasresult2);
		
		$rs = $conn->Execute($sqlupdatediasresult2);

		$fila=$rs->FetchRow();
		
 // die();
	
}


	if($_POST['modulo']=="INSERTARPROGMESTURNEW"){
		
		$cod_epl = $_POST['cod_epl'];
		
		$tdCompleto = $_POST['tdCompleto'];
		
		$mes = $_POST['mes'];

		if($mes == '01'){$mes = '1';}elseif($mes == '02'){$mes = '2';}elseif($mes == '03'){$mes = '3';} elseif($mes == '04'){$mes = '4';} elseif($mes == '05'){$mes = '5';} elseif($mes == '06'){$mes = '6';} elseif($mes == '07'){$mes = '7';} elseif($mes == '08'){$mes = '8';} elseif($mes == '09'){$mes = '9';}  

	    $ausenciaUpdate = $_POST['ausenciaUpdate'];

		foreach($_GET as $clave => $valor){
				@$campos_p.="$clave = '$ausenciaUpdate', ";
			}
			 $campos_p = substr($campos_p, 0, -2);

			 $campos_p = str_replace("_", " ", $campos_p);
			
		//print_r($campos_p);
		
		$sqlupdatediasprogmestur="UPDATE prog_mes_tur set $campos_p
		where cod_epl = '".$cod_epl."' and mes = '".$mes."' ";

		//var_dump($sqlupdatediasprogmestur);
		
		$rs = $conn->Execute($sqlupdatediasprogmestur);

		$fila=$rs->FetchRow();
		
 // die();
	
}


//VERIFICAR SI HAY DATOS EN EL MES SIGUIENTE SI HAY DATOS SE DEBE ACTUALIZAR SI NO HAY DATOS SE DEBE INSERTAR DATO


if($_POST['modulo']=="VERIFICARSIHAYDATOSENMESSIGUIENTE"){
		
		$cod_epl = $_POST['cod_epl'];
		
		$tabla = $_POST['tabla'];		
		
		$mes = $_POST['mes'];
		
		// $sqlverificardatos="select * from PROG_MES_TUR
		// where cod_epl = '".$cod_epl."' and mes = '".$mes."'  ";
		
		
		$sqlverificardatos="SELECT ROW_NUMBER() OVER(ORDER BY cod_epl DESC) AS datos from PROG_MES_TUR
		where cod_epl = '".$cod_epl."' and mes = '".$mes."' ";
		
		//var_dump($sqlverificardatos);
		
		$rs = $conn->Execute($sqlverificardatos);

		$fila=$rs->FetchRow();
		
		$datos = @$fila['datos'];
		
	    if($datos >= '1'){
			  echo "True";
		}else{
			  echo "False";
		} 
		

}




//TRAER DATOS PARA INSERTAR EN EL SIGUEIENTE QUERY



if($_POST['modulo']==="TRAERDATOSPARAINSERTARENELAJAXQVIENE"){
		
		$cod_epl = $_POST['cod_epl'];
		
		$tabla = $_POST['tabla'];	

        $mes = $_POST['mes'];		
		
		$sqltraerdatosdatos="SELECT * from PROG_MES_TUR
		where cod_epl = '".$cod_epl."' and mes = '".$mes."' ";
		
		//var_dump($sqltraerdatosdatos);
		
		
		
		$rs = $conn->Execute($sqltraerdatosdatos);

		$fila=$rs->FetchRow();
		
		echo $cod_ciclo = @$fila['cod_ciclo'].",";
		echo $cod_ciclo2 = @$fila['cod_ciclo2'].",";
		echo $cod_ciclo3 = @$fila['cod_ciclo3'].",";
		echo $cod_ciclo4 = @$fila['cod_ciclo4'].",";
		echo $cod_ciclo5 = @$fila['cod_ciclo5'].",";
		echo $id = @$fila['ID'].",";
		echo $sem1 = @$fila['sem1'].",";
		echo $sem2 = @$fila['sem2'].",";
		echo $sem3 = @$fila['sem3'].",";
		echo $sem4 = @$fila['sem4'].",";
		echo $sem5 = @$fila['sem5'].",";
		echo $sem6 = @$fila['sem6'].",";
		echo $cod_ciclo6 = @$fila['cod_ciclo6'].",";
		echo $cod_cc2 = @$fila['cod_cc2'].",";
		echo $cod_car = @$fila['cod_car'].",";
		echo $cod_epl_jefe = @$fila['cod_epl_jefe'];
		
	
		
		

}










if($_POST['modulo']=="INSERTARDATOSENPROGMESTUR"){
		
		$cod_epl = $_POST['cod_epl'];
		
		//$tabla = $_POST['tabla'];		
		
		$mes = $_POST['mes'];
		
		$anio = $_POST['anio'];
		
		$tiposql = $_POST['tiposql'];
		
		$resulTDCompleto = $_POST['resultdcompleto'];
		
		$arrayDatos = explode(",", $resulTDCompleto);
		
		//print_r($arrayDatos);
		
		$cod_ciclo = $arrayDatos[0];
		
		$cod_ciclo2 = $arrayDatos[1];
		
		$cod_ciclo3 = $arrayDatos[2];
		
		$cod_ciclo4 = $arrayDatos[3];
		
		$cod_ciclo5 = $arrayDatos[4];
		
		$id = $arrayDatos[5];
		
		$sem1 = $arrayDatos[6];
		
		$sem2 = $arrayDatos[7];
		
		$sem3 = $arrayDatos[8];
		
		$sem4 = $arrayDatos[9];
		
		$sem5 = $arrayDatos[10];
		
		$sem6 = $arrayDatos[11];
		
		$cod_ciclo6 = $arrayDatos[12];
		
		$cod_cc2 = $arrayDatos[13];
		
		$cod_car = $arrayDatos[14];
		
		$cod_epl_jefe = $arrayDatos[15];	
		
		echo $ausenciaUpdate = $_POST['ausencia'];
		
		
		//die("ggggggggg DEATHH");
		
		$datosllenar = $_POST['resultado'];
			
		$arrayTd = explode(",", $datosllenar);
		
		echo $contarTd = count($arrayTd);
		
	
		if($contarTd == "4"){
			
			$camposTd = "Td1, Td2, Td3, Td4";
			
			$valoresTd = "'$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		
		elseif($contarTd == "6"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5, Td6";
			
			$valoresTd = "'$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		elseif($contarTd == "3"){
			
			$camposTd = "Td1, Td2, Td3";
			
			$valoresTd = "'$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		elseif($contarTd == "2"){
			
			$camposTd = "Td1, Td2";
			
			$valoresTd = "'$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		elseif($contarTd == "1"){
			
			$camposTd = "Td1";
			
			$valoresTd = "'$ausenciaUpdate' ";
			
		}
		
		elseif($contarTd == "5"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5";
			
			$valoresTd = " '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		elseif($contarTd == "7"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5, Td6, Td7";
			
			$valoresTd = " '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		elseif($contarTd == "8"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5, Td6, Td7, Td8";
			
			$valoresTd = " '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		elseif($contarTd == "9"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5, Td6, Td7, Td8, Td9";
			
			$valoresTd = " '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		elseif($contarTd == "10"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5, Td6, Td7, Td8, Td9, Td10";
			
			$valoresTd = " '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		elseif($contarTd == "11"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5, Td6, Td7, Td8, Td9, Td10, Td11";
			
			$valoresTd = " '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		elseif($contarTd == "12"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5, Td6, Td7, Td8, Td9, Td10, Td11, Td12";
			
			$valoresTd = " '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate'";
			
		}
		
		
		elseif($contarTd == "13"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5, Td6, Td7, Td8, Td9, Td10, Td11, Td12, Td13";
			
			$valoresTd = " '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		elseif($contarTd == "14"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5, Td6, Td7, Td8, Td9, Td10, Td11, Td12, Td13, Td14";
			
			$valoresTd = " '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		
		
		elseif($contarTd == "15"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5, Td6, Td7, Td8, Td9, Td10, Td11, Td12, Td13, Td14, Td15";
			
			$valoresTd = " '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate'  ";
			
		}
		
		
		elseif($contarTd == "16"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5, Td6, Td7, Td8, Td9, Td10, Td11, Td12, Td13, Td14, Td15, Td16";
			
			$valoresTd = " '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		
		elseif($contarTd == "17"){
			
			$camposTd = "Td1, Td2, Td3, Td4, Td5, Td6, Td7, Td8, Td9, Td10, Td11, Td12, Td13, Td14, Td15, Td16, Td17";
			
			$valoresTd = " '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate', '$ausenciaUpdate' ";
			
		}
		
		
		
		
		
		if($tiposql == "SIDATO"){
			
			
			// foreach($_GET as $clave => $valor){
				// @$campos_p.="$clave = '$valor_p', ";
			// }
			
			// foreach($camposTd => $valor){
				// @$campos_p.="$clave = '$valoresTd', ";
			// }
			
			
			 // $campos_p = substr($campos_p, 0, -2);
			 
			 
			 // var_dump($campos_p);

			 //$campos_p = str_replace("_", " ", $campos_p);		
			
			// $sqlinsertardatos="UPDATE  ";
			
			// var_dump($sqlinsertardatos);die("------------DEath");
			
			// $rs = $conn->Execute($sqlinsertardatos);

		    // $fila=$rs->FetchRow();
			
			
		}else{
			
				
			$sqlinsertardatos="insert into prog_mes_tur (cod_epl, mes, $camposTd, Ano, cod_ciclo, cod_ciclo2, cod_ciclo3, cod_ciclo4, cod_ciclo5, sem1, sem2, sem3, sem4, sem5, sem6, cod_ciclo6, cod_cc2, cod_car, cod_epl_jefe) VALUES('".$cod_epl."', '".$mes."', $valoresTd, '".$anio."', '".$cod_ciclo."', '".$cod_ciclo2."', '".$cod_ciclo3."', '".$cod_ciclo4."', '".$cod_ciclo5."', '".$sem1."', '".$sem2."', '".$sem3."', '".$sem4."', '".$sem5."', '".$sem6."', '".$cod_ciclo6."', '".$cod_cc2."', '".$cod_car."', '".$cod_epl_jefe."' ) ";
			
			//var_dump($sqlinsertardatos);//die("------------DEath");
			
			
			//die("Muerte........");
			
			
			
			$rs = $conn->Execute($sqlinsertardatos);

		    $fila=$rs->FetchRow();
			
			
		}
		
	
		
		

}








	
?>