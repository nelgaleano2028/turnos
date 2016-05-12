<?php
require_once("../librerias/lib/connection.php");



global $conn;

		$cantidad=$_POST['cantidad'];
			
	
		
		$centro_costo=$_POST['centro_costo'];
		$cargo=$_POST['cargo'];
		$codigo=$_POST['codigo'];        
		$fecha=$_POST['fecha'];//2011-7
		
		
		
		
		$anio=substr($fecha, 0, 4);

		$mes=substr($fecha, 5, 2);
			
		
		//Eliminar primero que todo				
		$sql9="delete from prog_mes_tur_auditoria where cod_car='".$cargo."' and cod_epl_jefe ='".$codigo."' and mes='".$mes."' and ano='".$anio."'";
		
				
        $conn->Execute($sql9);
		
		
	function semana($dia,$mes,$anio){
		
		$con_sem=0;
       
		for ($z=1;$z<=$dia;$z++){
               
               $domingo=(int)date('N',strtotime($z."-".$mes."-".$anio));
               
               if($domingo==7 && $z != $dia){
                       $con_sem++;
               }else if($z==$dia && $z != $domingo){
						
                       $con_sem++;        
               }

      
	    }  
		
       return $con_sem;
    }
		
	function verificar_turno($turno1,$cod){

       global $conn;
       
	   if($turno1=="X" or $turno1=="x" or $turno1=="x" or $turno1=="N" or $turno1=="V" or $turno1=="VCTO" or $turno1=="IG" or $turno1=="LN" or $turno1=="SP" or $turno1=="LM" or $turno1=="AT" or $turno1=="LP" or $turno1=="EP" or $turno1=="VD" or $turno1=="R" or $turno1=="LR"){
				$horas=0;
	   }else{
	      
       $sql4="select horas from turnos_prog where cod_tur='".$turno1."'";
       $rs4=$conn->Execute($sql4);
       
       if($rs4->RecordCount() > 0){
               
               $row4= $rs4->fetchrow();
               $horas=$row4['horas'];
       }else{
               $sql5="select horas from turnos_prog_tmp where cod_tur='".$turno1."' AND cod_cargo ='".$cod."'";
               $rs5=$conn->Execute($sql5);
               $row5= $rs5->fetchrow();
               $horas=$row5['horas'];
       }
	   
	   }
	   
	   return $horas;
	}
		

//NUEVO
	function verificar_turno_hor_ini($turno1){

       global $conn;
       
	   if($turno1=="X" or $turno1=="x" or $turno1=="x" or $turno1=="N" or $turno1=="V" or $turno1=="VCTO" or $turno1=="IG" or $turno1=="LN" or $turno1=="SP" or $turno1=="LR" or $turno1=="LM" or $turno1=="AT" or $turno1=="LP" or $turno1=="EP" or $turno1=="VD" or $turno1=="R"){
				$hor_ini=0;
	   }else{
	      
       $sql4="select hor_ini from turnos_prog where cod_tur='".$turno1."'";
       $rs4=$conn->Execute($sql4);
       
       if($rs4->RecordCount() > 0){
               
               $row4= $rs4->fetchrow();
             		  
			   $hor_ini=@$row4['hor_ini'];
			   
			   if($hor_ini==null){
					
					$hor_ini=0;
			   
			   }
			   
			
			   
       }else{
               $sql5="select hor_ini from turnos_prog_tmp where cod_tur='".$turno1."'";
               $rs5=$conn->Execute($sql5);
               $row5= $rs5->fetchrow();
              		   
			   $hor_ini=$row5['hor_ini'];
			  
       }
	   
	   }
	   
	   return $hor_ini;
	}
	
	//NUEVO
	function verificar_turno_hor_fin($turno1){

       global $conn;
	   
	   
	   if($turno1=="X" or $turno1=="x" or $turno1=="x" or $turno1=="N" or $turno1=="V" or $turno1=="VCTO" or $turno1=="IG" or $turno1=="LN" or $turno1=="SP" or $turno1=="LR" or $turno1=="LM" or $turno1=="AT" or $turno1=="LP" or $turno1=="EP" or $turno1=="VD" or $turno1=="R"){
				$hor_fin=0;
	   }else{
	      
       $sql4="select hor_fin from turnos_prog where cod_tur='".$turno1."'";
       $rs4=$conn->Execute($sql4);
       
       if($rs4->RecordCount() > 0){
               
               $row4= $rs4->fetchrow();
              
			   $hor_fin=@$row4['hor_fin'];
			   
			   if($hor_fin==null){
					
				$hor_ini=0;
			   
			  }
			   
       }else{
               $sql5="select hor_fin from turnos_prog_tmp where cod_tur='".$turno1."'";
               $rs5=$conn->Execute($sql5);
               $row5= $rs5->fetchrow();
               		  			  
			   $hor_fin=$row5['hor_fin'];
       }
	   
	   }
	   
	   return $hor_fin;
	}
		

$turnos=array();
$turnos_reales=array();



  for($i=1; $i<=31; $i++){
  
		$sql="SELECT Td".$i." as turno
			  FROM prog_mes_tur 
			  WHERE Mes=".$mes." and Ano=".$anio." and cod_car='".$cargo."' and cod_cc2 = '".$centro_costo."' and cod_epl_jefe ='".$codigo."'
			  GROUP BY Td".$i;
		
		//var_dump($sql);die();	  
					
					
		$rs=$conn->Execute($sql);
		        		
		while($row = $rs->fetchrow()){
						
		$turno=$row["turno"];
			
				
		$turnos[]=$turno;
		}	
	    
    
  }
  

  
  
  $turnos_reales = array_values(array_unique($turnos));
  
   // var_dump($turnos_reales);die("");
  
  
  
  for($k=0; $k<count($turnos_reales); $k++){
  
      for($j=1; $j<=31; $j++){
  
		
			  
		$sql1="SELECT Td".$j." as turno_real, Count(Td".$j.") AS repetidos_tot
			  FROM prog_mes_tur 
			  WHERE Td".$j."='".$turnos_reales[$k]."' and Mes=".$mes." and Ano=".$anio." and cod_car='".$cargo."' and cod_cc2 = '".$centro_costo."'
			  GROUP BY Td".$j;
			  
		
		
					
					
		$rs1=$conn->Execute($sql1);
		        		
         
						
	    if($rs1->RecordCount() > 0){
		
		 $row1 = $rs1->fetchrow();
		
		$turno_real[]=$row1["turno_real"]; //F1
		$ubicacion[]="Td".$j;//Td1		
		$repeticiones[]=$row1["repetidos_tot"]; //2
		}
	    
    
  }
  
  }
  
   require_once("class_programacion.php");
					
	$obj=new programacion();	
	
	
	/*$sem1_1=10;
	$sem2_1=20;
	$sem3_1=30;
	$sem4_1=40;
	$sem5_1=50;
	$sem6_1=60;*/

  
  /*
	var_dump($turno_real);
   
	echo"<br><br>";
   
	var_dump($ubicacion);
  
    echo"<br><br>";
   
	var_dump($repeticiones);
 */ 
 
	$T1="Td1";
	$T2="Td2";
	$T3="Td3";
	$T4="Td4";
	$T5="Td5";
	$T6="Td6";
	$T7="Td7";
	$T8="Td8";
	$T9="Td9";
	$T10="Td10";
	$T11="Td11";
	$T12="Td12";
	$T13="Td13";
	$T14="Td14";
	$T15="Td15";
	$T16="Td16";
	$T17="Td17";
	$T18="Td18";
	$T19="Td19";
	$T20="Td20";
	$T21="Td21";
	$T22="Td22";
	$T23="Td23";
	$T24="Td24";
	$T25="Td25";
	$T26="Td26";
	$T27="Td27";
	$T28="Td28";
	$T29="Td29";
	$T30="Td30";
	$T31="Td31";

	//var_dump($turnos_reales);die();
	
	for($a=0;$a<count($turnos_reales);$a++){
	
						 $Td1="";
						 $Td2="";
						 $Td3="";
						 $Td4="";
						 $Td5="";
						 $Td6="";
						 $Td7="";
						 $Td8="";
						 $Td9="";
						 $Td10="";
						 $Td11="";
						 $Td12="";
						 $Td13="";
						 $Td14="";
						 $Td15="";
						 $Td16="";
						 $Td17="";
						 $Td18="";
						 $Td19="";
						 $Td20="";
						 $Td21="";
						 $Td22="";
						 $Td23="";
						 $Td24="";
						 $Td25="";
						 $Td26="";
						 $Td27="";
						 $Td28="";
						 $Td29="";
						 $Td30="";
						 $Td31="";
						 
						 $semana1=array();
						 $semana2=array();
						 $semana3=array();
						 $semana4=array();
						 $semana5=array();
						 $semana6=array();
						 $repetir=array();
						 
						 
						
	
			for($b=0;$b<count($turno_real);$b++){
			
			//var_dump(count($turno_real));die();
			
								
						if($turnos_reales[$a]==$turno_real[$b]){
						
							 if($T1==$ubicacion[$b]){
										$Td1=$repeticiones[$b];	
							 }
							 
							 if($T2==$ubicacion[$b]){
										@$Td2=$repeticiones[$b];	
							 }
							 
							 if($T3==$ubicacion[$b]){
										@$Td3=$repeticiones[$b];	
							 }
							 
							 if($T4==$ubicacion[$b]){
										@$Td4=$repeticiones[$b];	
							 }
							 
							 if($T5==$ubicacion[$b]){
										@$Td5=$repeticiones[$b];	
							 }
							 
							 if($T6==$ubicacion[$b]){
										@$Td6=$repeticiones[$b];	
							 }
							 
							 if($T7==$ubicacion[$b]){
										@$Td7=$repeticiones[$b];	
							 }
							 
							 if($T8==$ubicacion[$b]){
										@$Td8=$repeticiones[$b];	
							 }
							 
							 if($T9==$ubicacion[$b]){
										@$Td9=$repeticiones[$b];	
							 }
							 
							 if($T10==$ubicacion[$b]){
										@$Td10=$repeticiones[$b];	
							 }
							 
							 if($T11==$ubicacion[$b]){
										@$Td11=$repeticiones[$b];	
							 }
							 
							 if($T12==$ubicacion[$b]){
										@$Td12=$repeticiones[$b];	
							 }
							 
							 if($T13==$ubicacion[$b]){
										@$Td13=$repeticiones[$b];	
							 }
							 
							 if($T14==$ubicacion[$b]){
										@$Td14=$repeticiones[$b];	
							 }
							 
							 if($T15==$ubicacion[$b]){
										@$Td15=$repeticiones[$b];	
							 }
							 
							 if($T16==$ubicacion[$b]){
										@$Td16=$repeticiones[$b];	
							 }
							 
							 if($T17==$ubicacion[$b]){
										@$Td17=$repeticiones[$b];	
							 }
							 
							 if($T18==$ubicacion[$b]){
										@$Td18=$repeticiones[$b];	
							 }
							 
							 if($T19==$ubicacion[$b]){
										@$Td19=$repeticiones[$b];	
							 }
							 
							 if($T20==$ubicacion[$b]){
										@$Td20=$repeticiones[$b];	
							 }
							 
							 if($T21==$ubicacion[$b]){
										@$Td21=$repeticiones[$b];	
							 }
							 
							 if($T22==$ubicacion[$b]){
										@$Td22=$repeticiones[$b];	
							 }
							 
							 if($T23==$ubicacion[$b]){
										@$Td23=$repeticiones[$b];	
							 }
							 
							 if($T24==$ubicacion[$b]){
										@$Td24=$repeticiones[$b];	
							 }
							 
							 if($T25==$ubicacion[$b]){
										@$Td25=$repeticiones[$b];	
							 }
							 
							 if($T26==$ubicacion[$b]){
										@$Td26=$repeticiones[$b];	
							 }
							 
							 if($T27==$ubicacion[$b]){
										@$Td27=$repeticiones[$b];	
							 }
							 
							 if($T28==$ubicacion[$b]){
										@$Td28=$repeticiones[$b];	
							 }
							 
							 if($T29==$ubicacion[$b]){
										@$Td29=$repeticiones[$b];	
							 }
							 
							 if($T30==$ubicacion[$b]){
										@$Td30=$repeticiones[$b];	
							 }
							 
							 if($T31==$ubicacion[$b]){
										@$Td31=$repeticiones[$b];	
							 }
							
						}//fin if
				
		
		
						
						
						
						
			}//fin for
		
		
		$repetir = array($Td1, $Td2, $Td3, $Td4, $Td5 ,$Td6 ,$Td7 ,$Td8, $Td9, $Td10, $Td11, $Td12, $Td13, $Td14, $Td15, $Td16, $Td17, $Td18, $Td19, $Td20, $Td21, $Td22, $Td23, $Td24, $Td25, $Td26, $Td27, $Td28, $Td29, $Td30, $Td31);
				
		
		
		$turno_si=$turnos_reales[$a];
		$horas=verificar_turno(strip_tags($turno_si), $codigo);
		
		//NUEVO
		$hor_ini=verificar_turno_hor_ini(strip_tags($turno_si));
		$hor_fin=verificar_turno_hor_fin(strip_tags($turno_si));
		
		
		
		for($f=1;$f<=31;$f++){
		
		$semana=semana($f,$mes,$anio);			
			
        		
		if($semana==1){
				
		    $semana1[]= $repetir[$f-1];
		
		}else if($semana==2){
			
			        $semana2[]= $repetir[$f-1];
		
		      }else if($semana==3){
			  
				        $semana3[]= $repetir[$f-1];

						}else if($semana==4){
						
								   $semana4[]= $repetir[$f-1];
							
						           }else if($semana==5){
								   
											$semana5[]= $repetir[$f-1];
											
											}else if($semana==6){
													
													$semana6[]= $repetir[$f-1];
											
											}
		}
		

		
		
		//$sem1=array_sum($semana1);
		@$semana1==NULL ? $sem1_1=0 : $sem1_1=array_sum($semana1);
		
		//$sem2=array_sum($semana2);
		@$semana2==NULL ? $sem2_1=0 : $sem2_1=array_sum($semana2);
		
		//$sem3=array_sum($semana3);
		@$semana3==NULL ? $sem3_1=0 : $sem3_1=array_sum($semana3);
		
		//$sem4=array_sum($semana4);
		@$semana4==NULL ? $sem4_1=0 : $sem4_1=array_sum($semana4);
		
		//$sem5=array_sum($semana5);
		@$semana5==NULL ? $sem5_1=0 : $sem5_1=array_sum($semana5);
		
		//$sem6=array_sum($semana6);
	    @$semana6==NULL ? $sem6_1=0 : $sem6_1=array_sum($semana6);
		
	    
		/*VAR_DUMP($horas);
		VAR_DUMP($hor_ini);
		VAR_DUMP($hor_fin);die();*/
		
		/*if($a==1){
		var_dump(strip_tags($turno_si),$horas,$mes,$Td1, $Td2, $Td3, $Td4, $Td5, $Td6, $Td7, $Td8, $Td9, $Td10, $Td11, $Td12, $Td13, $Td14, $Td15, $Td16, $Td17, $Td18, $Td19, $Td20, $Td21, $Td22, $Td23, $Td24, $Td25, $Td26, $Td27, $Td28, $Td29, $Td30, $Td31,$anio,$sem1_1, $sem2_1, $sem3_1, $sem4_1 ,$sem5_1, $sem6_1,$centro_costo,$cargo,$codigo, $hor_ini, $hor_fin);die();
		}
		*/
		
		if($turno_si==NULL){
			continue;
		}else{
		
			$lista1=$obj->insertar_programacion_auditoria(strip_tags($turno_si),$horas,$mes,$Td1, $Td2, $Td3, $Td4, $Td5, $Td6, $Td7, $Td8, $Td9, $Td10, $Td11, $Td12, $Td13, $Td14, $Td15, $Td16, $Td17, $Td18, $Td19, $Td20, $Td21, $Td22, $Td23, $Td24, $Td25, $Td26, $Td27, $Td28, $Td29, $Td30, $Td31,$anio,$sem1_1, $sem2_1, $sem3_1, $sem4_1 ,$sem5_1, $sem6_1,$centro_costo,$cargo,$codigo, $hor_ini, $hor_fin);	
			//echo $lista1;	
		}
			
	} //fin for			
	
	
	 
	
	//CONSULTAR Y MOSTRAR
	
			
$sql2="select cod_tur, horas,td1, td2, td3, td4, td5, td6, td7, td8, 
td9, td10, td11, td12, td13, td14, td15, td16, td17, td18, td19, td20, td21, td22, td23, td24, td25, td26, td27, 
td28, td29, td30, td31 , sem1, sem2, sem3, sem4, sem5, sem6 , sem1+sem2+sem3+sem4+sem5+sem6  as Thoras
from prog_mes_tur_auditoria where ano = '".$anio."' and mes = '".$mes."'
and cod_car = '".$cargo."'   and cod_cc2 = '".$centro_costo."' 
and cod_epl_jefe ='".$codigo."' and cod_tur <> 'X' and cod_tur <> 'N' and cod_tur <> 'V' and cod_tur <> 'VCTO' and cod_tur <> 'IG' and cod_tur <> 'LN' and cod_tur <> 'LR'
and cod_tur <> 'SP' and cod_tur <> 'LM' and cod_tur <> 'AT' and cod_tur <> 'LP' and cod_tur <> 'EP' and cod_tur <> 'VD' and cod_tur <> 'R'";

//var_dump($sql2);die("");

//and cod_epl_jefe = (select COD_EPL from acc_usuarios where  usuario like '%RHERRERA%')";



		$rs=$conn->Execute($sql2);
		while($row8 = $rs->fetchrow()){
                  
                 $lista[]=array("turno"=>$row8["cod_tur"],
								"horas"=>$row8["horas"],
                                1=>$row8["td1"],
								2=>$row8["td2"],
								3=>$row8["td3"],
								4=>$row8["td4"],
								5=>$row8["td5"],
								6=>$row8["td6"],
								7=>$row8["td7"],
								8=>$row8["td8"],
								9=>$row8["td9"],
								10=>$row8["td10"],
								11=>$row8["td11"],
								12=>$row8["td12"],
								13=>$row8["td13"],
								14=>$row8["td14"],
								15=>$row8["td15"],
								16=>$row8["td16"],
								17=>$row8["td17"],
								18=>$row8["td18"],
								19=>$row8["td19"],
								20=>$row8["td20"],
								21=>$row8["td21"],
								22=>$row8["td22"],
								23=>$row8["td23"],
								24=>$row8["td24"],
								25=>$row8["td25"],
								26=>$row8["td26"],
								27=>$row8["td27"],
								28=>$row8["td28"],
								29=>$row8["td29"],
								30=>$row8["td30"],
								31=>$row8["td31"],
								'sem1'=>$row8["sem1"],
								'sem2'=>$row8["sem2"],
								'sem3'=>$row8["sem3"],
								'sem4'=>$row8["sem4"],
								'sem5'=>$row8["sem5"],
								'sem6'=>$row8["sem6"],
								'Thoras'=>$row8["Thoras"]
								);
			 }
		
	      $cont=count(@$lista);

		  $table= "<tbody id='creacion'>";
	 
          for($i=0; $i<$cont; $i++){
				
			    $table.="<tr>";
				
				$table.="<td align='center'>".@$lista[$i]['turno']."</td><td align='center'>".@$lista[$i]['horas']."</td>";
				
				for($j=1; $j <= $cantidad; $j++){
									
				        $sql1="select * from feriados where fec_fer='$anio-$mes-$j'";
					
					$rs1=$conn->Execute($sql1);
					
					$row11 = $rs1->FetchRow();
					
					$res=$row11["fec_fer"];
					
					//METODO IMPORTANTE que segun la fecha ingresada te dice que dia es. 0="sunday", 1="monday"...etc
					$fecha= "$anio/$mes/$j";
					$l = strtotime($fecha);
					$validar=jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$l),date("d",$l), date("Y",$l)) , 0 );
					//FIN METODO
					
										
					if($res or $validar==0){
										
					$table .= "<td align='center'  style='background:rgb(204, 204, 204);' >".@$lista[$i][$j]."</td>";
					
					}else{
					
					$table .= "<td align='center'>".@$lista[$i][$j]."</td>";	

					}
                                        
				}
		
				$table .= "<td align='center'>".@$lista[$i]["sem1"]."</td ><td align='center'>".@$lista[$i]["sem2"]."</td><td align='center'>".@$lista[$i]["sem3"]."</td><td align='center'>".@$lista[$i]["sem4"]."</td><td align='center'>".@$lista[$i]["sem5"]."</td><td align='center'>".@$lista[$i]["sem6"]."</td><td align='center'>".@$lista[$i]["Thoras"]."</td>";			
				$table .= "</tr>";
		
			}
		
		$table.= "</tbody>";
		
		echo $table;	
?>

	
 
