<?php

/*							
									var_dump($validacion_festivo);//TRUE
									var_dump($dia);//1
									var_dump($dia_letras);//LUNES
									var_dump($hor_ini_real_query);//7
									var_dump($hor_fin_real_query);//17
									die("bn30");
*/									


								$f=0;
																										
								unset($num_conceptos_extras_new);
								$num_conceptos_extras_new = array(); 
								
								unset($num_horas_extras_new);
								$num_horas_extras_new = array();
								
								
								
								$hora_sumada=0;

								//1.Saber si el turno programado cambio de dia
								
								//Su hora entrada del turno real,  le sumo las horas que trabajo del turno real
								$hora_sumada=$hora_ini_real_sin_cambio_holgura_seg+$horas_turno_real_seg;
								
								
								//var_dump($hora_sumada);die();
								
								//Variables para el dia que arranca con la hora inicial(el dia que es inicialmente)
								if($hora_ini_real_sin_cambio_holgura_seg<$hora_cero){
								
										$dia_inicial=$dia;								
										
										$validacion_festivo_existe_inicial=$validacion_festivo;									
								
								}
								
								//Variables si en la segunda hora de salida cambia de dia o no al turno programado
								if($hora_sumada>$hora_cero){
									
									if($dia==6){
											$dia_segundo=0;
												
											$validacion_festivo_existe_segundo=festivo($anio,($i+1),$mes);
									}else{									
											$dia_segundo=$dia+1;
											
											$validacion_festivo_existe_segundo=festivo($anio,($i+1),$mes);
									}								
								
								}else{									
										$dia_segundo=$dia;												
										$validacion_festivo_existe_segundo=$validacion_festivo;							
								}
								
								//Eso que vimos es para ver si el turno real se mantuvo en el mismo dia o no
								
								
								
							/*	
							var_dump($dia_inicial);
							var_dump($validacion_festivo_existe_inicial);
							var_dump("------");
							var_dump($dia_segundo);//sino pasa del dia el turno programado queda esta variable como la misma de dia_inicial
							var_dump($validacion_festivo_existe_segundo);
							die();
							*/	
							
							/*							
							VAR_DUMP($hora_ini_real_sin_cambio_holgura_seg);//19:00 68400
							VAR_DUMP($hora_fin_real_sin_cambio_holgura_seg);// 03:00 10800
							DIE("horas");
							*/	
								
								if($dia_inicial!=$dia_segundo){
									
									$hora_fin_real_sin_cambio_holgura_seg_mas_un_dia=$hora_fin_real_sin_cambio_holgura_seg+86405;
									//$hora_fin_real_sin_cambio_holgura_seg=$hora_fin_real_sin_cambio_holgura_seg_mas_un_dia;
								
								}
								
								
								
								//FUNCION PARA DETERMINAR SI EL TURNO EPL CAMBIA DE DIA O NO Y ASI SUMARLE EL DIA
								
								$hora_sumada_epl_funcion=$hor_ini_entrada_seg_epl+$horas_diferencia_totales_segundos;
								
								//var_dump($hora_sumada_epl_funcion);die();
									
								if($hora_sumada_epl_funcion>$hora_cero){
									
									$hor_fin_salida_seg_epl_mas_un_dia=$hor_fin_salida_seg_epl+86405;
									$variable_funcion=$hor_fin_salida_seg_epl_mas_un_dia;									
																	
								}else{
									
									$variable_funcion=$hor_fin_salida_seg_epl;
								
								}
								
								
								//var_dump($variable_funcion);die();//89945 01:00
								
								//FIN FUNCION
								
								
								
								
								
						
						
								$sin_extras_inicial=false;
								$sin_extras_final=false;
								
								
								
								/*
								var_dump($hor_ini_entrada_seg_epl);//18:47
								var_dump(">=");
								var_dump($hor_ini_t_start_contar_extra);//18:45
								var_dump($hor_ini_entrada_seg_epl);//18:47
								var_dump("<=");
								var_dump($hora_ini_real_sin_cambio_holgura_seg);//19:00
								
								var_dump("OR");
								
								//OJO ACA DETERMINO SI ES MAYOR NI MODO QUE TENGA EXTRAS
								var_dump($hor_ini_entrada_seg_epl);//18:47
								var_dump(">");
								var_dump($hora_ini_real_sin_cambio_holgura_seg);//19:00
								die();
								*/
								
								//Si Entra es que no tiene extra para la hora inicial PORQUE ESTA EN ESE RANGO de 19:45 a 20:00
								if(($hor_ini_entrada_seg_epl>=$hor_ini_t_start_contar_extra and $hor_ini_entrada_seg_epl<=$hora_ini_real_sin_cambio_holgura_seg) or ($hor_ini_entrada_seg_epl > $hora_ini_real_sin_cambio_holgura_seg )){
								
									$sin_extras_inicial=true;
									
								}
								
								
								
								/*
								var_dump($hor_fin_salida_seg_epl);//00:59 MISMO DIA 3540
								var_dump(">=");
								var_dump($hora_fin_real_sin_cambio_holgura_seg);// 03:00 MISMO DIA 10800
								var_dump($hor_fin_salida_seg_epl);//00:59 MISMO DIA 3540
								var_dump("<=");
								var_dump($hor_fin_t_start_contar_extra);//03:15 MISMO DIA 11700
													
								
								
								var_dump("OR");
								
								//OJO ACA DETERMINO SI ES MENOR NI MODO QUE TENGA EXTRAS
								var_dump($variable_funcion);//00:59 89945 OTRO DIA
								var_dump("<");
								var_dump($hora_fin_real_sin_cambio_holgura_seg_mas_un_dia);//03:00 OTRO DIA 97205
								die();
								*/
								
								
								//Si Entra es que no tiene extra para la hora final
								if(($hor_fin_salida_seg_epl>=$hora_fin_real_sin_cambio_holgura_seg and $hor_fin_salida_seg_epl<=$hor_fin_t_start_contar_extra)or ($variable_funcion < $hora_fin_real_sin_cambio_holgura_seg_mas_un_dia )){
									
									$sin_extras_final=true;
									
								}							
								
								
								/*
								//TRUE no hay extra
								var_dump($sin_extras_inicial);
								var_dump($sin_extras_final);die();
								*/
								
								
								
								if($sin_extras_inicial==false){
										
										//NUEVO
										$hora_sumada=0;
										

										//Hora que entro el epl - hora que inicia el turno
										$diferencia_horas_rango_extras=restarHoras($hor_entrada_epl,$hora_ini_real_solo_horas);
										
										
										//CONVERSION	
										$horas_turno_epl_diferencia_extra=substr($diferencia_horas_rango_extras, 0, 2);								
										$minutos_turno_epl_diferencia_extra=substr($diferencia_horas_rango_extras, 3, 2);
										
										$horas_turno_epl_seg_extra=$horas_turno_epl_diferencia_extra*3600;								
										$minutos_turno_epl_seg_extra=$minutos_turno_epl_diferencia_extra*60;
														
										//lO MISMO PERO EN SEGUNDOS
										$horas_diferencia_totales_segundos_extra=$horas_turno_epl_seg_extra+$minutos_turno_epl_seg_extra;
										
										
																		
										//hora entrada del epl,le sumo las horas de diferemcia 
										$hora_sumada=$hor_ini_entrada_seg_epl+$horas_diferencia_totales_segundos_extra; 
										
										
										/*
										var_dump($hora_sumada);
										die();
										*/	
										
										
										if($hora_sumada>$hora_cero){
															
												$flago1=1;
												
												$dia_letras_existe_anterior=dia_letras($dia);	
												
												
												if($dia==0){
															$dia_existe=6;
															$dia_letras_existe_anterior_antes=dia_letras($dia_existe);	
															$validacion_festivo_existe_antes=festivo($anio,($i-1),$mes);
												}else{									
															$dia_existe=$dia-1;
															$dia_letras_existe_anterior_antes=dia_letras($dia_existe);	
															$validacion_festivo_existe_antes=festivo($anio,($i-1),$mes);
												}										
										}else{
										
												$flago1=2;
												$dia_existe=$dia;
												$dia_letras_existe=dia_letras($dia_existe);	
												$validacion_festivo_existe=festivo($anio,($i),$mes);
												
										}						
										
										
										/*
										VAR_DUMP($dia_existe);
										VAR_DUMP($dia_letras_existe);
										VAR_DUMP($validacion_festivo_existe);
										VAR_DUMP("--------");
										VAR_DUMP($dia_letras_existe_anterior);
										VAR_DUMP($dia_existe);
										VAR_DUMP($dia_letras_existe_anterior_antes);
										VAR_DUMP($validacion_festivo_existe_antes);die();
										*/
										
										
										//COMPRUEBA SI EXISTE EXTRAS O NO										
										if($flago1==1){									
											
											
											$query="SELECT * FROM conceptos_extras_tmp WHERE estado='E' and ((hor_fin>='".$hor_entrada_epl."' and ".$dia_letras_existe_anterior_antes."=1) or (hor_ini<='".$hora_ini_real_solo_horas."' and ".$dia_letras_existe_anterior."=1))";
											
											/*$query="SELECT * FROM conceptos_extras_tmp WHERE estado='E' and ((hor_fin>='".$hor_entrada_epl."' and ".$dia_letras_existe_anterior."=1) or (hor_ini<='".$hora_ini_real_solo_horas."' and ".$dia_letras_existe_actual."=1))";	*/								

											
										}else{									
																				
											
											
											$query="SELECT * FROM conceptos_extras_tmp WHERE estado='E' and ((hor_fin>='".$hor_entrada_epl."' and ".$dia_letras_existe."=1) and (hor_ini<='".$hora_ini_real_solo_horas."' and ".$dia_letras_existe."=1))";
											
										}
										
										
										//var_dump($query);die();
																				
										
										$rs=$conn->Execute($query);											
										$row_query1=$rs->fetchrow();

										$extras_existe_si=$row_query1['cod_con'];
										
										$registros=$rs->RecordCount();
																	
										
										$rs_while=$conn->Execute($query);

										
										
										if($extras_existe_si != null){//Si existen extras entonces haga
										
												$entro=1;
												$f=0;
												
												unset($num_conceptos_extras_new);
												$num_conceptos_extras_new = array(); 
												
												unset($num_horas_extras_new);
												$num_horas_extras_new = array();
												
												
												$flagos5=1;
												while($row_query=$rs_while->fetchrow()){
																				
											
													//INGRESAMOS EL CODIGO Y EL NOMBRE DEL CONCEPTO A SUS ARRAYS
													$cod_con_pa_extras=$row_query['cod_con'];
													$num_conceptos_extras_new[$f]=$cod_con_pa_extras;
												
											
													//LOGICA DE CONTEO DE HORAS POR RANGO
													$t_hor_ini=$row_query['hor_ini'];
													$t_hor_ini_seg=convertir_segundos_horas($t_hor_ini);

													$t_hor_fin=$row_query['hor_fin'];
													$t_hor_fin_seg=convertir_segundos_horas($t_hor_fin);
											
											
													//ojo cuando entra en ese registro de abajo del if se ha sumado ya 1 a f
													/*	if($f==3){
															
															var_dump($num_conceptos_extras_new);
															var_dump("hor_ini: ".$t_hor_ini);//06:00
															var_dump("hor_fin: ".$t_hor_fin);//21:59
															die("si");
														
														}*/
													

											

													if($f==0){
														
														if($registros==1){
															//Hora entrada del turnos - la hora entrada epl
															$horas_rango_seg=$hora_ini_real_sin_cambio_holgura_seg-$hor_ini_entrada_seg_epl;
														
															//var_dump($horas_rango_seg);var_dump($hora_ini_real_sin_cambio_holgura_seg);var_dump($hor_ini_entrada_seg_epl);die();
														
														
														
															//Funcion para saber la hora militar exacta con 4 digitos 00:00
																$segundos_i = $horas_rango_seg; 

																$horas = intval($segundos_i/3600);

																if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
														  
																		$horas="0".$horas;
							
																}

																$restoSegundos = $segundos_i%3600;

																$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
															//Fin Funcion
															
															$num_horas_extras_new[$f]=$horas_rango;

															$flagos5=5;														
													
															//var_dump($num_horas_extras_new);die();
														}else{
															
															
															//Hora entrada delturnos - la hora entrada epl
															$horas_rango_seg=$t_hor_fin_seg-$hor_ini_entrada_seg_epl;
														
															//var_dump($horas_rango_seg);var_dump($t_hor_fin_seg);var_dump($hor_ini_entrada_seg_epl);die();
														
														
														
															//Funcion para saber la hora militar exacta con 4 digitos 00:00
																$segundos_i = $horas_rango_seg; 

																$horas = intval($segundos_i/3600);

																if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
														  
																		$horas="0".$horas;
							
																}

																$restoSegundos = $segundos_i%3600;

																$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
															//Fin Funcion
															
															$num_horas_extras_new[$f]=$horas_rango;

															$flagos5=4;//Para que entre en el mismo registro  abajo si entra aca														
													
															//var_dump($num_horas_extras_new);die();
														
														
														
														}
													
													
													
											
													}else{
											
											
															
															if($hor_fin_salida_seg_epl>=$t_hor_ini_seg and $hor_fin_salida_seg_epl<=$t_hor_fin_seg){
												
																	$horas_rango_seg=$hor_fin_salida_seg_epl-$t_hor_ini_seg;
												
																	//Funcion para saber la hora militar exacta con 4 digitos 00:00
																	$segundos_i = $horas_rango_seg; 

																	$horas = intval($segundos_i/3600);

																	if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
													  
																			$horas="0".$horas;
						
																	}

																	$restoSegundos = $segundos_i%3600;

																	$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
																	//Fin Funcion
												
													
														
																	$num_horas_extras_new[$f]=$hora_rango;										
																	//var_dump($num_horas_extras_new);die();
												
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
														
														
																
																	$num_horas_extras_new[$f]=$horas_rango;																						
																	//var_dump($num_horas_extras_new);die();
																																		
															}												 
																
											
													}
													
													
													/*
													//Por si entra en el mismo registro de nuevo
													var_dump($hora_ini_real_sin_cambio_holgura_seg);
													var_dump(">");
													var_dump($t_hor_ini_seg);//06:00
													var_dump($hora_ini_real_sin_cambio_holgura_seg);
													var_dump("<");
													var_dump($t_hor_fin_seg);//21:59
													die();
													*/
													
													
													if($hora_ini_real_sin_cambio_holgura_seg>$t_hor_ini_seg and $hora_ini_real_sin_cambio_holgura_seg<$t_hor_fin_seg and $flagos5==4){
												
														
												
														//INGRESAMOS EL CODIGO Y EL NOMBRE DEL CONCEPTO A SUS ARRAYS
														$cod_con_pa_extras=$row_query['cod_con'];
														$f++;
												
														$num_conceptos_extras_new[$f]=$cod_con_pa_extras;
												
												
												
														$horas_rango_seg=$hora_ini_real_sin_cambio_holgura_seg-$t_hor_ini_seg;
												
														//Funcion para saber la hora militar exacta con 4 digitos 00:00
														$segundos_i = $horas_rango_seg; 

														$horas = intval($segundos_i/3600);

														if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
													  
																$horas="0".$horas;
						
														}

														$restoSegundos = $segundos_i%3600;

														$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
														//Fin Funcion
												
														$num_horas_extras_new[$f]=$horas_rango;
														
													
													
														//var_dump($num_horas_extras_new);die();									
													
													
											
													}
													
													
													$extras=1;//para saber que si hay extras y entre a la condicion mas abajo.
													$f++;
										
									
										
												}//Cierre While																				
											
											
										}//fin Si existen extras entonces haga								
								
								}//fin sin_extras_inicial
								
								
								
								
								
								/*
									var_dump($num_conceptos_extras_new);
									var_dump($num_horas_extras_new);									
									die("bn");
								*/
								
								
								
								
								
								if($sin_extras_final==false){
										
																				
										
										$hora_sumada=0;
										
										//La hora de salida del turno REAL - la hora salida del epl
										$diferencia_horas_rango_extras=restarHoras($hora_fin_real_solo_horas,$hor_salida_epl);
										
										//var_dump($diferencia_horas_rango_extras);die("si");
										
										
										//CONVERSION
										$horas_turno_epl_diferencia_extra=substr($diferencia_horas_rango_extras, 0, 2);								
										$minutos_turno_epl_diferencia_extra=substr($diferencia_horas_rango_extras, 3, 2);
										
										$horas_turno_epl_seg_extra=$horas_turno_epl_diferencia_extra*3600;								
										$minutos_turno_epl_seg_extra=$minutos_turno_epl_diferencia_extra*60;
														
										//Las horas de diferencia de arribita pero convertido a seg
										$horas_diferencia_totales_segundos_extra=$horas_turno_epl_seg_extra+$minutos_turno_epl_seg_extra;
										
																		
										
										//2.Miro si entre la hora salida del turno real y la salida del epl cambio de dia o no
										
										//hora salida del turno,le sumo las horas de diferencia 
										$hora_sumada=$hora_fin_real_sin_cambio_holgura_seg+$horas_diferencia_totales_segundos_extra;
										
										
										
										//var_dump($hora_sumada);die();
										
										
																
											
										if($hora_sumada>$hora_cero){
															
												$flago1=1;
												
												$dia_letras_existe_anterior=dia_letras($dia_segundo);	
												
												
												if($dia_segundo==6){
															$dia_existe=0;
															$dia_letras_existe_actual=dia_letras($dia_existe);	
															$validacion_festivo_existe_actual=festivo($anio,($i+1),$mes);
												}else{									
															$dia_existe=$dia_segundo+1;
															$dia_letras_existe_actual=dia_letras($dia_existe);	
															$validacion_festivo_existe_actual=festivo($anio,($i+1),$mes);
												}
													
													
												
										}else{
										
												$flago1=2;
												
												$dia_existe=$dia_segundo;
												$dia_letras_existe=dia_letras($dia_existe);	
												$validacion_festivo_existe=$validacion_festivo_existe_segundo;
												
												
												
										}						
										
										
										//dia es. 0="sunday", 1="monday"...etc [0(sunday) <---> 6(saturday)]
										
										
										/*
										VAR_DUMP($dia_existe);
										VAR_DUMP($dia_letras_existe);
										VAR_DUMP($validacion_festivo_existe);
										VAR_DUMP("--------");
										VAR_DUMP($dia_letras_existe_anterior);
										VAR_DUMP($dia_existe);
										VAR_DUMP($dia_letras_existe_actual);
										VAR_DUMP($validacion_festivo_existe_actual);die();
										*/
										
										
										
										
										if($validacion_festivo){
											$dia_letras_existe_anterior="Festivo";
										}
										
										if($validacion_festivo_existe_actual){
											$dia_letras_existe_actual="Festivo";
										}
										
										if($validacion_festivo_existe){
											$dia_letras_existe="Festivo";
										}			
										
										
										//COMPRUEBA SI EXISTE EXTRAS O NO										
										if($flago1==1){									
											
											/*$query="SELECT * FROM conceptos_extras_tmp WHERE estado='E' and ((hor_fin>='".$hor_salida_epl."' and ".$dia_letras_existe_actual."=1) or (hor_ini<='".$hora_fin_real_solo_horas."' and ".$dia_letras_existe_anterior."=1))";*/


											
											$query="SELECT * FROM conceptos_extras_tmp WHERE estado='E' and (((hor_ini>='".$hora_fin_real_solo_horas."' or hor_fin>='".$hora_fin_real_solo_horas."') and ".$dia_letras_existe_anterior."=1 ) or (hor_fin<='".$hor_salida_epl."' or hor_ini<='".$hor_salida_epl."') and ".$dia_letras_existe_actual."=1)";

											
										}else{									
																						
											$query="SELECT * FROM conceptos_extras_tmp WHERE estado='E' and ((hor_fin>='".$hora_fin_real_solo_horas."' and ".$dia_letras_existe."=1) and (hor_ini<='".$hor_salida_epl."' and ".$dia_letras_existe."=1))";
											
										}
										
										
										//var_dump($query);die();
																				
										
										$rs=$conn->Execute($query);											
										$row_query1=$rs->fetchrow();

										$extras_existe_si=$row_query1['cod_con'];
										
										$registros=$rs->RecordCount();
																				
										
										$rs_while=$conn->Execute($query);


										
										if($extras_existe_si != null){//Si existen extras entonces haga
												
												
												//Por si viene un acumulado de arriba
												if(@$entro==1){
													
													
													$c=0;
													
													//var_dump($f);die("si");
													
													
												}else{
													
													$f=0;
																										
													unset($num_conceptos_extras_new);
													$num_conceptos_extras_new = array(); 
													
													unset($num_horas_extras_new);
													$num_horas_extras_new = array();
												
												}
																							
												
												$flagos5=1;
											
												
												while($row_query=$rs_while->fetchrow()){
																				
											
													//INGRESAMOS EL CODIGO Y EL NOMBRE DEL CONCEPTO A SUS ARRAYS
													$cod_con_pa_extras=$row_query['cod_con'];
													$num_conceptos_extras_new[$f]=$cod_con_pa_extras;
																								
													//TRAE LAS HORAS DEL REGISTRO INDICADO
													$t_hor_ini=$row_query['hor_ini'];
													$t_hor_ini_seg=convertir_segundos_horas($t_hor_ini);

													$t_hor_fin=$row_query['hor_fin'];
													$t_hor_fin_seg=convertir_segundos_horas($t_hor_fin);
											
													
													
													
													/*										
													VAR_DUMP($f);
													VAR_DUMP($c);DIE("BN");
													*/
													
												
													
													
													$bandera=1;
													if($registros==2){
													
																
																/*
																var_dump($hor_fin_salida_seg_epl);//07:39
																var_dump(">=");
																var_dump($t_hor_ini_seg);//06:00
																var_dump($hor_fin_salida_seg_epl);//07:39
																var_dump("<=");
																var_dump($t_hor_fin_seg);//21:59
																die();
																*/
																
													
														if($hor_fin_salida_seg_epl>=$t_hor_ini_seg and $hor_fin_salida_seg_epl<=$t_hor_fin_seg){
																
																
																	$horas_rango_seg=$hor_fin_salida_seg_epl-$t_hor_ini_seg;
														
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
																	
															
																	$num_horas_extras_new[$f]=$horas_rango;

																	$flagos5=5;

																	/*
																	if($f==0){
																		var_dump($num_horas_extras_new);die();
																	}
																	*/
																	
														}else{
																	
																	
																	$horas_rango_seg=$t_hor_fin_seg-$hora_fin_real_sin_cambio_holgura_seg;
														
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
																	
															
																	$num_horas_extras_new[$f]=$horas_rango;

																	$flagos5=5;

																	/*
																	if($f==1){
																		var_dump($num_horas_extras_new);die();
																	}
																	*/
														
														
														
														}
														
														$bandera=2;//Para que no entre al siguiente condicional porque ya no hay mas extras
													}
											
											
											
											
													
													//SI TIENE UN REGISTRO O MAS DE 2
													if($bandera==1){
												
												
														if($f==0 or $c==0){
													
													
															if($registros==1){
														
																//Hora entrada del turnos - la hora entrada epl
																$horas_rango_seg=$hor_fin_salida_seg_epl-$hora_fin_real_sin_cambio_holgura_seg;
														
																//var_dump($horas_rango_seg);var_dump($hora_fin_real_sin_cambio_holgura_seg);var_dump($t_hor_ini_seg);die();
														
														
														
																//Funcion para saber la hora militar exacta con 4 digitos 00:00
																	$segundos_i = $horas_rango_seg; 

																	$horas = intval($segundos_i/3600);

																	if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
														  
																		$horas="0".$horas;
							
																	}

																	$restoSegundos = $segundos_i%3600;

																	$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
																//Fin Funcion
															
																$num_horas_extras_new[$f]=$horas_rango;

																$flagos5=5;														
													
													
													
																/*
																if($f==0){
																	var_dump($num_horas_extras_new);die();
																}
																*/
															
															}else{
															
															
																/*
																//OJO ACA ARRANCA LA ULTIMA ETAPA DE DE QUE SI SALE
																//A LAS 6:45 ENTONCES RESTELE LA INICIAL 6:00 ESA RESTA
																var_dump($hor_fin_salida_seg_epl);//06:45:
																var_dump(">=");
																var_dump($t_hor_ini_seg);//06:00
																var_dump($hor_fin_salida_seg_epl);//06:45:
																var_dump("<=");
																var_dump($t_hor_fin_seg);//21:59
																die();
																*/
															
															
															
																if($hor_fin_salida_seg_epl>=$t_hor_ini_seg and $hor_fin_salida_seg_epl<=$t_hor_fin_seg){
												
																	$horas_rango_seg=$hor_fin_salida_seg_epl-$t_hor_ini_seg;
												
																	//Funcion para saber la hora militar exacta con 4 digitos 00:00
																	$segundos_i = $horas_rango_seg; 

																	$horas = intval($segundos_i/3600);

																	if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
													  
																			$horas="0".$horas;
						
																	}

																	$restoSegundos = $segundos_i%3600;

																	$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
																	//Fin Funcion
												
													
														
																	$num_horas_extras_new[$f]=$horas_rango;	

																	$c++;//pa que no vuelva a entrar aca ya que solo ingresa el primer registro
																	//var_dump($num_horas_extras_new);die();
												
																}else{
															
															
																	//Hora salida del turnos - la hora salida epl
																	$horas_rango_seg=$t_hor_fin_seg-$hora_fin_real_sin_cambio_holgura_seg;
																
																
																
																	/*
																	if($f==0){
																	var_dump($horas_rango_seg);var_dump($t_hor_fin_seg);var_dump($hora_fin_real_sin_cambio_holgura_seg);die();
																	}
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
																	
																	$num_horas_extras_new[$f]=$horas_rango;

																	$flagos5=4;//Para que entre en el mismo registro  abajo si entra aca														
															
																	//var_dump($num_horas_extras_new);die();
																
																	$c++;//pa que no vuelva a entrar aca ya que solo ingresa el primer registro
																	
															
																}
															
															
															}
													
													
													
											
														}else{
															
															/*	
															if($f==1){	
																//Esto es por si la salida el turno es 17:00 y debe restarlo con 21:59
																var_dump($hora_fin_real_sin_cambio_holgura_seg);//17:00
																var_dump(">=");
																var_dump($t_hor_ini_seg);//06:00
																var_dump($hora_fin_real_sin_cambio_holgura_seg);//17:00
																var_dump("<=");
																var_dump($t_hor_fin_seg);//21:59
																die("si");
																}
															*/	
															
															if($hora_fin_real_sin_cambio_holgura_seg>=$t_hor_ini_seg and $hora_fin_real_sin_cambio_holgura_seg<=$t_hor_fin_seg){
												
																	$horas_rango_seg=$t_hor_fin_seg-$hora_fin_real_sin_cambio_holgura_seg;
												
																//Funcion para saber la hora militar exacta con 4 digitos 00:00
																	$segundos_i = $horas_rango_seg; 

																	$horas = intval($segundos_i/3600);

																	if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
													  
																			$horas="0".$horas;
						
																	}

																	$restoSegundos = $segundos_i%3600;

																	$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
																//Fin Funcion
												
													
														
																	$num_horas_extras_new[$f]=$horas_rango;										
																	//var_dump($num_horas_extras_new);die();
												
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
														
														
																
																	$num_horas_extras_new[$f]=$horas_rango;	

																	
																	/*
																	if($f==7){						
																		var_dump($num_horas_extras_new);die();
																	}*/		
															}												 
																
											
														}
													}
													
													
													/*
													if($f==4){
													//Por si entra en el mismo registro de nuevo
													var_dump($hor_fin_salida_seg_epl);//06:59
													var_dump(">");
													var_dump($t_hor_ini_seg);//06:00
													var_dump($hor_fin_salida_seg_epl);//06:59
													var_dump("<");
													var_dump($t_hor_fin_seg);//21:59
													die();
													}
													*/
													
													if($hor_fin_salida_seg_epl>$t_hor_ini_seg and $hor_fin_salida_seg_epl<$t_hor_fin_seg and $flagos5==4){
												
														
												
														//INGRESAMOS EL CODIGO Y EL NOMBRE DEL CONCEPTO A SUS ARRAYS
														$cod_con_pa_extras=$row_query['cod_con'];
														$f++;
												
														$num_conceptos_extras_new[$f]=$cod_con_pa_extras;
												
												
												
														$horas_rango_seg=$hor_fin_salida_seg_epl-$t_hor_ini_seg;
												
														//Funcion para saber la hora militar exacta con 4 digitos 00:00
														$segundos_i = $horas_rango_seg; 

														$horas = intval($segundos_i/3600);

														if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
													  
																$horas="0".$horas;
						
														}

														$restoSegundos = $segundos_i%3600;

														$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
														//Fin Funcion
												
														$num_horas_extras_new[$f]=$horas_rango;
														
													
													
														//var_dump($num_horas_extras_new);die();									
													
													
											
													}
													
													
													/*
													if($f==1){
															
														var_dump($num_conceptos_extras_new);
														var_dump($num_horas_extras_new);											
														die("si");
														
													}
													*/
													
													
													
													$extras=1;//para saber que si hay extras y entre a la condicion mas abajo.
													$f++;
										
									
										
												}//Cierre While																				
										
										}//fin Si existen extras entonces haga								
								
								}//fin sin_extras_final
								
								
								
								
								/*
									var_dump($num_conceptos_extras_new);
									var_dump($num_horas_extras_new);									
									die("AFUERA FINAL");
								*/
																
								
								
								
								
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

								
								

								
							if(@$extras>0){	

										$cont=count($num_conceptos_extras_new);								

										for($x=0; $x<$cont; $x++){															   
											
											
											/*08:19
											Una hora y 30 minutos son 1,50 en decimales.

											1 * 60 + 30 = 90 minutos.
											90 minutos dividido entre 60 = 1,50.
											
											08*60 + 19=499 minutos										
											*/
											
											
											$hora_dada=$num_horas_extras_new[$x];
											
											
											$horas_dadas=substr($hora_dada, 0, 2);
											$min_dados=substr($hora_dada, 3, 2);
											
											
											
											$hora_en_minutos=$horas_dadas*60 + $min_dados;
											
											$hora_en_decimal=$hora_en_minutos/60;
											
																			
											
											$ingreso_extras_decimal=$hora_en_decimal;										
											

											

											
											switch($num_conceptos_extras_new[$x]){
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
										
							}//FIN @$extras>0 	

?>