<?php
    ob_start();
?> 
<?php

/**
 * @author juanito
 * @copyright 2010
 */



    include("conexion.php");
	$link = conexion();

	function redondear($numero, $decimales){
		$factor = pow(10, $decimales);
		return (round($numero*$factor)/$factor); 
	}	

    if($_GET){
        $id_solicitud = hexdec($_GET['id_solicitud']);
        $id_pedido    = hexdec($_GET['id_pedido']);
        
        $del          = $_GET['del'];
    }
    else{
        $id_solicitud = hexdec($_POST['id_solicitud']);
        $id_pedido    = hexdec($_POST['id_pedido']);
        
        $prec_estim   = $_POST['precio_estimado'];
        $cantidad     = $_POST['cantidad'];
		
        $del          = $_POST['del'];
    }
    
    //del 0 editar, 1 eliminar, 2 cancelar, 3 actualizar, 4 añadir
    
    $is = dechex($id_solicitud);
    
    if($del == 0){
        mysql_query("UPDATE itemSolicitudDinero SET flag = 0 WHERE idSolicitud = '$id_solicitud'",$link);
        mysql_query("UPDATE itemSolicitudDinero SET flag = 1 WHERE idSolicitud = '$id_solicitud' AND idPedido = '$id_pedido'",$link);
        header("Location: item_solicitud.php?id_solicitud=$is");
    }

    if($del == 1){
        mysql_query("DELETE FROM itemSolicitudDinero WHERE idSolicitud = '$id_solicitud' AND idPedido = '$id_pedido'",$link);
        header("Location: item_solicitud.php?id_solicitud=$is");
    }

    if($del == 2){
        mysql_query("UPDATE itemSolicitudDinero SET flag = 0 WHERE idSolicitud = '$id_solicitud'",$link);
        header("Location: item_solicitud.php?id_solicitud=$is");
    }

    if($del == 3){
        $pt = redondear(($prec_estim * $cantidad),2);
		//$pt = $prec_estim * $cantidad;
        $sql = "UPDATE itemSolicitudDinero SET precioUnitarioEstimado='$prec_estim', precioTotalEstimado='$pt' WHERE idSolicitud = '$id_solicitud' AND idPedido = '$id_pedido'";
        mysql_query($sql,$link);
        mysql_query("UPDATE itemSolicitudDinero SET flag = 0 WHERE idSolicitud = '$id_solicitud'",$link);
        //echo $sql;
        header("Location: item_solicitud.php?id_solicitud=$is");
    }

    if($del == 4){
        mysql_query("INSERT INTO itemSolicitudDinero(idSolicitud,idPedido,flag) VALUES('$id_solicitud','$id_pedido',0)",$link);
        
        header("Location: item_solicitud.php?id_solicitud=$is");
    }


?>
<?php
ob_end_flush();
?>