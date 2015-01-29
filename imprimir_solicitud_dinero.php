<?php
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login          = $_SESSION["login"];
	$rol            = $_SESSION["rol"];
	
	include("autenticacion.php");

	include("conexion.php");
	$link = conexion();
    include("funciones/literal.php");
    
    if($_POST){
        $id_solicitud = hexdec($_POST['id_solicitud']);
        $flag         = $_POST['flag'];
    }
    else{
        $id_solicitud = hexdec($_GET['id_solicitud']);
        $flag         = $_GET['flag'];
    }

    if ($flag == 1){
        $str_upd = "UPDATE solicitudDinero SET estado = 1 WHERE idSolicitud = '$id_solicitud'";
        $sql_upd = mysql_query($str_upd,$link);
    }

    //echo "SELECT codigoSolicitud, fecha FROM solicitudDinero WHERE idSolicitud = '$id_solicitud';";
    $sql_datos = mysql_query("SELECT idSolicitud, codigoSolicitud, fecha FROM solicitudDinero WHERE idSolicitud = '$id_solicitud';",$link);
    $fil_datos = mysql_fetch_array($sql_datos);
    
    
    $codigo_solicitud = $fil_datos['codigoSolicitud'];
    $fecha            = $fil_datos['fecha'];

    $sql_s = "SELECT idSolicitud, i.idPedido, nombreArticulo, unidad, cantidad, precioUnitarioEstimado, precioTotalEstimado, seccion, solicitante, fechaHoraRegistro, fechaHoraOrdenCompra, flag, observaciones";
    $sql_f = "FROM itemsolicituddinero i JOIN v_detallePedidos v USING(idPedido)";
    $sql_w = "WHERE idSolicitud = '$id_solicitud';";
        
    $sql   = $sql_s.' '.$sql_f.' '.$sql_w;
    
    $sql_item = mysql_query($sql,$link);

?>
<style type="text/css">
<!--
.style7 {color: #000000; font-weight: bold; font-size: 18px; }
-->
</style>
<html>
<head>
    <title>Solicitud Dinero para Compras SIDS S.A.</title>
</head>
<script language="Javascript">
function imprimir() {
print();
}
</script>
<body onLoad="imprimir();">

<h4><a href="solicitud_dinero.php">SOCIEDAD INDUSTRIAL DEL SUR S.A.</a></h4>
<h2><em>SOLICITUD DE DINERO  </em></h2>
<?
  $str_estado = "SELECT estado FROM solicitudDinero WHERE idSolicitud = '$id_solicitud'";
  $sql_estado = mysql_query($str_estado,$link);
  $fil_estado = mysql_fetch_array($sql_estado);
  if ($fil_estado[estado] == 0){
    echo "<h2>SOLICITUD SUJETA A CONFIRMACIÓN</h2>";
  }
?>
<table border="0">
  <tr>
    <td><strong>Solicitud</strong>:</td>
    <td><input name="textfield" type="text" size="7" maxlength="7" value="<? echo $codigo_solicitud?>" readonly=""/></td>
  </tr>
  <tr>
    <td><strong>Fecha</strong>:</td>
    <td><input name="textfield2" type="text" size="12" maxlength="12"  value="<? echo $fecha?>" readonly=""/></td>
  </tr>
</table>
<table width="842" border="0">
  <tr bgcolor="#6699FF">
    <td width="30"><div align="center" class="style7">N&ordm;</div></td>
    <td width="38"><div align="center" class="style7"><strong>Cant</strong></div></td>
    <td width="243"><div align="center" class="style7"><strong>Articulo</strong></div></td>
    <td width="38"><div align="center" class="style7"><strong>Unid</strong></div></td>    
    <td width="133"><div align="center" class="style7"><strong>Secci&oacute;n</strong></div></td>    
    <td width="160"><div align="center" class="style7"><strong>Observaciones</strong></div></td> 
    <td width="79"><div align="center" class="style7"><strong>Prec./Unit</strong></div></td>
    <td width="91"><div align="center" class="style7"><strong>Prec./Tot</strong></div></td>
  </tr>
  <?
     $cont = 1;
     $tot  = 0;
     while($fil_item = mysql_fetch_array($sql_item)){
        $id_solicitud = dechex($fil_item[0]);        
        $id_pedido    = dechex($fil_item[1]);
        
        $tot = $tot + $fil_item[precioTotalEstimado];
        
        echo "<tr style='font-size:13px'>";
            echo "<td align='center'>$cont</td>";
            echo "<td align='center'>$fil_item[cantidad]</td>";    
            echo "<td>$fil_item[nombreArticulo]</td>";
            echo "<td>$fil_item[unidad]</td>";
            echo "<td>$fil_item[seccion]</td>";            
            echo "<td>$fil_item[observaciones]</td>"; 
            $pue = number_format($fil_item[precioUnitarioEstimado], 2, '.', ',');        
            echo "<td align='right'>$pue</td>";
            $pte = number_format($fil_item[precioTotalEstimado], 2, '.', ',');
            echo "<td align='right'>$pte</td>";
        echo "</tr>";
        $cont = $cont + 1;
            }
  ?>
  <tr bgcolor="#6699FF">
    <td colspan="7"><div align="center" class="style7"><strong>Total</strong></div></td>
    <?
        $ptt = number_format($tot, 2, '.', ',');
    ?>
    <td align="right"><span class="style7"><strong><? echo $ptt?></strong></span></td>    
  </tr>
</table>
<table width="842" border="0">
  <tr>
    <td><h3>
			<? 
				$toti1 = round($tot,2);
				
				echo num_letra($toti1,2).' Bolivianos';
				
			?>
		</h3></td>
  </tr>
  <tr>
    <td><? 
            $ahora = mysql_fetch_array(mysql_query("select now()"));
            echo "<h5>$ahora[0]</h5>";
            //echo date('Y/m/d').' '.date('H:i:s');
        ?>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
