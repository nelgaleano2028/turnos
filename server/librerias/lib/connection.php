<?php
	   include_once("adodb/adodb.inc.php");
	   include_once("adodb/adodb-exceptions.inc.php");
       include_once("adodb/adodb-error.inc.php");
	  
	   
	   // $odbc="odbc_mssql";
	   // $user = "";
	   // $pass = "";
	   
	   $odbc="odbc_mssql";
	   $user = "";
	   $pass = "";
	   
	  
	   
	   $is_connect = false;
	   
	   try{
	  
	   $conn = ADONewConnection($odbc);
	      
		// $dsn = "Driver={SQL Server};Server=WIN-GOA11REGNIM;Database=cmi_full;";
		// $conn->Connect($dsn,$user,$pass);
	   
	      $dsn = "Driver={SQL Server};Server=LENOVO-PC\SQLEXPRESS;Database=CMI;";
		  $conn->Connect($dsn,'','');
		
		
	
		
	   
	   //$dsn ="Driver={SQL Server};Server=C2234\CMI2012Dev;Database=TalentoCMI;";
	   //@$conn->Connect($dsn,$user,$pass);
	   
	   $conn->SetFetchMode(ADODB_FETCH_ASSOC);
	   

	   
	   		if($conn->isConnected()){
		  		 $is_connect=true;				
	   		}else{ 	
				die("<div style='border: 1px solid #eed3d7; background:#f2dede; color:#b94a48; width:50%;margin:0 auto; text-align:center; padding:10px;margin-top:60px; line-height: 25px;'><h2 style='font-weight:bold;'>Error al conectar con la base de datos</h2><p style='font-size: 17.5px;'>Por favor contacte al administrador</p></div>");
	   			$is_connect=false;
			}
	   }catch (exception  $e) 
	   { 
	      die($e->getMessage());
	     
	   }
?>