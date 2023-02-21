<?php
session_start();

if($_SESSION['captcha'] == $_POST['captcha']){
	
	$_SESSION['msg'] = "<h3 style='color:green;'>Captcha sucess<h3>";
	header("Location: TemplateRegister.php");
}else{
	$_SESSION['msg'] = "<h3 style='color:red;'>ERRO! Captcha invalid<h3>";
	header("Location: TemplateRegister.php");
}