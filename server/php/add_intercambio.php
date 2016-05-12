<?php
require_once("../librerias/lib/connection.php");

global $conn;

$dia=$_POST['dia'];
$mes=$_POST['mes'];
$anio=$_POST['anio'];
$fecha=date('Y-d-m',time());// fecha para la tabla prog_ novedades que esta con formato año-dia-mes

//$fecha=$anio."-".$dia."-".$mes; 

$resta1=semana($dia,$mes,$anio,$_POST['turno1'],$_POST['turno2'],$_POST['cod_epl1'],$_POST['cod_cc2'],$_POST['cod_car'],$_POST['jefe']);

$sql="update prog_mes_tur set td".$_POST['dia']."='".$_POST['turno2']."', sem".$resta1['contador']."=".$resta1['resta']." where cod_epl='".$_POST['cod_epl1']."' and mes='".$_POST['mes']."' and ano='".$_POST['anio']."' and 
     cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."' and cod_epl_jefe='".$_POST['jefe']."'";
$rs=$conn->Execute($sql);

$resta2=semana($dia,$mes,$anio,$_POST['turno2'],$_POST['turno1'],$_POST['cod_epl2'],$_POST['cod_cc2'],$_POST['cod_car'],$_POST['jefe']);

$sql2="update prog_mes_tur set td".$_POST['dia']."='".$_POST['turno1']."', sem".$resta2['contador']."=".$resta2['resta']." where cod_epl='".$_POST['cod_epl2']."' and mes='".$_POST['mes']."' and ano='".$_POST['anio']."' and 
     cod_cc2='".$_POST['cod_cc2']."' and cod_car='".$_POST['cod_car']."' and cod_epl_jefe='".$_POST['jefe']."'";
	 

$rs2=$conn->Execute($sql2);



$sql8="insert into prog_novedades values('".$_POST['cod_epl1']."','".$anio."','".$mes."','El empleado ".$_POST['nom1']." cambia turno con el empleado ".$_POST['nom2']."','".$_POST['jefe']."',convert(varchar,'$fecha 00:00:00.000',121),1)";

$conn->Execute($sql8);

		
$sql9="insert into prog_novedades values('".$_POST['cod_epl1']."','".$anio."','".$mes."','El empleado ".$_POST['nom2']." realizar&aacute; un reemplazo  al empleado  ".$_POST['nom1']." por motivo de cambio de turno','".$_POST['jefe']."',convert(varchar,'$fecha 00:00:00.000',121),5)";
//var_dump($sql); die();
$rs9=$conn->Execute($sql9);


	 
if($rs9){			
 echo  $respuesta="<span class='mensajes_success'>Se ingreso correctamente.</span>";
}else{				
 echo $respuesta="<span class='mensajes_error'>Error al Ingresar los registros.</span>";
}


function semana($dia,$mes,$anio,$turno1,$turno2,$cod_epl,$cod_cc2,$cod_car,$jefe){

	global $conn;
	
	$con_sem=1;

	for ($j=1;$j<=$dia;$j++){
		
		$domingo=(int)date('N',strtotime($j."-".$mes."-".$anio));
		
		if($domingo==7 && $j != $dia){
			$con_sem++;
		}else if($j==$dia && $j != $domingo){
			$con_sem++;	
		}
	}
	
	$horas=verificar_turno($turno1,$turno2);

	$sql3="select ((sem".$con_sem." - ".$horas['horas1'].")+ ".$horas['horas2'].")as resta from prog_mes_tur where cod_epl='".$cod_epl."' and mes='".$mes."' and ano='".$anio."' and 
		   cod_cc2='".$cod_cc2."' and cod_car='".$cod_car."' and cod_epl_jefe='".$jefe."'";
	$rs3=$conn->Execute($sql3);
	$row = $rs3->fetchrow();
	return $retorno=array('resta'=>abs($row['resta']),'contador'=>$con_sem);
}

function verificar_turno($turno1,$turno2){

	global $conn;
	
	$sql4="select horas from turnos_prog where cod_tur='".$turno1."'";
	$rs4=$conn->Execute($sql4);
	
	if($rs4->RecordCount() > 0){
		
		$row4= $rs4->fetchrow();
		$horas1=$row4['horas'];
	}else{
		$sql5="select horas from turnos_prog_tmp where cod_tur='".$turno1."'";
		$rs5=$conn->Execute($sql5);
		$row5= $rs5->fetchrow();
		$horas1=$row5['horas'];
	}
	
	$sql6="select horas from turnos_prog where cod_tur='".$turno2."'";
	$rs6=$conn->Execute($sql6);
	
	if($rs6->RecordCount() > 0){
		
		$row6= $rs6->fetchrow();
		$horas2=$row6['horas'];
	}else{
		$sql7="select horas from turnos_prog_tmp where cod_tur='".$turno2."'";
		$rs7=$conn->Execute($sql7);
		$row7= $rs7->fetchrow();
		$horas2=$row7['horas'];
	}
	
	return $retorno=array('horas1'=>$horas1,'horas2'=>$horas2);
}
?>