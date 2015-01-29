<?php
    ob_start();
?> 
<?php

/**
 * @author juanito
 * @copyright 2010
 */
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];

	include("conexion.php");
	$link = conexion();
    
    $confirmar = $_POST['confirmar'];
    $anular    = $_POST['anular'];
  
    if(isset($confirmar)){
        //************confirmar************      
        //mysql_query("UPDATE pedidos SET estado = 1, fechaHoraAlmacen = now(), codigoUsuarioAlmacen = 'YYY' WHERE idPedido IN ('$ids')",$link);
        foreach($_POST['id_pedido'] as $ids){
            mysql_query("UPDATE pedidos SET estado = 2, fechaHoraOrdenCompra = now(), codigoUsuarioOrdenCompra = '$codigo_usuario' WHERE idPedido IN ('$ids')",$link);
        }
    }
    if(isset($anular)){
        //************anular***************
        foreach($_POST['id_pedido'] as $ids){
            mysql_query("UPDATE pedidos SET estado = 4, fechaHoraAnulacion = now(), codigoUsuarioAnulacion = '$codigo_usuario' WHERE idPedido IN ('$ids')",$link);    
        }
    }
    header("Location: orden_compra.php");
?>
<?php
    ob_end_flush();
?>