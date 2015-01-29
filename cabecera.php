<?php

/**
 * @author juanito
 * @copyright 2010
 */
	session_start();
	$login          = $_SESSION["login"];
    $codigo_usuario = $_SESSION["codigo_usuario"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="juanito" />

	<title>SISTEMA DE SEGUIMIENTO Y CONTROL DE PEDIDOS INTERNOS - SUREÑA</title>
</head>
<body>
<center>
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
      codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,42,0"
      id="Movie1" width="500" height="50">
      <param name="movie" value="cabecera.swf">
      <param name="quality" value="high">
      <param name="bgcolor" value="#FFFFFF">
        <embed name="Movie1" src="images/cabecera.swf"
         quality="high" bgcolor="#FFFFFF" swLiveConnect="true"
         width="700" height="65"
         type="application/x-shockwave-flash"
         pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
    </object>
</center>
<?
	if($login <> ''){
	    echo "<strong>Usuario: </strong>".$login." / ".$codigo_usuario;
	}
	else{
		echo "<strong>Usuario: </strong>"."No autenticado";
	}
    
?> 
</body>
</html>