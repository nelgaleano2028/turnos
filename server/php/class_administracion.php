<?php
require_once("../librerias/lib/connection.php");

class Administra{
    
	//ojo cree dos porque me salio error
	private $lista1=array();
	private $lista2=array();
	private $lista3=array();
	private $lista4=array();
    private $lista5=array();




		public function lista_centroCosto($codigo){
			try { 
				global $conn;
				$sql="SELECT distinct AREA.COD_CC2,   AREA.NOM_CC2 FROM  CENTROCOSTO2 AREA, EMPLEADOS_BASIC EPL, EMPLEADOS_GRAL GRAL
						WHERE EPL.COD_EPL = GRAL.COD_EPL
						AND EPL.COD_CC2=AREA.COD_CC2
						and GRAL.COD_JEFE = '".$codigo."'
						and AREA.estado='A'
						and EPL.estado='A'
						";
						
				$rs=$conn->Execute($sql);
				while($fila=$rs->FetchRow()){
					$this->lista3[]=array("codigo" => $fila["COD_CC2"],
										 "area"	  => utf8_encode($fila["NOM_CC2"]));
				}
				
				return $this->lista3;
			}catch (exception $e) { 

			   var_dump($e); 

			   adodb_backtrace($e->gettrace());

			} 
		}
		
		public function lista_jefes(){
		
			try { 
				global $conn;
				$sql="select usuario, cod_epl
				from acc_usuariosTurnosWeb where cod_gru_prg='TURNOSJEFE'";
						
				$rs=$conn->Execute($sql);
				while($fila=$rs->FetchRow()){
					$this->lista3[]=array("usuario" => $fila["usuario"],
										  "codigo" => $fila["cod_epl"]);
				}
				
				return $this->lista3;
			}catch (exception $e) { 

			   var_dump($e); 

			   adodb_backtrace($e->gettrace());

			} 
		
		
		
		}
		
		public function lista_empleados($cargo, $codigo){
			try { 
				global $conn;
				$sql="SELECT epl.cod_epl, epl.nom_epl,epl.ape_epl FROM  EMPLEADOS_BASIC EPL, EMPLEADOS_GRAL GRAL
						WHERE EPL.COD_EPL = GRAL.COD_EPL
						AND EPL.COD_CAR='".$cargo."'
						and gral.COD_JEFE = '".$codigo."'
						and (epl.estado = 'A' OR
						(datepart(yy,epl.fec_ing) = '2013' and datepart(mm,epl.fec_ing)='02') OR
						(datepart(yy,epl.fec_ret) = '2013' and datepart(mm,epl.fec_ret)='02') )";
						
				$rs=$conn->Execute($sql);
				
				while($fila=$rs->FetchRow()){
					$this->lista[]=array("codigo"   => $fila["cod_epl"],
										 "nombre"   =>utf8_encode($fila["nom_epl"]),
										 "apellido" =>utf8_encode($fila["ape_epl"]));
				}
				
				return $this->lista;
				
			}catch (exception $e) { 

			   var_dump($e); 

			   adodb_backtrace($e->gettrace());

			}	
	}
	
	
	public function  lista_privilegios(){
			try { 
				global $conn;
				$sql="select  DISTINCT cod_gru_prg from acc_usuariosTurnosWeb where cod_gru_prg in('TURNOSJEFE', 'TURNOS', 'TURNOSHE', 'GHUMANA')";
						
				$rs=$conn->Execute($sql);
				
				while($fila=$rs->FetchRow()){
					$this->lista[]=array("privilegio"   => $fila["cod_gru_prg"]);
				}
				
				return $this->lista;
				
			}catch (exception $e) { 

			   var_dump($e); 

			   adodb_backtrace($e->gettrace());

			}	
	}
	
	
	public function lista_usuarios($privilegio){
			try { 
				global $conn;
				$sql=" select  *  from acc_usuariosTurnosWeb a, empleados_basic b where a.cod_gru_prg='".$privilegio."' and a.cod_epl=b.cod_epl";
				
				$rs=$conn->Execute($sql);
				
				
				while($fila=$rs->FetchRow()){
					$this->lista[]=array("usuario"   => $fila["usuario"],
										 "nombre"   =>utf8_encode($fila["nom_epl"]),
										 "apellido" =>utf8_encode($fila["ape_epl"]));
				}
				
				return $this->lista;
				
			}catch (exception $e) { 

			   var_dump($e); 

			   adodb_backtrace($e->gettrace());

			}	
	}
	
	
	public function lista_cargos($area, $codigo){
		try { 
			global $conn;
			$sql="SELECT distinct c.cod_car, C.NOM_CAR  FROM CARGOS C, CENTROCOSTO2 AREA, EMPLEADOS_BASIC EPL, EMPLEADOS_GRAL GRAL
					WHERE EPL.COD_EPL = GRAL.COD_EPL
					AND EPL.COD_CC2='".$area."'
					AND EPL.COD_CAR=C.COD_CAR
					and gral.COD_JEFE  = '".$codigo."'";
					
					
			$rs=$conn->Execute($sql);
			while($fila=$rs->FetchRow()){
				$this->lista4[]=array("codigo" => $fila["cod_car"],
									 "cargo"  => utf8_encode($fila["NOM_CAR"]));
			}
			
			return $this->lista4;
		}catch (exception $e) { 

           var_dump($e); 

           adodb_backtrace($e->gettrace());

		}
	}
	
	public function parametrizacion(){
		
		try { 
			global $conn;
			$sql="select top 1 * from turnos_parametros";
							
			$rs=$conn->Execute($sql);
			while($fila=$rs->FetchRow()){
				$this->lista4[]=array(	"t_hor_max_turnos" => $fila["t_hor_max_turnos"],
										"t_hor_min_ciclos"  => $fila["t_hor_min_ciclos"],
										"t_hor_min_prog" => $fila["t_hor_min_prog"],
										"t_administradorTur"  => $fila["t_administradorTur"],
										"correo_jefe_gh" => $fila["correo_jefe_gh"],
										"correo_tiempo_extra"  => $fila["correo_tiempo_extra"],
										"tiempo_desc_turnos" => $fila["tiempo_desc_turnos"],
										"tiempo_hol_marca"  => $fila["tiempo_hol_marca"],
										"min_hora_extra"  => $fila["min_hora_extra"],
										"min_recargo"  => $fila["min_recargo"],
										"dias_vac"  => $fila["dias_vac"],
										"min_extra_horario"  => $fila["min_extra_horario"],
										"min_hora_completa"  => $fila["min_hora_completa"]
									 );
			}
			
			return $this->lista4;
		}catch (exception $e) { 

           var_dump($e); 

           adodb_backtrace($e->gettrace());

		}
			
	
	}
}