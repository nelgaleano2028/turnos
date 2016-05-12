<?php 
	require_once("../librerias/lib/connection.php");
	
	class empleado{
		
		private $codigo=null;
		private $lista=array();
                
                               
		public function empleado($codigo){
			$this->codigo=$codigo;
		}
                
                
         
		public function run(){
			global $conn;
			
			try{
				$sql="select b.cod_cc2, b.cod_car, gral.cod_jefe from empleados_basic b , empleados_gral gral where b.cod_epl=gral.cod_epl and estado='A' and b.cod_epl='{$this->codigo}'";
				$rs=$conn->Execute($sql);
				while($fila=$rs->FetchRow()){
				$this->lista[]=array("area"   => $fila["cod_cc2"],
									 "cargo"   =>$fila["cod_car"],
									 "jefe"   =>$fila["cod_jefe"]);
				return $this->lista;
			}
			}catch (exception $e) { 
				var_dump($e); 
				adodb_backtrace($e->gettrace());
			}
		}
                
                public function add_tmp_aus($cod_con,$cod_epl,$fec_ini,$fec_fin,$cod_cc2,$cod_car,$cod_jefe){
                    global $conn;
                        
                        $fecha=explode("-",$fec_ini);
                    
                        $sql2="select cod_aus from conceptos_ausencias where cod_con=".$cod_con."";
                        $rs2=$conn->Execute($sql2);
                        $fila=$rs2->FetchRow();
			
			try{
                            $sql="insert into ausencias_tmp values('".$cod_con."','".$cod_epl."',convert(varchar,'".$fec_ini."',103),convert(varchar,'".$fec_fin."',103),'P','".$cod_cc2."','".$cod_car."','".$cod_jefe."',".$fila['cod_aus']." )";
                            $conn->Execute($sql);

                            if($cod_con==11){

                                $ausencia='V';
                            }else{

                                 $ausencia='LR';
                            }
                            
                            //insertar ausencias en la tabla prog_novedades
                            $sql2="insert into prog_novedades values('".$cod_epl."',".$fecha[2].",".$fecha[1].",'solicitud de ausencia ".$ausencia." del empleado ".$cod_epl."  desde: ".$fec_ini."  hasta: ".$fec_fin."',".$cod_jefe.",GETDATE (),3)";
                            //var_dump($sql2); die();
                            $rs=$conn->Execute($sql2);

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
                
                public function add_inter_turnos($cod_epl_actual,$cod_epl_cambio,$turno_actual,$turno_cambio,$fecha_ini,$cod_cc2,$cod_car,$cod_jefe){
                    
                    global $conn;
                   
			try{
                            $sql="insert into solicitud_tur_tmp values('".$cod_epl_actual."','".$cod_epl_cambio."','".$turno_actual."','".$turno_cambio."',convert(varchar,'".$fecha_ini."',103),'PE','".$cod_cc2."','".$cod_car."','".$cod_jefe."' )";
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
                
                
                 public function add_solicitud_turnos($cod_epl,$turno_solicitud,$fecha_solicitud,$cod_cc2,$cod_car,$cod_jefe){
                    
                    global $conn;
                   
			try{
				$sql="insert into sol_cambio_tur_tmp(cod_epl,turno_solicitud,fecha_solicitud,estado,cod_cc2,cod_car,cod_jefe) values('".$cod_epl."','".$turno_solicitud."',convert(varchar,'".$fecha_solicitud."',103),'P','".$cod_cc2."','".$cod_car."','".$cod_jefe."')";
                                
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
                
                
                
                
                
                
                
                
		
		
	}
?>