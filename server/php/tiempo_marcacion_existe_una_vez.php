<?php 
require_once("../librerias/lib/connection.php");

global $conn;


$cod_epl=$_POST['cod_epl'];
$mes=$_POST['mes'];	
$anio=$_POST['anio'];
$dia=$_POST['dia'];
$codigo_jefe=$_POST['codigo_jefe'];
$turno=$_POST['turno'];

$lista=array();


$sql0="SELECT (RTRIM(emp.nom_epl)+' '+RTRIM(emp.ape_epl)) as empleado, convert(varchar,hor_entr,108) as hor_entrada, convert(varchar,hor_sal,108) as hor_salida FROM prog_reloj_tur tur, empleados_basic emp where emp.cod_epl=tur.cod_epl and tur.cod_epl='".$cod_epl."' and tur.fecha='".$anio."-".$dia."-".$mes."'";

$rs0=$conn->Execute($sql0);	

$row0 = $rs0->fetchrow();


	
$empleado=$row0["empleado"];
@$hor_entrada=$row0["hor_entrada"];
@$hor_salida=$row0["hor_salida"];


//ME DEVUELVE LAS HORAS, HORA INICIO Y HORA FIN DEL TURNO REAL
				$sql2="select horas,hor_ini, hor_fin from turnos_prog where cod_tur='".$turno."'";
				$rs2=$conn->Execute($sql2);
       
				if($rs2->RecordCount() > 0){
               
					$row2= $rs2->fetchrow();
              
					$horas_turno_real=$row2['horas']; 
					$hor_ini_real=substr($row2["hor_ini"], 11, 5); 
					$hor_fin_real=substr($row2["hor_fin"], 11, 5);
							   
				}else{
					
					$sql3="select horas,hor_ini, hor_fin from turnos_prog_tmp where cod_tur='".$turno."'";
					$rs3=$conn->Execute($sql3);
					$row3= $rs3->fetchrow();
               		  			  
					$horas_turno_real=$row3['horas'];
					$hor_ini_real=substr($row3["hor_ini"], 11, 5);
					$hor_fin_real=substr($row3["hor_fin"], 11, 5);
									
				}


	
	$mensaje  = "<p style='text-align:center; color:rgb(41, 76, 139);font-weight: bold;'>".$empleado."</p>";
	$mensaje .= "<p style='color:rgb(41, 76, 139); margin-left:15px;'><span style='font-weight: bold;'>Fecha: </span>".$dia."-".$mes."-".$anio."</p>";
	$mensaje .= "<p style='color:rgb(41, 76, 139); margin-left:15px;'><span style='font-weight: bold;'>Turno Programado: </span>".$turno." - ".$hor_ini_real." - ".$hor_fin_real."</p>";
	$mensaje .= "<p style='color:rgb(41, 76, 139); margin-left:15px;'><span style='font-weight: bold;'>Marcaci&oacute;n del Reloj: </span>".$hor_entrada." - ".$hor_salida."</p>";			
	$mensaje .= "<input type='hidden' id='codigo_epl' value='".$cod_epl."' />"; 
	
	
	echo $mensaje;
?>	
