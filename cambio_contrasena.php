<?

/**
 * @author dieguin
 * @copyright 2010
 */

	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login          = $_SESSION["login"];
	
	include("autenticacion.php");

 	include("conexion.php");
	$link = conexion();
    include("cabecera.php");
    include("menu.html");
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="dieguin" />

	<title>Untitled 2</title>
</head>

<body>

<form name="form1" method="post" action="msg_cambio_contrasena.php">
<table width="358" border="0" bordercolor="#CCCCCC" bgcolor="#3399FF">
  <tr>
    <td colspan="2" align="center" bgcolor="#FFFFFF"><strong>Cambio de Contrase&ntilde;a</strong></td>    
    </tr>
  <tr>
    <td width="164" style="color: white;"><strong>Contrase&ntilde;a Actual</strong></td>
    <td>
      <label>
        <input name="contrasena_actual" id="contrasena_actual" type="password">
      </label>
    </td>
  </tr>
  <tr>
    <td style="color: white;"><strong>Nueva Contrase&ntilde;a</strong></td>
    <td><input name="nueva_contrasena" id="nueva_contrasena" type="password"></td>
  </tr>
  <tr>
    <td style="color: white;"><strong>Confirmar Contrase&ntilde;a</strong></td>
    <td><input name="confirmar_contrasena" id="confirmar_contrasena" type="password"></td>
  </tr>
  <tr>
    <td><input type="submit" name="cambiar" id="cambiar" value="Cambiar"></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>


</body>
</html>