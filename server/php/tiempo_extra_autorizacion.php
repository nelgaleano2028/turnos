<?php
require_once("../librerias/lib/connection.php");
		global $conn;

//Metodo que devuelve en horas y minutos la cantidad de segundos enviados
function conversor_segundos($seg_ini) {
				$horas = floor($seg_ini/3600);
				$minutos = floor(($seg_ini-($horas*3600))/60);
				return $horas."h:".$minutos."m";
}
		
				
		$centro_costo=$_POST['centro_costo'];
		$cargo=$_POST['cargo'];	
		$codigo_jefe=$_POST['codigo'];
		
		$fecha=$_POST['fecha'];//2011-7
		$anio=substr($fecha, 0, 4);
		$mes=substr($fecha, 5, 2);
	

/*	
$sql="select reloj.cod_epl, rtrim(emp.nom_epl) + ' ' + rtrim(emp.ape_epl) as nombre,
hed_apr, hen_apr, hedf_apr, henf_apr, hfd_apr, rno_apr, rnf_apr, reloj.estado
FROM prog_reloj_he reloj, empleados_basic emp 
where reloj.cod_epl=emp.cod_epl and MONTH(reloj.fecha)='".$mes."' and YEAR(reloj.fecha)='".$anio."' and reloj.estado='Validada' and 
reloj.cod_epl_jefe='".$codigo_jefe."' order by emp.cod_car, emp.cod_cc2,emp.ape_epl";
*/
 
$sql="select reloj.cod_epl, rtrim(emp.nom_epl) + ' ' + rtrim(emp.ape_epl) as nombre, SUM(hed_apr) AS hed_apr, SUM(hen_apr) AS hen_apr, SUM(hedf_apr) AS hedf_apr, 
SUM(henf_apr) AS henf_apr, SUM(hfd_apr) AS hfd_apr, SUM(rno_apr) AS rno_apr, SUM(rnf_apr) AS rnf_apr, reloj.estado 
FROM prog_reloj_he reloj, empleados_basic emp 
where reloj.cod_epl=emp.cod_epl and MONTH(reloj.fecha)='".$mes."' and YEAR(reloj.fecha)='".$anio."' and reloj.estado='Validada' and reloj.cod_epl_jefe='".$codigo_jefe."' 
group by emp.nom_epl, emp.ape_epl, reloj.estado, reloj.cod_epl,emp.cod_car, emp.cod_cc2 
order by emp.cod_car, emp.cod_cc2,emp.ape_epl";

//var_dump($sql);die("bn");


$rs=$conn->Execute($sql);

		while($row10 = $rs->fetchrow()){
                  
                 $lista0[]=array("empleado"=>$row10["nombre"],
								"cod_epl"=>$row10["cod_epl"],
								"hed_apr"=>$row10["hed_apr"],
								"hen_apr"=>$row10["hen_apr"],								
								"hedf_apr"=>$row10["hedf_apr"],
								"henf_apr"=>$row10["henf_apr"],								
								"hfd_apr"=>$row10["hfd_apr"],
								"rno_apr"=>$row10["rno_apr"],								
								"rnf_apr"=>$row10["rnf_apr"],															
								"estado"=>$row10["estado"]							                          
								);
			 }
			 


			
	$cont=count(@$lista0);
		
		   $mensaje= "<tbody>";
		   
		   $j=0;
	 
           for($i=0; $i<$cont; $i++){
		   
//Validacion-----------------------------------------

				if(@$lista0[$i]['hed_apr'] !=0.0000){
				
					$hed_apr=@$lista0[$i]['hed_apr'];
					$hed_apr_seg=@$lista0[$i]['hed_apr']*3600;			
					$mostrar_jefe_extras_hed_apr=conversor_segundos($hed_apr_seg);
					$concepto_hed_apr="EXTRAS DIURNAS";	
					
					if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}else{
						$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}			
					
					$mensaje .= "<td height='20px' style='width:52px;'>".@$lista0[$i]['cod_epl']."</td>";
					$mensaje .= "<input type='hidden' name='cod_epl_".$j."' value='".@$lista0[$i]['cod_epl']."' />";
					$mensaje .= "<td height='20px' style='width:112px; font-size:11px'>".@$lista0[$i]['empleado']."</td>";
					$mensaje .= "<td height='20px' style='width:112px; font-size:12px'>".$concepto_hed_apr."</td>";
					$mensaje .= "<input type='hidden' name='cod_con_".$j."' value='".$concepto_hed_apr."' />";
					$mensaje .= "<td height='20px' style='width:30px;'>".$mostrar_jefe_extras_hed_apr."</td>";
					$mensaje .= "<input type='hidden' name='vlr_".$j."' value='".$mostrar_jefe_extras_hed_apr."' />";
					$mensaje .= "<input type='hidden' name='vlr_nov_".$j."' value='".$hed_apr."' />";					
					$mensaje .= "<td height='20px' style='width:30px;'>".@$lista0[$i]['estado']."</td>";
					$mensaje .= "</tr>";

					$j++;
					
				}
				
				if(@$lista0[$i]['hen_apr'] !=0.0000){
					
					$hen_apr=@$lista0[$i]['hen_apr'];
					$hen_apr_seg=@$lista0[$i]['hen_apr']*3600;			
					$mostrar_jefe_extras_hen_apr=conversor_segundos($hen_apr_seg);
					$concepto_hen_apr="EXTRAS NOCTURNAS";
					
					if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}else{
						$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}			
					
					$mensaje .= "<td height='20px' style='width:52px;'>".@$lista0[$i]['cod_epl']."</td>";
					$mensaje .= "<input type='hidden' name='cod_epl_".$j."' value='".@$lista0[$i]['cod_epl']."' />";
					$mensaje .= "<td height='20px' style='width:112px; font-size:11px'>".@$lista0[$i]['empleado']."</td>";
					$mensaje .= "<td height='20px' style='width:112px; font-size:12px'>".$concepto_hen_apr."</td>";
					$mensaje .= "<input type='hidden' name='cod_con_".$j."' value='".$concepto_hen_apr."' />";
					$mensaje .= "<td height='20px' style='width:30px;'>".$mostrar_jefe_extras_hen_apr."</td>";
					$mensaje .= "<input type='hidden' name='vlr_".$j."' value='".$mostrar_jefe_extras_hen_apr."' />";
					$mensaje .= "<input type='hidden' name='vlr_nov_".$j."' value='".$hen_apr."' />";	
					$mensaje .= "<td height='20px' style='width:30px;'>".@$lista0[$i]['estado']."</td>";
					$mensaje .= "</tr>";	
					
					$j++;
					
				}
				
				if(@$lista0[$i]['hedf_apr']  !=0.0000){
					
					$hedf_apr=@$lista0[$i]['hedf_apr'];
					$hedf_apr_seg=@$lista0[$i]['hedf_apr'] *3600;			
					$mostrar_jefe_extras_hedf_apr=conversor_segundos($hedf_apr_seg);
					$concepto_hedf_apr="EXTRAS DIURNA FESTIVAS";
					
					if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}else{
						$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}			
					
					$mensaje .= "<td height='20px' style='width:52px;'>".@$lista0[$i]['cod_epl']."</td>";
					$mensaje .= "<input type='hidden' name='cod_epl_".$j."' value='".@$lista0[$i]['cod_epl']."' />";
					$mensaje .= "<td height='20px' style='width:112px; font-size:11px'>".@$lista0[$i]['empleado']."</td>";
					$mensaje .= "<td height='20px' style='width:112px; font-size:12px'>".$concepto_hedf_apr."</td>";
					$mensaje .= "<input type='hidden' name='cod_con_".$j."' value='".$concepto_hedf_apr."' />";
					$mensaje .= "<td height='20px' style='width:30px;'>".$mostrar_jefe_extras_hedf_apr."</td>";
					$mensaje .= "<input type='hidden' name='vlr_".$j."' value='".$mostrar_jefe_extras_hedf_apr."' />";
					$mensaje .= "<input type='hidden' name='vlr_nov_".$j."' value='".$hedf_apr."' />";	
					$mensaje .= "<td height='20px' style='width:30px;'>".@$lista0[$i]['estado']."</td>";
					$mensaje .= "</tr>";	
				
					$j++;
				}
					
				if(@$lista0[$i]['henf_apr']  !=0.0000){
					
					$henf_apr=@$lista0[$i]['henf_apr'];
					$henf_apr_seg=@$lista0[$i]['henf_apr']*3600;			
					$mostrar_jefe_extras_henf_apr=conversor_segundos($henf_apr_seg);
					$concepto_henf_apr="EXTRAS NOCTURNA FESTIVA";
					
					if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}else{
						$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}			
					
					$mensaje .= "<td height='20px' style='width:52px;'>".@$lista0[$i]['cod_epl']."</td>";
					$mensaje .= "<input type='hidden' name='cod_epl_".$j."' value='".@$lista0[$i]['cod_epl']."' />";
					$mensaje .= "<td height='20px' style='width:112px; font-size:11px'>".@$lista0[$i]['empleado']."</td>";
					$mensaje .= "<td height='20px' style='width:112px; font-size:12px'>".$concepto_henf_apr."</td>";
					$mensaje .= "<input type='hidden' name='cod_con_".$j."' value='".$concepto_henf_apr."' />";
					$mensaje .= "<td height='20px' style='width:30px;'>".$mostrar_jefe_extras_henf_apr."</td>";
					$mensaje .= "<input type='hidden' name='vlr_".$j."' value='".$mostrar_jefe_extras_henf_apr."' />";
					$mensaje .= "<input type='hidden' name='vlr_nov_".$j."' value='".$henf_apr."' />";	
					$mensaje .= "<td height='20px' style='width:30px;'>".@$lista0[$i]['estado']."</td>";
					$mensaje .= "</tr>";	
					
					$j++;
				}
						
				if(@$lista0[$i]['hfd_apr']  !=0.0000){
				
					$hfd_apr=@$lista0[$i]['hfd_apr'];
					$hfd_apr_seg=@$lista0[$i]['hfd_apr']*3600;			
					$mostrar_jefe_extras_hfd_apr=conversor_segundos($hfd_apr_seg);
					$concepto_hfd_apr="FESTIVO DIURNO";
					
					if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}else{
						$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}			
					
					$mensaje .= "<td height='20px' style='width:52px;'>".@$lista0[$i]['cod_epl']."</td>";
					$mensaje .= "<input type='hidden' name='cod_epl_".$j."' value='".@$lista0[$i]['cod_epl']."' />";
					$mensaje .= "<td height='20px' style='width:112px; font-size:11px'>".@$lista0[$i]['empleado']."</td>";
					$mensaje .= "<td height='20px' style='width:112px; font-size:12px'>".$concepto_hfd_apr."</td>";
					$mensaje .= "<input type='hidden' name='cod_con_".$j."' value='".$concepto_hfd_apr."' />";
					$mensaje .= "<td height='20px' style='width:30px;'>".$mostrar_jefe_extras_hfd_apr."</td>";
					$mensaje .= "<input type='hidden' name='vlr_".$j."' value='".$mostrar_jefe_extras_hfd_apr."' />";
					$mensaje .= "<input type='hidden' name='vlr_nov_".$j."' value='".$hfd_apr."' />";	
					$mensaje .= "<td height='20px' style='width:30px;'>".@$lista0[$i]['estado']."</td>";
					$mensaje .= "</tr>";	

					$j++;
				}
								
				if(@$lista0[$i]['rno_apr']  !=0.0000){
					
					$rno_apr=@$lista0[$i]['rno_apr'];
					$rno_apr_seg=@$lista0[$i]['rno_apr']*3600;			
					$mostrar_jefe_extras_rno_apr=conversor_segundos($rno_apr_seg);
					$concepto_rno_apr="RECARGO NOCTURNO ORDINARIO";
					
					if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}else{
						$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}			
					
					$mensaje .= "<td height='20px' style='width:52px;'>".@$lista0[$i]['cod_epl']."</td>";
					$mensaje .= "<input type='hidden' name='cod_epl_".$j."' value='".@$lista0[$i]['cod_epl']."' />";
					$mensaje .= "<td height='20px' style='width:112px; font-size:11px'>".@$lista0[$i]['empleado']."</td>";
					$mensaje .= "<td height='20px' style='width:112px; font-size:12px'>".$concepto_rno_apr."</td>";
					$mensaje .= "<input type='hidden' name='cod_con_".$j."' value='".$concepto_rno_apr."' />";
					$mensaje .= "<td height='20px' style='width:30px;'>".$mostrar_jefe_extras_rno_apr."</td>";
					$mensaje .= "<input type='hidden' name='vlr_".$j."' value='".$mostrar_jefe_extras_rno_apr."' />";
					$mensaje .= "<input type='hidden' name='vlr_nov_".$j."' value='".$rno_apr."' />";	
					$mensaje .= "<td height='20px' style='width:30px;'>".@$lista0[$i]['estado']."</td>";
					$mensaje .= "</tr>";	

					$j++;
				}
									
				if(@$lista0[$i]['rnf_apr']  !=0.0000){
					
					$rnf_apr=@$lista0[$i]['rnf_apr'];
					$rnf_apr_seg=@$lista0[$i]['rnf_apr']*3600;			
					$mostrar_jefe_extras_rnf_apr=conversor_segundos($rnf_apr_seg);
					$concepto_rnf_apr="RECARGO FESTIVO NOCTURNO";
					
					if($i % 2){			
					$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}else{
						$mensaje .= "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id=".$i.">";
					}			
					
					$mensaje .= "<td height='20px' style='width:52px;'>".@$lista0[$i]['cod_epl']."</td>";
					$mensaje .= "<input type='hidden' name='cod_epl_".$j."' value='".@$lista0[$i]['cod_epl']."' />";
					$mensaje .= "<td height='20px' style='width:112px; font-size:11px'>".@$lista0[$i]['empleado']."</td>";
					$mensaje .= "<td height='20px' style='width:112px; font-size:12px'>".$concepto_rnf_apr."</td>";
					$mensaje .= "<input type='hidden' name='cod_con_".$j."' value='".$concepto_rnf_apr."' />";
					$mensaje .= "<td height='20px' style='width:30px;'>".$mostrar_jefe_extras_rnf_apr."</td>";
					$mensaje .= "<input type='hidden' name='vlr_".$j."' value='".$mostrar_jefe_extras_rnf_apr."' />";
					$mensaje .= "<input type='hidden' name='vlr_nov_".$j."' value='".$rnf_apr."' />";	
					$mensaje .= "<td height='20px' style='width:30px;'>".@$lista0[$i]['estado']."</td>";
					$mensaje .= "</tr>";

					$j++;
				}		
				

//Fin Validacion----------------------------------------		   
		 		 
				
		}
		$mensaje .= "<input type='hidden' name='conta_epl'  value='".$j."' />";
		
		$mensaje .=  "</tbody>";	
		
		echo $mensaje;	
?>