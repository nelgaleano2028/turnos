<?php 
	include_once("class_mailer.php");
	$mail= new mailer();
	//VAR_DUMP($_POST);DIE("BN");
	
	$destinatario=$_POST["correo"];
	
	//var_dump($destinatario);die("");
	
	$opciones = explode(",", $destinatario);
	
	foreach($opciones as $destinatarios) {
              $mail->addAddress($destinatarios);      
    }

         $mail->IsHTML(true);
		 
		 /*Parametros administrador*/
		$sql2="select top 1 correo_jefe_gh,correo_tiempo_extra from turnos_parametros";
		$rs=$conn->Execute($sql2);
		$fila=$rs->FetchRow();
		
		if($_POST['info']==1){
			
			 $mail->AddCC($fila['correo_tiempo_extra']);
				
		}else if($_POST['info']==2){
		
			$mail->AddCC($fila['correo_jefe_gh']);
		}
			
		
         $mail->Subject = "Programacion Turnos"; // Este es el titulo del email.
           //-----FIN EMAIL-----
         
         $mail->Body = $_POST["mens"]; // Mensaje a enviar
         $exito = $mail->Send(); // Envía el correo.
		 
        if($exito){
                echo '<span class="mensajes_success_correo">Se ha Enviado correctamente</span>';
        }else{
                echo '<span class="mensajes_error_correo" >No se ha podido enviar los correos, intente mas tarde</span>';
        }

?>