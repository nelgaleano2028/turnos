<?php
require_once("../librerias/lib/connection.php");
		global $conn;
		
		$codigo=$_POST['codigo'];		
		$centro_costo=$_POST['centro_costo'];
		$cargo=$_POST['cargo'];	
		
		$fecha=$_POST['fecha'];//2011-7
		
		$anio=substr($fecha, 0, 4);

		$mes=substr($fecha, 5, 2);

		

$sql="select r.cod_epl, rtrim(e.nom_epl) + ' ' + rtrim(e.ape_epl) as nombre, sum(hed_rel)AS HED,sum(hed_apr)AS HED_APR,
sum(hen_rel) AS HEN,sum(hen_apr)AS HEN_APR,
sum(hedf_rel)AS HEDF,sum(hedf_apr)AS HEDF_APR,sum(henf_rel)AS HENF,sum(henf_apr)AS HENF_APR,
sum(hfd_rel) AS FD,sum(hfd_apr) AS FD_APR,sum(rno_rel)AS RNO,sum(rno_apr)AS RNO_APR,sum(rnf_rel)AS RNF,
sum(rnf_apr)AS RNF_APR
from prog_reloj_he r, empleados_basic e, prog_mes_tur p 
where r.cod_epl=e.cod_epl and p.cod_epl = r.cod_epl
and p.cod_car = '".$cargo."' and p.cod_cc2 = '".$centro_costo."'  and p.cod_epl_jefe = '".$codigo."'
and DATEPART(month, r.fecha) = p.mes and  DATEPART(year, r.fecha) = p.ano
and p.ano=".$anio." and p.mes=".$mes."
group by r.cod_epl, e.nom_epl, e.ape_epl";

$rs=$conn->Execute($sql);

		while($row10 = $rs->fetchrow()){
                  
                 $lista0[]=array("empleado"=>$row10["nombre"],
								"cod_epl"=>$row10["cod_epl"],
								"hed_rel"=>$row10["HED"],
								"hed_apr"=>$row10["HED_APR"],								
								"hen_rel"=>$row10["HEN"],
								"hen_apr"=>$row10["HEN_APR"],								
								"hedf_rel"=>$row10["HEDF"],
								"hedf_apr"=>$row10["HEDF_APR"],								
								"henf_rel"=>$row10["HENF"],
								"henf_apr"=>$row10["HENF_APR"],								
								"hfd_rel"=>$row10["FD"],
								"hfd_apr"=>$row10["FD_APR"],								
								"rno_rel"=>$row10["RNO"],
								"rno_apr"=>$row10["RNO_APR"],								
								"rnf_rel"=>$row10["RNF"],					
								"rnf_apr"=>$row10["RNF_APR"]                               
								);
			 }
		
	$cont=count(@$lista0);
		
		   $table= "<tbody id='creacion'>";
	 
           for($i=0; $i<$cont; $i++){
				
				//clase empleado
			    $empleado=str_replace(" ","_",@$lista0[$i]['empleado']);
				
			    $table.="<tr class='si'>";
				
				$table.="<td align='center'>".($i+1)."</td><td  class='context-menu-one ".$empleado." ".@$lista0[$i]['cod_epl']."' id='".@$lista0[$i]['id']."' align='left'>".@$lista0[$i]['empleado']."</td>";
				
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['hed_rel']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['hed_apr']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['hen_rel']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['hen_apr']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['hedf_rel']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['hedf_apr']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['henf_rel']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['henf_apr']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['hfd_rel']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['hfd_apr']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['rno_rel']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['rno_apr']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['rnf_rel']."</td>";	
				$table .= "<td align='center' class='context-menu-two ".$i." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i]['rnf_apr']."</td>";	

			
                        
				
		
				
				$table .= "</tr>";
		
			}
		
		$table.= "</tbody>";
		
		echo $table;	
?>