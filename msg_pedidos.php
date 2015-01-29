<?php
    ob_start();
?> 
<?php
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];

	include("conexion.php");
	$link = conexion();

    $origen      = $_POST['origen'];
    $flag        = $_POST['flag'];    
    $solicitante = $_POST['solicitante'];
    $seccion     = $_POST['seccion'];
    $cantidad    = $_POST['cantidad'];
    $observaciones = $_POST['observaciones'];
    
    $bandera = 1;
    
    if($solicitante == ''){
      header("Location: pedidos.php");        
    }
    
    if($seccion==''){
        header("Location: pedidos.php");
    }

    if($flag==0){
        $id_articulo = $_POST['id_articulo'];
    }
    else{
        $articulo = $_POST['articulo'];
        $unidad   = $_POST['unidad'];

        echo $flag.' '.$articulo.' '.$unidad.'<br>';

        $articulos_insertados = 0;        
        $sql_insertar_articulo = mysql_query("INSERT INTO articulos(nombreArticulo, unidad) VALUES('$articulo','$unidad')",$link);
        $articulos_insertados = mysql_affected_rows();
        
        
        echo $articulos_insertados.' articulos ';
        
        if($articulos_insertados<>0){            
            $sql_nuevo_id_articulo = mysql_query("SELECT idArticulo FROM articulos ORDER BY idArticulo DESC LIMIT 1",$link);
            $res_nuevo_id_articulo = mysql_fetch_array($sql_nuevo_id_articulo);
            $id_articulo           = $res_nuevo_id_articulo[0];
            $bandera = 1;                    
        }
        else{
            $bandera = 0;
        }
    }
    
    if($bandera==1){
        $fecha = date(Y).'-'.date(m).'-'.date(d);
        $estado = 2;
        $sql_i = "INSERT INTO pedidos(origen,fecha,idArticulo,cantidad,seccion,solicitante,estado,fechaHoraRegistro,codigoUsuarioRegistro, observaciones)";
        $sql_v = "VALUES('$origen','$fecha', '$id_articulo', '$cantidad', '$seccion', '$solicitante', '$estado', now(), '$codigo_usuario', '$observaciones')";   
        $sql   = $sql_i.' '.$sql_v;  
        $sql_insertar_pedido = mysql_query($sql,$link);
        header("Location: pedidos.php");        
    }
    else{
        echo "ERROR EN LA REGISTRO DE DATOS, SI EL ERROR PERSISTE, COMUNIQUESE CON EL ADMINISTRADOR!!!"."<br>";
        echo "click<a href='pedidos.php'> aqui </a>para regresar";
    }        
    unset($bandera);
    unset($id_articulo);
    unset($solicitante);
    unset($cantidad);
    unset($seccion);
    unset($flag);
?>
<?php
ob_end_flush();
?>