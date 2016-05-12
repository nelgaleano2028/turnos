<?php

		if($f==0){
					
					
				/*
				var_dump($hor_fin_salida_seg_epl);//07:27
				var_dump("<=");
				var_dump($t_hor_fin_seg);//21:59
				var_dump($hor_ini_entrada_seg_epl);//18:54
				var_dump(">=");
				var_dump($t_hor_ini_seg);die("si2");//06:00
				*/
				
				if($hor_fin_salida_seg_epl<=$t_hor_fin_seg and $hor_ini_entrada_seg_epl>=$t_hor_ini_seg and $registros==1){
						
					
						
					$horas_rango_seg=$hor_fin_salida_seg_epl-$hor_ini_entrada_seg_epl;
					
					//var_dump($horas_rango_seg);var_dump($hor_fin_salida_seg_epl);var_dump($hor_ini_entrada_seg_epl);die();
					
					
					//Funcion para saber la hora militar exacta con 4 digitos 00:00
						$segundos_i = $horas_rango_seg; 

						$horas = intval($segundos_i/3600);

						if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
					  
								$horas="0".$horas;

						}

						$restoSegundos = $segundos_i%3600;

						$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
					//Fin Funcion
									
						
					$num_horas_extras[$f]=$horas_rango;

					$flagos5=5;														
				
				}else{
				
								
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
																												
						
						
					$num_horas_extras[$f]=$horas_rango;											
				
				}				
			
		
		}else{
		
			/*
			if($f==1){
			
				var_dump($hor_fin_salida_seg_epl);//23:05
				var_dump(">=");
				var_dump($t_hor_ini_seg);//22:00
				var_dump($hor_fin_salida_seg_epl);//23:05
				var_dump("<=");
				var_dump($t_hor_fin_seg);die("si2");//23:59
				
			
			}*/
			
			
			
			if($hor_fin_salida_seg_epl>=$t_hor_ini_seg and $hor_fin_salida_seg_epl<=$t_hor_fin_seg){
			
				$horas_rango_seg=$hor_fin_salida_seg_epl-$t_hor_ini_seg;
				
				
				/*
				if($f==1){
					var_dump($horas_rango_seg);die();
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
			
				
					
				$num_horas_extras[$f]=$horas_rango;
				
				$flagos5=5;
			
			}else{
			
					
					$horas_rango_seg=$t_hor_fin_seg-$t_hor_ini_seg;
					
					//var_dump($horas_rango_seg);var_dump($t_hor_fin_seg);var_dump($t_hor_ini_seg);die();
					
					//Funcion para saber la hora militar exacta con 4 digitos 00:00
						$segundos_i = $horas_rango_seg; 

						$horas = intval($segundos_i/3600);

						if($horas==0 or $horas==1 or $horas==2 or $horas==3 or $horas==4 or $horas==5 or $horas==6 or $horas==7 or $horas==8 or $horas==9){
						  
								$horas="0".$horas;

						}

						$restoSegundos = $segundos_i%3600;

						$horas_rango = $horas.':'.date("i",mktime (0,0,$restoSegundos,0,0,0));
						//Fin Funcion
					
					
							
						$num_horas_extras[$f]=$horas_rango;
		
			}												 
							
		
		}
	
		
		/*
			var_dump($hor_salida_epl);
			var_dump(">");
			var_dump($t_hor_ini);
			var_dump($hor_salida_epl);												
			var_dump("<");
			var_dump($t_hor_fin);												
			die("si");
		*/
		
		if($hor_salida_epl>$t_hor_ini and $hor_salida_epl<$t_hor_fin and $flagos5==1){
			
			
			//INGRESAMOS EL CODIGO Y EL NOMBRE DEL CONCEPTO A SUS ARRAYS
			$cod_con_pa_extras=$row_query['cod_con'];
			
			$f++;
			
			$num_conceptos_extras[$f]=$cod_con_pa_extras;
			
			
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
			
				$num_horas_extras[$f]=$horas_rango;
					
			
		
		}
		
		/*
		//SEGUIMIENTO
			if($f==1){
				var_dump($num_conceptos_extras);
				var_dump($num_horas_extras);		
				die();
			}
		*/
		
		
		
		

?>