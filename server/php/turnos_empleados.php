<?php  require_once("../librerias/lib/connection.php");

global $conn;

$sql="SELECT COD_TUR FROM TURNOS_PROG_TMP 
    WHERE COD_TUR <> 'N'  AND COD_TUR <> 'SP' AND COD_TUR <> 'VCTO' AND COD_TUR <> 'IG' AND COD_TUR <> 'VD' AND COD_TUR <> 'V' AND COD_TUR <> 'R'
    AND COD_TUR <> 'LN' AND COD_TUR <> 'LM' AND COD_TUR <> 'AT' AND COD_TUR <> 'LP' AND COD_TUR <> 'EP'
    UNION
    SELECT COD_TUR FROM TURNOS_PROG WHERE COD_TUR <> 'N'  AND COD_TUR <> 'SP' AND COD_TUR <> 'VCTO' AND COD_TUR <> 'IG' AND COD_TUR <> 'VD' AND COD_TUR <> 'V' AND COD_TUR <> 'R'
    AND COD_TUR <> 'LN' AND COD_TUR <> 'LM' AND COD_TUR <> 'AT' AND COD_TUR <> 'LP' AND COD_TUR <> 'EP'";
      
      $rs=$conn->Execute($sql);

    $html="";
    $html.= "<option value='0'>Seleccione una ausencia....</option>";

	while($fila=$rs->FetchRow()){

		$html.= "<option value=".$fila['COD_TUR'].">".$fila['COD_TUR']."</option>";
	}
		
		echo $html;
                
                
 ?>