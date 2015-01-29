<?
    include("cabecera.php");
    include("menu.html");
    $error = $_GET["error"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="juanito" />

	<title>Untitled 2</title>
    <style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
.style5 {color: #3399FF; font-weight: bold; }
-->
    </style>
</head>

<body>
<form name="form1" method="post" action="validar.php">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
<div align="center">
<table width="221" border="0" bordercolor="#CCCCCC" bgcolor="#3399FF">
    <tr>
      <td colspan="2" bgcolor="#FFFFFF"><div align="center"><span class="style5">Iniciar Sesi&oacute;n </span></div></td>
    </tr>
    <?
        if($error == 1){
            echo "<tr><td colspan='2' aling='center'>Autenticaci&oacute;n erronea</td></tr>";
        }
    ?>
    <tr>
      <td width="91"><span class="style3">Usuario</span></td>
      <td width="120"><input name="login" type="text" id="login" style="font-size:11px" /></td>
    </tr>
    <tr>
      <td><span class="style3">Contrase&ntilde;a</span></td>
      <td><input name="contrasena" type="password" id="contrasena" style="font-size:11px"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Login" /></td>
    </tr>
  </table>
</form>
</div>
<p>&nbsp;</p>

</body>
</html>