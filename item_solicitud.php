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
    include("funciones/literal.php");
    
    if($_POST){
        $id_solicitud = hexdec($_POST['id_solicitud']);
    }
    else{
        $id_solicitud = hexdec($_GET['id_solicitud']);
    }

    $sql_s = "SELECT idSolicitud, i.idPedido, nombreArticulo, unidad, cantidad, precioUnitarioEstimado, precioTotalEstimado, seccion, solicitante, fechaHoraRegistro, fechaHoraOrdenCompra, flag";
    $sql_f = "FROM itemsolicituddinero i JOIN v_detallePedidos v USING(idPedido)";
    $sql_w = "WHERE idSolicitud = '$id_solicitud';";
        
    $sql   = $sql_s.' '.$sql_f.' '.$sql_w;
    
    //echo "SELECT codigoSolicitud, fecha FROM solicitudDinero WHERE idSolicitud = '$id_solicitud';";
    $sql_datos = mysql_query("SELECT idSolicitud, codigoSolicitud, fecha FROM solicitudDinero WHERE idSolicitud = '$id_solicitud';",$link);
    $fil_datos = mysql_fetch_array($sql_datos);
    
    
    $codigo_solicitud = $fil_datos['codigoSolicitud'];
    $fecha            = $fil_datos['fecha'];
    
    $sql_item = mysql_query($sql,$link);
?>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
-->
</style>

<table border="0">
    <tr>
        <td>Solicitud:</td>
        <td><input name="textfield" type="text" size="7" maxlength="7" value="<? echo $codigo_solicitud?>" readonly=""/></td>
    </tr>
    <tr>
        <td>Fecha:</td>
        <td><input name="textfield2" type="text" size="12" maxlength="12"  value="<? echo $fecha?>" readonly=""/></td>
    </tr>
</table>
<h3>PEDIDOS DE LA SOLICITUD DE DINERO</h3>
<table width="818" border="0">
  <tr bgcolor="#6699FF">
    <td width="27"><div align="center"><span class="style3">N&ordm;</span></div></td>
    <td width="265"><div align="center"><span class="style3">Articulo</span></div></td>
    <td width="31"><div align="center"><span class="style3">Unid</span></div></td>    
    <td width="162"><div align="center"><span class="style3">Secci&oacute;n</span></div></td>
    <td width="40"><div align="center"><span class="style3">Cant</span></div></td>
    <td width="66"><div align="center"><span class="style3">Prec./Unit</span></div></td>
    <td width="72"><div align="center"><span class="style3">Prec./Tot</span></div></td>
    <td width="41"><div align="center"><span class="style3">Editar</span></div></td>
    <td width="56"><div align="center"><span class="style3">Eliminar</span></div></td>
  </tr>
  <?
     $cont = 1;
     $tot  = 0;
     while($fil_item = mysql_fetch_array($sql_item)){
        $id_solicitud = dechex($fil_item[0]);        
        $id_pedido    = dechex($fil_item[1]);
        
        $tot = $tot + $fil_item[6];
        
        echo "<tr style='font-size:10px'>";
            echo "<td align='right'>$cont</td>";
            echo "<td>$fil_item[2]</td>";
            echo "<td>$fil_item[3]</td>";
            echo "<td>$fil_item[7]</td>";
            echo "<td align='right'>$fil_item[4]</td>";

            if($fil_item[11]==0){
                echo "<td align='right'>$fil_item[5]</td>";
                echo "<td align='right'>$fil_item[6]</td>";
                echo "<td align='center'><a href='msg_item_solicitud.php?id_solicitud=$id_solicitud&id_pedido=$id_pedido&del=0'><img src='images/editar.png' border='0'></a></td>";
                echo "<td align='center'><a href='msg_item_solicitud.php?id_solicitud=$id_solicitud&id_pedido=$id_pedido&del=1'><img src='images/eliminar.png' border='0'></a></td>";            
            }
            else{                    
                echo "<td align='center'>";
                    echo "<form action='msg_item_solicitud.php' name='form1' id='form1' method='post'>";                    
                    echo "<input type='hidden' id='id_solicitud' name='id_solicitud' value='$id_solicitud'/>";
                    echo "<input type='hidden' id='id_pedido' name='id_pedido' value='$id_pedido'/>";
                    echo "<input name='precio_estimado' type='text' id='precio_estimado' size='6' maxlength='6' style='font-size:10px'/>";
                    echo "<input type='hidden' id='cantidad' name='cantidad' value='$fil_item[4]'/>";
                    echo "<input type='hidden' id='del' name='del' value='3'/>";                    
                echo "</td>";
                echo "<td></td>";
                echo "<td><input type='submit' name='Submit' value='Guardar'/></td>";
                echo "</form>";
                echo "<td align='center'><a href='msg_item_solicitud.php?id_solicitud=$id_solicitud&id_pedido=$id_pedido&del=2'>Cancelar</a></td>";
            }
        echo "</tr>";
        $cont = $cont + 1;
     }
  ?>
  <tr bgcolor="#6699FF">
    <td colspan="6"><div align="center"><span class="style3">Total</span></div></td>
    <td align="right"><span class="style3"><strong><? echo $tot?></strong></span></td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="imprimir_solicitud_dinero.php">
  <input type="submit" name="Submit" value="Imprimir / Confirmar" /> 
  <input type="hidden" name="id_solicitud" value="<? echo $id_solicitud?>"/>
  <input type="hidden" name="flag" value="1"/>
</form>
<h3>PEDIDOS PENDIENTES </h3>
<table width="754" border="0">
  <tr bgcolor="#6699FF">
    <td width="27"><div align="center"><span class="style3">N&ordm;</span></div></td>
    <td width="276"><div align="center"><span class="style3">Articulo</span></div></td>
    <td width="31"><div align="center"><span class="style3">Unid</span></div></td>
    <td width="165"><div align="center"><span class="style3">Secci&oacute;n</span></div></td>
    <td width="40"><div align="center"><span class="style3">Cant</span></div></td>
    <td width="94"><div align="center"><span class="style3">Cod Sol.</span></div></td>
    <td width="91"><div align="center"><span class="style3">Agregar</span></div></td>
  </tr>
  <?
    $cont = 0; 
    $str_pen = "SELECT idPedido, nombreArticulo, unidad, seccion, cantidad FROM v_detallePedidos WHERE estado = 2 AND idPedido NOT IN(SELECT idPedido FROM itemsolicituddinero);";
    //echo $str_pen;
    $sql_pen = mysql_query($str_pen,$link);
    while($fil_pen = mysql_fetch_array($sql_pen)){

        $id_sol    = dechex($fil_datos[idSolicitud]);        
        $id_pedido = dechex($fil_pen[idPedido]);

        $cont = $cont + 1;
        echo "<tr style='font-size:10px'>";
            echo "<td align='right'>$cont</td>";
            echo "<td>$fil_pen[nombreArticulo]</td>";
            echo "<td>$fil_pen[unidad]</td>";
            echo "<td>$fil_pen[seccion]</td>";
            echo "<td align='right'>$fil_pen[cantidad]</td>";
            echo "<td>$codigo_solicitud</td>";  
            echo "<td align='center'><a href='msg_item_solicitud.php?id_solicitud=$id_sol&id_pedido=$id_pedido&del=4'>+</a></td>";          
        echo "</tr>";
    } 
  ?>
</table>
