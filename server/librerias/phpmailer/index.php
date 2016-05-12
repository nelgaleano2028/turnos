<?php
session_start();

if(isset($_SESSION['cod'])){
header('location:../php/main.php');

}else if(isset($_SESSION['nom'])){
header('location:../php/main_admin.php');
	
	}
	else{
		header('location:../');
	}
?>