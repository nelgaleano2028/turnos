<?php 
require_once("../librerias/lib/connection.php");

global $conn;

//METODO que devuelve en horas y minutos la cantidad de segundos enviados
function conversor_segundos($seg_ini) {
				$horas = floor($seg_ini/3600);
				$minutos = floor(($seg_ini-($horas*3600))/60);
				return $horas."h:".$minutos."m";
}

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
$hor_entrada=$row0["hor_entrada"];
$hor_salida=$row0["hor_salida"];

$sql="SELECT hed_rel, hen_rel, hedf_rel, henf_rel, hfd_rel, rno_rel, rnf_rel FROM prog_reloj_he where cod_epl='".$cod_epl."' and cod_epl_jefe='".$codigo_jefe."' and fecha='".$anio."-".$dia."-".$mes."'";

$rs1=$conn->Execute($sql);


//ME DEVUELVE LAS HORAS, HORA INICIO Y HORA FIN DEL TURNO REAL
				$sql2="select horas,hor_ini, hor_fin from turnos_prog where cod_tur='".$turno."'";
				$rs2=$conn->Execute($sql2);
       
				if($rs2->RecordCount() > 0){
               
					$row2= $rs2->fetchrow();
              
					$horas_turno_real=$row2['horas']; 
					@$hor_ini_real=substr(@$row2["hor_ini"], 11, 5); 
					@$hor_fin_real=substr(@$row2["hor_fin"], 11, 5);
							   
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
	$mensaje .= "<p style='color:rgb(41, 76, 139); margin-left:15px;'><span style='font-weight: bold;'>Marcaci&oacute;n del Reloj: </span>  ".$hor_entrada." - ".$hor_salida."</p>";
	
	$mensaje .= "<input type='hidden' id='codigo_epl' value='".$cod_epl."' />"; 	
	$mensaje .= "<table class='tableone table-bordered' border='1'>";
    $mensaje .= "<thead>";
	$mensaje .= "<tr style='background-color: rgb(41, 76, 139); color: #fff; text-align: center;'>";
	$mensaje .= "<th  scope='col' width='10px'>Turno</th>";
	$mensaje .= "<th  scope='col'>Concepto</th>";
	$mensaje .= "<th  scope='col' width='70px'>H.Regist</th>";
	$mensaje .= "<th scope='col'  width='70px'>H.Aprob</th>";
	$mensaje .= "</tr>";
	$mensaje .= "</thead>";
	 
	$mensaje .= "<tbody>";
	 
	 $i=1;
	 
	 
	 
	 
	 
	 
	 while($row1 = $rs1->fetchrow()){

			$hed_rel = $row1["hed_rel"];
			$hen_rel = $row1["hen_rel"];
			$hedf_rel= $row1["hedf_rel"];
			$henf_rel= $row1["henf_rel"];
			$hfd_rel = $row1["hfd_rel"];
			$rno_rel = $row1["rno_rel"];
			$rnf_rel = $row1["rnf_rel"];			
			
			//var_dump($hed_rel);die("bn");
			
			if($hed_rel !=0.000){				
				
				$hed_rel_seg=$hed_rel*3600;			
				$mostrar_jefe_extras_hed_rel=conversor_segundos($hed_rel_seg);
				$concepto_hed_rel="EXTRAS DIURNAS";
				
				if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
				}else{
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar odd' id=".$i.">";
				}			
				
				$mensaje .= "<td height='18px' width='10px'>".$turno."</td>";
				$mensaje .= "<td height='18px' class='concepto'>".$concepto_hed_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'>".$mostrar_jefe_extras_hed_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'><select name='extras_jefe' id='extras_jefe_hed_rel'><option value=0>0</option><option value=0.5>0.5</option><option value=1>1</option><option value=1.5>1.5</option><option value=2>2</option><option value=2.5>2.5</option><option value=3>3</option><option value=3.5>3.5</option><option value=4>4</option><option value=4.5>4.5</option><option value=5>5</option><option value=5.5>5.5</option><option value=6>6</option><option value=6.5>6.5</option><option value=7>7</option><option value=7.5>7.5</option><option value=8>8</option><option value=8.5>8.5</option><option value=9>9</option><option value=9.5>9.5</option><option value=10>10</option><option value=10.5>10.5</option><option value=11>11</option><option value=11.5>11.5</option><option value=12>12</option><option value=12.5>12.5</option><option value=13>13</option><option value=13.5>13.5</option><option value=14>14</option><option value=14.5>14.5</option><option value=15>15</option></select></td>";
				
				$mensaje .= "</tr>";
			}
				
			if($hen_rel !=0.000){					
					
				$hen_rel_seg=$hen_rel*3600;			
				$mostrar_jefe_extras_hen_rel=conversor_segundos($hen_rel_seg);
				$concepto_hen_rel="EXTRAS NOCTURNAS";
				
				if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
				}else{
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar odd' id=".$i.">";
				}			
				
				$mensaje .= "<td height='18px' width='10px'>".$turno."</td>";
				$mensaje .= "<td height='18px' class='concepto'>".$concepto_hen_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'>".$mostrar_jefe_extras_hen_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'><select name='extras_jefe' id='extras_jefe_hen_rel'><option value=0>0</option><option value=0.5>0.5</option><option value=1>1</option><option value=1.5>1.5</option><option value=2>2</option><option value=2.5>2.5</option><option value=3>3</option><option value=3.5>3.5</option><option value=4>4</option><option value=4.5>4.5</option><option value=5>5</option><option value=5.5>5.5</option><option value=6>6</option><option value=6.5>6.5</option><option value=7>7</option><option value=7.5>7.5</option><option value=8>8</option><option value=8.5>8.5</option><option value=9>9</option><option value=9.5>9.5</option><option value=10>10</option><option value=10.5>10.5</option><option value=11>11</option><option value=11.5>11.5</option><option value=12>12</option><option value=12.5>12.5</option><option value=13>13</option><option value=13.5>13.5</option><option value=14>14</option><option value=14.5>14.5</option><option value=15>15</option></select></td>";
				
				$mensaje .= "</tr>";
				
					
			}
				
			if($hedf_rel !=0.000){
					
				$hedf_rel_seg=$hedf_rel*3600;			
				$mostrar_jefe_extras_hedf_rel=conversor_segundos($hedf_rel_seg);
				$concepto_hedf_rel="EXTRAS DIURNA FESTIVAS";
				
				if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
				}else{
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar odd' id=".$i.">";
				}			
				
				$mensaje .= "<td height='18px' width='10px'>".$turno."</td>";
				$mensaje .= "<td height='18px' class='concepto'>".$concepto_hedf_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'>".$mostrar_jefe_extras_hedf_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'><select name='extras_jefe' id='extras_jefe_hedf_rel'><option value=0>0</option><option value=0.5>0.5</option><option value=1>1</option><option value=1.5>1.5</option><option value=2>2</option><option value=2.5>2.5</option><option value=3>3</option><option value=3.5>3.5</option><option value=4>4</option><option value=4.5>4.5</option><option value=5>5</option><option value=5.5>5.5</option><option value=6>6</option><option value=6.5>6.5</option><option value=7>7</option><option value=7.5>7.5</option><option value=8>8</option><option value=8.5>8.5</option><option value=9>9</option><option value=9.5>9.5</option><option value=10>10</option><option value=10.5>10.5</option><option value=11>11</option><option value=11.5>11.5</option><option value=12>12</option><option value=12.5>12.5</option><option value=13>13</option><option value=13.5>13.5</option><option value=14>14</option><option value=14.5>14.5</option><option value=15>15</option></select></td>";
				
				$mensaje .= "</tr>";
				
			}
				
			if($henf_rel !=0.000){
					
				$henf_rel_seg=$henf_rel*3600;			
				$mostrar_jefe_extras_henf_rel=conversor_segundos($henf_rel_seg);
				$concepto_henf_rel="EXTRAS NOCTURNA FESTIVA";
				
				if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
				}else{
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar odd' id=".$i.">";
				}			
				
				$mensaje .= "<td height='18px' width='10px'>".$turno."</td>";
				$mensaje .= "<td height='18px' class='concepto'>".$concepto_henf_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'>".$mostrar_jefe_extras_henf_rel."</td>";
				
				$mensaje .= "<td height='18px'  width='70px'><select name='extras_jefe' id='extras_jefe_henf_rel'><option value=0>0</option><option value=0.5>0.5</option><option value=1.0>1.0</option><option value=1.5>1.5</option><option value=2>2</option><option value=2.5>2.5</option><option value=3>3</option><option value=3.5>3.5</option><option value=4>4</option><option value=4.5>4.5</option><option value=5>5</option><option value=5.5>5.5</option><option value=6>6</option><option value=6.5>6.5</option><option value=7>7</option><option value=7.5>7.5</option><option value=8>8</option><option value=8.5>8.5</option><option value=9>9</option><option value=9.5>9.5</option><option value=10>10</option><option value=10.5>10.5</option><option value=11>11</option><option value=11.5>11.5</option><option value=12>12</option><option value=12.5>12.5</option><option value=13>13</option><option value=13.5>13.5</option><option value=14>14</option><option value=14.5>14.5</option><option value=15>15</option></select></td>";
				$mensaje .= "</tr>";
				
			}
						
			if($hfd_rel !=0.000){
					
				$hfd_rel_seg=$hfd_rel*3600;			
				$mostrar_jefe_extras_hfd_rel=conversor_segundos($hfd_rel_seg);
				$concepto_hfd_rel="RECARGO FESTIVO DIURNO";
				$hfd_rel=(int)$hfd_rel;
				
				if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
				}else{
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar odd' id=".$i.">";
				}			
				
				$mensaje .= "<td height='18px' width='10px'>".$turno."</td>";
				$mensaje .= "<td height='18px' class='concepto'>".$concepto_hfd_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'>".$mostrar_jefe_extras_hfd_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'><span id='extras_jefe_hfd_rel'>".$hfd_rel."</span></td>";
				$mensaje .= "</tr>";
			}
								
			if($rno_rel !=0.000){
					
				$rno_rel_seg=$rno_rel*3600;			
				$mostrar_jefe_extras_rno_rel=conversor_segundos($rno_rel_seg);
				$concepto_rno_rel="RECARGO NOCTURNO ORDINARIO";
				$rno_rel=(int)$rno_rel;
			
				
				if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
				}else{
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar odd' id=".$i.">";
				}			
				
				$mensaje .= "<td height='18px' width='10px'>".$turno."</td>";
				$mensaje .= "<td height='18px' class='concepto'>".$concepto_rno_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'>".$mostrar_jefe_extras_rno_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'><span id='extras_jefe_rno_rel'>".$rno_rel."</span></td>";
				$mensaje .= "</tr>";
			}
									
			if($rnf_rel !=0.000){
					
				$rnf_rel_seg=$rnf_rel*3600;			
				$mostrar_jefe_extras_rnf_rel=conversor_segundos($rnf_rel_seg);
				$concepto_rnf_rel="RECARGO FESTIVO NOCTURNO";
				$rnf_rel=(int)$rnf_rel;
				
				if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
				}else{
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar odd' id=".$i.">";
				}			
				
				$mensaje .= "<td height='18px' width='10px'>".$turno."</td>";
				$mensaje .= "<td height='18px' class='concepto'>".$concepto_rnf_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'>".$mostrar_jefe_extras_rnf_rel."</td>";
				$mensaje .= "<td height='18px'  width='70px'><span id='extras_jefe_rnf_rel'>".$rnf_rel."</span></td>";
				$mensaje .= "</tr>";
			}
			
		$i++;	
	}
	
	$mensaje .= "</tbody>";
	
	echo $mensaje;
	
/*
4	EXTRAS DIURNAS
5	EXTRAS NOCTURNAS
6	EXTRAS DIURNA FESTIVAS
7	EXTRAS NOCTURNA FESTIVA
8	FESTIVO DIURNO
9	RECARGO NOCTURNO ORDINARIO
10	RECARGO FESTIVO NOCTURNO

	[hed_rel] 	= Concepto 4
	[hen_rel] 	= Concepto 5 
	[hedf_rel] 	= Concepto 6
	[henf_rel] 	= Concepto 7
	[hfd_rel]  	= Concepto 8 
	[rno_rel] 	= Concepto 9
	[rnf_rel] 	= Concepto 10
*/	
