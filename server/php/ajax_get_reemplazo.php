<?phprequire_once('class_novedades.php');$obj= new novedades();$lista=$obj->listar_reemplazos($_POST["area"],$_POST["cargo"],$_POST["epl_nop"]);	$html="";	$html.= "<option value='0'>Seleccione una Reemplazo...</option>";	for($i=0;$i<count($lista);$i++){				$html.= "<option value=".$lista[$i]['codigo'].">".$lista[$i]['nombre']."</option>";	}		echo $html;?>