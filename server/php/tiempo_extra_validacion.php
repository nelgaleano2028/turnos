<?php
		require_once("../librerias/lib/connection.php");
		global $conn;		
	
	
//FUNCIONES-----------------------------------------------------------------------------------------------

		function restarHoras($horaInicio,$horaTermino) {
			$h1=substr($horaInicio,0,-3);
			$m1=substr($horaInicio,3,2);
			$h2=substr($horaTermino,0,-3);
			$m2=substr($horaTermino,3,2);
			
			
			$ini=(($h1*60)*60)+($m1*60);
			$fin=(($h2*60)*60)+($m2*60);
			$dif=$fin-$ini;
			$difh=floor($dif/3600);
			$difm=floor(($dif-($difh*3600))/60);
			
			return date("H:i",mktime($difh,$difm));
		}

		function festivo($anio,$i,$mes){		
			
			global $conn;
			
			if($i==32 or $i==0){
				$feriado=NULL;
			}else{
				
				$sql5="select * from feriados where fec_fer='$anio-$i-$mes'";
							
				$rs5=$conn->Execute($sql5);
						
				$row5 = $rs5->FetchRow();
				
				$feriado=$row5["fec_fer"];
			
			
			}
			
			
			if($feriado==NULL){
				$resp=false;
			}else{
				$resp=true;
			}			
						
			return $resp;
		}
		
		//METODO que segun la fecha ingresada te dice que dia es. 0="sunday", 1="monday"...etc [0(sunday) <---> 6(saturday)]
		function dia_en_entero($anio,$i,$mes){	
		
			$fecha= "$anio/$mes/$i";
			$l = strtotime($fecha);
			$validar=jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$l),date("d",$l), date("Y",$l)) , 0 );
							
			return $validar;
		}
		
		//METODO que devuelve en horas y minutos la cantidad de segundos enviados
		function conversor_segundos($seg_ini) {

			$horas = floor($seg_ini/3600);
			$minutos = floor(($seg_ini-($horas*3600))/60);
							
			return $horas."h:".$minutos."m";
									
									}
	
		//Funcion para poner por el dia y hacer el 
		function dia_letras($dia){	
									
			switch($dia)
			{
			case 1:
			  $dia_letras="Lunes";
			  break;
			case 2:
			  $dia_letras="Martes";
			  break;
			case 3:
			 $dia_letras="Miercoles";
			  break;
			case 4:
			  $dia_letras="Jueves";
			  break;
			case 5:
			 $dia_letras="Viernes";
			  break;
			 case 6:
			  $dia_letras="Sabado";
			  break;
			case 0:
			  $dia_letras="Domingo";		 
			  break;
			case 10:
			 $dia_letras="Festivo";
			  break;	
			}
			
			return $dia_letras;
			
		}

		//METODO que devuelve en horas y minutos la cantidad de segundos enviados
		function convertir_hora_militar($seg_ini) {

			$horas = floor($seg_ini/3600);
			$minutos = floor(($seg_ini-($horas*3600))/60);
							
			return $horas.":".$minutos;
									
									}
	
		function convertir_segundos_horas($hora){
				
					$hor_hora=substr($hora, 0, 2);
					$hor_min=substr($hora, 3, 2);
								
					$hor_hora_seg=$hor_hora*3600;
					$hor_min_seg=$hor_min*60;
					
					$hor_seg=$hor_hora_seg+$hor_min_seg;
					
					return $hor_seg;
				
				}
		
//FIN FUNCIONES ----------------------------------------------------------------------------------------------------------


//PARAMETRIZACION

		$sql0="select * from turnos_parametros";
		$rs0=$conn->Execute($sql0);					
		$row0= $rs0->fetchrow();
					  
		$tiempo_marcacion=$row0['tiempo_hol_marca'];//5min
		$holgura_seg=$tiempo_marcacion*60;
		
		$tiempo_extra=$row0['min_hora_extra'];//15min
		$tiempo_extra_seg=$tiempo_extra*60;
		
		$tiempo_recargo=$row0['min_recargo'];//15min
		$tiempo_recargo_seg=$tiempo_recargo*60;
					
		$tiempo_extra_horario=$row0['min_extra_horario'];//10min :Ya esta en seg
		
		$tiempo_hora_completa=$row0['min_hora_completa'];//5min :Ya esta en seg
		
		
	
//DATOS ACTUALES
		$centro_costo=$_POST['centro_costo'];
		$cargo=$_POST['cargo'];		
		$codigo=$_POST['codigo'];//Codigo Jefe		
		$codigo_epl=$_POST['codigo_epl']; 	
			
       	$fecha=$_POST['fecha'];	
		$anio=substr($fecha, 0, 4);
		$mes=substr($fecha, 5, 2);
		
		

		
//INICIA TODO EL MODULO 1 31
		for($i=1; $i<=31; $i++){
		
		
			/*if($i==31){
				break;
			}*/
		
			$sql46="select color from colores where posicion=".$i." and cod_epl='".$codigo_epl."' and cod_cc2='".$centro_costo."' and cargo='".$cargo."' and mes='".$mes."' and anio='".$anio."'";
						
			$rs2=$conn->Execute($sql46);
				
			$row46 = $rs2->FetchRow();
					
			@$color=$row46["color"];
			
					
			
			
			if(@$color == "#6D87DA"){ 
								
					continue;
		 
			}else{
			
					$sql47="DELETE FROM colores where mes='".$mes."' and anio='".$anio."' and posicion=".$i." and color <> '#6D87DA' and cod_epl='".$codigo_epl."'";
												
					$conn->Execute($sql47);	
					
					
					$sql48="DELETE FROM prog_reloj_he where MONTH(fecha)='".$mes."' and  YEAR(fecha)='".$anio."' and cod_epl='".$codigo_epl."' and cod_epl_jefe='".$codigo."' and DAY(fecha)='".$i."'";
					
					$conn->Execute($sql48);	
					
								
			
				$sql_valida="select Td$i from prog_mes_tur where cod_epl='".$codigo_epl."' and mes='".$mes."' and ano='".$anio."' and cod_cc2='".$centro_costo."' and cod_car='".$cargo."' and cod_epl_jefe='".$codigo."'";
				
				$rs=$conn->Execute($sql_valida);
				
				$row_valida= $rs->fetchrow();
				
				$cajita=strip_tags($row_valida['Td'.$i]);

				

				if($cajita=='X' or $cajita=='N' or $cajita=='V' or $cajita=='VCTO' or $cajita=='IG' or $cajita=='LN'
					or $cajita=='SP' or $cajita=='LM' or $cajita=='AT' or $cajita=='LP' or $cajita=='EP' or $cajita=='VD' or $cajita=='R'){
				
				
					$color="#FFFFFF";//Blanco
					
					$sql_exc="insert into colores(cod_epl, posicion,color,cod_cc2,cargo,cod_epl_jefe, mes, anio)values('$codigo_epl', '$i','$color','$centro_costo','$cargo','$codigo','$mes','$anio') ";							
							
					$conn->Execute($sql_exc);
				
					continue;
				}
				
			
						
			
			
			//INICIALIZAR VARIABLES
				$hora_cero=86350;		
				$flag=0;
			
			
			//CONSULTA TURNO REAL INDICADO AL DIA(i) 
				$sql1="select Td$i from prog_mes_tur where cod_epl='".$codigo_epl."' and mes='".$mes."' and ano='".$anio."' and cod_cc2='".$centro_costo."' and cod_car='".$cargo."' and cod_epl_jefe='".$codigo."'";
				$rs1=$conn->Execute($sql1);
				$row1= $rs1->fetchrow();
				$turno=$row1['Td'.$i];		
				
							
			//ME DEVUELVE LAS HORAS, HORA INICIO Y HORA FIN DEL TURNO REAL
				$sql2="select horas,hor_ini, hor_fin from turnos_prog where cod_tur='".$turno."'";
				$rs2=$conn->Execute($sql2);
       
				if($rs2->RecordCount() > 0){
               
					$row2= $rs2->fetchrow();
              
					$horas_turno_real=$row2['horas']; 
					@$hor_ini_real=$row2['hor_ini']; 
					@$hor_fin_real=$row2['hor_fin']; 
							   
				}else{
					
					$sql3="select horas,hor_ini, hor_fin from turnos_prog_tmp where cod_tur='".$turno."'";
					$rs3=$conn->Execute($sql3);
					$row3= $rs3->fetchrow();
               		  			  
					$horas_turno_real=$row3['horas'];
					@$hor_ini_real=$row3['hor_ini'];
					@$hor_fin_real=$row3['hor_fin'];
									
				}
				
					
				
					
			//HORA ENTRADA TURNO REAL	
			
				$hora_ini_real_solo_horas=substr($hor_ini_real, 11, 5);
				
				$hora_ini_real_hora=substr($hor_ini_real, 11, 2);
				$hora_ini_real_min=substr($hor_ini_real, 14, 2);
											
				$hora_ini_real_hora_seg=$hora_ini_real_hora*3600;
				$hora_ini_real_min_seg=$hora_ini_real_min*60;
				
				$hora_ini_real_sin_cambio_holgura_seg=$hora_ini_real_hora_seg+$hora_ini_real_min_seg;
				$hora_ini_real_con_cambio_holgura_seg=$hora_ini_real_hora_seg+$hora_ini_real_min_seg+$holgura_seg;
						
					
			//HORA SALIDA TURNO REAL
			
				$hora_fin_real_solo_horas=substr($hor_fin_real, 11, 5);
				
				$hora_fin_real_hora=substr($hor_fin_real, 11, 2);
				$hora_fin_real_min=substr($hor_fin_real, 14, 2);
																
				$hora_fin_real_hora_seg=$hora_fin_real_hora*3600;
				$hora_fin_real_min_seg=$hora_fin_real_min*60;
						
				$hora_fin_real_sin_cambio_holgura_seg=$hora_fin_real_hora_seg+$hora_fin_real_min_seg;
				$hora_fin_real_con_cambio_holgura_seg=$hora_fin_real_hora_seg+$hora_fin_real_min_seg+$holgura_seg;
				
				
			//ME DEVUELVE LA MARCACION DE DICHO EMPLEADO HOR_ENTRADA_EPL, HOR_SALIDA_EPL				
				$sql4="select convert(varchar,hor_entr,108) as hor_entr, convert(varchar,hor_sal,108) as hor_sal from prog_reloj_tur where cod_epl='".$codigo_epl."' and fecha=convert(datetime,'".$anio."-".$i."-".$mes." 00:00:00.000')";											
								
				$rs4=$conn->Execute($sql4);
				$row4= $rs4->fetchrow();
				
				$hor_entrada_epl=$row4['hor_entr'];
				$hor_salida_epl=$row4['hor_sal'];
				
				
			//HORA ENTRADA EPL EN SEG			
				$hor_entrada_epl=substr($hor_entrada_epl, 0, 5);
				
				$hor_entrada_epl_hora=substr($hor_entrada_epl, 0, 2);
				$hor_entrada_epl_min=substr($hor_entrada_epl, 3, 2);
								
				$hor_entrada_epl_hora_seg=$hor_entrada_epl_hora*3600;
				$hor_entrada_epl_min_seg=$hor_entrada_epl_min*60;
							
				$hor_ini_entrada_seg_epl=$hor_entrada_epl_hora_seg+$hor_entrada_epl_min_seg;
								
				
			//HORA SALIDA EPL EN SEG
				$hor_salida_epl=substr($hor_salida_epl, 0, 5);
							
				$hor_salida_epl_hora=substr($hor_salida_epl, 0, 2);
				$hor_salida_epl_min=substr($hor_salida_epl, 3, 2);
								
				$hor_salida_epl_hora_seg=$hor_salida_epl_hora*3600;
				$hor_salida_epl_min_seg=$hor_salida_epl_min*60;
					
				$hor_fin_salida_seg_epl=$hor_salida_epl_hora_seg+$hor_salida_epl_min_seg;			
				
			
			//DIFERENCIA ENTRE HORAS EPL y REAL							
				$diferencia_horas_epl=restarHoras($hor_entrada_epl,$hor_salida_epl);
				
				
				//CASO 1
				$horas_turno_epl=substr($diferencia_horas_epl, 0, 2);
				$horas_turno_epl_seg=$horas_turno_epl*3600;
				
				
				//CASO 2
				$horas_turno_epl_diferencia=substr($diferencia_horas_epl, 0, 2);
				$horas_turno_epl_seg=$horas_turno_epl*3600;
				
				$minutos_turno_epl_diferencia=substr($diferencia_horas_epl, 3, 2);
				$minutos_turno_epl_seg=$minutos_turno_epl_diferencia*60;
								
				//Diferencia total en seg de la hora entrada y salida del EPL
				$horas_diferencia_totales_segundos=$horas_turno_epl_seg+$minutos_turno_epl_seg;
				
				
				//Diferencia total en seg de la hora del turno REAL en segundos	
				$horas_turno_real_seg=$horas_turno_real*3600;		
				
				//var_dump($hor_entrada_epl);
				//var_dump($hor_salida_epl);die("bn");
				
			//VAL1	
			//Cuando el empleado no tiene marcacion ninguna pero tiene un Turno indicado diferente de L
				if($hor_entrada_epl==null  and  $hor_salida_epl==null and $turno != 'L'){
						
						
			
						$color="#BBF6C0";//Verde
					
						$sql20="insert into colores(cod_epl, posicion,color,cod_cc2,cargo,cod_epl_jefe, mes, anio)values('$codigo_epl', '$i','$color','$centro_costo','$cargo','$codigo','$mes','$anio')";
						
						
						/*if($i==30){
							var_dump($sql20);
						}*/
						
						$conn->Execute($sql20);	
						
						
						
						continue;			
				}
			
			
			//VAL2		
			//Cuando en algun momento en la marcacion ya sea entrada o salida tiene null
				if(($hor_entrada_epl==null  or  $hor_salida_epl==null) and  $turno != 'L'){
				
						$color="#93E5DF";//Azul Claro
					
						$sql21="insert into colores(cod_epl, posicion,color,cod_cc2,cargo,cod_epl_jefe, mes, anio)values('$codigo_epl', '$i','$color','$centro_costo','$cargo','$codigo','$mes','$anio') ";
								   									   
						$rs21=$conn->Execute($sql21);	
					
						continue;				
				}
				
			 				
				
			//VAL3								
			//Cuando el Turno es LIBRE= L
				if($hor_ini_real==null and $hor_fin_real==null and $turno=='L'){
							
						
							
						if($hor_entrada_epl==null and $hor_salida_epl==null){
										
								$color="#CBD0CB";//Gris
					
								$sql11="insert into colores(cod_epl, posicion,color,cod_cc2,cargo,cod_epl_jefe, mes, anio)values('$codigo_epl', '$i','$color','$centro_costo','$cargo','$codigo','$mes','$anio') ";
								   			
										
								$rs11=$conn->Execute($sql11);
																		
						}else{
						
								//LOGICA TODO
																		
								$num_conceptos_extras=array();
								$num_extras=array();
									
								$validacion_festivo=festivo($anio,$i,$mes);							
								$dia=dia_en_entero($anio,$i,$mes);						
								$dia_letras=dia_letras($dia);					
								
								$hora_entrada_epl_la_misma=$hor_entrada_epl;//hora entrada real del turno: 13:40					
								$hora_salida_epl_la_misma=$hor_salida_epl;//hora salida real del turno: 07:36	
									
								
								
								
								//----------------SEGUIMIENTO 2-----------------
								/*
									var_dump($validacion_festivo);
									var_dump("Dia: ".$dia);
									var_dump("Dia Letras ".$dia_letras);
									var_dump("Hora entrada del EPL: ".$hora_entrada_epl_la_misma);
									var_dump("Hora salida  del EPL: ".$hora_salida_epl_la_misma);
									die("bn2");
								*/								
									 							 
									 
									 
									 
								//*************EXTRAS_ESPECIAL*****************************************************************
								
								
								$hora_sumada=0;

								//Su hora entrada EPL y le sumo las horas que trabajo a ver si se pasa a otro dia 
								$hora_sumada=$hor_ini_entrada_seg_epl+$horas_diferencia_totales_segundos;
								
								
								
								//var_dump($hora_sumada);die();
									
									
									
								if($hora_sumada>$hora_cero){
													
										$flago1=1;
										
										$dia_letras_existe_anterior=dia_letras($dia);	
										
										
										if($dia==6){
													$dia_existe=0;
													$dia_letras_existe_actual=dia_letras($dia_existe);	
													$validacion_festivo_existe_actual=festivo($anio,($i+1),$mes);
										}else{									
													$dia_existe=$dia+1;
													$dia_letras_existe_actual=dia_letras($dia_existe);	
													$validacion_festivo_existe_actual=festivo($anio,($i+1),$mes);
										}										
								}else{
								
										$flago1=2;
										$dia_existe_actual=$dia;
										$dia_letras_existe_actual_extras=dia_letras($dia_existe_actual);	
										$validacion_festivo_existe_actual_extras=$validacion_festivo;
										
								}						
								
								//dia es. 0="sunday", 1="monday"...etc [0(sunday) <---> 6(saturday)]

								
								if($validacion_festivo){
									$dia_letras_existe_anterior="Festivo";
								}
								
								if($validacion_festivo_existe_actual){
									$dia_letras_existe_actual="Festivo";
								}
								
								if($validacion_festivo_existe_actual_extras){
									$dia_letras_existe_actual_extras="Festivo";
								}
			
								
								
								
								/*													
									VAR_DUMP($dia_existe_actual);
									VAR_DUMP($dia_letras_existe_actual_extras);
									VAR_DUMP($validacion_festivo_existe_actual_extras);
									
									VAR_DUMP("-------------------------------");
									VAR_DUMP($dia_letras_existe_anterior);
									
									VAR_DUMP($dia_existe);
									VAR_DUMP($dia_letras_existe_actual);
									
									VAR_DUMP($validacion_festivo_existe_actual);
									die();
								*/		
								
								
								
								
								//QUERY IMPORTANTE
								
								if($flago1==1){	//--se pasa del dia laborado 								
									
									$query="SELECT * FROM conceptos_extras_tmp WHERE estado='E' and ((hor_fin>='".$hor_entrada_epl."' and ".$dia_letras_existe_anterior."=1) or (hor_ini<='".$hor_salida_epl."' and ".$dia_letras_existe_actual."=1))"; 

									
								}else{	//--no se pasa del dia laborado								
																		
									$query="SELECT * FROM conceptos_extras_tmp WHERE estado='E' and ((hor_fin>='".$hor_entrada_epl."' and ".$dia_letras_existe_actual_extras."=1) and (hor_ini<='".$hor_salida_epl."' and ".$dia_letras_existe_actual_extras."=1))"; 
								}
								
								
								
								//var_dump($query);die();
								
								
								
								$rs=$conn->Execute($query);											
								$row_query1=$rs->fetchrow();

								$recargos_existe=$row_query1['cod_con'];
								
								$registros=$rs->RecordCount();
								
								$rs_while=$conn->Execute($query);	
								
								if($recargos_existe != null){//Si existen extras entonces haga
									
									$f=0;
									$flagos5=1;
									while($row_query=$rs_while->fetchrow()){
																				
											
											//INGRESAMOS EL CODIGO Y EL NOMBRE DEL CONCEPTO A SUS ARRAYS
											$cod_con_pa_extras=$row_query['cod_con'];
											$num_conceptos_extras[$f]=$cod_con_pa_extras;
											
											
											//LAS HORAS DEL RANGO INDICADO
											$t_hor_ini=$row_query['hor_ini'];
											$t_hor_ini_seg=convertir_segundos_horas($t_hor_ini);

											$t_hor_fin=$row_query['hor_fin'];
											$t_hor_fin_seg=convertir_segundos_horas($t_hor_fin);
											
										/*
											if($f==0){
												
												var_dump($num_conceptos_extras);
												var_dump("hor_ini_seg: ".$t_hor_ini_seg);//06:00
												var_dump("hor_fin_seg: ".$t_hor_fin_seg);//21:59
												die("si");
											
											}
										*/	

																
										//INICIO LOGICA INCLUDE

										include("funcion_extras_libre.php");			
																
										//FIN LOGICA INCLUDE
										

										
										
										
										$extras=1;//Para saber que si hay extras y de esta forma entre a la condicion mas abajo.
										$f++;
										
										
										
										
										
									
									}//Cierre While	
										
								}

										
									
								//PROCEDO A REALIZAR LA RESPECTIVA INSERCCION
									
								//Inicializar Variables
								$hed_rel= 0.000; 
								$hen_rel= 0.000;
								$hedf_rel=0.000; 
								$henf_rel=0.000;

								$hfd_rel= 0.000; 
								$rno_rel= 0.000;
								$rnf_rel= 0.000;
									
								$hed_apr= 0.000;
								$hen_apr= 0.000;
								$hedf_apr=0.000;
								$henf_apr=0.000;
									
								$hfd_apr= 0.000;
								$rno_apr= 0.000;
								$rnf_apr= 0.000;
								
								
								
							/*
								var_dump($num_conceptos_extras);
								var_dump($num_horas_extras);		
								die("Probando");
							*/	
								
								
								
								if(@$extras>0){													
										
										$cont=count($num_conceptos_extras);								
										
																				
										for($x=0; $x<$cont; $x++){															   
											
											
											/*08:19
											Una hora y 30 minutos son 1,50 en decimales.

											1 * 60 + 30 = 90 minutos.
											90 minutos dividido entre 60 = 1,50.
											
											08*60 + 19=499 minutos										
											*/
											
											
											$hora_dada=$num_horas_extras[$x];
											
											//Tengo por aparte horas y minutos de $hora_dada
											$horas_dadas=substr($hora_dada, 0, 2);
											$min_dados=substr($hora_dada, 3, 2);
											
											//Proceso Matematico
											$hora_en_minutos=$horas_dadas*60 + $min_dados;											
											$hora_en_decimal=$hora_en_minutos/60;		
											
											$ingreso_extras_decimal=$hora_en_decimal;										
											

											switch($num_conceptos_extras[$x]){
											   case 4:	
													@$hed_rel+=$ingreso_extras_decimal;
													break;
											   case 5:
													@$hen_rel+=$ingreso_extras_decimal;
													break;
											   case 6:
													@$hedf_rel+=$ingreso_extras_decimal;
													break;
											   case 7:
													@$henf_rel+=$ingreso_extras_decimal;
													break;
											}
											
											   
										}//Fin For x	   
							
						
										//**************SEGUIMIENTO 17******************//	
										/*
											var_dump("hen_rel cod 4: ".@$hed_rel);
											var_dump("hen_rel cod 5: ".@$hen_rel);
											var_dump("hedf_rel cod 6: ".@$hedf_rel);
											var_dump("henf_rel cod 7: ".@$henf_rel);																					
											die("bn14");	
										*/					
						
								}
								
																
								//*************FIN EXTRAS_ESPECIAL***************************************************************************
								
									    
								
								
								//*************RECARGOS_ESPECIAL***********************************************************************
								
										
								$validacion_festivo=festivo($anio,$i,$mes);							
								$dia=dia_en_entero($anio,$i,$mes);						
								$dia_letras=dia_letras($dia);					
							   
								//Hora entrada Real del turno
								$hora_entrada_epl_la_misma;
									
								$hora_entrada_epl_la_misma_hora=substr($hora_entrada_epl_la_misma, 0, 2);
								$hora_entrada_epl_la_misma_min=substr($hora_entrada_epl_la_misma, 3, 2);
															
								$hora_ini_epl_hora_seg_misma=$hora_entrada_epl_la_misma_hora*3600;
								$hora_ini_epl_min_seg_misma=$hora_entrada_epl_la_misma_min*60;
								
								$hora_ini_epl_la_misma_seg=$hora_ini_epl_hora_seg_misma+$hora_ini_epl_min_seg_misma;
								
										
								//Hora Salida Real del turno
								$hora_salida_epl_la_misma;	
								
								$hora_salida_epl_la_misma_hora=substr($hora_salida_epl_la_misma, 0, 2);
								$hora_salida_epl_la_misma_min=substr($hora_salida_epl_la_misma, 3, 2);
															
								$hora_fin_epl_hora_seg_misma=$hora_salida_epl_la_misma_hora*3600;
								$hora_fin_epl_min_seg_misma=$hora_salida_epl_la_misma_min*60;
								
								$hora_fin_epl_la_misma_seg=$hora_fin_epl_hora_seg_misma+$hora_fin_epl_min_seg_misma;
								
								
								
								/*
								var_dump("Hora Entrada: ".$hora_entrada_epl_la_misma);
								var_dump("Hora Entrada en seg: ".$hora_ini_epl_la_misma_seg);
								var_dump("Hora Salida: ".$hora_salida_epl_la_misma);
								var_dump("Hora Salida en seg: ".$hora_fin_epl_la_misma_seg);
								
								die();
								*/
								
								
								$hora_sumada=0;
								
								//Su hora entrada y le sumo las horas que trabajo a ver si se pasa el dia
								$hora_sumada=$hora_ini_epl_la_misma_seg+$horas_diferencia_totales_segundos;
								
								
																
								//var_dump($hora_sumada);die();
								
								
								
								if($hora_sumada>$hora_cero){
													
										$flago1=1;
										
										$dia_letras_existe_anterior=dia_letras($dia);	
										
										
										if($dia==6){
													$dia_existe=0;
													$dia_letras_existe_actual=dia_letras($dia_existe);	
													$validacion_festivo_existe=festivo($anio,($i+1),$mes);
										}else{									
													$dia_existe=$dia+1;
													$dia_letras_existe_actual=dia_letras($dia_existe);	
													$validacion_festivo_existeactual=festivo($anio,($i+1),$mes);
										}										
								}else{
								
										$flago1=2;
										$dia_existe=$dia;
										$dia_letras_existe=dia_letras($dia_existe);	
										$validacion_festivo_existe=festivo($anio,($i),$mes);
										
								}						
								
								//COMPRUEBA SI EXISTE RECARGOS O NO
								
								if($flago1==1){ //--se pasa del dia laborado 
									
									$query="SELECT * FROM conceptos_extras_tmp WHERE estado='R' and (hor_fin>='".$hora_entrada_epl_la_misma."' and ".$dia_letras_existe_anterior."=1 or hor_ini<='".$hora_salida_epl_la_misma."'and ".$dia_letras_existe_actual."=1)";

									
								}else{
									
																		
									$query="SELECT * FROM conceptos_extras_tmp WHERE estado='R' and ((hor_fin>='".$hora_entrada_epl_la_misma."' and ".$dia_letras_existe."=1) and (hor_ini<='".$hora_salida_epl_la_misma."' and ".$dia_letras_existe."=1))";
								}
								
								
								//var_dump($query);die("nuevo");
								
																
								$rs=$conn->Execute($query);											
								$row_query1=$rs->fetchrow();

								$recargos_existe=$row_query1['cod_con'];															
								
								$registros_libre=$rs->RecordCount();
								
								$rs_while=$conn->Execute($query);	
								
								if($recargos_existe != null){//Si existe recargos entonces haga
									
									unset($num_conceptos_recargos_libres);
									$num_conceptos_recargos_libres = array(); 
									
									unset($num_horas);
									$num_horas = array();								
																		
									$f=0;
									
									while($row_query=$rs_while->fetchrow()){
											
																				
											
											//INGRESAMOS EL CODIGO Y EL NOMBRE DEL CONCEPTO A SUS ARRAYS
											$cod_con_pa_recargos=$row_query['cod_con'];
											$num_conceptos_recargos_libres[$f]=$cod_con_pa_recargos;
																														
											
											//LAS HORAS DEL RANGO INDICADO
											$t_hor_ini=$row_query['hor_ini'];
											$t_hor_ini_seg=convertir_segundos_horas($t_hor_ini);

											$t_hor_fin=$row_query['hor_fin'];
											$t_hor_fin_seg=convertir_segundos_horas($t_hor_fin);
											
											
											/*
											if($f==0){
											
												var_dump($num_conceptos_recargos_libres);
												var_dump("hor_ini_seg: ".$t_hor_ini_seg);
												var_dump("hor_fin_seg: ".$t_hor_fin_seg);
												die("si");
											
											}
											*/
											
						
						
						
						
											/*
											if($f==0){
												var_dump($hora_ini_epl_la_misma_seg);//07:19
												var_dump("<=");
												var_dump($t_hor_fin_seg);//21:59
												
												var_dump($hora_ini_epl_la_misma_seg);//07:19
												var_dump(">=");
												var_dump($t_hor_ini_seg);//06:00
												die("si");
											}
											*/
											
											
											if($f==0){


												if($hora_ini_epl_la_misma_seg<=$t_hor_fin_seg and $hora_ini_epl_la_misma_seg>=$t_hor_ini_seg and $registros_libre==1){
															
																
														$horas_rango_seg=$hora_fin_epl_la_misma_seg-$hora_ini_epl_la_misma_seg;
														
														//var_dump($horas_rango_seg);
														//var_dump($hora_fin_epl_la_misma_seg);
														//var_dump($hora_ini_epl_la_misma_seg);die();
														
														
														//Funcion para saber la hora militar exacta con 4 digitos 00:00
															$segundos_i = $horas_rango_seg; 

															$horas = intval($segundos_i/3600);

															if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
														  
																	$horas="0".$horas;
							
															}

															$restoSegundos = $segundos_i%3600;

															$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
														//Fin Funcion
													
														//OJO LOGICA PARA DETERMINAR SI HIZO EL RECARGO QUE LE CORESPONDE HASTA EL FIN O NO
														
														//APROXIMACION MINUTOS PARA EL RECARGO																								
														$holgura_seg_aprox=$tiempo_recargo*60;
														
														$horas_rango_hora=substr($horas_rango, 0, 2);//08												
														$horas_rango_min=substr($horas_rango, 3, 2);//19
														
														$horas_rango_hora_seg=$horas_rango_hora*3600;													
														$horas_rango_min_seg=$horas_rango_min*60;
														
														
														
														$hora_llevada_a_exacta_seg=3600-$horas_rango_min_seg;//resto 1 hora menos los minutos que tiene la hora
																																								
														$hora_aproximada=$horas_rango_min_seg+$hora_llevada_a_exacta_seg;//sumo esos minutos que tiene la hora + el restante
														
														$hora_aproximada_convertida_seg=$hora_aproximada-$holgura_seg_aprox;// resto la hora - 15min de parametrizacion
														
														
														
														if($horas_rango_min_seg>=$hora_aproximada_convertida_seg){
															
															$hora_rango_fija=(int)$horas_rango_hora+1;
																													
															$num_horas[$f]=$hora_rango_fija;
														
														}else{
															
															$hora_rango_fija=(int)$horas_rango_hora;
															
															$num_horas[$f]=$hora_rango_fija;
															
														}
																												
														//var_dump($num_horas);die();
														//FIN DEL OJO DE LA LOGICA
													
																
											
												}else{ 
												
														if($hora_ini_epl_la_misma_seg<=$t_hor_fin_seg and $hora_ini_epl_la_misma_seg>=$t_hor_ini_seg ){
															
																$horas_rango_seg=$t_hor_fin_seg-$hora_ini_epl_la_misma_seg;
																
																//var_dump($horas_rango_seg);
																//var_dump($t_hor_fin_seg);
																//var_dump($hora_ini_epl_la_misma_seg);die();
																
																
																//Funcion para saber la hora militar exacta con 4 digitos 00:00
																	$segundos_i = $horas_rango_seg; 

																	$horas = intval($segundos_i/3600);

																	if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
																  
																			$horas="0".$horas;
									
																	}

																	$restoSegundos = $segundos_i%3600;

																	$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
																//Fin Funcion
															
															
																//OJO LOGICA PARA DETERMINAR SI HIZO EL RECARGO QUE LE CORESPONDE HASTA EL FIN O NO
																
																//APROXIMACION MINUTOS PARA EL RECARGO																								
																$holgura_seg_aprox=$tiempo_recargo*60;
																
																$horas_rango_hora=substr($horas_rango, 0, 2);//08												
																$horas_rango_min=substr($horas_rango, 3, 2);//19
																
																$horas_rango_hora_seg=$horas_rango_hora*3600;													
																$horas_rango_min_seg=$horas_rango_min*60;
																
																
																$hora_llevada_a_exacta_seg=3600-$horas_rango_min_seg;//resto 1 hora menos los minutos que tiene la hora
																																										
																$hora_aproximada=$horas_rango_min_seg+$hora_llevada_a_exacta_seg;//sumo esos minutos que tiene la hora + el restante
																
																$hora_aproximada_convertida_seg=$hora_aproximada-$holgura_seg_aprox;// resto la hora - 15min de parametrizacion
																
																
																
																if($horas_rango_min_seg>=$hora_aproximada_convertida_seg){
																	
																	$hora_rango_fija=(int)$horas_rango_hora+1;
																															
																	$num_horas[$f]=$hora_rango_fija;
																
																}else{
																	
																	$hora_rango_fija=(int)$horas_rango_hora;
																	
																	$num_horas[$f]=$hora_rango_fija;
																	
																}
																
																
																//var_dump($num_horas);die();
																//FIN DEL OJO DE LA LOGICA
																
																
													
													
														}
													}
											
											}else{
											
											
												/*
												if($f==1){
												
													var_dump($hora_fin_epl_la_misma_seg);
													var_dump(">=");
													var_dump($t_hor_ini_seg);
													var_dump($hora_fin_epl_la_misma_seg);
													var_dump("<=");
													var_dump($t_hor_fin_seg);die("si2");
													
												
												}*/
																			
											
												
												if($hora_fin_epl_la_misma_seg>=$t_hor_ini_seg and $hora_fin_epl_la_misma_seg<=$t_hor_fin_seg){
												
													$horas_rango_seg=$hora_fin_epl_la_misma_seg-$t_hor_ini_seg;
												
													//Funcion para saber la hora militar exacta con 4 digitos 00:00
														$segundos_i = $horas_rango_seg; 

														$horas = intval($segundos_i/3600);

														if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
													  
																$horas="0".$horas;
						
														}

														$restoSegundos = $segundos_i%3600;

														$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
													//Fin Funcion
												
																								
													
													//OJO LOGICA PARA DETERMINAR SI HIZO EL RECARGO QUE LE CORESPONDE HASTA EL FIN O NO
													
													//APROXIMACION MINUTOS PARA EL RECARGO																								
													$holgura_seg_aprox=$tiempo_recargo*60;
													
													$horas_rango_hora=substr($horas_rango, 0, 2);//08												
													$horas_rango_min=substr($horas_rango, 3, 2);//19
													
													$horas_rango_hora_seg=$horas_rango_hora*3600;													
													$horas_rango_min_seg=$horas_rango_min*60;
													
													
													$hora_llevada_a_exacta_seg=3600-$horas_rango_min_seg;//resto 1 hora menos los minutos que tiene la hora
																																							
													$hora_aproximada=$horas_rango_min_seg+$hora_llevada_a_exacta_seg;//sumo esos minutos que tiene la hora + el restante
													
													$hora_aproximada_convertida_seg=$hora_aproximada-$holgura_seg_aprox;// resto la hora - 15min de parametrizacion
													
													
													
													if($horas_rango_min_seg>=$hora_aproximada_convertida_seg){
														
														$hora_rango_fija=(int)$horas_rango_hora+1;
																												
														$num_horas[$f]=$hora_rango_fija;
													
													}else{
														
														$hora_rango_fija=(int)$horas_rango_hora;
														
														$num_horas[$f]=$hora_rango_fija;
														
													}
													
													//FIN DEL OJO DE LA LOGICA
													
												
												
												}else{
														
															$horas_rango_seg=$t_hor_fin_seg-$t_hor_ini_seg;
														
															//Funcion para saber la hora militar exacta con 4 digitos 00:00
																$segundos_i = $horas_rango_seg; 

																$horas = intval($segundos_i/3600);

																if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
															  
																		$horas="0".$horas;
								
																}

																$restoSegundos = $segundos_i%3600;

																$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
															//Fin Funcion
														
														
															//OJO LOGICA PARA DETERMINAR SI HIZO EL RECARGO QUE LE CORESPONDE HASTA EL FIN O NO
													
															//APROXIMACION MINUTOS PARA EL RECARGO																								
															$holgura_seg_aprox=$tiempo_recargo*60;
															
															$horas_rango_hora=substr($horas_rango, 0, 2);//08												
															$horas_rango_min=substr($horas_rango, 3, 2);//19
															
															$horas_rango_hora_seg=$horas_rango_hora*3600;													
															$horas_rango_min_seg=$horas_rango_min*60;
															
															
															$hora_llevada_a_exacta_seg=3600-$horas_rango_min_seg;//resto 1 hora menos los minutos que tiene la hora
																																									
															$hora_aproximada=$horas_rango_min_seg+$hora_llevada_a_exacta_seg;//sumo esos minutos que tiene la hora + el restante
															
															$hora_aproximada_convertida_seg=$hora_aproximada-$holgura_seg_aprox;// resto la hora - 15min de parametrizacion
															
															
															
															if($horas_rango_min_seg>=$hora_aproximada_convertida_seg){
																
																$hora_rango_fija=(int)$horas_rango_hora+1;
																														
																$num_horas[$f]=$hora_rango_fija;
															
															}else{
																
																$hora_rango_fija=(int)$horas_rango_hora;
																
																$num_horas[$f]=$hora_rango_fija;
																
															}
															
															//FIN DEL OJO DE LA LOGICA
																	
											
												}												 
																
											
											}
										
										$f++;
										
									}//Cierre while	
							
							
							
							/*
								var_dump($num_conceptos_recargos_libres);
								var_dump($num_horas);		
								die("Probando");
							*/
							
							
								
								
								$cant=count($num_conceptos_recargos_libres);								

								for($y=0; $y<$cant; $y++){				

									//[hfd_rel]  	= Concepto 8 
									//[rno_rel] 	= Concepto 9
									//[rnf_rel] 	= Concepto 10												  

									switch($num_conceptos_recargos_libres[$y]){
											case 8:	
												@$hfd_rel+=$num_horas[$y];
												break;
											case 9:
												@$rno_rel+=$num_horas[$y];
												break;
											case 10:
												@$rnf_rel+=$num_horas[$y];
												break;											   
									}														   
								}//FIN FOR Y		
													
							}
							
							
							//*********FIN INCLUDE RECARGOS*********************************************************************
																
																						
							//INSERCCIONES DE EXTRAS Y RECARGOS ESPECIALES DE TURNO L
								
															
								$fecha_aut=$anio."-".$i."-".$mes;
								$estado="Pendiente";
								$color="#F5F4B1";//Amarillo
								
								
								//**************SEGUIMIENTO 17******************	
								/*
									var_dump("Fecha del Turno ".@$fecha_aut);
									var_dump("Estado ".@$estado);
									var_dump("Cantidad de veces el for EXTRAS: ".@$cont);
									var_dump("hed_rel cod 4 ".@$hed_rel);
									var_dump("hed_rel cod 5 ".@$hen_rel);
									var_dump("hed_rel cod 6 ".@$hedf_rel);
									var_dump("hed_rel cod 7 ".@$henf_rel);
									var_dump("Cantidad de veces el for RECARGOS: ".@$cant);
									var_dump("hed_rel cod 8: ".@$hfd_rel);
									var_dump("hed_rel cod 9: ".@$rno_rel);
									var_dump("hed_rel cod 10: ".@$rnf_rel);											
									die("bn14");	
								*/
									
									
								$sql8="insert into prog_reloj_he(cod_epl, fecha, hed_rel, hen_rel, hedf_rel, henf_rel, hfd_rel, rno_rel, rnf_rel, hed_apr, hen_apr, hedf_apr, henf_apr, hfd_apr, rno_apr, rnf_apr, estado, cod_epl_jefe) 
										values('$codigo_epl', '$fecha_aut', $hed_rel, $hen_rel, $hedf_rel, $henf_rel, $hfd_rel, $rno_rel, $rnf_rel, $hed_apr, $hen_apr, $hedf_apr, $henf_apr, $hfd_apr, $rno_apr, $rnf_apr, '$estado', '$codigo')";
								
								
								
								$sql9="insert into colores(cod_epl, posicion,color,cod_cc2,cargo,cod_epl_jefe, mes, anio) 
										values('$codigo_epl', '$i','$color','$centro_costo','$cargo','$codigo','$mes','$anio') ";
									
									
								//**************SEGUIMIENTO 15*****************	
								/*
								var_dump($sql8);
								var_dump($sql9);
								die("bn15");										
								*/						
									
									
								$rs8=$conn->Execute($sql8);							
																	   
								$rs9=$conn->Execute($sql9);   
					
					
								
								
									
						}//Fin else DE //LOGICA TODO
								
						continue;
						
			}//FIN TURNO LIBRE
			
			
			
			
			
				
				
				
				//10 MIN DE HOLGURA PARA QUE haya holgura antes de la entrada					
						$holgura_seg_diez=$tiempo_extra_horario*60;						
						$hora_ini_con_cambio_holgura_seg_entrada_bien=$hora_ini_real_sin_cambio_holgura_seg-$holgura_seg_diez;
						
						$holgura_seg_cinco=$tiempo_hora_completa*60;	
						$hora_fin_con_cambio_holgura_seg_entrada_bien=$hora_fin_real_sin_cambio_holgura_seg-$holgura_seg_cinco;
							
							
				//---------------SEGUIMIENTO 2-------------------				
				/*
					var_dump($hor_ini_entrada_seg_epl);//17:03
					var_dump(">=");
					var_dump($hora_ini_con_cambio_holgura_seg_entrada_bien);//16:50
					var_dump($hor_ini_entrada_seg_epl);//17:03
					var_dump("<=");
					var_dump($hora_ini_real_con_cambio_holgura_seg);//17:05
					var_dump($hor_fin_salida_seg_epl);//03:56
					var_dump(">=");
					var_dump($hora_fin_con_cambio_holgura_seg_entrada_bien);//03:55
					var_dump($hor_fin_salida_seg_epl);//03:56
					var_dump("<=");
					var_dump($hora_fin_real_con_cambio_holgura_seg);//04:05					
					die("bn2");
				*/
				
				
				
			//VAL4					
			//VALIDACION 1 = "MARCACION IGUAL A LO PROGRAMADO?"
				if($hor_ini_entrada_seg_epl>=$hora_ini_con_cambio_holgura_seg_entrada_bien and $hor_ini_entrada_seg_epl<=$hora_ini_real_con_cambio_holgura_seg and
					$hor_fin_salida_seg_epl>=$hora_fin_con_cambio_holgura_seg_entrada_bien and $hor_fin_salida_seg_epl<=$hora_fin_real_con_cambio_holgura_seg){
					
					
					
					
						//INCLUDE_RECARGOS**********************************************************************************************
					
						
								$validacion_festivo=festivo($anio,$i,$mes);							
								$dia=dia_en_entero($anio,$i,$mes);						
								$dia_letras=dia_letras($dia);					
				
							
								$hor_ini_real_query=substr($hor_ini_real, 11, 5);//hora entrada real del turno						
								$hor_fin_real_query=substr($hor_fin_real, 11, 5);//hora salida real del turno														
								
								//Para que entre y haga el insert si no pornga gris
								$extras=0;
								$recargos=0;
								
								//Inicializar Variables
								$hed_rel= 0.000; 
								$hen_rel= 0.000;
								$hedf_rel=0.000; 
								$henf_rel=0.000;

								$hfd_rel= 0.000; 
								$rno_rel= 0.000;
								$rnf_rel= 0.000;

								$hed_apr= 0.000;
								$hen_apr= 0.000;
								$hedf_apr=0.000;
								$henf_apr=0.000;

								$hfd_apr= 0.000;
								$rno_apr= 0.000;
								$rnf_apr= 0.000;
								
								//INCLUDE RECARGOS Bueno*******************************************************************
															
								
											include("funcion_recargos.php");
							
								//*********FIN INCLUDE RECARGOS Bueno*******************************************
								


							
				
								if($recargos==1){

											$fecha_aut=$anio."-".$i."-".$mes;
											$estado="Pendiente";
											$color="#F5A65D";//Naranja
											//$color="#CBD0CB";//GRIS
						
						
						
											//**************SEGUIMIENTO 14******************//	
											/*												
												var_dump("hed_rel cod 8: ".@$hfd_rel);
												var_dump("hed_rel cod 9: ".@$rno_rel);
												var_dump("hed_rel cod 10: ".@$rnf_rel);											
												die("bn14");	
											*/
								
								
								
											$sql8="insert into prog_reloj_he(cod_epl, fecha, hed_rel, hen_rel, hedf_rel, henf_rel, hfd_rel, rno_rel, rnf_rel, hed_apr, hen_apr, hedf_apr, henf_apr, hfd_apr, rno_apr, rnf_apr, estado, cod_epl_jefe) 
												values('$codigo_epl', '$fecha_aut', $hed_rel, $hen_rel, $hedf_rel, $henf_rel, $hfd_rel, $rno_rel, $rnf_rel, $hed_apr, $hen_apr, $hedf_apr, $henf_apr, $hfd_apr, $rno_apr, $rnf_apr, '$estado', '$codigo') ";
											

									
											
											$sql9="insert into colores(cod_epl, posicion,color,cod_cc2,cargo,cod_epl_jefe, mes, anio) 
												values('$codigo_epl', '$i','$color','$centro_costo','$cargo','$codigo','$mes','$anio') ";
								
								
								
											//**************SEGUIMIENTO 15******************//	
											/*	var_dump($sql8);die("bn");
												var_dump($sql9);
												die("bn15");	*/									
																		
								
								
								
											$rs8=$conn->Execute($sql8);							
								   									   
											$rs9=$conn->Execute($sql9);	
											
								}else{				
					
									$color="#CBD0CB";//Gris
					
									$sql11="insert into colores(cod_epl, posicion,color,cod_cc2,cargo,cod_epl_jefe, mes, anio)values('$codigo_epl', '$i','$color','$centro_costo','$cargo','$codigo','$mes','$anio') ";
								   									   
									$rs11=$conn->Execute($sql11);	
								}
								
					continue;
				
				}//Fin if Validacion 1				
				
				
				
				//**************SEGUIMIENTO 11******************//
				/*
				var_dump("hora_entrada_epl ".$hor_entrada_epl);var_dump("hora_salida_epl ".$hor_salida_epl);var_dump("Diferencia_del_epl: ".$diferencia_horas_epl);//OJO ME DA LA DIFERENCIA EXACTA				
				var_dump("Son las horas de diferencia que tiene el turno REAL ".$horas_turno_real);
				var_dump("Son las horas de diferencia que tiene el turno hecho por el EMPLEADO ".$horas_turno_epl); 			
				var_dump("Son LOS SEGUNDOS de diferencia que tiene el turno REAL ".$horas_turno_real_seg); 
				var_dump("Son LOS SEGUNDOS de diferencia que tiene el turno hecho por el EMPLEADO ".$horas_turno_epl_seg);die("bn11");			
			    */
				
				
				
				//diferencia_horas_epl---pasarla a segundos			
				$diferencia_horas_epl_hora=substr($diferencia_horas_epl, 0, 2);
				$diferencia_horas_epl_min=substr($diferencia_horas_epl, 3, 2);
								
				$diferencia_horas_epl_hora_seg=$diferencia_horas_epl_hora*3600;
				$diferencia_horas_epl_min_seg=$diferencia_horas_epl_min*60;
							
				$diferencia_horas_epl_seg_final=$diferencia_horas_epl_hora_seg+$diferencia_horas_epl_min_seg;
				
				//5 MIN DE HOLGURA PARA SABER QUE SI ALCANZO A HACER SU HORA
				$holgura_seg_cinco=$tiempo_hora_completa*60;
				$horas_turno_real_seg_ajustado_holgura=$horas_turno_real_seg-$holgura_seg_cinco;
				
				
				
				//Validacion ingreso a este condicional son horas de diferencia OJO
				//var_dump($horas_turno_real_seg_ajustado_holgura);var_dump("<=");var_dump($diferencia_horas_epl_seg_final);die();
				
							
				
				//VAL5	
				//VALIDACION 2= "Cumple con las horas igual a lo del turno?"		
				if($horas_turno_real_seg_ajustado_holgura<=$diferencia_horas_epl_seg_final){ //----> Ejemplo:  (REAL)9<=10(EPL)  si porque asi sea que sea igual o se pase ha cumplido con su turno
												
					
						
						//15 MIN DE HOLGURA PARA QUE CUENTEN EXTRAS (Antes y Despues)						
						$holgura_seg_quince=$tiempo_extra*60;
												
						$hor_ini_t_start_contar_extra=$hora_ini_real_sin_cambio_holgura_seg-$holgura_seg_quince;
						$hor_fin_t_start_contar_extra=$hora_fin_real_sin_cambio_holgura_seg+$holgura_seg_quince;
						
						//10 MIN DE HOLGURA PARA QUE haya holgura antes de la entrada					
						$holgura_seg_diez=$tiempo_extra_horario*60;
						$hora_ini_con_cambio_holgura_seg_entrada=$hora_ini_real_sin_cambio_holgura_seg-$tiempo_extra_horario;						
						
						
						
						//**************Validacion 3******************//				
						/*
						var_dump("Validacion 3: Tu horario de tu marcacion SI o NO COINCIDE CON TURNO que se programo?");
						var_dump($hor_ini_entrada_seg_epl."(".$hor_entrada_epl.") >=".$hora_ini_real_sin_cambio_holgura_seg ."(".$hor_ini_real.")");
						var_dump($hor_ini_entrada_seg_epl."(".$hor_entrada_epl.") <=".$hora_ini_real_con_cambio_holgura_seg ."(".$hor_ini_real." +5min)");die("bn12");
						*/
				
				
				
									
						//VALIDACION 3= "Tu horario de tu marcacion SI COINCIDE CON TURNO que se programo CON RESPECTO A LA ENTRADA"   (hor_ini_entrada_seg_epl)09:55>=09:55 and  (hor_ini_entrada_seg_epl)9:55<=10:05
						
						//ACA SIEMPRE VA ENTRAR SIN EXTRAS AL PIRNCIPIO PORQUE COINCIDE CON LA ENTRADA
						if($hor_ini_entrada_seg_epl >=$hora_ini_con_cambio_holgura_seg_entrada  and  $hor_ini_entrada_seg_epl<=$hora_ini_real_con_cambio_holgura_seg){					
									

									
								$num_conceptos_extras=array();
								$num_extras=array();
								
								$validacion_festivo=festivo($anio,$i,$mes);							
								$dia=dia_en_entero($anio,$i,$mes);						
								$dia_letras=dia_letras($dia);					
							
								$hor_ini_real_query=substr($hor_ini_real, 11, 5);//hora entrada real del turno						
								$hor_fin_real_query=substr($hor_fin_real, 11, 5);//hora salida real del turno														
								
								//Para que entre y haga el insert si no ponga gris
								$extras=0;
								$recargos=0;
								
								
								
								/*
								
									var_dump($validacion_festivo);
									var_dump($dia);
									var_dump($dia_letras);
									var_dump($hor_ini_real_query);
									var_dump($hor_fin_real_query);
									die("wow");
								
								*/
								
								
								
								//validacion desde aca miro si tiene extras o no despues de los 15 min
								$total_validar_extras=$hora_fin_real_sin_cambio_holgura_seg+$tiempo_extra_seg;
								
								
								/*
								VAR_DUMP("SALIDA DEL EPL: ".$hor_fin_salida_seg_epl);//19:14
								VAR_DUMP($hora_fin_real_sin_cambio_holgura_seg);//19:00
								VAR_DUMP($tiempo_extra_seg);//19:00
								VAR_DUMP($total_validar_extras);//19:00
								DIE();	
								*/
								
							if($hor_fin_salida_seg_epl>$total_validar_extras){
		
								
								//INCLUDE EXTRAS BUENO*************************************************************
								
											include("funcion_extras_una.php");
								
								//**********FIN INCLUDE EXTRAS BUENO**********************************							
							
								//INCLUDE RECARGOS Bueno*******************************************************************
															
								
											include("funcion_recargos.php");
							
								//*********FIN INCLUDE RECARGOS Bueno*******************************************
								
								
													
							}
								
								if($extras==1 or $recargos==1){

							
											$fecha_aut=$anio."-".$i."-".$mes;
											$estado="Pendiente";
											$color="#F5A65D";//Naranja
											//$color="#CBD0CB";//GRIS
						
						
						
											//**************SEGUIMIENTO 14******************//	
											/*
												var_dump("Fecha del Turno ".@$fecha_aut);
												var_dump("Estado ".@$estado);
												var_dump("Cantidad de veces el for EXTRAS: ".@$cont);
												var_dump("hed_rel cod 4 ".@$hed_rel);
												var_dump("hed_rel cod 5 ".@$hen_rel);
												var_dump("hed_rel cod 6 ".@$hedf_rel);
												var_dump("hed_rel cod 7 ".@$henf_rel);
												var_dump("Cantidad de veces el for RECARGOS: ".@$cant);
												var_dump("hed_rel cod 8: ".@$hfd_rel);
												var_dump("hed_rel cod 9: ".@$rno_rel);
												var_dump("hed_rel cod 10: ".@$rnf_rel);											
												die("bn14");	
											*/
								
								
								
											$sql8="insert into prog_reloj_he(cod_epl, fecha, hed_rel, hen_rel, hedf_rel, henf_rel, hfd_rel, rno_rel, rnf_rel, hed_apr, hen_apr, hedf_apr, henf_apr, hfd_apr, rno_apr, rnf_apr, estado, cod_epl_jefe) 
												values('$codigo_epl', '$fecha_aut', $hed_rel, $hen_rel, $hedf_rel, $henf_rel, $hfd_rel, $rno_rel, $rnf_rel, $hed_apr, $hen_apr, $hedf_apr, $henf_apr, $hfd_apr, $rno_apr, $rnf_apr, '$estado', '$codigo') ";
											

									
											
											$sql9="insert into colores(cod_epl, posicion,color,cod_cc2,cargo,cod_epl_jefe, mes, anio) 
												values('$codigo_epl', '$i','$color','$centro_costo','$cargo','$codigo','$mes','$anio') ";
								
								
								
											//**************SEGUIMIENTO 15******************//	
											/*	var_dump($sql8);die("bn");
												var_dump($sql9);
												die("bn15");	*/									
																		
								
								
								
											$rs8=$conn->Execute($sql8);							
								   									   
											$rs9=$conn->Execute($sql9);	
							
								}else{
							
									
									
									$color="#CBD0CB";//Gris
					
									$sql11="insert into colores(cod_epl, posicion,color,cod_cc2,cargo,cod_epl_jefe, mes, anio)values('$codigo_epl', '$i','$color','$centro_costo','$cargo','$codigo','$mes','$anio') ";
															
									$rs11=$conn->Execute($sql11);
							
							
								}						
								
													
						
						}else{//CIERRE VALIDACION 3 Y ABRE NUEVO VAL7							
										
								
														
								$color='#E78587';//Rojo
												
								$sql21="insert into colores(cod_epl, posicion,color,cod_cc2,cargo,cod_epl_jefe, mes, anio) 
										values('$codigo_epl', '$i','$color','$centro_costo','$cargo','$codigo','$mes','$anio') ";
																		   
															
								
								//**************SEGUIMIENTO 22******************//	
								/*
									var_dump($sql21);
									var_dump("Bandera ".@$flag);								
									die("bn22");	
								*/
								
								$conn->Execute($sql21);	
								
								$flag=1;
																
								
								$num_conceptos_extras=array();
								$num_extras=array();
								
								$validacion_festivo=festivo($anio,$i,$mes);							
								$dia=dia_en_entero($anio,$i,$mes);						
								$dia_letras=dia_letras($dia);					
							
								$hor_ini_real_query=substr($hor_ini_real, 11, 5);//hora entrada real del turno							
								$hor_fin_real_query=substr($hor_fin_real, 11, 5);//hora salida real del turno

														
								
								//INCLUDE EXTRAS BUENO*************************************************************
								
											include("funcion_extras_ambas.php");
								
								//**********FIN INCLUDE EXTRAS BUENO**********************************							
							
							
								
								//INCLUDE RECARGOS Bueno*******************************************************************
															
								
											include("funcion_recargos.php");
							
								//*********FIN INCLUDE RECARGOS Bueno*******************************************
					

																							
										

										
									$fecha_aut=$anio."-".$i."-".$mes;
									$estado="Pendiente";
									$color="#F5A65D";//Naranja
									
									
										
									//**************SEGUIMIENTO 17******************//	
									/*
										var_dump("Fecha del Turno ".@$fecha_aut);
										var_dump("Estado ".@$estado);
										var_dump("Cantidad de veces el for EXTRAS: ".@$cont);
										var_dump("hed_rel cod 4 ".@$hed_rel);
										var_dump("hed_rel cod 5 ".@$hen_rel);
										var_dump("hed_rel cod 6 ".@$hedf_rel);
										var_dump("hed_rel cod 7 ".@$henf_rel);
										var_dump("Cantidad de veces el for RECARGOS: ".@$cant);
										var_dump("hed_rel cod 8: ".@$hfd_rel);
										var_dump("hed_rel cod 9: ".@$rno_rel);
										var_dump("hed_rel cod 10: ".@$rnf_rel);											
										die("bn14");	
									*/
						
						
								
									if($flag==1){
										
										$sql8="insert into prog_reloj_he(cod_epl, fecha, hed_rel, hen_rel, hedf_rel, henf_rel, hfd_rel, rno_rel, rnf_rel, hed_apr, hen_apr, hedf_apr, henf_apr, hfd_apr, rno_apr, rnf_apr, estado, cod_epl_jefe) 
												values('$codigo_epl', '$fecha_aut', $hed_rel, $hen_rel, $hedf_rel, $henf_rel, $hfd_rel, $rno_rel, $rnf_rel, $hed_apr, $hen_apr, $hedf_apr, $henf_apr, $hfd_apr, $rno_apr, $rnf_apr, '$estado', '$codigo') ";
									
									/*
											if($i==9){
												VAR_DUMP($sql8);DIE('MUAK4');
											}*/
										
										$sql9="update colores set color_mas='$color' 
											   where posicion='$i' and mes='$mes' and anio='$anio' and cod_epl='".$codigo_epl."'";

										//**************SEGUIMIENTO 23******************//	
										/*
											var_dump($sql21);											
											var_dump("sql 8: ".$sql8);
											var_dump("sql 9: ".$sql9);																													
											die("bn23");	
										*/										
								
										$rs8=$conn->Execute($sql8);
								   								  							
										$rs9=$conn->Execute($sql9);	
										
									}									
										
													
												
						}//FIN ELSE	de tu horario no coincide con lo programado	CIERRE VALIDACIO 3		
					
					
				}else{// FIN VALIDACION 2
						
						
						//echo "Menor tiempo laborado a lo programado \n";

						$color='#F997C5';//Rosado
						
						$sql10="insert into colores(cod_epl, posicion,color,cod_cc2,cargo,cod_epl_jefe, mes, anio, hor_trab) 
								values('$codigo_epl', '$i','$color','$centro_costo','$cargo','$codigo','$mes','$anio', '$horas_turno_epl') ";
						
						//var_dump($sql10);die();
						
						$rs10=$conn->Execute($sql10);	
				}				
			}	
		
		
		}//FIN FOR MODULO			
			
?>

