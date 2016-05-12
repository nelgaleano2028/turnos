<?php
session_start();

require_once("../librerias/lib/connection.php");
		global $conn;
		
		$cantidad=$_POST['cantidad'];
		
		$centro_costo=$_POST['centro_costo'];
		$cargo=$_POST['cargo'];	
		$fecha=$_POST['fecha'];//2011-7

		
$anio=substr($fecha, 0, 4);

$mes=substr($fecha, 5, 2);

//$perfil="RHERRERA";

//$perfil=$_SESSION['nom']; 

$sql2="select usuario from acc_usuariosTurnosWeb where cod_epl= (select cod_jefe from empleados_gral where cod_epl='".$_SESSION['cod']."')";

$rs2=$conn->Execute($sql2);
$fila=$rs2->fetchrow();
$perfil=$fila['usuario']; 


//pERFIL JEFE 

 $sql = "exec ('SuperQueryTurnos @ano=".$anio.", @mes=".$mes." , @usuario=".$perfil.", @cargo=".$cargo.", @centrocosto=".$centro_costo.",  @param=0')";

 

$rs=$conn->Execute($sql);
		while($row10 = $rs->fetchrow()){
                  
                    
                 $lista0[]=array("empleado"=>utf8_encode($row10["nombre"]),
								"cod_epl"=>$row10["cod_epl"],
								"id"=>$row10["ID"],
                                1=>$row10["td1"],
								2=>$row10["td2"],
								3=>$row10["td3"],
								4=>$row10["td4"],
								5=>$row10["td5"],
								6=>@$row10["td6"],
								7=>$row10["td7"],
								8=>$row10["td8"],
								9=>$row10["td9"],
								10=>$row10["td10"],
								11=>$row10["td11"],
								12=>$row10["td12"],
								13=>$row10["td13"],
								14=>$row10["td14"],
								15=>$row10["td15"],
								16=>@$row10["td16"],
								17=>$row10["td17"],
								18=>$row10["td18"],
								19=>$row10["td19"],
								20=>$row10["td20"],
								21=>$row10["td21"],
								22=>$row10["td22"],
								23=>$row10["td23"],
								24=>$row10["td24"],
								25=>$row10["td25"],
								26=>@$row10["td26"],
								27=>$row10["td27"],
								28=>$row10["td28"],
								29=>$row10["td29"],
								30=>$row10["td30"],
								31=>$row10["td31"],
								'sem1'=>$row10["sem1"],
								'sem2'=>$row10["sem2"],
								'sem3'=>$row10["sem3"],
								'sem4'=>$row10["sem4"],
								'sem5'=>$row10["sem5"],
								'sem6'=>$row10["sem6"],
								'horas'=>$row10["horas"],
								);
			 }
		
	$cont=count(@$lista0);
		
			$table= "<tbody id='creacion'>";
	 
           for($i=0; $i<$cont; $i++){
				
				//clase empleado
			    $empleado=str_replace(" ","_",@$lista0[$i]['empleado']);
				
			    $table.="<tr class='si'>";
				
				$table.="<td align='center'>".($i+1)."</td><td  class='context-menu-one ".$empleado." ".@$lista0[$i]['cod_epl']."' id='".@$lista0[$i]['id']."'style='cursor:pointer;' title='Doble click para realizar programaci&oacute;n' align='left'  onDblClick='return programacion_empleado(\"".@$lista0[$i]['cod_epl']."\",\"".@$lista0[$i]['empleado']."\");'>".@$lista0[$i]['empleado']."</td>";
				
				for($j=1; $j <= $cantidad; $j++){
									
				        $sql1="select * from feriados where fec_fer='$anio-$j-$mes'";
					
					$rs1=$conn->Execute($sql1);
					
					$row11 = $rs1->FetchRow();
					
					$res=$row11["fec_fer"];
					
					//METODO IMPORTANTE que segun la fecha ingresada te dice que dia es. 0="sunday", 1="monday"...etc
					$fecha= "$anio/$mes/$j";
					$l = strtotime($fecha);
					$validar=jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$l),date("d",$l), date("Y",$l)) , 0 );
					//FIN METODO
					
					
					
					if($res or $validar==0){
										
					$table .= "<td align='center' class='context-menu-two ".$j." ".$empleado." ".@$lista0[$i]['cod_epl']."' style='background:rgb(204, 204, 204);' >".@$lista0[$i][$j]."</td>";
					
					}else{
					
					$table .= "<td align='center' class='context-menu-two ".$j." ".$empleado." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i][$j]."</td>";	

					}
                        
				}
		
				$table .= "<td align='center'>".@$lista0[$i]["sem1"]."</td ><td align='center'>".@$lista0[$i]["sem2"]."</td><td align='center'>".@$lista0[$i]["sem3"]."</td><td align='center'>".@$lista0[$i]["sem4"]."</td><td align='center'>".@$lista0[$i]["sem5"]."</td><td align='center'>".@$lista0[$i]["sem6"]."</td><td align='center' class='".@$lista0[$i]["horas"]."'>".@$lista0[$i]["horas"]."</td>";			
				$table .= "</tr>";
		
			}
		
		$table.= "</tbody>";
		
		echo $table;	
?>