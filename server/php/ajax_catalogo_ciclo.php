<?php require_once("class_programacion.php");




$turnos = new programacion();

$param=$_GET['param'];
$mes=$_GET['mes'];
$anio=$_GET['anio'];
$cod_epl=$_GET['cod_epl'];
$cod_jefe=$_GET['jefe_prog'];


$centro_costo=$turnos->get_cod_cc2($cod_jefe); 

$tabla="";
$tablas=$turnos->ciclos_programacion($centro_costo[0]['cod_cc2'],$cod_jefe); //02 es parametro que define los ciclos del perfil ingresado por ejemplo RHERRERA
$tabla .= "<table class='tableone table-bordered' border='0' id='ciclos' style=' width: 100%;  border:2px solid rgb(41, 76, 139) !important;'>";
		
        $tabla .= "<thead>";
		$tabla .= "<tr style='background-color: rgb(41, 76, 139); color: #fff; text-align: center;'>";
		$tabla .= "<th  scope='col' style='overflow: hidden;'>C&oacute;d. Ciclo</th>";
		$tabla .= "<th  scope='col' style='overflow: hidden;'>L</th>";
		$tabla .= "<th scope='col' style='overflow: hidden;'>M</th>";
		$tabla .= "<th scope='col' style='overflow: hidden;'>M</th>";
		$tabla .= "<th scope='col' style='overflow: hidden;'>J</th>";
		$tabla .= "<th scope='col' style='overflow: hidden;'>V</th>";
		$tabla .= "<th scope='col' style='overflow: hidden;'>S</th>";
		$tabla .= "<th scope='col' style='overflow: hidden;'>D</th>";
		
		$tabla .= "</tr>";		
		$tabla .= "</thead>";
		
		$tabla .= "<tbody id='cicl'>";
			$i=1;
			
		
			foreach($tablas as $value){
			
						if($i % 2){                             
                             $tabla .= "<tr id='tur$i' class='si' style='cursor:pointer; background-color: #FFF;' onclick=\"return copiar_ciclo('".$i."',".$param.",".$cod_epl.")\" onMouseOver='this.style.background=\"rgb(175, 203, 238)\"' onMouseOut='this.style.background=\"#FFF\"'>";
                        }else{
                             $tabla .= "<tr id='tur$i' class='si' style='cursor:pointer; background-color: #eee;' onclick=\"return copiar_ciclo('".$i."',".$param.",".$cod_epl.")\" onMouseOver='this.style.background=\"rgb(175, 203, 238)\"' onMouseOut='this.style.background=\"#eee\"'>"; 
							 
                        }			
				
				$tabla  .= "<td  style='overflow: hidden;'>".$value["codigo_ciclo"]."</td>";
				$tabla  .= "<td  style='overflow: hidden;' class='1'>".$value["uno"]."</td>";
				$tabla  .= "<td  style='overflow: hidden;' class='2'>".$value["dos"]."</td>";
				$tabla  .= "<td  style='overflow: hidden;' class='3'>".$value["tres"]."</td>";
				$tabla  .= "<td  style='overflow: hidden;' class='4'>".$value["cuatro"]."</td>";
				$tabla  .= "<td  style='overflow: hidden;' class='5'>".$value["cinco"]."</td>";
				$tabla  .= "<td  style='overflow: hidden;' class='6'>".$value["seis"]."</td>";
				$tabla  .= "<td  style='overflow: hidden;' class='7'>".$value["siete"]."</td>";
				$tabla  .= "<td  style='overflow: hidden; display:none;'>".$value["horas"]."</td>";
				
				$tabla .= "</tr>";
				
				$i++;
			}

		$tabla .= "</tbody>";
		$tabla .= "</table>";
	
	echo $tabla;
?>