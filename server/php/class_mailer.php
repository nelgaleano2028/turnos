<?php

    /*~ class_mailer.php
    .---------------------------------------------------------------------------.
    |   Software: mailer - PHP clase de correos                                 |
    |   Versión: 1.0.0                                                          |
    |   Contacto: (www.talentsw.com)                                            |
    | ------------------------------------------------------------------------- |
    |    Author: Juan Manuel lópez                                              |
    | Copyright (c) 2012-2016, Talentsw. All Rights Reserved.                   |
    | ------------------------------------------------------------------------- |
    |License: Distribuida para los desarrolladores web de Talentos y Tecnologia |
    | este programa es distribuido para el envió de correos el uso es           |
    | laboral, estudiantil y experimental.                                      |
    '---------------------------------------------------------------------------'
    
    /**
     * mailer - PHP envio de correos
     * @package mailer
     * @author Juan Manuel López
     * @copyright 2012 - 2016 Talentos y Tecnologia S.A.S
     */
    
    
    
    /*
    .-------------------------------------------.
    |llamado de la conexion a la base de datos  |
    '-------------------------------------------'
    */
	require_once("../librerias/lib/connection.php");
 
    
    /*
    .--------------------------------.
    |Llamado de la libreria PHPMAILER|
    '--------------------------------'
    */
    require_once("../librerias/phpmailer/class.phpmailer.php");
    require_once("../librerias/phpmailer/class.smtp.php");
    require_once('../librerias/phpmailer/class.pop3.php');
  
    

    
    class mailer extends PHPMailer{
        
        /*variables que se heredó de la clase PHPMailer las cuales me permiten configurar el envio de correos*/
        var $From;
        var $FromName;
        var $Host;
        var $Port;
        var $Mailer;
        var $SMTPAuth;
        var $Username;
        var $Password;
        var $WordWrap;
        
        function __construct(){
            
            global $conn; //variable que nos permite conectarnos a la bd
            
            /*Consultamos la tabla parametros_nue para traer la configuracion del servidor de correo*/
            $sql="select des_var as DES_VAR,descripcion AS DESCRIPCION from parametros_nue
                  where nom_var in('chc_servidor_correo','chc_password_correo',
                  'chc_remitente_correo','chc_usuario_correo') order by des_var desc";
                  
            /*Ejecutamos la sentencia*/     
            $rs= $conn->Execute($sql);
                 /*Hacemos un recorrido de los datos y se almacenan en un array*/
                 while($fila=$rs->FetchRow()){
                  $return[] = $fila;
                 }
                 /*COnfiguramos los parametos de la libreria php mailer*/
                 $this->From ="cmi@imbanaco.com.co"; // $return[0]["DESCRIPCION"]; /*Quien envia el correo DEBE SER EL JEFE*/
                 $this->FromName = "Centro Medico Imbanaco"; //$return[0]["DESCRIPCION"];
                 $this->Host = "mail.imbanaco.net"; //$return[1]["DESCRIPCION"]; /*Host del servidor de correo*/
                 $this->Port = 25; /*Puerto del servidor de correo*/
                 $this->Mailer = "smtp";  // Alternative to IsSMTP()
                 $this->SMTPAuth = false; /*Se activa la autencticacion del servidor de correo*/
                 //$this->Username = $return[0]["DESCRIPCION"];/*Usuario del servidor de correo */
                 //$this->Password = $return[2]["DESCRIPCION"];/*Password del servidor de correo*/
                 $this->WordWrap = 72;
                 
        }
        
    }
?>