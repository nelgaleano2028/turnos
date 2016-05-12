<?php require_once("../librerias/lib/connection.php");

class Superquery{

	private $lista=array();

	
	public function tabla($anio,$mes,$cargo,$centro_costo,$perfil){ //inicio del metodo tabla
		
		global $conn;
                
                //$perfil="RHERRERA";
		
		$sql="exec ('SuperQueryTurnos @ano=".$anio.", @mes=".$mes." , @usuario=".$perfil.", @cargo=".$cargo.", @centrocosto=".$centro_costo.",  @param=0')";
			$rs=$conn->Execute($sql);
			
			
			while($row = $rs->fetchrow()){
                  
            $this->lista[]=array("empleado"=>utf8_encode($row["nombre"]),
								"cod_epl"=>$row["cod_epl"],
								"id"=>$row["ID"],
                                1=>$row["td1"],
								2=>$row["td2"],
								3=>$row["td3"],
								4=>$row["td4"],
								5=>$row["td5"],
								6=>$row["td6"],
								7=>$row["td7"],
								8=>$row["td8"],
								9=>$row["td9"],
								10=>$row["td10"],
								11=>$row["td11"],
								12=>$row["td12"],
								13=>$row["td13"],
								14=>$row["td14"],
								15=>$row["td15"],
								16=>$row["td16"],
								17=>$row["td17"],
								18=>$row["td18"],
								19=>$row["td19"],
								20=>$row["td20"],
								21=>$row["td21"],
								22=>$row["td22"],
								23=>$row["td23"],
								24=>$row["td24"],
								25=>$row["td25"],
								26=>$row["td26"],
								27=>$row["td27"],
								28=>$row["td28"],
								29=>$row["td29"],
								30=>$row["td30"],
								31=>$row["td31"],
								'sem1'=>$row["sem1"],
								'sem2'=>$row["sem2"],
								'sem3'=>$row["sem3"],
								'sem4'=>$row["sem4"],
								'sem5'=>$row["sem5"],
								'sem6'=>$row["sem6"],
								'horas'=>$row["horas"],
								);
			}
				
			return $this->lista;
			
	} //fin del metodo tabla
}
?>