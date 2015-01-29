<?php

/**
 * @author juanito
 * @copyright 2010
 */
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login          = $_SESSION["login"];
	$rol            = $_SESSION["rol"];
	
	include("autenticacion.php");

	include("conexion.php");
	$link = conexion();
    include("cabecera.php");
    include("menu.html");

?>
<html>
<head>
<title>ORDENES DE COMPRA</title>
<style type="text/css">
<!--
.style2 {font-weight: bold}
.style5 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<h1>Solicitud de Dinero</h1>
<?
    $flag = 0;
    for($i=0;$i<count($rol);$i++){
        if($rol[$i] == '5'){
            //echo "exito";
            $flag = 1;
        }
    }
    if($flag == 1){
?>
<?
    $sql_s = "SELECT *";
    $sql_f = "FROM pedidos"; 
    $sql_w = "WHERE estado = 2 AND idPedido NOT IN(SELECT idPedido FROM itemsolicituddinero);";

    $sql   = $sql_s.' '.$sql_f.' '.$sql_w;
    //echo $sql;
    $reg = mysql_query($sql,$link);    
    if(mysql_num_rows($reg)<>0){
?>
<form action="msg_solicitud_dinero.php" name="form1" id="form1" method="post">
  <table width="439" border="0" id="tabla3">
    <tr>
      <td width="97"><input type="submit" name="Submit" value="Crear Solicitud" /></td>      
      <td width="359"><input name="flag" type="hidden" id="flag" value="1"></td>
    </tr>
  </table>
</form>
<?
    }
    else{
        echo "<h3>NO EXISTEN PEDIDOS PENDIENTES!!!</h3>";
    }    
?>
<table width='579' border='0' id='tabla5'>
  <tr bgcolor='#59ACFF'>
    <td width='101'><div align="center" class="style5">Cod. Solicitud </div></td>
    <td width='107'><div align="center" class="style5"><strong>Fecha</strong></div></td>
    <td width='182'><div align='center' class="style2 style5">
      <div align="center">Precio Estimado </div>
    </div></td>
    <td width='40'><div align='center' class="style5">
      <div align="center">Editar.</div>
    </div></td>
    <td width='61'><div align='center' class="style5">
      <div align="center">Confirmar</div>
    </div></td>
    <td width='62'><div align='center' class="style5">
      <div align="center">Imprimir</div>
    </div></td>
  </tr>
  <?
  	$sql_s = "SELECT s.idSolicitud, codigoSolicitud, SUM(precioTotalestimado), fecha, estado";
    $sql_f = "FROM solicituddinero s LEFT JOIN itemSolicitudDinero i USING(idSolicitud)";
    $sql_g = "GROUP BY s.idSolicitud, codigoSolicitud, fecha, estado";
    $sql_o = "ORDER BY fecha DESC;";
    
    $sql   = mysql_query($sql_s.' '.$sql_f.' '.$sql_g.' '.$sql_o,$link);
    while($fil = mysql_fetch_array($sql)){
       $id_solicitud = dechex($fil[0]);
        
       echo "<tr style='font-size: 12px;'>";
            echo "<td>$fil[1]</td>"; 
            echo "<td>$fil[3]</td>";
            $ptt = number_format($fil[2], 2, '.', ',');
            echo "<td align='right'>$ptt Bs.</td>";
            if($fil[4]==0){
                echo "<td align='center'><a href='item_solicitud.php?id_solicitud=$id_solicitud'><img src='images/editar.png' border='0'></a></td>";
                echo "<td align='center'><a href='imprimir_solicitud_dinero.php?id_solicitud=$id_solicitud'&flag=0><img src='images/ok.gif' border='0'></a></td>";
                echo "<td></td>";
            }
            else{
                echo "<td></td>";
                echo "<td></td>";
                echo "<td align='center'><a href='imprimir_solicitud_dinero.php?id_solicitud=$id_solicitud'&flag=0><img src='images/impresora.jpg' border='0'></a></td>";                
            }                        
       echo "</tr>";
    }     
  ?>
</table>
<?
    } //CON PERMISOS NECESARIOS PARA EJECUTAR
    else{
        echo "<h2>¡¡¡ZONA RESTRINGIDA!!!</h2>";
    }
?>
</body>

</html>