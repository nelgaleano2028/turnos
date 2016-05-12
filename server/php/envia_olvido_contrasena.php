<?php
include_once("../librerias/lib/connection.php");

/*
 *libreria para enviar correos electronicos 
 */
require_once('class_mailer.php');

 $mail = new mailer();
 

$email = $_POST["email"];


$query1 = "SELECT PASS, USUARIO FROM T_NUEVO_PASS where usuario = '$email'";
$rs1 = $conn->Execute($query1);
$row1 = $rs1->fetchrow();
$password_nuevo = $row1['PASS'];
$usuario_nuevo = $row1['USUARIO'];

$query = "SELECT a.COD_EPL, b.COD_EPL, a.NOM_EPL, a.APE_EPL, a.CEDULA, b.EMAIL, a.ESTADO FROM EMPLEADOS_BASIC a, EMPLEADOS_GRAL b WHERE a.ESTADO = 'A' and a.COD_EPL = b.COD_EPL and b.EMAIL = '$email'";
$rs = $conn->Execute($query);
$row = $rs->fetchrow();
$password = $row['CEDULA'];
$usuario = $row['EMAIL'];


if (isset($password_nuevo)){

$destinatario = "$email";
$asuntogeneral = utf8_decode("Recuperar Contraseña");
$cuerpo = "
<html>
<head>
</head>
<body>
<h1></h1>

<p>
\n Recibimos una solicitud para recordar la contrase&ntilde;a de tu cuenta, para acceder a la aplicacion de monitores: tu usario es $usuario_nuevo y tu contrase&ntilde;a es $password_nuevo . \n
Recuerda que puedes cambiarla accediendo a la aplicacion. \n
</p>
<p>
\n Si tienes problemas para ingresar al sitio con tu contrase&ntilde;a por favor reporta este error en soporte. \n
Por favor, ignora este mensaje en el caso que no nos hayas enviado la solicitud de contrase&ntilde;a de tu cuenta.  \n
</p>
</body>
</html>
";


	/*
    ------------------------------ENVIO DE COMPROBANTE EMAIL------------------------------------------------------------------
    */
      
       //Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>�?) de //correo.
       $mail->AddAddress("$email"); // Esta es la dirección a donde enviamos 
       $mail->IsHTML(true); // El correo se envía como HTML
       $mail->Subject = $asuntogeneral; // Este es el titulo del email.
       $mail->Body = $cuerpo; // Mensaje a enviar
       $exito = @$mail->Send(); // Envía el correo.
       $mail->ClearAddresses();
       $mail->ClearAttachments();
       //También podríamos agregar simples verificaciones para saber si se envió:
        if($exito){
            echo 'true';
        }else{
          echo 'Hubo un inconveniente. Contacta a un administrador.';
		   
        }
    /* ----------------------------------FIN DE ENVIO--------------------------------------------------------------------*/      
      


 




}elseif(isset($password)){
 
$destinatario = "$email";
$asuntogeneral = utf8_decode("Recuperar Contraseña");
$cuerpo = "
<html>
<head>
</head>
<body>
<h1></h1>

<p>
\n Recibimos una solicitud para recordar la contrase&ntilde;a de tu cuenta, para acceder a la aplicacion de monitores: tu usario es $usuario y tu contrase&ntilde;a es $password . \n
Recuerda que puedes cambiarla accediendo a la aplicacion. \n
</p>
<p>
\n Si tienes problemas para ingresar al sitio con tu contrase&ntilde;a por favor reporta este error en soporte. \n
Por favor, ignora este mensaje en el caso que no nos hayas enviado la solicitud de contrase&ntilde;a de tu cuenta.  \n
</p>
</body>
</html>
";



	/*
    ------------------------------ENVIO DE COMPROBANTE EMAIL------------------------------------------------------------------
    */
      
       //Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>�?) de //correo.
       $mail->AddAddress("$email"); // Esta es la dirección a donde enviamos 
       $mail->IsHTML(true); // El correo se envía como HTML
       $mail->Subject = $asuntogeneral; // Este es el titulo del email.
       $mail->Body = $cuerpo; // Mensaje a enviar
       $exito = @$mail->Send(); // Envía el correo.
       $mail->ClearAddresses();
       $mail->ClearAttachments();
       //También podríamos agregar simples verificaciones para saber si se envió:
        if($exito){
            echo 'true';
        }else{
           echo 'Hubo un inconveniente. Contacta a un administrador.';
		   
        }
    /* ----------------------------------FIN DE ENVIO--------------------------------------------------------------------*/          

}elseif($email <> $usuario){
 
 echo "Usted no se encuentra en la base de datos, verifique de nuevo su email.";
 
}

?>