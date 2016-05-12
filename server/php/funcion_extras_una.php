<?php


									/*
									var_dump($validacion_festivo);//TRUE
									var_dump($dia);//1
									var_dump($dia_letras);//Lunes
									var_dump($hor_ini_real_query);//7
									var_dump($hor_fin_real_query);//17
									die("wow");
									*/
														
								$hora_sumada=0;
								$dia_segundo=null;
								$validacion_festivo_existe_segundo=null;

								
								//Su hora entrada del turno real,  le sumo las horas que trabajo del turno real
								$hora_sumada=$hora_ini_real_sin_cambio_holgura_seg+$horas_turno_real_seg;
								
								
								//var_dump($hora_sumada);die();
								
								
								
								//Variables para saber si el la hora del turno programado la hora de salida cambia de dia o no con respecto a la hora inicial del turno
								if($hora_sumada>$hora_cero){
									
									if($dia==6){
											$dia_segundo=0;
												
											$validacion_festivo_existe_segundo=festivo($anio,($i+1),$mes);
									}else{									
											$dia_segundo=$dia+1;
											
											$validacion_festivo_existe_segundo=festivo($anio,($i+1),$mes);
									}								
								
								}
								
								//Eso que vimos es para ver si la hora de salida del turno cambio de dia o se mantuvo
								//dia es. 0="sunday", 1="monday"...etc [0(sunday) <---> 6(saturday)]
								
								
								//var_dump($dia_segundo);
								//var_dump($validacion_festivo_existe_segundo);
								//die();
								
								
								
								
								//----------------------------------------------------------------------
					
								
								$sin_extras_final=false;
								
								
								
								/*
								var_dump($hor_fin_salida_seg_epl);//19_29
								var_dump(">=");
								var_dump($hora_fin_real_sin_cambio_holgura_seg);//13:00
								var_dump($hor_fin_salida_seg_epl);//19_29
								var_dump("<=");
								var_dump($hor_fin_t_start_contar_extra);//13:15
								die();
								*/
								
								
								
								//Si Entra es que no tiene extra para la hora final
								if($hor_fin_salida_seg_epl>=$hora_fin_real_sin_cambio_holgura_seg and $hor_fin_salida_seg_epl<=$hor_fin_t_start_contar_extra){
									
									$sin_extras_final=true;
									
								}							
								
								
								
								
								/*
								var_dump($sin_extras_final);die();
								*/
								
								
								
								
								if($sin_extras_final==false){
										
																				
										
										$hora_sumada=0;
										
										//Me da las horas de diferencia entre la salida del ep final o la salida del tuno final
										$diferencia_horas_rango_extras=restarHoras($hora_fin_real_solo_horas,$hor_salida_epl);
										
										//var_dump($diferencia_horas_rango_extras);die("si");
										
										
										//CONVERSION
										$horas_turno_epl_diferencia_extra=substr($diferencia_horas_rango_extras, 0, 2);								
										$minutos_turno_epl_diferencia_extra=substr($diferencia_horas_rango_extras, 3, 2);
										
										$horas_turno_epl_seg_extra=$horas_turno_epl_diferencia_extra*3600;								
										$minutos_turno_epl_seg_extra=$minutos_turno_epl_diferencia_extra*60;
														
										//LO MISMO DE ARRIBA PERO EN SEGUNDOS
										$horas_diferencia_totales_segundos_extra=$horas_turno_epl_seg_extra+$minutos_turno_epl_seg_extra;
										
										//var_dump($horas_diferencia_totales_segundos_extra);die("bn");										
										
										
										//hora salida del Turno,le sumo las horas de diferencia 
										$hora_sumada=$hora_fin_real_sin_cambio_holgura_seg+$horas_diferencia_totales_segundos_extra;
										
										
										
										
										//el dia que es que viene de tiempo_extra_validacion.php
										/*
										if($i==5){
											var_dump("Dia del click en el dia:------------------");
											var_dump($validacion_festivo);
											var_dump($dia);
											var_dump($dia_letras);
											
											var_dump("Hora salida del Turno + las horas de diferencia:-------------");
											var_dump($hora_sumada);
											

											var_dump("Cambio de dia la hora de salida o no:-------------");
											var_dump($dia_segundo);
											var_dump($validacion_festivo_existe_segundo);
								
											die("aca");
										
										}
										*/
										
										
										
										
										//OJO ESTO NO ES VALIDACION PARA BORRAR HACE PARTE DEL PROCESO
										if($dia_segundo!==null){																				
											
											$dia=$dia_segundo;
											$dia_letras=dia_letras($dia_segundo);
											$validacion_festivo=$validacion_festivo_existe_segundo;
											
										
										}
										
										
										
										//VERIFICO A VER LA HORA DE SALIDA REALMENTE EN QUE DIA ESTA
										/*
										if($i==5){
											var_dump("Resultado para seguir:------------------");
											var_dump($validacion_festivo);
											var_dump($dia);
											var_dump($dia_letras);
											die("segundo dia");
										}
										*/
										
											
											
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

										//NUEVO OJO
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
										if($i==5){
											
											VAR_DUMP($dia_existe_actual);
											VAR_DUMP($dia_letras_existe_actual_extras);
											VAR_DUMP($validacion_festivo_existe_actual_extras);
											
											VAR_DUMP("-------------------------------");
											VAR_DUMP($dia_letras_existe_anterior);
											
											VAR_DUMP($dia_existe);
											VAR_DUMP($dia_letras_existe_actual);
											
											VAR_DUMP($validacion_festivo_existe_actual);
											die();
										}
										*/
										
										
										
										
										//COMPRUEBA SI EXISTE EXTRAS O NO
										
										if($flago1==1){									
											
											$query="SELECT * FROM conceptos_extras_tmp WHERE estado='E' and ((hor_fin>='".$hor_salida_epl."' and ".$dia_letras_existe_actual."=1) or (hor_ini<='".$hora_fin_real_solo_horas."' and ".$dia_letras_existe_anterior."=1))";									

											
										}else{									
																						
											$query="SELECT * FROM conceptos_extras_tmp WHERE estado='E' and ((hor_fin>='".$hora_fin_real_solo_horas."' and ".$dia_letras_existe_actual_extras."=1) and (hor_ini<='".$hor_salida_epl."' and ".$dia_letras_existe_actual_extras."=1))";
											
										}
										
										
										/*
										if($i==5){
										var_dump($query);die();
										}
										*/
										
										
										$rs=$conn->Execute($query);											
										$row_query1=$rs->fetchrow();

										$extras_existe_si=$row_query1['cod_con'];
										
										$registros=$rs->RecordCount();
																				
										
										$rs_while=$conn->Execute($query);	
										
										if($extras_existe_si != null){//Si existen extras entonces haga
												
												$f=0;
												
												$flagos5=1;
												
												
												unset($num_conceptos_extras_new);
												$num_conceptos_extras_new = array(); 
												
												unset($num_horas_extras_new);
												$num_horas_extras_new = array();

												
												while($row_query=$rs_while->fetchrow()){
																				
											
													//INGRESAMOS EL CODIGO Y EL NOMBRE DEL CONCEPTO A SUS ARRAYS
													$cod_con_pa_extras=$row_query['cod_con'];
													$num_conceptos_extras_new[$f]=$cod_con_pa_extras;
																								
													//LOGICA DE CONTEO DE HORAS POR RANGO
													$t_hor_ini=$row_query['hor_ini'];
													$t_hor_ini_seg=convertir_segundos_horas($t_hor_ini);

													$t_hor_fin=$row_query['hor_fin'];
													$t_hor_fin_seg=convertir_segundos_horas($t_hor_fin);
											
													
													/*
														if($f==0){
															
															var_dump($num_conceptos_extras_new);
															var_dump("hor_ini: ".$t_hor_ini);
															var_dump("hor_fin: ".$t_hor_fin);
															die("si");
														
														}
													*/


													
													$bandera=1;
													if($registros==2){
													
														
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
																	if($f==2){
																		var_dump($num_horas_extras_new);die();
																	}
																	*/
														
														
														
														}
														
														$bandera=2;//Para que no entre al siguiente condicional porque ya no hay mas extras
													}
											
											
											
											
													
													//SI TIENE UN REGISTRO O VARIOS O MAS DE 2
												if($bandera==1){
												
													
													if($f==0){
														
														if($registros==1){
														
															//Hora salida del turnos - la hora entrada epl
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
															}															*/		
													
															
																
											
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
													
													
													
													
													
													
													$extras=1;//para saber que si hay extras y entre a la condicion mas abajo.
													$f++;
										
									
										
												}//Cierre While																				
										
										}//fin Si existen extras entonces haga								
								
								}//fin sin_extras_final
								
								
								
								
								/*
								if($i==11){
									var_dump($num_conceptos_extras_new);
									var_dump($num_horas_extras_new);									
									die();
								}
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
										if($i==11){
											var_dump("hen_rel cod 4: ".@$hed_rel);
											var_dump("hen_rel cod 5: ".@$hen_rel);
											var_dump("hedf_rel cod 6: ".@$hedf_rel);
											var_dump("henf_rel cod 7: ".@$henf_rel);																					
											die("bn14");	
										}
										*/
										
							}//FIN @$extras>0 	

?>