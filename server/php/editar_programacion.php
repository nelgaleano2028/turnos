<?php require_once("../librerias/lib/connection.php");

global $conn;

$arreglo1=array();

$arreglo2=array();

$result1=array();
$result2=array();



$sql="SELECT * FROM prog_mes_tur WHERE ID='".@$_POST['id']."'";
$res=$conn->Execute($sql);




	while($row = $res->FetchRow()){
		
		$cod_epl=$row['cod_epl'];
		$cod_cc2=$row['cod_cc2'];
		
		for($i=1;$i<=31;$i++){
		
			array_push($arreglo1,$row['Td'.$i]);
		}
	}
	
	
	for($j=1; $j<=31; $j++){
	
		array_push($arreglo2,$_POST['Td'.$j]);
	}
	
	$result1=  array_diff_assoc($arreglo1, $arreglo2);
	
	$result2 = array_diff_assoc($arreglo2, $arreglo1);
	
	$html="Cambia los siguientes turnos: ";
	
	$flag=0;
	
	foreach($result1 as $key=>$value ){
	
		$value=strip_tags($value);
	
		switch($value):
			
			case 'V' :
			case 'IG' :
			case 'LN' :
			case 'SP' :
			case 'LM' :
			case 'AT' :
			case  'LP' :
			case  'EP' :
				$flag=1;
				break;	
		endswitch;
		
		$html.="el dia ".($key+1)." ".$value." por ".$result2[$key].", ";
		
	}
	
	
	
	// para eliminar las ausencias
//$sql3="select estado from ausencias where DATEPART(month, fec_ini_r)='".$_POST['mes']."' and DATEPART(year, fec_ini_r)='".$_POST['anio']."' and cod_epl='".$cod_epl."' and cod_cc2='".$cod_cc2."'";	

	

if($flag==0){
	
	$sql2="insert into prog_novedades values('".$cod_epl."','".$_POST['anio']."','".$_POST['mes']."','".$html."','".$_POST['cod_epl_jefe']."',getdate(),1)";
	$conn->Execute($sql2);
}else{
	$sql2="insert into prog_novedades values('".$cod_epl."','".$_POST['anio']."','".$_POST['mes']."','".$html."','".$_POST['cod_epl_jefe']."',getdate(),2)";
	$conn->Execute($sql2);
	
		
	enviar_correo($cod_epl,$_POST['anio'],$_POST['mes'],$html,$_POST['cod_epl_jefe'],$_POST['vigencia_vac']);
	
	
}


$sql="UPDATE  prog_mes_tur SET
Td1='".@$_POST['Td1']."', Td2='".@$_POST['Td2']."',Td3='".@$_POST['Td3']."',Td4='".@$_POST['Td4']."',Td5='".@$_POST['Td5']."',Td6='".@$_POST['Td6']."',Td7='".@$_POST['Td7']."',Td8='".@$_POST['Td8']."',Td9='".@$_POST['Td9']."',Td10='".@$_POST['Td10']."',Td11='".@$_POST['Td11']."',Td12='".@$_POST['Td12']."',Td13='".@$_POST['Td13']."',Td14='".@$_POST['Td14']."',Td15='".@$_POST['Td15']."',Td16='".@$_POST['Td16']."',Td17='".@$_POST['Td17']."',Td18='".@$_POST['Td18']."',Td19='".@$_POST['Td19']."',Td20='".@$_POST['Td20']."',Td21='".@$_POST['Td21']."',Td22='".@$_POST['Td22']."',Td23='".@$_POST['Td23']."',Td24='".@$_POST['Td24']."',Td25='".@$_POST['Td25']."',Td26='".@$_POST['Td26']."',Td27='".@$_POST['Td27']."',Td28='".@$_POST['Td28']."',Td29='".@$_POST['Td29']."',Td30='".@$_POST['Td30']."',Td31='".@$_POST['Td31']."', sem1='".@$_POST['sem1']."', sem2='".@$_POST['sem2']."', sem3='".@$_POST['sem3']."', sem4='".@$_POST['sem4']."' ,sem5='".@$_POST['sem5']."', sem6='".@$_POST['sem6']."'
WHERE ID='".@$_POST['id']."'";

$rs=$conn->Execute($sql);
if($rs)
	echo 1;
else
	echo 2;

function enviar_correo($cod_epl,$anio,$mes,$mensaje,$cod_jefe,$vigencia){
     
    include_once("class_mailer.php");
    $mail= new mailer();
    $destinatario='rober.ospina@talentsw.com';  //$row['email'];


     $mail->IsHTML(true);
     $mail->Subject = "Solcitud de  cambio de ausencias"; // Este es el titulo del email.
       //-----FIN EMAIL-----
     $mail->addAddress($destinatario);      
	
	if($vigencia==1){
		$mail->Body = "".$mensaje." del mes ".$mes." y a&ntilde;o".$anio." Empleado:".$cod_epl."  jefe:".$cod_jefe.""; // Mensaje a enviar
	}else{
		$mail->Body = "El empleado con vacaciones vigentes ".$mensaje." del mes ".$mes." y a&ntilde;o".$anio." Empleado:".$cod_epl."  jefe:".$cod_jefe.""; // Mensaje a enviar
	}
     
     $exito = $mail->Send(); // Enviar el correo.

    if($exito){
            return  1;
    }else{
            return 3;
    }
     
 }

?>