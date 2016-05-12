<?php
SESSION_START();
require_once("../librerias/lib/connection.php");
		global $conn;
		
		$cantidad=$_POST['cantidad'];
		
		$centro_costo=$_POST['centro_costo'];
		$cargo=$_POST['cargo'];	
		$fecha=$_POST['fecha'];//2011-7

		
		$anio=substr($fecha, 0, 4);

		$mes=substr($fecha, 5, 2);


		$perfil=$_SESSION['nom']; //PERFIL JEFE
		
		/*$sql0="select cod_epl FROM acc_usuarios where usuario='".$perfil."'";

		$rs0=$conn->Execute($sql0);	

		$row0 = $rs0->fetchrow();

		$codigo=$row0["cod_epl"];*/
		
		$codigo=$_SESSION['cod_epl'];
		
	
		
				
		$sql = "exec ('SuperQueryTurnos @ano=".$anio.", @mes=".$mes." , @usuario=".$perfil.", @cargo=".$cargo.", @centrocosto=".$centro_costo.",  @param=1')";


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
								6=>$row10["td6"],
								7=>$row10["td7"],
								8=>$row10["td8"],
								9=>$row10["td9"],
								10=>$row10["td10"],
								11=>$row10["td11"],
								12=>$row10["td12"],
								13=>$row10["td13"],
								14=>$row10["td14"],
								15=>$row10["td15"],
								16=>$row10["td16"],
								17=>$row10["td17"],
								18=>$row10["td18"],
								19=>$row10["td19"],
								20=>$row10["td20"],
								21=>$row10["td21"],
								22=>$row10["td22"],
								23=>$row10["td23"],
								24=>$row10["td24"],
								25=>$row10["td25"],
								26=>$row10["td26"],
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
	 
			$f=0;
	 
           for($i=0; $i<$cont; $i++){ //1 a 2
				
				//clase empleado
			    $empleado=str_replace(" ","_",@$lista0[$i]['empleado']);
				
			    $table.="<tr class='si'>";
				
				$table.="<td align='center'>".($i+1)."</td><td  class='context-menu-one ".$empleado." ".@$lista0[$i]['cod_epl']."' id='".@$lista0[$i]['id']."'style='cursor:pointer;' align='left'>".@$lista0[$i]['empleado']."</td>";
				
				for($j=1; $j <= $cantidad; $j++){ //0 a 30
					
					//".$j."
					//$f=$f+1;
					
						$sql2="select * from colores where posicion=".$j." and cod_epl='".$lista0[$i]['cod_epl']."' and cod_cc2='".$centro_costo."' and cargo='".$cargo."' and mes='".$mes."' and anio='".$anio."'";
						
						
						
						$rs2=$conn->Execute($sql2);
						
						$row5 = $rs2->FetchRow();
						
						$color=$row5["color"];
						$cod_epl_colores=$row5["cod_epl"];
						$posicion=$row5["posicion"];
						
						/*if($j==16){
							var_dump($sql2);
						}*/
					
					
					
					
					//if($color==null){ var_dump($sql2);var_dump($lista0[$i]['cod_epl']);}		
					
					if($cod_epl_colores==@$lista0[$i]['cod_epl'] and $posicion==$j){
						
						$table .= "<td style='background-color:$color;' align='center' class='".$j." ".@$lista0[$i]['cod_epl']." ".$color."' onDblClick='return modal_marcacion(\"".$color."\",\"".@$lista0[$i]['cod_epl']."\", \"".$mes."\", \"".$anio."\", \"".$j."\", \"".$codigo."\", \"".@$lista0[$i][$j]."\",\"".$fecha."\", \"".$centro_costo."\", \"".$cargo."\", \"".$codigo."\")';>".@$lista0[$i][$j]."</td>";	
						
					}else{
					
						$table .= "<td align='center' class='".$j." ".@$lista0[$i]['cod_epl']."' >".@$lista0[$i][$j]."</td>";	
					
					}
					
					

					}
                     
						//var_dump($f);
				}
		
				
				$table .= "</tr>";
		
			
		
		$table.= "</tbody>";
		
		echo $table;	
?>