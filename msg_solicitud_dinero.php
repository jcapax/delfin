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
	$login          = $_SESSION["login"];
	$rol            = $_SESSION["rol"];

	include("conexion.php");
	$link = conexion();

    $flag        = $_POST['flag'];    

    $fecha = date('Y').'/'.date('m').'/'.date('d');
    
    if($flag==1){
        unset($flag);
        
        
        
        $sql = mysql_query("INSERT INTO solicitudDinero(fecha,codigoUsuario,estado, fechaHoraRegistro) VALUES('$fecha','$codigo_usuario',0,now())",$link);        
        if(mysql_affected_rows() <> 0){
            $sql_last_id = mysql_query("SELECT idSolicitud FROM solicitudDinero ORDER BY idSolicitud DESC limit 1;",$link);
            $fli_id = mysql_fetch_array($sql_last_id);
            $id = dechex($fli_id[idSolicitud]); 
            
            $codigo_solicitud = 'A'.date('y').'-'.$fli_id[idSolicitud];
            mysql_query("UPDATE solicitudDinero SET codigoSolicitud = '$codigo_solicitud' WHERE idSolicitud = '$fli_id[idSolicitud]'",$link);
            
            $sql_i = "INSERT INTO itemSolicitudDinero(idSolicitud,idPedido,flag)";
            $sql_s = "SELECT '$fli_id[0]',idPedido,0";
            $sql_f = "FROM pedidos"; 
            $sql_w = "WHERE estado = 2 AND idPedido NOT IN(SELECT idPedido FROM itemsolicituddinero);";
            
            $sql   = $sql_i.' '.$sql_s.' '.$sql_f.' '.$sql_w;
            
            $sql_vaciar = mysql_query($sql,$link);
            
            header("Location: item_solicitud.php?id_solicitud='$id'");
        }        
    }
    else{
        header("Location: solicitud_dinero.php");
    }
?>
<?php
ob_end_flush();
?>