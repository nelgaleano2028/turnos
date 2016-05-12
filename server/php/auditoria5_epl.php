<?php
require_once("../librerias/lib/connection.php");

global $conn;		
	
		
		//$centro_costo=$_POST['centro_costo'];
		//$cargo=$_POST['cargo'];
		$codigo=$_POST['codigo'];
       	$fecha=$_POST['fecha'];
		
		$anio=substr($fecha, 0, 4);

		$mes=substr($fecha, 5, 2);
		
		
		$sql1="select cod_jefe from empleados_gral where cod_epl='".$codigo."'";
		
		$rs1=$conn->Execute($sql1);
		
		$row = $rs1->fetchrow();
		
		$codigo_jefe=$row["cod_jefe"];
			


//CONSULTAR Y MOSTRAR

//and cod_car = '".$cargo."'   and cod_cc2 = '".$centro_costo."' 
					
$sql2="select cod_tur, horas, hor_ini, hor_fin
from prog_mes_tur_auditoria where ano = '".$anio."' and mes = '".$mes."'
and cod_epl_jefe ='".$codigo_jefe."' and cod_tur <> 'X' and cod_tur <> 'N' and cod_tur <> 'V' and cod_tur <> 'VCTO' and cod_tur <> 'IG' and cod_tur <> 'LN'
and cod_tur <> 'SP' and cod_tur <> 'LR' and cod_tur <> 'LM' and cod_tur <> 'AT' and cod_tur <> 'LP' and cod_tur <> 'EP' and cod_tur <> 'VD' and cod_tur <> 'R'";

//var_dump($sql2);die("");

//and cod_epl_jefe = (select COD_EPL from acc_usuarios where  usuario like '%RHERRERA%')";

//NUEVO 

		$rs=$conn->Execute($sql2);
		while($row8 = $rs->fetchrow()){
                  
                 $lista[]=array("turno"=>$row8["cod_tur"],
								"horas"=>$row8["horas"],
								"hora_ini"=>substr($row8["hor_ini"], 11, 5),
								"hora_fin"=>substr($row8["hor_fin"], 11, 5)                               
								);
			 }
		
	      $cont=count(@$lista);

		  $table= "<tbody id='creacion'>";
			
		  
			
          for($i=0; $i<$cont; $i++){
				
			    $table.="<tr>";
				
				$table.="<td align='center'>".@$lista[$i]['turno']."</td><td align='center'>".@$lista[$i]['hora_ini']."</td>";
				$table.="<td align='center'>".@$lista[$i]['hora_fin']."</td><td align='center'>".@$lista[$i]['horas']."</td>";
							
				$table .= "</tr>";
		}
			
		
		$table.= "</tbody>";
		
		echo $table;	
?>
