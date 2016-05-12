<?php
//FUNCION RECARGOS para ambas horas tanto entrada como salida

									$validacion_festivo=festivo($anio,$i,$mes);							
									$dia=dia_en_entero($anio,$i,$mes);						
									$dia_letras=dia_letras($dia);					

									
									
									//ENTRADA Y SALIDA DEL TURNO REAL						
									$hor_ini_real_query=substr($hor_ini_real, 11, 5);//hora entrada real del turno
									$hora_ini_real_sin_cambio_holgura_seg;//hora entrada real del turno en segundos

									$hor_fin_real_query=substr($hor_fin_real, 11, 5);//hora salida real del turno														
									$hora_fin_real_sin_cambio_holgura_seg;//hora salida real del turno en segundos

									$horas_turno_real_seg;//DIFERENCIA HORAS DE TURNOS REAL

									//ENTRADA Y SALIDA DEL EMPLEADO
									$hor_entrada_epl;//hora entrada epl
									$hor_ini_entrada_seg_epl;//hora entrada epl segundos

									$hor_salida_epl;//hora salida epl							
									$hor_fin_salida_seg_epl;//hora salida epl segundos

									/*
									var_dump("Hora Entrada Real: ".$hor_ini_real_query);
									var_dump("Hora Salida Real: ".$hor_fin_real_query);
									var_dump("Horas Diferencia tuno Real: ".$horas_turno_real_seg);
									var_dump("Hora Entrada EPL: ".$hor_entrada_epl);
									var_dump("Hora Salida Epl: ".$hor_salida_epl);
									var_dump("Horas Diferencia tuno EPL: ".$horas_diferencia_totales_segundos);									
									die();
									*/
									
									
									

									
									
								//NUEVO
								$hora_sumada=0;
								
								
								//hora entrada del turno real y le sumo las horas que hay de diferencia en ese turno real								
								$hora_sumada=$hora_ini_real_sin_cambio_holgura_seg+$horas_turno_real_seg;
								
								
								/*								
								var_dump($hora_sumada);die();
								*/
								
								
								if($hora_sumada>$hora_cero){
													
										$flago1=1;
										
										$dia_letras_existe_anterior=dia_letras($dia);	
										//var_dump($dia_letras_existe_anterior);die("bn2");
										
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
										$dia_letras_existe_actual_recargo=dia_letras($dia_existe_actual);	
										$validacion_festivo_existe_actual_recargo=festivo($anio,($i),$mes);
										
								}						
								
								/*
								var_dump($dia_existe_actual);
								var_dump($dia_letras_existe_actual_recargo);
								var_dump($validacion_festivo_existe_actual_recargo);
								var_dump("-----");
								var_dump("FESTIVO EL DIA ANTERIOR O NO: ".$validacion_festivo);
								var_dump($validacion_festivo);
								var_dump("anterior: ".$dia_letras_existe_anterior);
								var_dump($dia_letras_existe_actual);
								var_dump($validacion_festivo_existe_actual);
								die();
								*/
								
								
								//NUEVO OJO
								if($validacion_festivo){
									$dia_letras_existe_anterior="Festivo";
								}
								
								if($validacion_festivo_existe_actual){
									$dia_letras_existe_actual="Festivo";
								}
								
								if($validacion_festivo_existe_actual_recargo){
									$dia_letras_existe_actual_recargo="Festivo";
								}
								
								
								
								//Otra Validacion
								//Si la  hor_entrada_epl>hor_ini_real_query => COJA LA hor_entrada_epl
								
								
								if($hor_ini_entrada_seg_epl>$hora_ini_real_sin_cambio_holgura_seg){
									
									$hor_ini_real_query=$hor_entrada_epl;
									$hora_ini_real_sin_cambio_holgura_seg=$hor_ini_entrada_seg_epl;
								
								}
								
								
								
								
								
								//COMPRUEBA SI EXISTE RECARGOS O NO
								
								if($flago1==1){
									
									$query="SELECT * FROM conceptos_extras_tmp WHERE estado='R' and (hor_fin>='".$hor_ini_real_query."' and ".$dia_letras_existe_anterior."=1 or hor_ini<='".$hor_fin_real_query."'and ".$dia_letras_existe_actual."=1)"; //--se pasa del dia laborado 

									
								}else{
									
																		
									$query="SELECT * FROM conceptos_extras_tmp WHERE estado='R' and ((hor_fin>='".$hor_ini_real_query."' and ".$dia_letras_existe_actual_recargo."=1) and (hor_ini<='".$hor_fin_real_query."' and ".$dia_letras_existe_actual_recargo."=1))";
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
																														
											//LOGICA DE CONTEO DE HORAS POR RANGO
											$t_hor_ini=$row_query['hor_ini'];
											$t_hor_ini_seg=convertir_segundos_horas($t_hor_ini);

											$t_hor_fin=$row_query['hor_fin'];
											$t_hor_fin_seg=convertir_segundos_horas($t_hor_fin);
											
											
											/*
											if($f==0){
											
												var_dump($num_conceptos_recargos_libres);
												var_dump("hor_ini: ".$t_hor_ini);//06:00
												var_dump("hor_fin: ".$t_hor_fin);//21:59
												die("si");
											
											}
											*/
											
						
						
						
											/*
											if($f==0){
												var_dump($hora_ini_real_sin_cambio_holgura_seg);//19:00
												var_dump("<=");
												var_dump($t_hor_fin_seg);//23:59
												
												var_dump($hora_ini_real_sin_cambio_holgura_seg);//19:00
												var_dump(">=");
												var_dump($t_hor_ini_seg);//22:00
												die("si");
											}
											*/
											


											
											
											if($f==0){

//VAL1
												if($hora_ini_real_sin_cambio_holgura_seg<=$t_hor_fin_seg and $hora_ini_real_sin_cambio_holgura_seg>=$t_hor_ini_seg and $registros_libre==1){
															
																
																$horas_rango_seg=$hora_fin_real_sin_cambio_holgura_seg-$hora_ini_real_sin_cambio_holgura_seg;
																
																//var_dump($hora_fin_real_sin_cambio_holgura_seg);
																//var_dump($hora_ini_real_sin_cambio_holgura_seg);
																//var_dump($horas_rango_seg);die();
																
																
																//Funcion para saber la hora militar exacta con 4 digitos 00:00
																	$segundos_i = $horas_rango_seg; 

																	$horas = intval($segundos_i/3600);

																	if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
																  
																			$horas="0".$horas;
									
																	}

																	$restoSegundos = $segundos_i%3600;

																	$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
																//Fin Funcion
															
															
															/*
																//OJO LOGICA PARA DETERMINAR SI HIZO EL RECARGO QUE LE CORESPONDE HASTA EL FIN O NO
																
																//APROXIMACION MINUTOS PARA EL RECARGO																								
																$holgura_seg_aprox=$tiempo_recargo*60;
																
																$horas_rango_hora=substr($horas_rango, 0, 2);//08												
																$horas_rango_min=substr($horas_rango, 3, 2);//19
																
																$horas_rango_hora_seg=$horas_rango_hora*3600;													
																$horas_rango_min_seg=$horas_rango_min*60;
																
																//var_dump("holgura: ".$holgura_seg_aprox);
																//var_dump("hora: ".$horas_rango_hora);
																//var_dump("min: ".$horas_rango_min);
																//var_dump("hora_seg: ".$horas_rango_hora_seg);
																//var_dump("min_seg: ".$horas_rango_min_seg);
																//die("bn");
																
																
																$hora_llevada_a_exacta_seg=3600-$horas_rango_min_seg;//resto 1 hora menos los minutos que tiene la hora
																																										
																$hora_aproximada=$horas_rango_min_seg+$hora_llevada_a_exacta_seg;//sumo esos minutos que tiene la hora + el restante
																
																$hora_aproximada_convertida_seg=$hora_aproximada-$holgura_seg_aprox;// resto la hora - 15min de parametrizacion
																
																//var_dump($hora_aproximada_convertida_seg);die("bm");
																
																
																if($horas_rango_min_seg>=$hora_aproximada_convertida_seg){
																	
																	$hora_rango_fija=(int)$horas_rango_hora+1;
																															
																	$num_horas[$f]=$hora_rango_fija;
																
																}else{
																	
																	$hora_rango_fija=(int)$horas_rango_hora;
																	
																	$num_horas[$f]=$hora_rango_fija;
																	
																}
																
																
																//var_dump($num_horas);die();
																//FIN DEL OJO DE LA LOGICA
																*/
																
																$num_horas[$f]=$horas_rango;
																
																//var_dump($num_horas);die();
																
																
																
											
												}else{ 
														
														
												
												
														if($hora_ini_real_sin_cambio_holgura_seg<=$t_hor_fin_seg and $hora_ini_real_sin_cambio_holgura_seg>=$t_hor_ini_seg ){
															
																$horas_rango_seg=$t_hor_fin_seg-$hora_ini_real_sin_cambio_holgura_seg;
																
																/*
																var_dump($t_hor_fin_seg);
																var_dump($hora_ini_real_sin_cambio_holgura_seg);
																var_dump($horas_rango_seg);die();
																*/
																
																//Funcion para saber la hora militar exacta con 4 digitos 00:00
																	$segundos_i = $horas_rango_seg; 

																	$horas = intval($segundos_i/3600);

																	if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
																  
																			$horas="0".$horas;
									
																	}

																	$restoSegundos = $segundos_i%3600;

																	$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
																//Fin Funcion
															
															
															/*
																//OJO LOGICA PARA DETERMINAR SI HIZO EL RECARGO QUE LE CORESPONDE HASTA EL FIN O NO
																
																//APROXIMACION MINUTOS PARA EL RECARGO																								
																$holgura_seg_aprox=$tiempo_recargo*60;
																
																$horas_rango_hora=substr($horas_rango, 0, 2);//08												
																$horas_rango_min=substr($horas_rango, 3, 2);//19
																
																$horas_rango_hora_seg=$horas_rango_hora*3600;													
																$horas_rango_min_seg=$horas_rango_min*60;
																
																//var_dump("holgura: ".$holgura_seg_aprox);
																//var_dump("hora: ".$horas_rango_hora);
																//var_dump("min: ".$horas_rango_min);
																//var_dump("hora_seg: ".$horas_rango_hora_seg);
																//var_dump("min_seg: ".$horas_rango_min_seg);
																//die("bn");
																
																
																$hora_llevada_a_exacta_seg=3600-$horas_rango_min_seg;//resto 1 hora menos los minutos que tiene la hora
																																										
																$hora_aproximada=$horas_rango_min_seg+$hora_llevada_a_exacta_seg;//sumo esos minutos que tiene la hora + el restante
																
																$hora_aproximada_convertida_seg=$hora_aproximada-$holgura_seg_aprox;// resto la hora - 15min de parametrizacion
																
																//var_dump($hora_aproximada_convertida_seg);die("bm");
																
																
																if($horas_rango_min_seg>=$hora_aproximada_convertida_seg){
																	
																	$hora_rango_fija=(int)$horas_rango_hora+1;
																															
																	$num_horas[$f]=$hora_rango_fija;
																
																}else{
																	
																	$hora_rango_fija=(int)$horas_rango_hora;
																	
																	$num_horas[$f]=$hora_rango_fija;
																	
																}
																
																
																//var_dump($num_horas);die();
																//FIN DEL OJO DE LA LOGICA
																*/
																
																$num_horas[$f]=$horas_rango;
																
																//var_dump($num_horas);die();
																
																
													
													
														}else{
														
																$horas_rango_seg=$t_hor_fin_seg-$t_hor_ini_seg;
																
																/*
																var_dump($t_hor_fin_seg);
																var_dump($t_hor_ini_seg);
																var_dump($horas_rango_seg);die();
																*/
																
																//Funcion para saber la hora militar exacta con 4 digitos 00:00
																	$segundos_i = $horas_rango_seg; 

																	$horas = intval($segundos_i/3600);

																	if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
																  
																			$horas="0".$horas;
									
																	}

																	$restoSegundos = $segundos_i%3600;

																	$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
																//Fin Funcion
																
																
															/*
																//OJO LOGICA PARA DETERMINAR SI HIZO EL RECARGO QUE LE CORESPONDE HASTA EL FIN O NO
																
																//APROXIMACION MINUTOS PARA EL RECARGO																								
																$holgura_seg_aprox=$tiempo_recargo*60;
																
																$horas_rango_hora=substr($horas_rango, 0, 2);//08												
																$horas_rango_min=substr($horas_rango, 3, 2);//19
																
																$horas_rango_hora_seg=$horas_rango_hora*3600;													
																$horas_rango_min_seg=$horas_rango_min*60;
																
																//var_dump("holgura: ".$holgura_seg_aprox);
																//var_dump("hora: ".$horas_rango_hora);
																//var_dump("min: ".$horas_rango_min);
																//var_dump("hora_seg: ".$horas_rango_hora_seg);
																//var_dump("min_seg: ".$horas_rango_min_seg);
																//die("bn");
																
																
																$hora_llevada_a_exacta_seg=3600-$horas_rango_min_seg;//resto 1 hora menos los minutos que tiene la hora
																																										
																$hora_aproximada=$horas_rango_min_seg+$hora_llevada_a_exacta_seg;//sumo esos minutos que tiene la hora + el restante
																
																$hora_aproximada_convertida_seg=$hora_aproximada-$holgura_seg_aprox;// resto la hora - 15min de parametrizacion
																
																//var_dump($hora_aproximada_convertida_seg);die("bm");
																
																
																if($horas_rango_min_seg>=$hora_aproximada_convertida_seg){
																	
																	$hora_rango_fija=(int)$horas_rango_hora+1;
																															
																	$num_horas[$f]=$hora_rango_fija;
																
																}else{
																	
																	$hora_rango_fija=(int)$horas_rango_hora;
																	
																	$num_horas[$f]=$hora_rango_fija;
																	
																}
																*/
																
																
																
																
																	
																$num_horas[$f]=$horas_rango;
																
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
													
												
												}
												*/							
											
												
												if($hora_fin_real_sin_cambio_holgura_seg>=$t_hor_ini_seg and $hora_fin_real_sin_cambio_holgura_seg<=$t_hor_fin_seg){
												
													$horas_rango_seg=$hora_fin_real_sin_cambio_holgura_seg-$t_hor_ini_seg;
												
												//Funcion para saber la hora militar exacta con 4 digitos 00:00
														$segundos_i = $horas_rango_seg; 

														$horas = intval($segundos_i/3600);

														if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
													  
																$horas="0".$horas;
						
														}

														$restoSegundos = $segundos_i%3600;

														$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
													//Fin Funcion
												
													
													
													/*
													//OJO LOGICA PARA DETERMINAR SI HIZO EL RECARGO QUE LE CORESPONDE HASTA EL FIN O NO
													
													//APROXIMACION MINUTOS PARA EL RECARGO																								
													$holgura_seg_aprox=$tiempo_recargo*60;
													
													$horas_rango_hora=substr($horas_rango, 0, 2);//08												
													$horas_rango_min=substr($horas_rango, 3, 2);//19
													
													$horas_rango_hora_seg=$horas_rango_hora*3600;													
													$horas_rango_min_seg=$horas_rango_min*60;
													
													//var_dump("holgura: ".$holgura_seg_aprox);
													//var_dump("hora: ".$horas_rango_hora);
													//var_dump("min: ".$horas_rango_min);
													//var_dump("hora_seg: ".$horas_rango_hora_seg);
													//var_dump("min_seg: ".$horas_rango_min_seg);
													//die("bn");
													
													
													$hora_llevada_a_exacta_seg=3600-$horas_rango_min_seg;//resto 1 hora menos los minutos que tiene la hora
																																							
													$hora_aproximada=$horas_rango_min_seg+$hora_llevada_a_exacta_seg;//sumo esos minutos que tiene la hora + el restante
													
													$hora_aproximada_convertida_seg=$hora_aproximada-$holgura_seg_aprox;// resto la hora - 15min de parametrizacion
													
													//var_dump($hora_aproximada_convertida_seg);die("bm");
													
													
													if($horas_rango_min_seg>=$hora_aproximada_convertida_seg){
														
														$hora_rango_fija=(int)$horas_rango_hora+1;
																												
														$num_horas[$f]=$hora_rango_fija;
													
													}else{
														
														$hora_rango_fija=(int)$horas_rango_hora;
														
														$num_horas[$f]=$hora_rango_fija;
														
													}
													
													//FIN DEL OJO DE LA LOGICA
													*/
													
													$num_horas[$f]=$horas_rango;
																
													//var_dump($num_horas);die();
																
												
												
												
												}else{
														/*
														if($f==2){
														
															var_dump($t_hor_fin_seg);
															var_dump("-");
															var_dump($t_hor_ini_seg);
															die("si");
																													
														}
														*/
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
														
														
														/*
															//OJO LOGICA PARA DETERMINAR SI HIZO EL RECARGO QUE LE CORESPONDE HASTA EL FIN O NO
													
															//APROXIMACION MINUTOS PARA EL RECARGO																								
															$holgura_seg_aprox=$tiempo_recargo*60;
															
															$horas_rango_hora=substr($horas_rango, 0, 2);//08												
															$horas_rango_min=substr($horas_rango, 3, 2);//19
															
															$horas_rango_hora_seg=$horas_rango_hora*3600;													
															$horas_rango_min_seg=$horas_rango_min*60;
															
															//var_dump("holgura: ".$holgura_seg_aprox);
															//var_dump("hora: ".$horas_rango_hora);
															//var_dump("min: ".$horas_rango_min);
															//var_dump("hora_seg: ".$horas_rango_hora_seg);
															//var_dump("min_seg: ".$horas_rango_min_seg);
															//die("bn");
															
															
															$hora_llevada_a_exacta_seg=3600-$horas_rango_min_seg;//resto 1 hora menos los minutos que tiene la hora
																																									
															$hora_aproximada=$horas_rango_min_seg+$hora_llevada_a_exacta_seg;//sumo esos minutos que tiene la hora + el restante
															
															$hora_aproximada_convertida_seg=$hora_aproximada-$holgura_seg_aprox;// resto la hora - 15min de parametrizacion
															
															//var_dump($hora_aproximada_convertida_seg);die("bm");
															
															
															if($horas_rango_min_seg>=$hora_aproximada_convertida_seg){
																
																$hora_rango_fija=(int)$horas_rango_hora+1;
																														
																$num_horas[$f]=$hora_rango_fija;
															
															}else{
																
																$hora_rango_fija=(int)$horas_rango_hora;
																
																$num_horas[$f]=$hora_rango_fija;
																
															}
															
															//FIN DEL OJO DE LA LOGICA
															*/

															$num_horas[$f]=$horas_rango;
																
															//var_dump($num_horas);die();
																														
																	
											
												}												 
																
											
											}
										$recargos=1;
										$f++;
										
									}	
										
								
								
								//INSERT DE RECARGOS**********************************************************
								

						
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

									$hora_dada_reca=$num_horas[$y];
										
									$horas_dadas_reca=substr($hora_dada_reca, 0, 2);
									$min_dados_reca=substr($hora_dada_reca, 3, 2);
											
									$hora_en_minutos_reca=$horas_dadas_reca*60 + $min_dados_reca;
											
									$hora_en_decimal_reca=$hora_en_minutos_reca/60;
											
																			
									$ingreso_extras_decimal_reca=round($hora_en_decimal_reca);
								
									//var_dump($ingreso_extras_decimal_reca);die();


									switch($num_conceptos_recargos_libres[$y]){
											case 8:	
												@$hfd_rel+=$ingreso_extras_decimal_reca;
												break;
											case 9:
												@$rno_rel+=$ingreso_extras_decimal_reca;
												break;
											case 10:
												@$rnf_rel+=$ingreso_extras_decimal_reca;
												break;											   
									}														   
								}//FIN FOR Y		
													
							}//fin recargos existe

?>