<?php
	require_once("../librerias/lib/connection.php");
	
	class novedades{
		
		private $arrays=array();
		public function listar_novedades(){
			global $conn;
			
			$sql="SELECT        c.cod_con, con.nom_con, c.tabla, c.cod_uni, c.cod_gru, c.vlr_min, c.vlr_max
					FROM            conceptos_ayu AS c INNER JOIN
                        conceptos AS con ON c.cod_con = con.cod_con
					WHERE        (c.tabla = 'ausencias')";
			
			$rs=$conn->Execute($sql);
			
			if($rs){
				while($fila=@$rs->FetchRow()){
					$this->arrays[]=array("codigo"=>$fila["cod_con"],
										  "nombre"=>$fila["nom_con"]);
				}
				return $this->arrays;
			}else{
				return null;
			}
			
		}
		
		public function listar_reemplazos($area,$cargo,$epl_nop){
			global $conn;
			$sql="select cod_epl,nom_epl+' '+ape_epl as reemplazo 
					from empleados_basic 
					where cod_cc2='550101' and estado='A' and cod_Epl <> '66989584'
					and cod_car='100301'";
			$rs=$conn_>Execute($sql);
			if($rs){
				while($fila=@$rs->FetchRow()){
					$this->arrays[]=array("codigo"=>$fila["cod_epl"],
										  "nombre"=>$fila["reemplazo"]);
				}
				return $this->arrays;
			}else{
				return null;
			}
			
		}
		
                 /*$sql="select inte.id,fecha_ini as Fecha, RTRIM(emp.nom_epl)+' '+RTRIM(emp.ape_epl) as Empleado_de_la_solicitud,
                                    turno_actual as Turno_Actual , turno_cambio  as Turno_a_Cambiar ,
                                    inte.cod_epl_cambio, inte.cod_epl_actual  ,
                                    (select RTRIM(emp2.nom_epl)+' '+RTRIM(emp2.ape_epl) as Empleado_a_Intercambiar from
                                    empleados_basic emp2 where emp2.cod_epl = inte.cod_epl_cambio) as Empleado_a_intercambiar
                                    from empleados_basic emp, solicitud_tur_tmp inte 
                                    where emp.cod_epl=inte.cod_epl_actual and inte.cod_jefe='".$cod_epl_jefe."' and inte.estado='P'";*/
                
		
		public function get_inter_tur($cod_epl_jefe){
                    
                    global $conn;
			
			try{
                                                                                         
                                $sql="select inte.id,fecha_ini as Fecha, RTRIM(emp.nom_epl)+' '+RTRIM(emp.ape_epl) as Empleado_de_la_solicitud,
				turno_actual as Turno_Actual ,turno_cambio as Turno_a_Cambiar , 
                                inte.cod_epl_cambio, inte.cod_epl_actual, RTRIM(emp2.nom_epl)+' '+RTRIM(emp2.ape_epl) as empleado_intercambiar                                 
                                from empleados_basic emp, solicitud_tur_tmp inte ,empleados_basic emp2 
                                where emp.cod_epl=inte.cod_epl_actual and inte.cod_jefe='".$cod_epl_jefe."' and inte.estado <> 'C'  and inte.estado <> 'PE' and inte.estado <> 'R'
                                and emp2.cod_Epl = inte.cod_epl_cambio";                   
                                
				$rs=$conn->Execute($sql);
                                
				while($fila=$rs->FetchRow()){
                                    
                                    @$hora_actual=  $this->turnos_horas($fila["Turno_Actual"]);
                                    @$hora_cambiar= $this->turnos_horas($fila["Turno_a_Cambiar"]);                               
                                    
                                    $this->arrays[]=array("id"                  => $fila["id"],
                                                    "Fecha"                     => $fila["Fecha"],
                                                    "Empleado_de_la_solicitud"  => $fila["Empleado_de_la_solicitud"],
                                                    "Turno_Actual"     		=> $fila["Turno_Actual"],
                                                    "Turno_a_Cambiar"     	=> $fila["Turno_a_Cambiar"],
                                                    "cod_epl_cambio"            => $fila["cod_epl_cambio"],
                                                    "cod_epl_actual"            => $fila["cod_epl_actual"],
                                                    "Empleado_a_Intercambiar"    =>$fila["empleado_intercambiar"],                                                   
                                                    "hora_actual"               => $hora_actual,
                                                    "hora_cambiar"              => $hora_cambiar              
                                                   
                                                    );
				
                                }
                               
                                 
                                return $this->arrays;
                                
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}        
                              
           }
           
           public function get_inter_epl($cod_epl){
                    
                    global $conn;
			
			try{
                                                                                         
                                $sql="select inte.cod_jefe,inte.id,fecha_ini as Fecha, RTRIM(emp.nom_epl)+' '+RTRIM(emp.ape_epl) as Empleado_de_la_solicitud,
				turno_actual as Turno_Actual ,turno_cambio as Turno_a_Cambiar , 
                                inte.cod_epl_cambio, inte.cod_epl_actual, RTRIM(emp2.nom_epl)+' '+RTRIM(emp2.ape_epl) as empleado_intercambiar                                 
                                from empleados_basic emp, solicitud_tur_tmp inte ,empleados_basic emp2 
                                where emp.cod_epl=inte.cod_epl_actual and inte.cod_epl_cambio='".$cod_epl."' and inte.estado='PE'
                                and emp2.cod_Epl = inte.cod_epl_cambio"; 
                                
                  
                                
				$rs=$conn->Execute($sql);
                                
				while($fila=$rs->FetchRow()){
                                    
                                    @$hora_actual=  $this->turnos_horas($fila["Turno_Actual"]);
                                    @$hora_cambiar= $this->turnos_horas($fila["Turno_a_Cambiar"]);                               
                                    
                                    $this->arrays[]=array("id"                  => $fila["id"],
                                                    "Fecha"                     => $fila["Fecha"],
                                                    "Empleado_de_la_solicitud"  => $fila["Empleado_de_la_solicitud"],
                                                    "Turno_Actual"     		=> $fila["Turno_Actual"],
                                                    "Turno_a_Cambiar"     	=> $fila["Turno_a_Cambiar"],
                                                    "cod_epl_cambio"            => $fila["cod_epl_cambio"],
                                                    "cod_epl_actual"            => $fila["cod_epl_actual"],
                                                    "Empleado_a_Intercambiar"    =>$fila["empleado_intercambiar"],                                                   
                                                    "hora_actual"               => $hora_actual,
                                                    "hora_cambiar"              => $hora_cambiar,
                                                    "jefe"                      => $fila["cod_jefe"]
                                                   
                                                    );
				
                                }
                               
                                 
                                return $this->arrays;
                                
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}        
                              
           }
           
           public function get_sol_tur($cod_epl_jefe){
                    
                    global $conn;
			
			try{
                                                                                         
                                $sql="select sol.id,sol.fecha_solicitud, b.cod_epl, RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl) as Empleado_de_la_solicitud, sol.turno_solicitud
                                     from empleados_basic as b, sol_cambio_tur_tmp as sol where sol.estado='P' and b.cod_epl=sol.cod_epl and cod_jefe='".$cod_epl_jefe."'"; 
                                
				$rs=$conn->Execute($sql);
                                
				while($fila=$rs->FetchRow()){
                                    
                                    @$hora_actual=  $this->turnos_horas($fila["turno_solicitud"]);                             
                                    
                                    $this->arrays[]=array("id"                  => $fila["id"],
                                                    "fecha_solicitud"                     => $fila["fecha_solicitud"],
                                                    "cod_epl"                   => $fila["cod_epl"],
                                                    "Empleado_de_la_solicitud"  => $fila["Empleado_de_la_solicitud"],
                                                    "turno_solicitud"           => $fila["turno_solicitud"],                                               
                                                    "hora_actual"               => $hora_actual
                                                    );
				
                                }
                               
                                 
                                return $this->arrays;
                                
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}        
                              
           }
           
        
       public function verifi_soli_inter($fecha,$cod_epl_cambio,$cod_epl_actual,$ta,$tc,$jefe){
           
           global $conn;
           
           $fecha=explode("-",$fecha);
           
           $sql2="select td".$fecha[0]." as turno1 from prog_mes_tur where Mes='". $fecha[1]."' and cod_epl='".$cod_epl_actual."' and Td".$fecha[0]."='".$ta."' and cod_epl_jefe='".$jefe."'";
           $rs2=$conn->Execute($sql2);
           $row1= $rs2->fetchrow();
           
           $sql3="select td".$fecha[0]." as turno2 from prog_mes_tur where Mes='". $fecha[1]."' and cod_epl='".$cod_epl_cambio."' and Td".$fecha[0]."='".$tc."' and cod_epl_jefe='".$jefe."'";
           $rs3=$conn->Execute($sql3);
           $row2= $rs3->fetchrow();
           
           if($row1['turno1']==$ta && $row2['turno2']==$tc ){
               
               return 2;

           }else if($row1['turno1'] != $ta && $row2['turno2'] !=$tc ){
               
                $sql2="select td".$fecha[0]." as turno1 from prog_mes_tur where Mes='". $fecha[1]."' and cod_epl='".$cod_epl_actual."' and Td".$fecha[0]."='".$tc."' and cod_epl_jefe='".$jefe."'";
                $rs2=$conn->Execute($sql2);
                $row1= $rs2->fetchrow();

                $sql3="select td".$fecha[0]." as turno2 from prog_mes_tur where Mes='". $fecha[1]."' and cod_epl='".$cod_epl_cambio."' and Td".$fecha[0]."='".$ta."' and cod_epl_jefe='".$jefe."'";
                $rs3=$conn->Execute($sql3);
                $row2= $rs3->fetchrow();
                
                if($row1['turno1'] == $tc && $row2['turno2'] ==$ta ){
                    
                       return 1;
                }else{
                    
                       return 3;
                }
               
               
               
           }else {
               
               return 3;
               
           }
   
       }
       
       
      
        public function verifi_soli_turno($fecha_solicitud,$cod_epl,$turno_solicitud,$jefe){
           
           global $conn;
           
           $fecha=explode("-",$fecha_solicitud);
           
           $sql2="select td".$fecha[0]." as turno1 from prog_mes_tur where Mes='". $fecha[1]."' and cod_epl='".$cod_epl."' and cod_epl_jefe='".$jefe."'";
          
           $rs2=$conn->Execute($sql2);
           $row1= $rs2->fetchrow();
           
           if(@$row1['turno1']==NULL || @$row1['turno1']!=$turno_solicitud){
               
               return 2;

           }else if(@$row1['turno1']==$turno_solicitud){
               
               return 1;
                
           }
   
       }
       
       public function verifi_soli_aus($cod_epl,$fecha_ini,$fecha_fin,$cod_cc2,$cod_con){
            
            global $conn;

            $sql2="SELECT * FROM ausencias WHERE cod_epl='".$cod_epl."' and fec_ini_r=convert(date,'".$fecha_ini."',105) and fec_fin_r=convert(date,'".$fecha_fin."',105)
            and cod_cc2='".$cod_cc2."' and cod_con='".$cod_con."'";
            $rs2=$conn->Execute($sql2);
            if($rs2->RecordCount() > 0){
                
               return 1;
                
            }else{
                
                return 2;
            }
          
        }
        
        public function turnos_horas($turno){
                
             global $conn;
            
              $sql2="select convert(varchar,hor_ini,108) as hor_ini, convert(varchar,hor_fin,108) as hor_fin  from turnos_prog where cod_tur='".$turno."'";
                $rs2=$conn->Execute($sql2);

                if($rs2->RecordCount() > 0){

                        $row2= $rs2->fetchrow();

                        $turn=$row2['hor_ini']."-".$row2['hor_fin'];
                     

                }else{
                        $sql3="select convert(varchar,hor_ini,108) as hor_ini, convert(varchar,hor_fin,108) as hor_fin from turnos_prog_tmp where cod_tur='".$turno."'";
                        $rs3=$conn->Execute($sql3);
                        $row3= $rs3->fetchrow();
                        
                        $turn=$row3['hor_ini']."-".$row3['hor_fin'];
                      

                }
                
                return $turn;
            
        }
		
		
	public function get_ausencias($cod_epl_jefe){
                    
            global $conn;
			
			try{
				$sql="select aus.cod_cc2,aus.cod_con,emp.cod_epl,aus.id, RTRIM(emp.nom_epl)+' '+RTRIM(emp.ape_epl) as empleado, fecha_ini, fecha_fin, nom_tip_aus 
					from empleados_basic emp, ausencias_tmp aus, tipo_ausentismo tip
					where emp.cod_epl=aus.cod_epl and tip.cod_aus=aus.cod_aus and aus.cod_jefe='".$cod_epl_jefe."' and aus.estado='P'
					";
                                
                                
				$rs=$conn->Execute($sql);
				while($fila=$rs->FetchRow()){
                         
				 $this->arrays[]=array("empleado"	=> $fila["empleado"],
									 "cod_epl"      => $fila["cod_epl"],
									 "fecha_ini"   	=> $fila["fecha_ini"],									 
									 "fecha_fin"    => $fila["fecha_fin"],
									 "nom_tip_aus"  => $fila["nom_tip_aus"],									 
									 "id"           => $fila["id"],
                                                                         "cod_cc2"      => $fila["cod_cc2"],
                                                                         "cod_con"       => $fila["cod_con"],
									 );
				
                                }
                             
                             
                              return  $this->arrays;
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}        
                              
        }
		
		
		public function aceptar_soli_inter($id){
			
			global $conn;
			
			try{
				$sql="update solicitud_tur_tmp set estado='C' where id=".$id;
				$rs=$conn->Execute($sql);
				if($rs){
					return 1;
				}else{
					return 5;
				}
				
				
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}      
		
		}
                
                
                public function aceptar_soli_inter_emp($id){
			
			global $conn;
			
			try{
				$sql="update solicitud_tur_tmp set estado='P' where id=".$id;
				$rs=$conn->Execute($sql);
				if($rs){
					return 1;
				}else{
					return 5;
				}
				
				
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}      
		
		}
                
                public function rechazar_soli_inter_emp($id){
			
			global $conn;
			
			try{
				$sql="update solicitud_tur_tmp set estado='R' where id=".$id;
				$rs=$conn->Execute($sql);
				if($rs){
					return 1;
				}else{
					return 5;
				}
				
				
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}      
		
		}
                
                
                public function aceptar_soli_turnos($id){
			
			global $conn;
			
			try{
                            $sql="update sol_cambio_tur_tmp set estado='C' where id=".$id;
                            $rs=$conn->Execute($sql);
                            if($rs){
                                    return 1;
                            }else{
                                    return 5;
                            }
                            
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}      
		}
                
                
                public function aceptar_soli_aus($id){
			
			global $conn;
			
			try{
				$sql="update ausencias_tmp set estado='C' where id=".$id;
				$rs=$conn->Execute($sql);
				if($rs){
					return 1;
				}else{
					return 3;
				}
				
				
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}      
		
		}
		
		
		public function rechazar_soli_inter($id){
			
			global $conn;
			
			try{
				$sql="update solicitud_tur_tmp set estado='R' where id=".$id;
                               
				$rs=$conn->Execute($sql);
				if($rs){
					return 1;
				}else{
					return 2;
				}
				
				
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}      
		}
		
		public function rechazar_soli_aus($id){
		
			global $conn;
			
			try{
				$sql="update ausencias_tmp set estado='R' where id=".$id;
				$rs=$conn->Execute($sql);
				if($rs){
					return 1;
				}else{
					return 2;
				}
				
				
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}      
		
		}
                
                public function rechazar_soli_turno($id){
		
			global $conn;
			
			try{
                            
                            $sql="update sol_cambio_tur_tmp set estado='R' where id=".$id;
                            $rs=$conn->Execute($sql);
                            if($rs){
                                    return 1;
                            }else{
                                    return 2;
                            }	
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}      
		
		}
                
                
                public function bit_mov_turnos($cod_epl_jefe){
                    
                    global $conn;
			
						try{
																					 
							$sql="select nov.id,b.cedula, RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl) as empleado,nov.detalle,nov.cod_epl,convert(varchar,nov.fecha,103) as fecha,nov.mes,nov.ano
									from prog_novedades nov, empleados_basic b, tipos_novedades tip
									where nov.cod_epl=b.cod_epl and nov.tip_novedades=tip.tip_novedades and nov.cod_epl_jefe='".$cod_epl_jefe."' and nov.tip_novedades=1"; 
											
							$rs=$conn->Execute($sql);
											
							while($fila=$rs->FetchRow()){
												
												@$hora_actual=  $this->turnos_horas($fila["turno_solicitud"]);                             
												
												$this->arrays[]=array("id"                  => $fila["id"],
																"cedula"                    => $fila["cedula"],
																"empleado"                  => $fila["empleado"],
																"detalle"                   => $fila["detalle"],
																"fecha"                     => $fila["fecha"],                                               
																"mes"                       => $fila["mes"],
																"ano"                       => $fila["ano"]  
																);
							
											}
										   
											 
											return $this->arrays;
											
						}catch (exception $e) { 
							var_dump($e); 
							adodb_backtrace($e->gettrace());
						}        
                              
                }
                
                
                
                public function bit_mov_ausencias($cod_epl_jefe){
                    
                    global $conn;
			
                        try{

                                $sql="select nov.id,b.cedula, RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl) as empleado,nov.detalle,nov.cod_epl,convert(varchar,nov.fecha,103) as fecha,nov.mes,nov.ano
                                                from prog_novedades nov, empleados_basic b, tipos_novedades tip
                                                where nov.cod_epl=b.cod_epl and nov.tip_novedades=tip.tip_novedades and nov.cod_epl_jefe='".$cod_epl_jefe."' and nov.tip_novedades=2"; 

                                $rs=$conn->Execute($sql);

                                while($fila=$rs->FetchRow()){

                                    @$hora_actual=  $this->turnos_horas($fila["turno_solicitud"]);                             

                                    $this->arrays[]=array("id"                  => $fila["id"],
                                                                    "cedula"                    => $fila["cedula"],
                                                                    "empleado"                  => $fila["empleado"],
                                                                    "detalle"                   => $fila["detalle"],
                                                                    "fecha"                     => $fila["fecha"],                                               
                                                                    "mes"                       => $fila["mes"],
                                                                    "ano"                       => $fila["ano"]  
                                                                    );

                                }


                                return $this->arrays;

                        }catch (exception $e) { 
                                var_dump($e); 
                                adodb_backtrace($e->gettrace());
                        }        

                }
                
                
                public function bit_mov_vaca_li($cod_epl_jefe){
                    
                    global $conn;
			
                        try{

                                $sql="select nov.id,b.cedula, RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl) as empleado,nov.detalle,nov.cod_epl,convert(varchar,nov.fecha,103) as fecha,nov.mes,nov.ano
                                                from prog_novedades nov, empleados_basic b, tipos_novedades tip
                                                where nov.cod_epl=b.cod_epl and nov.tip_novedades=tip.tip_novedades and nov.cod_epl_jefe='".$cod_epl_jefe."' and nov.tip_novedades=3"; 

                                $rs=$conn->Execute($sql);

                                while($fila=$rs->FetchRow()){

                                    @$hora_actual=  $this->turnos_horas($fila["turno_solicitud"]);                             

                                    $this->arrays[]=array("id"                  => $fila["id"],
                                                                    "cedula"                    => $fila["cedula"],
                                                                    "empleado"                  => $fila["empleado"],
                                                                    "detalle"                   => $fila["detalle"],
                                                                    "fecha"                     => $fila["fecha"],                                               
                                                                    "mes"                       => $fila["mes"],
                                                                    "ano"                       => $fila["ano"]  
                                                                    );

                                }


                                return $this->arrays;

                        }catch (exception $e) { 
                                var_dump($e); 
                                adodb_backtrace($e->gettrace());
                        }        

                }
                
                
                public function bit_aprodesa_ausencias($cod_epl_jefe){
                    
                    global $conn;
			
                        try{

                                $sql="select nov.id,b.cedula, RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl) as empleado,nov.detalle,nov.cod_epl,convert(varchar,nov.fecha,103) as fecha,nov.mes,nov.ano
                                                from prog_novedades nov, empleados_basic b, tipos_novedades tip
                                                where nov.cod_epl=b.cod_epl and nov.tip_novedades=tip.tip_novedades and nov.cod_epl_jefe='".$cod_epl_jefe."' and nov.tip_novedades=6"; 

                                $rs=$conn->Execute($sql);

                                while($fila=$rs->FetchRow()){

                                    @$hora_actual=  $this->turnos_horas($fila["turno_solicitud"]);                             

                                    $this->arrays[]=array("id"                  => $fila["id"],
                                                                    "cedula"                    => $fila["cedula"],
                                                                    "empleado"                  => $fila["empleado"],
                                                                    "detalle"                   => $fila["detalle"],
                                                                    "fecha"                     => $fila["fecha"],                                               
                                                                    "mes"                       => $fila["mes"],
                                                                    "ano"                       => $fila["ano"]  
                                                                    );

                                }


                                return $this->arrays;

                        }catch (exception $e) { 
                                var_dump($e); 
                                adodb_backtrace($e->gettrace());
                        }        

                }
                
                
                public function bit_soli_tur($cod_epl_jefe){
                    
                    global $conn;
			
                        try{

                                $sql="select nov.id,b.cedula, RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl) as empleado,nov.detalle,nov.cod_epl,convert(varchar,nov.fecha,103) as fecha,nov.mes,nov.ano
                                                from prog_novedades nov, empleados_basic b, tipos_novedades tip
                                                where nov.cod_epl=b.cod_epl and nov.tip_novedades=tip.tip_novedades and nov.cod_epl_jefe='".$cod_epl_jefe."' and nov.tip_novedades=7"; 

                                $rs=$conn->Execute($sql);

                                while($fila=$rs->FetchRow()){

                                    @$hora_actual=  $this->turnos_horas($fila["turno_solicitud"]);                             

                                    $this->arrays[]=array("id"                  => $fila["id"],
                                                                    "cedula"                    => $fila["cedula"],
                                                                    "empleado"                  => $fila["empleado"],
                                                                    "detalle"                   => $fila["detalle"],
                                                                    "fecha"                     => $fila["fecha"],                                               
                                                                    "mes"                       => $fila["mes"],
                                                                    "ano"                       => $fila["ano"]  
                                                                    );

                                }


                                return $this->arrays;

                        }catch (exception $e) { 
                                var_dump($e); 
                                adodb_backtrace($e->gettrace());
                        }        

                }
                
                public function bit_aprodesa_turnos($cod_epl_jefe){
                    
                    global $conn;
			
                        try{

                                $sql="select nov.id,b.cedula, RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl) as empleado,nov.detalle,nov.cod_epl,convert(varchar,nov.fecha,103) as fecha,nov.mes,nov.ano
                                                from prog_novedades nov, empleados_basic b, tipos_novedades tip
                                                where nov.cod_epl=b.cod_epl and nov.tip_novedades=tip.tip_novedades and nov.cod_epl_jefe='".$cod_epl_jefe."' and nov.tip_novedades=8 order by fecha asc "; 

                                $rs=$conn->Execute($sql);

                                while($fila=$rs->FetchRow()){

                                    @$hora_actual=  $this->turnos_horas($fila["turno_solicitud"]);                             

                                    $this->arrays[]=array("id"                  => $fila["id"],
                                                                    "cedula"                    => $fila["cedula"],
                                                                    "empleado"                  => $fila["empleado"],
                                                                    "detalle"                   => $fila["detalle"],
                                                                    "fecha"                     => $fila["fecha"],                                               
                                                                    "mes"                       => $fila["mes"],
                                                                    "ano"                       => $fila["ano"]  
                                                                    );

                                }


                                return $this->arrays;

                        }catch (exception $e) { 
                                var_dump($e); 
                                adodb_backtrace($e->gettrace());
                        }        

                }
                
                
                 public function bit_reemplazos($cod_epl_jefe){
                    
                    global $conn;
			
                        try{

                                $sql="select nov.id,b.cedula, RTRIM(b.nom_epl)+' '+RTRIM(b.ape_epl) as empleado,nov.detalle,nov.cod_epl,convert(varchar,nov.fecha,103) as fecha,nov.mes,nov.ano
                                                from prog_novedades nov, empleados_basic b, tipos_novedades tip
                                                where nov.cod_epl=b.cod_epl and nov.tip_novedades=tip.tip_novedades and nov.cod_epl_jefe='".$cod_epl_jefe."' and nov.tip_novedades=5 order by fecha asc "; 

                                $rs=$conn->Execute($sql);

                                while($fila=$rs->FetchRow()){

                                    @$hora_actual=  $this->turnos_horas($fila["turno_solicitud"]);                             

                                    $this->arrays[]=array("id"                  => $fila["id"],
                                                                    "cedula"                    => $fila["cedula"],
                                                                    "empleado"                  => $fila["empleado"],
                                                                    "detalle"                   => $fila["detalle"],
                                                                    "fecha"                     => $fila["fecha"],                                               
                                                                    "mes"                       => $fila["mes"],
                                                                    "ano"                       => $fila["ano"]  
                                                                    );

                                }


                                return $this->arrays;

                        }catch (exception $e) { 
                                var_dump($e); 
                                adodb_backtrace($e->gettrace());
                        }        

                }
	}
 ?>