

	<style type="text/css" title="currentStyle">
			@import "../../js/DataTables/media/css/demo_page.css";
			@import "../../js/DataTables/media/css/jquery.dataTables.css";
		</style>
		<script type="text/javascript" language="javascript" src="../../js/DataTables/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../../js/DataTables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#calendario').dataTable();
			} );
		</script>
<?php	
	$mostrar="";
	
			/*
			function fecha ($valor)
			{
				$timer = explode(" ",$valor);
				$fecha = explode("-",$timer[0]);
				$fechex = $fecha[2]."/".$fecha[1]."/".$fecha[0];
				return $fechex;
			} Por ahora esta funcion no sirve*/
			

			if (!isset($_GET["fecha"])) 
			{
				$mesactual=intval(date("m"));
				if ($mesactual<10) $elmes="0".$mesactual;
				else $elmes=$mesactual;
				$elanio=date("Y");
			} 
			else 
			{
				$cortefecha=explode("-",$_GET["fecha"]);
				$mesactual=intval($cortefecha[1]);
				if ($mesactual<10) $elmes="0".$mesactual;
				else $elmes=$mesactual;
				$elanio=$cortefecha[0]; 
			} // asigno la fecha, mes y anio
			
			$primeromes=date("N",mktime(0,0,0,$mesactual,1,$elanio)); // para que me diga el primer mes del anio
			
			/*if (!isset($_GET["mes"])) $hoy=date("Y-m-d"); 
			else $hoy=$_GET["ano"]."-".$_GET["mes"]."-01"; Esto por ahora no sirve*/ 
			
			if (($elanio % 4 == 0) && (($elanio % 100 != 0) || ($elanio % 400 == 0))) $dias=array("","31","29","31","30","31","30","31","31","30","31","30","31");
			else $dias=array("","31","28","31","30","31","30","31","31","30","31","30","31"); /*es para los dias de los meses y si hay anio bisiesto*/
			
			/*$ides=array(); por ahora no sirve*/
			$eventos=array();
			/*$titulos=array(); Por ahora no sirve*/

			$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); /*arreglo con los nombres del mes*/
			$diasantes=$primeromes-1;
			$diasdespues=42;
			$tope=$dias[$mesactual]+$diasantes;
			
			if ($tope%7!=0) $totalfilas=intval(($tope/7)+1);
			else $totalfilas=intval(($tope/7));
			

			echo "<table class='calendario display' border='1' id='calendario' style='font-size:12px;'>		
			
			<tr><td rowspan='2'>No</td><td rowspan='2'>Empleado</td>"; 
			
			$p=1;
			$filita2=0;
			for ($v=1;$v<=$diasdespues;$v++)
			{
				if ($filita2<$totalfilas)
				{
				  
				if ($v>=$primeromes && $v<=$tope) 
				{
					
					
					if ($p<10) $dd="0".$p;else $dd=$p;
					
					date_default_timezone_set('America/Bogota');
				    $prueba="$dd-$elmes-".$elanio;
					$prueba=strtotime($prueba);
					$prueba2=date('l',$prueba);
					$prueba3=get_dias($prueba2);
					
					echo "<th";
					
					
					
					
					$compuesta=$elanio."-$elmes-$dd";
					
					if (count($eventos)>0 && in_array($compuesta,$eventos,true)) {echo " class=' evento";$noagregar=true;}
					else {echo " class='activa";$noagregar=false;}
					
					echo "' >$prueba3";

					echo "</th>";
					$p+=1;
				}
			}
			}
			echo "<td rowspan='2'>Sem1</td><td rowspan='2'>Sem2</td><td rowspan='2'>Sem3</td><td rowspan='2'>Sem4</td><td rowspan='2'>Sem5</td><td rowspan='2'>Horas</td></tr>";
			$j=1;
			$filita=0;
			
			for ($i=1;$i<=$diasdespues;$i++)
			{
				if ($filita<$totalfilas)
				{
				if ($i>=$primeromes && $i<=$tope) 
				{ 
					
					echo "<td";
				
					if ($j<10) $dd="0".$j;else $dd=$j;
					$compuesta=$elanio."-$elmes-$dd";
					
					if (count($eventos)>0 && in_array($compuesta,$eventos,true)) {echo " class=' evento";$noagregar=true;}
					else {echo " class='activa";$noagregar=false;}
					
					echo "'>$j";

					echo "</td>";
					$j+=1;
					
				}
							
				}
				
				
			}
			$filita+=1;
			
			
			
			echo"<tr><td>01</td><td>Steven Morales</td>";
			for($m=0;$m<$j-1;$m++){
					
					echo"<td>
						WWW
					</td>";
			}					
				echo "<td>144</td><td>144</td><td>144</td><td>144</td><td>144</td><td>255</td></tr>";
				
				
			echo"</table>";// aca donde steven introduce el codigo dentro del tbody
			?>
	</td></tr></table>
	<?php
		function get_dias($prueba2){
			
			$dia=$prueba2;
			$return="";
		
			switch ($dia){

				case 'Monday':
					$return='L';
				break;
				case 'Tuesday':
					$return='M';
				break;
				case 'Wednesday':
					$return='M';
				break;
				case 'Thursday':
					$return='J';
				break;
				case 'Friday':
					$return='V';
				break;
				case 'Saturday':
					$return='S';
				break;
				case 'Sunday':
					$return='D';
				break;
				
			}
			
			return $return;
			
		}
	
?>